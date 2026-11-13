<?php

declare(strict_types=1);

namespace App\Orchid\Screens\News;

use App\Models\Post;
use App\Orchid\Layouts\News\PostListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'posts' => Post::orderByDesc('published_at')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('News & Events');
    }

    public function description(): ?string
    {
        return __('Manage news posts and events.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.news'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('bs.plus-circle')
                ->route('platform.content.news.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            PostListLayout::class,
        ];
    }

    public function remove(int $id): RedirectResponse
    {
        Post::findOrFail($id)->delete();

        Toast::info(__('Post was removed.'));

        return redirect()->route('platform.content.news');
    }
}
