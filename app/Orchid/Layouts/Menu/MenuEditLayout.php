<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Menu;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class MenuEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('menu.name')
                ->type('text')
                ->title('Название меню')
                ->help('Понятное название, отображается в админке. Обязательное поле.')
                ->required(),

            Input::make('menu.slug')
                ->type('text')
                ->title('Слаг')
                ->required()
                ->placeholder('например: main')
                ->help('Служебный идентификатор меню. Латиница и дефис. Используется в шаблоне сайта.'),
        ];
    }
}