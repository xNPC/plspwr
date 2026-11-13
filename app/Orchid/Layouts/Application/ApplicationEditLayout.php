<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Application;

use Orchid\Screen\Layouts\Tabs;

class ApplicationEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => ApplicationEditRuLayout::class,
            'English' => ApplicationEditEnLayout::class,
            'Общие'   => ApplicationEditCommonLayout::class,
        ];
    }
}