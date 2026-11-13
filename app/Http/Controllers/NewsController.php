<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $posts = Post::ofCategory('news')->published()->orderByDesc('published_at')->paginate(9);

        return view('pages.news', [
            'posts' => $posts,
            'category' => 'news',
            'page' => Page::where('section', 'news')->where('is_active', true)->first(),
            'seo' => $this->seoFor(null, ['title' => __('News')]),
        ]);
    }

    public function events(): View
    {
        $posts = Post::ofCategory('event')->published()->orderByDesc('published_at')->paginate(9);

        return view('pages.news', [
            'posts' => $posts,
            'category' => 'event',
            'page' => Page::where('section', 'news')->where('is_active', true)->first(),
            'seo' => $this->seoFor(null, ['title' => __('Events')]),
        ]);
    }

    public function show(string $slug): View
    {
        $slugField = 'slug_'.app()->getLocale();
        $fallbackField = 'slug_'.config('locale.default');

        $post = Post::published()
            ->where(function ($q) use ($slug, $slugField, $fallbackField) {
                $q->where($slugField, $slug)->orWhere($fallbackField, $slug);
            })
            ->firstOrFail();

        return view('pages.post', [
            'post' => $post,
            'seo' => $this->seoFor($post, ['title' => $post->title]),
        ]);
    }
}
