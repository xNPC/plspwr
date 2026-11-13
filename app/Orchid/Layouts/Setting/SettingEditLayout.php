<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Setting;

use Orchid\Screen\Layouts\Tabs;

class SettingEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => SettingEditRuLayout::class,
            'English' => SettingEditEnLayout::class,
            'Общие'   => SettingEditCommonLayout::class,
        ];
    }
}