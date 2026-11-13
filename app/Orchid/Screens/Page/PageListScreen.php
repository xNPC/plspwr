<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Page;

use App\Models\Page;
use App\Orchid\Layouts\Page\PageListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PageListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'pages' => Page::orderBy('is_home', 'desc')->orderBy('slug_ru')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Pages');
    }

    public function description(): ?string
    {
        return __('Manage CMS pages and their blocks.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.pages'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('bs.plus-circle')
                ->route('platform.content.pages.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            PageListLayout::class,
        ];
    }

    public function remove(int $id): RedirectResponse
    {
        Page::findOrFail($id)->delete();

        Toast::info(__('Page was removed.'));

        return redirect()->route('platform.content.pages');
    }
}
