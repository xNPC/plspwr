<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ProductEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('product.slug_ru')
                ->type('text')
                ->title('Слаг (рус.)')
                ->placeholder('naprimer-moduliator-100')
                ->help('Латиница, цифры и дефис. Если пусто — будет сгенерирован автоматически.'),

            Input::make('product.title_ru')
                ->type('text')
                ->title('Название (рус.)')
                ->help('Название изделия на русском языке. Обязательное поле.')
                ->required(),

            TextArea::make('product.intro_ru')
                ->title('Краткое описание (рус.)')
                ->rows(3)
                ->help('Короткая аннотация для списков и SEO-описания.'),

            Quill::make('product.description_ru')
                ->title('Описание (рус.)')
                ->height('320px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Развёрнутое описание изделия. Визуальный редактор — картинки вставляются в base64.'),

            Matrix::make('product.specifications_ru_rows')
                ->columns(['Название' => 'name', 'Значение' => 'value'])
                ->fields([
                    'name' => Input::make()->placeholder('Название'),
                    'value' => Input::make()->placeholder('Значение'),
                ])
                ->addRowLabel('Добавить характеристику')
                ->title('Характеристики (рус.)')
                ->help('Каждая строка — параметр и значение на русском. Например: Напряжение = 10 кВ.'),
        ];
    }
}