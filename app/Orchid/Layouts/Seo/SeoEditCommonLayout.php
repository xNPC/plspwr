<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Seo;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Rows;

class SeoEditCommonLayout extends Rows
{
    public function fields(): array
    {
        return [
            Picture::make('seo.og_image')
                ->title('Изображение для соцсетей (OG)')
                ->help('Рекомендуемый размер 1200×630. Используется при публикации ссылки в соцсетях/мессенджерах.'),

            Input::make('seo.robots')
                ->type('text')
                ->title('Robots')
                ->placeholder('index, follow')
                ->help('Директива для поисковых роботов. Если пусто — index, follow.'),

            CheckBox::make('seo.noindex')
                ->title('Запретить индексацию')
                ->placeholder('Закрыть страницу от поисковых систем')
                ->sendTrueOrFalse(),
        ];
    }
}