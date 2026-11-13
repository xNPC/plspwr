<?php

declare(strict_types=1);

namespace App\Orchid\Screens\CaseStudy;

use App\Models\CaseStudy;
use App\Orchid\Layouts\CaseStudy\CaseStudyListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CaseStudyListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'cases' => CaseStudy::orderBy('sort')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Cases');
    }

    public function description(): ?string
    {
        return __('Manage case studies.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.cases'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('bs.plus-circle')
                ->route('platform.content.cases.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            CaseStudyListLayout::class,
        ];
    }

    public function remove(int $id): RedirectResponse
    {
        CaseStudy::findOrFail($id)->delete();

        Toast::info(__('Case was removed.'));

        return redirect()->route('platform.content.cases');
    }
}
