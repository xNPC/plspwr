<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Menu;

use App\Models\MenuItem;
use App\Models\Page;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class MenuItemEditCommonLayout extends Rows
{
    public function __construct(protected ?int $menuId = null)
    {
    }

    public function fields(): array
    {
        return [
            Select::make('item.type')
                ->options([
                    'link' => 'Ссылка (URL)',
                    'route' => 'Маршрут',
                    'page' => 'Страница',
                ])
                ->title('Тип')
                ->help('Чем является пункт меню: прямая ссылка, именованный маршрут или страница сайта.')
                ->required()
                ->value('link'),

            Select::make('item.parent_id')
                ->fromQuery(
                    MenuItem::query()->when($this->menuId, fn ($query) => $query->where('menu_id', $this->menuId)),
                    'label_ru'
                )
                ->empty('Нет (верхний уровень)')
                ->title('Родительский пункт')
                ->help('Если указать — пункт станет вложенным.'),

            Select::make('item.page_id')
                ->fromModel(Page::class, 'title_ru')
                ->empty('Не привязано')
                ->title('Страница')
                ->help('Страница сайта, на которую ведёт пункт (для типа «Страница»).'),

            Input::make('item.route_name')
                ->type('text')
                ->title('Маршрут')
                ->placeholder('напр.: products.index')
                ->help('Имя маршрута (для типа «Маршрут»).'),

            Input::make('item.url')
                ->type('text')
                ->title('URL')
                ->placeholder('/products')
                ->help('Адрес ссылки (для типа «Ссылка»).'),

            Input::make('item.sort')
                ->type('number')
                ->title('Порядок сортировки')
                ->value(0)
                ->help('Меньшее значение — выше в списке. Обычно 0.'),

            CheckBox::make('item.is_active')
                ->title('Активно')
                ->placeholder('Показывать пункт в меню')
                ->value(true)
                ->sendTrueOrFalse(),
        ];
    }
}