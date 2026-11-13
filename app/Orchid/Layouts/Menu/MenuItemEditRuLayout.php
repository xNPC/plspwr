<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Menu;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class MenuItemEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('item.label_ru')
                ->type('text')
                ->title('Название (рус.)')
                ->placeholder('например: О компании')
                ->help('Текст пункта меню на русском языке. Обязательное поле.')
                ->required(),
        ];
    }
}