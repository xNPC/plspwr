<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Setting;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class SettingEditRuLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('settings.brand.tagline_ru')
                ->type('text')
                ->title('Слоган бренда (рус.)')
                ->help('Короткий слоган, отображается в шапке и подвале сайта на русском.'),

            TextArea::make('settings.contacts.address_ru')
                ->title('Адрес (рус.)')
                ->rows(2)
                ->placeholder('129281, Москва, ул. Промышленная, д. 1')
                ->help('Юридический/фактический адрес (рус.).'),

            Input::make('settings.contacts.work_hours_ru')
                ->type('text')
                ->title('Часы работы (рус.)')
                ->placeholder('Пн–Пт, 9:00–18:00')
                ->help('Режим работы компании (рус.).'),
        ];
    }
}