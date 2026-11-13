<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CaseStudy;
use App\Models\Page;
use App\Models\Post;
use App\Models\ProductFamily;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $page = Page::where('is_home', true)->first();

        if (! $page) {
            return $this->renderDefaultLanding();
        }

        $content = $page->blocks()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        $seo = $this->seoFor($page, ['title' => config('app.name')]);

        return view('pages.home', [
            'page' => $page,
            'content' => $content,
            'seo' => $seo,
            'products' => ProductFamily::where('is_active', true)->orderBy('sort')->get(),
            'applications' => Application::where('is_active', true)->orderBy('sort')->get(),
            'cases' => CaseStudy::where('is_active', true)->orderBy('sort')->get(),
            'posts' => Post::published()->orderByDesc('published_at')->limit(3)->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $slugField = 'slug_'.app()->getLocale();
        $fallbackField = 'slug_'.config('locale.default');

        $page = Page::where('is_active', true)
            ->where(function ($q) use ($slug, $slugField, $fallbackField) {
                $q->where($slugField, $slug)->orWhere($fallbackField, $slug);
            })
            ->firstOrFail();

        if ($page->is_home) {
            return $this->home();
        }

        $content = $page->blocks()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        $seo = $this->seoFor($page, ['title' => $page->title]);

        return view('pages.default', [
            'page' => $page,
            'content' => $content,
            'seo' => $seo,
            'products' => ProductFamily::where('is_active', true)->orderBy('sort')->get(),
            'applications' => Application::where('is_active', true)->orderBy('sort')->get(),
            'cases' => CaseStudy::where('is_active', true)->orderBy('sort')->get(),
            'posts' => Post::published()->orderByDesc('published_at')->limit(3)->get(),
        ]);
    }

    private function renderDefaultLanding(): View
    {
        return view('pages.default-landing', [
            'products' => ProductFamily::where('is_active', true)->orderBy('sort')->get(),
            'applications' => Application::where('is_active', true)->orderBy('sort')->get(),
            'cases' => CaseStudy::where('is_active', true)->orderBy('sort')->get(),
            'posts' => Post::published()->orderByDesc('published_at')->limit(3)->get(),
        ]);
    }
}
