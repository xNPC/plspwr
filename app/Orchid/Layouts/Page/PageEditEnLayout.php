<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PageEditEnLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('page.slug_en')
                ->type('text')
                ->title('Slug (EN)')
                ->placeholder('e.g. about-us')
                ->help('Latin letters, digits, hyphen. Leave empty to generate automatically. Section/list-pages usually have no slug.'),

            Input::make('page.title_en')
                ->type('text')
                ->title('Title (EN)')
                ->help('English page title used in the header and search engines.'),

            TextArea::make('page.description_en')
                ->title('Description (EN)')
                ->rows(3)
                ->help('Page subtitle in English, shown below the title (e.g. on section pages).'),
        ];
    }
}