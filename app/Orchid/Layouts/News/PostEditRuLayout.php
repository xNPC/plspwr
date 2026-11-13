<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\News;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PostEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('post.slug_ru')
                ->type('text')
                ->title('Слаг (рус.)')
                ->placeholder('naprimer-itogi-vystavki')
                ->help('Латиница, цифры и дефис. Если пусто — будет сгенерирован автоматически.'),

            Input::make('post.title_ru')
                ->type('text')
                ->title('Заголовок (рус.)')
                ->help('Заголовок новости на русском языке. Обязательное поле.')
                ->required(),

            TextArea::make('post.intro_ru')
                ->title('Краткое описание (рус.)')
                ->rows(3)
                ->help('Короткая аннотация для списков и SEO-описания.'),

            Quill::make('post.body_ru')
                ->title('Текст (рус.)')
                ->height('400px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Полный текст новости. Визуальный редактор — картинки вставляются в base64.'),
        ];
    }
}