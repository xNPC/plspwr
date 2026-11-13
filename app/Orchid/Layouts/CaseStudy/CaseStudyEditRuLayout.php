<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\CaseStudy;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class CaseStudyEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('case.slug_ru')
                ->type('text')
                ->title('Слаг (рус.)')
                ->placeholder('naprimer-uvelichitelnyi-blok')
                ->help('Латиница, цифры и дефис. Если пусто — будет сгенерирован автоматически.'),

            Input::make('case.title_ru')
                ->type('text')
                ->title('Заголовок (рус.)')
                ->help('Заголовок кейса на русском языке. Обязательное поле.')
                ->required(),

            TextArea::make('case.intro_ru')
                ->title('Краткое описание (рус.)')
                ->rows(3)
                ->help('Короткая аннотация для списков и SEO-описания.'),

            Quill::make('case.body_ru')
                ->title('Содержание (рус.)')
                ->height('400px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Полный текст кейса. Визуальный редактор.'),
        ];
    }
}