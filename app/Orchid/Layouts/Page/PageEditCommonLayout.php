<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class PageEditCommonLayout extends Rows
{
    public function fields(): array
    {
        return [
            Picture::make('page.banner_image')
                ->title('Баннер страницы')
                ->help('Широкое фото 1920×800 (21:9). Показывается на всю ширину под шапкой, заголовок и описание выводятся поверх него. Если баннер не задан — используется обычная градиентная шапка.'),

            Select::make('page.template')
                ->options([
                    'default' => __('Default'),
                    'landing' => __('Landing'),
                    'home' => __('Home'),
                ])
                ->title('Шаблон')
                ->help('Внешний вид страницы. Обычно «Default».'),

            Select::make('page.section')
                ->options([
                    'products' => __('Products'),
                    'applications' => __('Applications'),
                    'cases' => __('Case studies'),
                    'contacts' => __('Contacts'),
                ])
                ->empty('—')
                ->title('Раздел сайта')
                ->help('Если страница обслуживает фиксированный раздел (каталог, контакты и т.п.), укажите раздел. Для обычных CMS-страниц оставьте пустым.'),

            CheckBox::make('page.is_active')
                ->title('Активно')
                ->placeholder('Показывать страницу на сайте')
                ->value(true)
                ->sendTrueOrFalse(),

            CheckBox::make('page.is_home')
                ->title('Главная страница')
                ->placeholder('Страница, открывающаяся при входе на сайт')
                ->sendTrueOrFalse(),
        ];
    }
}