<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Menu;

use App\Models\MenuItem;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MenuItemListLayout extends Table
{
    public $target = 'items';

    public function columns(): array
    {
        return [
            TD::make('label_ru', __('Label (RU)'))
                ->cantHide()
                ->render(fn (MenuItem $item) => $this->indent($item).$item->label_ru),

            TD::make('type', __('Type'))
                ->render(fn (MenuItem $item) => $item->type),

            TD::make('sort', __('Sort'))
                ->align(TD::ALIGN_RIGHT),

            TD::make('is_active', __('Active'))
                ->render(fn (MenuItem $item) => $item->is_active ? 'Yes' : 'No')
                ->align(TD::ALIGN_CENTER),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (MenuItem $item) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.menus.items.edit', $item->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this menu item?'))
                            ->method('removeItem', ['id' => $item->id]),
                    ])),
        ];
    }

    protected function indent(MenuItem $item): string
    {
        return $item->parent_id ? '↳ ' : '';
    }
}
