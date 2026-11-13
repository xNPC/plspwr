<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Application;

use App\Models\Application;
use App\Orchid\Layouts\Application\ApplicationEditLayout;
use App\Orchid\Layouts\Seo\SeoEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ApplicationEditScreen extends Screen
{
    /**
     * @var Application
     */
    public $application;

    public function query(Application $application): iterable
    {
        $application->load('seo');

        return [
            'application' => $application,
            'seo' => $application->seo,
        ];
    }

    public function name(): ?string
    {
        return $this->application->exists ? __('Edit Application') : __('Create Application');
    }

    public function description(): ?string
    {
        return $this->application->exists ? $this->application->title_ru : __('Add a new application.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.applications'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Delete this application?'))
                ->method('remove')
                ->canSee($this->application->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(ApplicationEditLayout::class)
                ->title(__('Application'))
                ->description(__('Localized fields for this application.')),

            Layout::block(SeoEditLayout::class)
                ->title(__('SEO'))
                ->description(__('Search engine metadata (optional).')),
        ];
    }

    public function save(Application $application, Request $request): RedirectResponse
    {
        $data = $request->collect('application')->toArray();
        $data['image'] = $this->normalizeImage($data['image'] ?? null);
        $data['icon'] = $this->normalizeImage($data['icon'] ?? null);

        $application->fill($data)->save();

        $seoData = $request->collect('seo')->toArray();
        if (! empty($seoData['title_ru']) || ! empty($seoData['title_en']) || ! empty($seoData['description_ru'])) {
            $application->seo()->updateOrCreate([], $seoData);
        }

        Toast::info(__('Application was saved.'));

        return redirect()->route('platform.content.applications.edit', $application->id);
    }

    public function remove(Application $application): RedirectResponse
    {
        $application->delete();

        Toast::info(__('Application was removed.'));

        return redirect()->route('platform.content.applications');
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
