<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Setting;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class SettingEditCommonLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('settings.contacts.phone')
                ->type('text')
                ->title('Телефон')
                ->placeholder('+7 (3822) 99 99 99')
                ->help('Контактный телефон компании.'),

            Input::make('settings.contacts.email')
                ->type('text')
                ->title('Email')
                ->placeholder('info@plspwr.ru')
                ->help('Контактный e-mail.'),
        ];
    }
}