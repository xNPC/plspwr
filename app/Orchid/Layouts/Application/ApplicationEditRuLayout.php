<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Application;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ApplicationEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('application.slug_ru')
                ->type('text')
                ->title('Слаг (рус.)')
                ->placeholder('naprimer-nauchnye-issledovaniia')
                ->help('Латиница, цифры и дефис. Если пусто — будет сгенерирован автоматически.'),

            Input::make('application.title_ru')
                ->type('text')
                ->title('Название (рус.)')
                ->help('Название области применения на русском языке. Обязательное поле.')
                ->required(),

            TextArea::make('application.intro_ru')
                ->title('Краткое описание (рус.)')
                ->rows(3)
                ->help('Короткая аннотация для списков и SEO-описания.'),

            Quill::make('application.description_ru')
                ->title('Описание (рус.)')
                ->height('320px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Развёрнутое описание области применения. Визуальный редактор.'),
        ];
    }
}