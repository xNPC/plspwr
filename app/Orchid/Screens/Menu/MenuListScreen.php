<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Menu;

use App\Models\Menu;
use App\Orchid\Layouts\Menu\MenuListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MenuListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'menus' => Menu::withCount('items')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Menus');
    }

    public function description(): ?string
    {
        return __('Manage navigation menus and their items.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.menus'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('bs.plus-circle')
                ->route('platform.content.menus.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            MenuListLayout::class,
        ];
    }

    public function remove(int $id): RedirectResponse
    {
        Menu::findOrFail($id)->delete();

        Toast::info(__('Menu was removed.'));

        return redirect()->route('platform.content.menus');
    }
}
