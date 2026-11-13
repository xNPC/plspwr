<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\News;

use App\Models\Post;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostListLayout extends Table
{
    public $target = 'posts';

    public function columns(): array
    {
        return [
            TD::make('title_ru', __('Title (RU)'))
                ->sort()
                ->cantHide()
                ->render(fn (Post $post) => $post->title_ru),

            TD::make('category', __('Type'))
                ->sort()
                ->render(fn (Post $post) => $post->category === 'event' ? __('Event') : __('News')),

            TD::make('published_at', __('Published'))
                ->sort(),

            TD::make('is_active', __('Active'))
                ->render(fn (Post $post) => $post->is_active ? 'Yes' : 'No')
                ->align(TD::ALIGN_CENTER),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Post $post) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.content.news.edit', $post->id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this post?'))
                            ->method('remove', ['id' => $post->id]),
                    ])),
        ];
    }
}
