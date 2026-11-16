<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Setting;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
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

            Input::make('settings.contacts.telegram')
                ->type('text')
                ->title('Telegram')
                ->placeholder('https://t.me/username')
                ->help('Ссылка на профиль или канал в Telegram. Пустое поле — ссылка не показывается на сайте.'),

            Input::make('settings.contacts.whatsapp')
                ->type('text')
                ->title('WhatsApp')
                ->placeholder('https://wa.me/79000000000')
                ->help('Ссылка для чата в WhatsApp (wa.me). Пустое поле — ссылка не показывается на сайте.'),

            Input::make('settings.contacts.max')
                ->type('text')
                ->title('Max')
                ->placeholder('https://max.ru/...')
                ->help('Ссылка на профиль или чат в Max (можно скопировать из приложения «Поделиться»). Пустое поле — ссылка не показывается на сайте.'),

            TextArea::make('settings.leads.notify_emails')
                ->title('Получатели заявок')
                ->rows(3)
                ->placeholder("info@plspwr.ru\nsales@plspwr.ru")
                ->help('Куда отправлять уведомления о заявках с сайта. Можно указать несколько адресов — через запятую или по одному в строке. Если поле пустое, используется контактный e-mail выше.'),
        ];
    }
}
