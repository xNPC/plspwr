<?php

declare(strict_types=1);

namespace App\Orchid\Screens\CaseStudy;

use App\Models\CaseStudy;
use App\Orchid\Layouts\CaseStudy\CaseStudyEditLayout;
use App\Orchid\Layouts\Seo\SeoEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CaseStudyEditScreen extends Screen
{
    /**
     * @var CaseStudy
     */
    public $case;

    public function query(CaseStudy $case): iterable
    {
        $case->load('seo');

        return [
            'case' => $case,
            'seo' => $case->seo,
        ];
    }

    public function name(): ?string
    {
        return $this->case->exists ? __('Edit Case') : __('Create Case');
    }

    public function description(): ?string
    {
        return $this->case->exists ? $this->case->title_ru : __('Add a new case study.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.cases'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Delete this case?'))
                ->method('remove')
                ->canSee($this->case->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(CaseStudyEditLayout::class)
                ->title(__('Case'))
                ->description(__('Localized fields for this case study.')),

            Layout::block(SeoEditLayout::class)
                ->title(__('SEO'))
                ->description(__('Search engine metadata (optional).')),
        ];
    }

    public function save(CaseStudy $case, Request $request): RedirectResponse
    {
        $data = $request->collect('case')->toArray();
        $data['image'] = $this->normalizeImage($data['image'] ?? null);

        $case->fill($data)->save();

        $seoData = $request->collect('seo')->toArray();
        if (! empty($seoData['title_ru']) || ! empty($seoData['title_en']) || ! empty($seoData['description_ru'])) {
            $case->seo()->updateOrCreate([], $seoData);
        }

        Toast::info(__('Case was saved.'));

        return redirect()->route('platform.content.cases.edit', $case->id);
    }

    public function remove(CaseStudy $case): RedirectResponse
    {
        $case->delete();

        Toast::info(__('Case was removed.'));

        return redirect()->route('platform.content.cases');
    }

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

        return $first !== null ? (string) $first : null;
    }
}
