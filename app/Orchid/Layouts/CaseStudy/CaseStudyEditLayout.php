<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\CaseStudy;

use Orchid\Screen\Layouts\Tabs;

class CaseStudyEditLayout extends Tabs
{
    public function __construct()
    {
        $this->layouts = [
            'Русский' => CaseStudyEditRuLayout::class,
            'English' => CaseStudyEditEnLayout::class,
            'Общие'   => CaseStudyEditCommonLayout::class,
        ];
    }
}