<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\CaseStudy;

use App\Models\CaseStudy;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CaseStudyListLayout extends Table
{
    public $target = 'cases';

    public function columns(): array
    {
        return [
            TD::make('title_ru', __('Title (RU)'))
                ->sort()
                ->cantHide()
                ->render(fn (CaseStudy $case) => $case->title_ru),

            TD::make('slug_ru', __('Slug'))
                ->sort(),

            TD::make('is_featured', __('Featured'))
                ->render(fn (CaseStudy $case) => $case->is_featured ? 'Yes' : 'No')
                ->align(TD::ALIGN_CENTER),

            TD::make('sort', __('Sort'))
                ->sort()
                ->align(TD::ALIGN_RIGHT),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (CaseStudy $case) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.cases.edit', $case->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this case?'))
                            ->method('remove', ['id' => $case->id]),
                    ])),
        ];
    }
}
