<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ProductFamilyEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('family.slug_ru')
                ->type('text')
                ->title('Слаг (рус.)')
                ->placeholder('naprimer-seriya-m')
                ->help('Латиница, цифры и дефис. Если пусто — будет сгенерирован автоматически.'),

            Input::make('family.title_ru')
                ->type('text')
                ->title('Название (рус.)')
                ->help('Название семейства на русском языке. Обязательное поле.')
                ->required(),

            TextArea::make('family.intro_ru')
                ->title('Краткое описание (рус.)')
                ->rows(3)
                ->help('Короткая аннотация для списков и SEO-описания.'),

            Quill::make('family.description_ru')
                ->title('Описание (рус.)')
                ->height('320px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Развёрнутое описание семейства. Визуальный редактор.'),
        ];
    }
}