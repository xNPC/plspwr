<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Layouts\Tabs;

class BlockEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => BlockEditRuLayout::class,
            'English' => BlockEditEnLayout::class,
            'Общие'   => BlockEditCommonLayout::class,
        ];
    }
}