<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\CaseStudy;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class CaseStudyEditEnLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('case.slug_en')
                ->type('text')
                ->title('Slug (EN)')
                ->placeholder('e.g. amplifier-block')
                ->help('Latin letters, digits, hyphen. Leave empty to generate automatically.'),

            Input::make('case.title_en')
                ->type('text')
                ->title('Title (EN)'),

            TextArea::make('case.intro_en')
                ->title('Intro (EN)')
                ->rows(3)
                ->help('Short summary for listings and the SEO description.'),

            Quill::make('case.body_en')
                ->title('Body (EN)')
                ->height('400px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Full case study text. WYSIWYG editor.'),
        ];
    }
}