<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Menu;

use App\Models\Menu;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MenuListLayout extends Table
{
    public $target = 'menus';

    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide(),

            TD::make('slug', __('Slug'))
                ->sort(),

            TD::make('items', __('Items'))
                ->render(fn (Menu $menu) => $menu->items()->count()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Menu $menu) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.menus.edit', $menu->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this menu?'))
                            ->method('remove', ['id' => $menu->id]),
                    ])),
        ];
    }
}
