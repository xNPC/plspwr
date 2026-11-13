<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Menu;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class MenuItemEditEnLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('item.label_en')
                ->type('text')
                ->title('Label (EN)')
                ->placeholder('e.g. About us')
                ->help('Menu item text in English. If empty, the Russian label is used.'),
        ];
    }
}