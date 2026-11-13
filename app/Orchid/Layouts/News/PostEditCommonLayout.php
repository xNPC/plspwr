<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\News;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class PostEditCommonLayout extends Rows
{
    public function fields(): array
    {
        return [
            Select::make('post.category')
                ->options([
                    'news' => __('News'),
                    'event' => __('Event'),
                ])
                ->title('Тип записи')
                ->help('Новость или анонс события. Обязательное поле.')
                ->required(),

            Picture::make('post.image')
                ->title('Изображение')
                ->help('Иллюстрация к новости.'),

            DateTimer::make('post.published_at')
                ->title('Дата публикации')
                ->enableTime()
                ->help('Если не указано — будет установлена сейчас.'),

            CheckBox::make('post.is_active')
                ->title('Активно')
                ->placeholder('Показывать запись на сайте')
                ->value(true)
                ->sendTrueOrFalse(),
        ];
    }
}