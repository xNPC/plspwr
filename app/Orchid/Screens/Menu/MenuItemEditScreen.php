<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Menu;

use App\Models\MenuItem;
use App\Orchid\Layouts\Menu\MenuItemEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MenuItemEditScreen extends Screen
{
    /**
     * @var MenuItem
     */
    public $item;

    public function query(MenuItem $item, ?int $menu = null): iterable
    {
        $item = $item->exists
            ? $item
            : new MenuItem(['type' => 'link', 'sort' => 0, 'is_active' => true]);

        if ($menu) {
            $item->menu_id = $menu;
        }

        return [
            'item' => $item,
            'menuId' => $menu ?? $item->menu_id,
        ];
    }

    public function name(): ?string
    {
        return $this->item->exists ? __('Edit Menu Item') : __('Create Menu Item');
    }

    public function description(): ?string
    {
        return __('A single navigation entry.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.menus'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Delete this menu item?'))
                ->method('remove')
                ->canSee($this->item->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(new MenuItemEditLayout($this->item->menu_id))
                ->title(__('Menu Item'))
                ->description(__('Label, link target and ordering.')),
        ];
    }

    public function save(MenuItem $item, Request $request): RedirectResponse
    {
        $data = $request->collect('item')->toArray();
        if (! $item->menu_id) {
            $item->menu_id = (int) $request->route('menu', 0);
        }

        $item->fill($data)->save();

        Toast::info(__('Menu item was saved.'));

        return redirect()->route('platform.content.menus.edit', $item->menu_id);
    }

    public function remove(MenuItem $item): RedirectResponse
    {
        $menuId = $item->menu_id;
        $item->delete();

        Toast::info(__('Menu item was removed.'));

        return redirect()->route('platform.content.menus.edit', $menuId);
    }
}
