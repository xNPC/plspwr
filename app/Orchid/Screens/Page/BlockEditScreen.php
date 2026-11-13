<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Page;

use App\Models\Block;
use App\Models\Page;
use App\Orchid\Layouts\Page\BlockEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BlockEditScreen extends Screen
{
    /**
     * @var Block
     */
    public $block;

    /** All textual+group fields per locale, keyed by the content key they map to. */
    private const SCALAR_LOCALIZED = [
        'badge', 'eyebrow', 'title', 'subtitle', 'description',
        'text', 'body', 'link_label', 'link2_label', 'primary_label', 'secondary_label', 'image_alt',
    ];

    /** Non-localized fields duplicated into both ru/en branches. */
    private const SCALAR_SHARED = [
        'link_url', 'link2_url', 'primary_url', 'secondary_url', 'image', 'side', 'align', 'max_width', 'columns',
    ];

    /** Repeatable groups stored per locale. */
    private const GROUPS = ['stats', 'items', 'points', 'images'];

    public function query(Block $block, ?int $page = null): iterable
    {
        $block = $block->exists
            ? $block
            : new Block([
                'type' => 'text',
                'sort' => 0,
                'is_active' => true,
            ]);

        if ($page) {
            $block->page_id = $page;
        }

        $content = $block->content ?? [];

        $ru = $this->branchOf($content, 'ru');
        $en = $this->branchOf($content, 'en');

        // Localized scalar fields -> content_ru_* / content_en_*
        foreach (self::SCALAR_LOCALIZED as $key) {
            $block->setAttribute('content_ru_'.$key, $ru[$key] ?? null);
            $block->setAttribute('content_en_'.$key, $en[$key] ?? null);
        }

        // Shared scalar fields (duplicated in both branches) -> content_*
        foreach (self::SCALAR_SHARED as $key) {
            $block->setAttribute('content_'.$key, $ru[$key] ?? $en[$key] ?? null);
        }

        // Repeatable groups per locale
        foreach (self::GROUPS as $group) {
            $scalarKey = $group === 'points' ? 'point' : ($group === 'images' ? 'image' : null);

            $block->setAttribute('content_ru_'.$group, $this->asRows($ru[$group] ?? null, $scalarKey));
            $block->setAttribute('content_en_'.$group, $this->asRows($en[$group] ?? null, $scalarKey));
        }

        return [
            'block' => $block,
            'page' => $page ?? $block->page_id,
        ];
    }

    public function name(): ?string
    {
        return $this->block->exists ? __('Edit Block') : __('Create Block');
    }

    public function description(): ?string
    {
        return __('Page block with type-specific JSON content.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.pages'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Delete this block?'))
                ->method('remove')
                ->canSee($this->block->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(BlockEditLayout::class)
                ->title(__('Block'))
                ->description(__('Select the block type and provide its localized JSON content.')),
        ];
    }

    public function save(Block $block, Request $request): RedirectResponse
    {
        $data = $request->collect('block')->toArray();

        // Model columns must survive save. (Was unset() → type/sort/is_active dropped →
        // SQLSTATE[HY000] 1364 'Field type doesn't have a default value' on create.)
        $data['type'] = (string) ($data['type'] ?? '');
        if ($data['type'] === '') {
            $data['type'] = 'text';
        }
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        // Let group pruning know the chosen type (fresh create instance has none yet).
        $block->type = $data['type'];

        $ru = [];
        $en = [];

        // Localized scalar fields
        foreach (self::SCALAR_LOCALIZED as $key) {
            $this->takeScalar($data, 'content_ru_'.$key, $ru, $key);
            $this->takeScalar($data, 'content_en_'.$key, $en, $key);
        }

        // Shared scalar fields -> duplicate into both branches
        foreach (self::SCALAR_SHARED as $key) {
            $value = $data['content_'.$key] ?? null;
            unset($data['content_'.$key]);

            if ($value === null || $value === '') {
                unset($ru[$key], $en[$key]);
            } else {
                $ru[$key] = $value;
                $en[$key] = $value;
            }
        }

        // Repeatable groups per locale
        foreach (self::GROUPS as $group) {
            $this->takeRows($data, 'content_ru_'.$group, $ru, $group);
            $this->takeRows($data, 'content_en_'.$group, $en, $group);
        }

        // Keep only the relevant group key for the block type; drop empty ones.
        $ru = $this->pruneGroups($ru);
        $en = $this->pruneGroups($en);

        unset($data['page_id']);

        $data['content'] = ['ru' => $ru, 'en' => $en];

        $block->fill($data);

        if (! $block->page_id) {
            $block->page_id = (int) ($request->route('page') ?? $request->input('page'));
        }

        $block->save();

        Toast::info(__('Block was saved.'));

        return redirect()->route('platform.content.pages.edit', $block->page_id);
    }

    public function remove(Block $block): RedirectResponse
    {
        $pageId = $block->page_id;
        $block->delete();

        Toast::info(__('Block was removed.'));

        return redirect()->route('platform.content.pages.edit', $pageId);
    }

    private function branchOf(array $content, string $locale): array
    {
        $branch = $content[$locale] ?? [];

        return is_array($branch) ? $branch : [];
    }

    private function takeScalar(array &$data, string $field, array &$target, string $key): void
    {
        $value = $data[$field] ?? null;
        unset($data[$field]);

        if ($value === null || $value === '') {
            unset($target[$key]);
        } else {
            $target[$key] = $value;
        }
    }

    /**
     * Convert Matrix rows (list of keyed arrays) into a list, dropping fully-empty rows.
     * Legacy flat-scalar list items (e.g. points/images stored as plain strings) are
     * wrapped into the Matrix row shape via $scalarKey so they stay editable and survive save.
     */
    private function asRows(mixed $items, ?string $scalarKey = null): array
    {
        $items = is_array($items) ? $items : [];

        $rows = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                if ($scalarKey === null) {
                    continue;
                }

                $row = [$scalarKey => $item];
            } else {
                $row = array_filter($item, fn ($v) => $v !== null && $v !== '');
            }

            if ($row !== []) {
                $rows[] = $row;
            }
        }

        return array_values($rows);
    }

    private function takeRows(array &$data, string $field, array &$target, string $group): void
    {
        $rows = $data[$field] ?? null;
        unset($data[$field]);

        $clean = $this->asRows($rows);

        if ($clean === []) {
            unset($target[$group]);
        } else {
            $target[$group] = $clean;
        }
    }

    /**
     * Drop group keys that are irrelevant to the current block type.
     */
    private function pruneGroups(array $branch): array
    {
        $type = $this->blockTypeFromBranch($branch);

        $keep = match ($type) {
            'stats' => ['stats'],
            'timeline', 'features', 'faq' => ['items'],
            'technology' => ['points'],
            'gallery' => ['images'],
            default => [],
        };

        foreach (self::GROUPS as $group) {
            if (! in_array($group, $keep, true)) {
                unset($branch[$group]);
            }
        }

        return $branch;
    }

    private function blockTypeFromBranch(array $branch): string
    {
        $type = $this->block->type ?? ($this->block['type'] ?? 'text');

        return (string) $type;
    }
}