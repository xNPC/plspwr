<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ProductFamilyEditEnLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('family.slug_en')
                ->type('text')
                ->title('Slug (EN)')
                ->placeholder('e.g. m-series')
                ->help('Latin letters, digits, hyphen. Leave empty to generate automatically.'),

            Input::make('family.title_en')
                ->type('text')
                ->title('Title (EN)'),

            TextArea::make('family.intro_en')
                ->title('Intro (EN)')
                ->rows(3)
                ->help('Short summary for listings and the SEO description.'),

            Quill::make('family.description_en')
                ->title('Description (EN)')
                ->height('320px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Detailed description. WYSIWYG editor.'),
        ];
    }
}