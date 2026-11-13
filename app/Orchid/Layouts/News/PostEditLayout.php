<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\News;

use Orchid\Screen\Layouts\Tabs;

class PostEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => PostEditRuLayout::class,
            'English' => PostEditEnLayout::class,
            'Общие'   => PostEditCommonLayout::class,
        ];
    }
}