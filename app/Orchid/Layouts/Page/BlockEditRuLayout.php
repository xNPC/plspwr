<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Layouts\Rows;

class BlockEditRuLayout extends Rows
{
    use BlockEditFields;

    public function fields(): array
    {
        return array_values(array_filter(
            array_merge(
                $this->localeTextFields('ru'),
                $this->localeGroupFields('ru')
            )
        ));
    }
}