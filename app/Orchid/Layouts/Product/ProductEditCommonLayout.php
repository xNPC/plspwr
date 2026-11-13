<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use App\Models\ProductFamily;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class ProductEditCommonLayout extends Rows
{
    public function fields(): array
    {
        return [
            Select::make('product.product_family_id')
                ->fromModel(ProductFamily::class, 'title_ru')
                ->empty('Выберите семейство')
                ->title('Семейство')
                ->help('Семейство, к которому относится изделие. Обязательное поле.')
                ->required(),

            Input::make('product.code')
                ->type('text')
                ->title('Обозначение / артикул')
                ->placeholder('например: ИМ-10/100')
                ->help('Заводское обозначение изделия.'),

            Upload::make('product.gallery')
                ->title('Галерея')
                ->multiple()
                ->help('Фотографии изделия. Первое изображение используется как обложка.'),

            Input::make('product.sort')
                ->type('number')
                ->title('Порядок сортировки')
                ->value(0)
                ->help('Меньшее значение — выше в списке. Обычно 0.'),

            CheckBox::make('product.is_active')
                ->title('Активно')
                ->placeholder('Показывать изделие на сайте')
                ->value(true)
                ->sendTrueOrFalse(),
        ];
    }
}