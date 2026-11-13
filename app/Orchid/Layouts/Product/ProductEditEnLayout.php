<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ProductEditEnLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('product.slug_en')
                ->type('text')
                ->title('Slug (EN)')
                ->placeholder('e.g. modulator-100')
                ->help('Latin letters, digits, hyphen. Leave empty to generate automatically.'),

            Input::make('product.title_en')
                ->type('text')
                ->title('Title (EN)'),

            TextArea::make('product.intro_en')
                ->title('Intro (EN)')
                ->rows(3)
                ->help('Short summary for listings and the SEO description.'),

            Quill::make('product.description_en')
                ->title('Description (EN)')
                ->height('320px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Detailed description. WYSIWYG editor — images are embedded as base64.'),

            Matrix::make('product.specifications_en_rows')
                ->columns(['Name' => 'name', 'Value' => 'value'])
                ->fields([
                    'name' => Input::make()->placeholder('Name'),
                    'value' => Input::make()->placeholder('Value'),
                ])
                ->addRowLabel('Add specification')
                ->title('Specifications (EN)')
                ->help('Each row is a parameter and its value in English. E.g.: Voltage = 10 kV.'),
        ];
    }
}