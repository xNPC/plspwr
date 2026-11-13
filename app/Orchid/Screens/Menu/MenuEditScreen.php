<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Menu;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Orchid\Layouts\Menu\MenuEditLayout;
use App\Orchid\Layouts\Menu\MenuItemListLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MenuEditScreen extends Screen
{
    /**
     * @var Menu
     */
    public $menu;

    public function query(Menu $menu): iterable
    {
        return [
            'menu' => $menu,
            'items' => $menu->items()->orderBy('sort')->get(),
        ];
    }

    public function name(): ?string
    {
        return $this->menu->exists ? __('Edit Menu') : __('Create Menu');
    }

    public function description(): ?string
    {
        return __('Navigation menu and its items.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.menus'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add item'))
                ->icon('bs.plus-circle')
                ->route('platform.content.menus.items.create', $this->menu->id ?? 0)
                ->canSee($this->menu->exists),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Delete this menu?'))
                ->method('remove')
                ->canSee($this->menu->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(MenuEditLayout::class)
                ->title(__('Menu'))
                ->description(__('Menu name and unique slug.')),

            Layout::block(MenuItemListLayout::class)
                ->title(__('Items'))
                ->description(__('Menu items in render order.')),
        ];
    }

    public function save(Menu $menu, Request $request): RedirectResponse
    {
        $menu->fill($request->collect('menu')->toArray())->save();

        Toast::info(__('Menu was saved.'));

        return redirect()->route('platform.content.menus.edit', $menu->id);
    }

    public function remove(Menu $menu): RedirectResponse
    {
        $menu->delete();

        Toast::info(__('Menu was removed.'));

        return redirect()->route('platform.content.menus');
    }

    public function removeItem(int $id): RedirectResponse
    {
        MenuItem::findOrFail($id)->delete();

        Toast::info(__('Menu item was removed.'));

        return redirect()->back();
    }
}
