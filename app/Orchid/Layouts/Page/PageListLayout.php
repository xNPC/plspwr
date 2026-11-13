<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use App\Models\Page;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PageListLayout extends Table
{
    public $target = 'pages';

    public function columns(): array
    {
        return [
            TD::make('title_ru', __('Title (RU)'))
                ->sort()
                ->cantHide()
                ->render(fn (Page $page) => $page->title_ru),

            TD::make('slug_ru', __('Slug'))
                ->sort()
                ->render(fn (Page $page) => $page->is_home ? '(home)' : $page->slug_ru),

            TD::make('template', __('Template'))
                ->sort(),

            TD::make('is_active', __('Active'))
                ->render(fn (Page $page) => $page->is_active ? 'Yes' : 'No')
                ->align(TD::ALIGN_CENTER),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Page $page) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.pages.edit', $page->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this page?'))
                            ->method('remove', ['id' => $page->id]),
                    ])),
        ];
    }
}
