<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Seo;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class SeoEditEnLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('seo.title_en')
                ->type('text')
                ->title('SEO Title (EN)')
                ->help('Search engine title. If empty, falls back to the page title.'),

            TextArea::make('seo.description_en')
                ->title('SEO Description (EN)')
                ->rows(3)
                ->help('Search engine description, ideally 120–160 chars. If empty, falls back to the intro.'),

            Input::make('seo.keywords_en')
                ->type('text')
                ->title('Keywords (EN)')
                ->placeholder('keyword, another keyword')
                ->help('Optional. Ignored by Google and Yandex.'),

            Input::make('seo.canonical_en')
                ->type('text')
                ->title('Canonical URL (EN)')
                ->placeholder('https://imp-tech.com/...')
                ->help('Canonical page URL. If empty, derived from the route.'),
        ];
    }
}