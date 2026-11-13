<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Rows;

class ProductFamilyEditCommonLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('family.code')
                ->type('text')
                ->title('Обозначение / артикул')
                ->placeholder('например: M-Series')
                ->help('Краткое обозначение семейства.'),

            Picture::make('family.image')
                ->title('Изображение')
                ->help('Фотография или логотип семейства.'),

            Input::make('family.sort')
                ->type('number')
                ->title('Порядок сортировки')
                ->value(0)
                ->help('Меньшее значение — выше в списке. Обычно 0.'),

            CheckBox::make('family.is_active')
                ->title('Активно')
                ->placeholder('Показывать семейство на сайте')
                ->value(true)
                ->sendTrueOrFalse(),
        ];
    }
}