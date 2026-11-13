<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    | List of locales the site supports. The first entry is treated as default.
    | Each locale has a human-readable name used in the UI language switcher.
    */

    'available' => [
        'ru' => 'Русский',
        'en' => 'English',
    ],

    'default' => env('APP_DEFAULT_LOCALE', 'ru'),

    /*
    |--------------------------------------------------------------------------
    | Locale domains
    |--------------------------------------------------------------------------
    | Each locale may be bound to its own domain. The value may be empty,
    | in which case routing falls back to the locale path prefix /{locale}.
    |
    | Example:
    |   'domains' => ['ru' => 'imp-tech.ru', 'en' => 'imp-tech.com']
    */

    'domains' => [
        'ru' => env('APP_LOCALE_DOMAIN_RU', ''),
        'en' => env('APP_LOCALE_DOMAIN_EN', ''),
    ],

    /* URL scheme used when building absolute sitemap/robots URLs. */
    'scheme' => env('APP_URL_SCHEME', 'https'),

];
