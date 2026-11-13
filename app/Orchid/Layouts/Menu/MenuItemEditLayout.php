<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Menu;

use Orchid\Screen\Layouts\Tabs;

class MenuItemEditLayout extends Tabs
{
    public function __construct(protected ?int $menuId = null)
    {
        $this->layouts = [
            'Русский' => MenuItemEditRuLayout::class,
            'English' => MenuItemEditEnLayout::class,
            'Общие'   => new MenuItemEditCommonLayout($this->menuId),
        ];
    }
}