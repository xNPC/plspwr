<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class BlockEditCommonLayout extends Rows
{
    use BlockEditFields;

    public function fields(): array
    {
        $fields = [
            Select::make('block.type')
                ->options($this->types())
                ->title('Тип блока')
                ->help('Тип блока определяет, как он отображается на странице.')
                ->required(),

            $this->row(Input::make('block.content_primary_url')->title('Основная кнопка — адрес'), ['hero', 'cta']),
            $this->row(Input::make('block.content_secondary_url')->title('Вторичная кнопка — адрес'), ['hero', 'cta']),
            $this->row(Input::make('block.content_link_url')->title('Ссылка 1 — адрес'), ['intro', 'technology']),
            $this->row(Input::make('block.content_link2_url')->title('Ссылка 2 — адрес'), ['intro', 'technology']),

            $this->row(Picture::make('block.content_image')->title('Изображение'), ['intro', 'technology', 'media']),
            $this->row(Select::make('block.content_side')->options(['right' => 'Справа', 'left' => 'Слева'])->title('Положение изображения'), ['media']),
            $this->row(Select::make('block.content_align')->options(['left' => 'Слева', 'center' => 'По центру'])->title('Выравнивание'), ['text']),
            $this->row(Select::make('block.content_max_width')->options(['prose' => 'Стандарт', 'narrow' => 'Узкий', 'wide' => 'Широкий'])->title('Ширина'), ['text']),
            $this->row(Select::make('block.content_columns')->options([2 => '2', 3 => '3', 4 => '4'])->title('Колонки'), ['features']),

            Input::make('block.sort')
                ->type('number')
                ->title('Порядок сортировки')
                ->value(0)
                ->help('Порядок вывода блоков на странице. Меньшее значение — выше.'),

            CheckBox::make('block.is_active')
                ->title('Активно')
                ->placeholder('Показывать блок на странице')
                ->value(true)
                ->sendTrueOrFalse(),
        ];

        return array_values(array_filter($fields));
    }
}