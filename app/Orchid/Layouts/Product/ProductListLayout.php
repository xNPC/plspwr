<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductListLayout extends Table
{
    public $target = 'products';

    public function columns(): array
    {
        return [
            TD::make('title_ru', __('Title (RU)'))
                ->sort()
                ->cantHide()
                ->render(fn (Product $product) => $product->title_ru),

            TD::make('code', __('Code'))
                ->sort(),

            TD::make('family', __('Family'))
                ->render(fn (Product $product) => $product->family?->title_ru ?? '-'),

            TD::make('sort', __('Sort'))
                ->sort()
                ->align(TD::ALIGN_RIGHT),

            TD::make('is_active', __('Active'))
                ->render(fn (Product $product) => $product->is_active ? 'Yes' : 'No')
                ->align(TD::ALIGN_CENTER),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Product $product) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.products.edit', $product->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this product?'))
                            ->method('remove', ['id' => $product->id]),
                    ])),
        ];
    }
}
