<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Application;

use App\Models\Application;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ApplicationListLayout extends Table
{
    public $target = 'applications';

    public function columns(): array
    {
        return [
            TD::make('title_ru', __('Title (RU)'))
                ->sort()
                ->cantHide()
                ->render(fn (Application $app) => $app->title_ru),

            TD::make('slug_ru', __('Slug'))
                ->sort(),

            TD::make('sort', __('Sort'))
                ->sort()
                ->align(TD::ALIGN_RIGHT),

            TD::make('is_active', __('Active'))
                ->render(fn (Application $app) => $app->is_active ? 'Yes' : 'No')
                ->align(TD::ALIGN_CENTER),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Application $app) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.applications.edit', $app->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this application?'))
                            ->method('remove', ['id' => $app->id]),
                    ])),
        ];
    }
}
