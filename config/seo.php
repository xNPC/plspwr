<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SEO defaults
    |--------------------------------------------------------------------------
    | Locale-aware fallbacks used when a page/model has no explicit SEO metadata.
    | Real production copy replaces these once the imp-tech.ru content is wired in.
    */

    /*
    |--------------------------------------------------------------------------
    | Search engine indexing
    |--------------------------------------------------------------------------
    | Master switch for search engines. While the site is being filled with
    | content it should stay off: robots.txt disables crawling and every page
    | gets a "noindex, nofollow" meta tag. Set SEO_INDEXABLE=true (and run
    | `php artisan config:clear`) when the site is ready to be indexed.
    */

    'indexable' => env('SEO_INDEXABLE', false),

    'defaults' => [
        'ru' => [
            'title' => 'НПП «Импульсные технологии» — высоковольтные импульсные модуляторы',
            'description' => 'Производство высоковольтных импульсных модуляторов и систем импульсной энергетики для науки, медицины и промышленности. Более 40 лет в импульсной технике.',
        ],
        'en' => [
            'title' => 'NPP "Impulse Technologies" — High-Voltage Pulse Modulators',
            'description' => 'Manufacturer of high-voltage pulse modulators and pulsed-power systems for science, medicine and industry. Over 40 years in pulsed-power technology.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Open Graph image
    |--------------------------------------------------------------------------
    | Used when a page/model carries no own og:image / picture.
    */

    'og_image' => '/og-default.png',

];