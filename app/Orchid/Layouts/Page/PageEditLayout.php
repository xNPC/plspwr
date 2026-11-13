<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Layouts\Tabs;

class PageEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => PageEditRuLayout::class,
            'English' => PageEditEnLayout::class,
            'Общие'   => PageEditCommonLayout::class,
        ];
    }
}