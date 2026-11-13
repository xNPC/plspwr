<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use App\Models\Block;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PageBlocksLayout extends Table
{
    public $target = 'blocks';

    public function columns(): array
    {
        return [
            TD::make('type', __('Type'))
                ->sort()
                ->cantHide()
                ->render(fn (Block $block) => $block->typeLabel()),

            TD::make('content', __('Content'))
                ->render(fn (Block $block) => $block->summary()),

            TD::make('sort', __('Sort'))
                ->sort()
                ->align(TD::ALIGN_RIGHT),

            TD::make('is_active', __('Active'))
                ->render(fn (Block $block) => $block->is_active ? __('Yes') : __('No'))
                ->align(TD::ALIGN_CENTER),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Block $block) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.blocks.edit', $block->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this block?'))
                            ->method('removeBlock', [
                                'id' => $block->id,
                            ]),
                    ])),
        ];
    }
}
