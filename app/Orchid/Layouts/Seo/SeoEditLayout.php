<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Seo;

use Orchid\Screen\Layouts\Tabs;

class SeoEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => SeoEditRuLayout::class,
            'English' => SeoEditEnLayout::class,
            'Общие'   => SeoEditCommonLayout::class,
        ];
    }
}