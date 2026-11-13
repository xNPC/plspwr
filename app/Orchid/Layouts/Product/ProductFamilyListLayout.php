<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\ProductFamily;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductFamilyListLayout extends Table
{
    public $target = 'families';

    public function columns(): array
    {
        return [
            TD::make('title_ru', __('Title (RU)'))
                ->sort()
                ->cantHide()
                ->render(fn (ProductFamily $family) => $family->title_ru),

            TD::make('title_en', __('Title (EN)'))
                ->sort()->render(fn (ProductFamily $family) => $family->title_en),

            TD::make('code', __('Code'))
                ->sort(),

            TD::make('slug_ru', __('Slug'))
                ->render(fn (ProductFamily $family) => $family->slug_ru),

            TD::make('is_active', __('Active'))
                ->render(fn (ProductFamily $family) => $family->is_active ? 'Yes' : 'No')
                ->align(TD::ALIGN_CENTER),

            TD::make('sort', __('Sort'))
                ->sort()
                ->align(TD::ALIGN_RIGHT),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (ProductFamily $family) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.product-families.edit', $family->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this product family?'))
                            ->method('remove', ['id' => $family->id]),
                    ])),
        ];
    }
}
