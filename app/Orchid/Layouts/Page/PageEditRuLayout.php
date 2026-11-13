<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PageEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('page.slug_ru')
                ->type('text')
                ->title('Слаг (рус.)')
                ->placeholder('naprimer-o-kompanii')
                ->help('Латиница, цифры и дефис. Если пусто — будет сгенерирован автоматически. Листинг-страницы (секции) обычно не используют слаг.'),

            Input::make('page.title_ru')
                ->type('text')
                ->title('Заголовок (рус.)')
                ->help('Название страницы, отображается в шапке и поиске. Обязательное поле.')
                ->required(),

            TextArea::make('page.description_ru')
                ->title('Описание (рус.)')
                ->rows(3)
                ->help('Подзаголовок страницы на русском. Отображается под заголовком (например, на страницах разделов).'),
        ];
    }
}