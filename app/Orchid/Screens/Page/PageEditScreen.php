<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Page;

use App\Models\Block;
use App\Models\Page;
use App\Orchid\Layouts\Page\PageBlocksLayout;
use App\Orchid\Layouts\Page\PageEditLayout;
use App\Orchid\Layouts\Seo\SeoEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PageEditScreen extends Screen
{
    /**
     * @var Page
     */
    public $page;

    public function query(Page $page): iterable
    {
        $page->load(['blocks', 'seo']);

        return [
            'page' => $page,
            'seo' => $page->seo,
            'blocks' => $page->blocks,
        ];
    }

    public function name(): ?string
    {
        return $this->page->exists ? __('Edit Page') : __('Create Page');
    }

    public function description(): ?string
    {
        return $this->page->exists ? $this->page->title_ru : __('Add a new CMS page.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.pages'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add block'))
                ->icon('bs.plus-circle')
                ->route('platform.content.pages.blocks.create', $this->page->id ?? 0)
                ->canSee($this->page->exists),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Delete this page?'))
                ->method('remove')
                ->canSee($this->page->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(PageEditLayout::class)
                ->title(__('Page'))
                ->description(__('Page metadata and visibility.')),

            Layout::block(SeoEditLayout::class)
                ->title(__('SEO'))
                ->description(__('Search engine metadata (optional).')),

            Layout::block(PageBlocksLayout::class)
                ->title(__('Blocks'))
                ->description(__('Blocks that make up this page, in render order.')),
        ];
    }

    public function save(Page $page, Request $request): RedirectResponse
    {
        $data = $request->collect('page')->toArray();
        $data['banner_image'] = $this->normalizeImage($data['banner_image'] ?? null);

        $page->fill($data)->save();

        $seoData = $request->collect('seo')->toArray();
        if (! empty($seoData['title_ru']) || ! empty($seoData['title_en']) || ! empty($seoData['description_ru'])) {
            $page->seo()->updateOrCreate([], $seoData);
        }

        Toast::info(__('Page was saved.'));

        return redirect()->route('platform.content.pages.edit', $page->id);
    }

    public function remove(Page $page): RedirectResponse
    {
        $page->delete();

        Toast::info(__('Page was removed.'));

        return redirect()->route('platform.content.pages');
    }

    public function removeBlock(int $id): RedirectResponse
    {
        Block::findOrFail($id)->delete();

        Toast::info(__('Block was removed.'));

        return redirect()->back();
    }

    /**
     * Picture stores a single image path, but be resilient to arrays /
     * JSON strings / Orchid upload JS artifacts leaking into the JSON column.
     */
    private function normalizeImage(mixed $value): ?string
    {
        $first = null;

        if (is_array($value)) {
            $flat = array_values(array_filter($value, fn ($item) => is_string($item) && trim($item) !== ''));
            $first = $flat[0] ?? null;
        } elseif (is_string($value) && trim($value) !== '') {
            $decoded = json_decode($value, true);

            if (is_array($decoded)) {
                $flat = array_values(array_filter($decoded, fn ($item) => is_string($item) && trim($item) !== ''));
                $first = $flat[0] ?? null;
            } else {
                $first = $value;
            }
        }

        if ($first !== null && in_array($first, ['undefined', 'null', 'false', 'NaN', '[object Object]'], true)) {
            return null;
        }

        return $first !== null ? (string) $first : null;
    }
}
