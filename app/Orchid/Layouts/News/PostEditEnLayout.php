<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\News;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PostEditEnLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('post.slug_en')
                ->type('text')
                ->title('Slug (EN)')
                ->placeholder('e.g. exhibition-recap')
                ->help('Latin letters, digits, hyphen. Leave empty to generate automatically.'),

            Input::make('post.title_en')
                ->type('text')
                ->title('Title (EN)'),

            TextArea::make('post.intro_en')
                ->title('Intro (EN)')
                ->rows(3)
                ->help('Short summary for listings and the SEO description.'),

            Quill::make('post.body_en')
                ->title('Body (EN)')
                ->height('400px')
                ->base64()
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format', 'media'])
                ->help('Full text of the post. WYSIWYG editor — images are embedded as base64.'),
        ];
    }
}