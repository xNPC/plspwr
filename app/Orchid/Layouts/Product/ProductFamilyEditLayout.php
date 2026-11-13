<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Layouts\Tabs;

class ProductFamilyEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => ProductFamilyEditRuLayout::class,
            'English' => ProductFamilyEditEnLayout::class,
            'Общие'   => ProductFamilyEditCommonLayout::class,
        ];
    }
}