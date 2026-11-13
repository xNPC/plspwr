<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Application;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Rows;

class ApplicationEditCommonLayout extends Rows
{
    public function fields(): array
    {
        return [
            Picture::make('application.image')
                ->title('Изображение')
                ->help('Фотография/иллюстрация области применения.'),

            Picture::make('application.icon')
                ->title('Иконка')
                ->help('Небольшая иконка, используется в списках.'),

            Input::make('application.sort')
                ->type('number')
                ->title('Порядок сортировки')
                ->value(0)
                ->help('Меньшее значение — выше в списке. Обычно 0.'),

            CheckBox::make('application.is_active')
                ->title('Активно')
                ->placeholder('Показывать на сайте')
                ->value(true)
                ->sendTrueOrFalse(),
        ];
    }
}