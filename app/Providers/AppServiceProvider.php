<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Menu;
use App\Services\SeoPresenter;
use App\Services\SiteSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SiteSettings::class);
    }

    public function boot(): void
    {
        Paginator::useTailwind();
        View::composer('*', function ($view) {
            $settings = app(SiteSettings::class);

            $view->with('siteSettings', $settings);
            $view->with('siteMenu', Menu::where('slug', 'main')
                ->with([
                    'items' => fn ($q) => $q->where('is_active', true),
                    'items.children' => fn ($q) => $q->where('is_active', true),
                ])
                ->first());
            $view->with('currentLocale', app()->getLocale());

            if (! ($view->offsetExists('seo') && $view->offsetGet('seo'))) {
                $view->with('seo', app()->has(SeoPresenter::class)
                    ? app(SeoPresenter::class)
                    : new SeoPresenter(null, ['title' => config('app.name')]));
            }
        });
    }
}
