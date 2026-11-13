<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Seo;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class SeoEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('seo.title_ru')
                ->type('text')
                ->title('SEO-заголовок (рус.)')
                ->help('Заголовок в поисковой выдаче. Если пусто — берётся из заголовка страницы.'),

            TextArea::make('seo.description_ru')
                ->title('SEO-описание (рус.)')
                ->rows(3)
                ->help('Описание в поисковой выдаче. Оптимально 120–160 символов. Если пусто — берётся из аннотации.'),

            Input::make('seo.keywords_ru')
                ->type('text')
                ->title('Ключевые слова (рус.)')
                ->placeholder('ключевое слово, другое слово')
                ->help('Необязательно. Google и Яндекс их игнорируют.'),

            Input::make('seo.canonical_ru')
                ->type('text')
                ->title('Канонический URL (рус.)')
                ->placeholder('https://imp-tech.ru/...')
                ->help('Канонический адрес страницы. Если пусто — используется адрес из маршрута.'),
        ];
    }
}