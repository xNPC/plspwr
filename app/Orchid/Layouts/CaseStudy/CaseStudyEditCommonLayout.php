<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\CaseStudy;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Rows;

class CaseStudyEditCommonLayout extends Rows
{
    public function fields(): array
    {
        return [
            Picture::make('case.image')
                ->title('Изображение')
                ->help('Фотография/иллюстрация кейса.'),

            Input::make('case.sort')
                ->type('number')
                ->title('Порядок сортировки')
                ->value(0)
                ->help('Меньшее значение — выше в списке. Обычно 0.'),

            CheckBox::make('case.is_active')
                ->title('Активно')
                ->placeholder('Показывать кейс на сайте')
                ->value(true)
                ->sendTrueOrFalse(),

            CheckBox::make('case.is_featured')
                ->title('Избранный')
                ->placeholder('Показывать в блоке избранного на главной')
                ->sendTrueOrFalse(),
        ];
    }
}