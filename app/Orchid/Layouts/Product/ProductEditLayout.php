<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Layouts\Tabs;

class ProductEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => ProductEditRuLayout::class,
            'English' => ProductEditEnLayout::class,
            'Общие'   => ProductEditCommonLayout::class,
            'Документы' => ProductEditDocumentsLayout::class,
        ];
    }
}