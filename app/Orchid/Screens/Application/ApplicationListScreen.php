<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Application;

use App\Models\Application;
use App\Orchid\Layouts\Application\ApplicationListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ApplicationListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'applications' => Application::orderBy('sort')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Applications');
    }

    public function description(): ?string
    {
        return __('Manage application areas.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.applications'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('bs.plus-circle')
                ->route('platform.content.applications.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            ApplicationListLayout::class,
        ];
    }

    public function remove(int $id): RedirectResponse
    {
        Application::findOrFail($id)->delete();

        Toast::info(__('Application was removed.'));

        return redirect()->route('platform.content.applications');
    }
}
