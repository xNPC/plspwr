<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Setting;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class SettingEditEnLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('settings.brand.tagline_en')
                ->type('text')
                ->title('Brand tagline (EN)')
                ->help('Short tagline shown in the header and footer on the English site.'),

            TextArea::make('settings.contacts.address_en')
                ->title('Address (EN)')
                ->rows(2)
                ->placeholder('129281, Moscow, Promyshlennaya str., 1')
                ->help('Registered/physical address (EN).'),

            Input::make('settings.contacts.work_hours_en')
                ->type('text')
                ->title('Working hours (EN)')
                ->placeholder('Mon–Fri, 9:00–18:00')
                ->help('Company working hours (EN).'),
        ];
    }
}