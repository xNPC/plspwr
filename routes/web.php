<?php

declare(strict_types=1);

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Locale is resolved per-request by the global SetLocaleFromDomain middleware:
//   - path prefix first (dev fallback, e.g. /en), which is stripped before routing
//   - then the host (production separate domains)
// Routes below are the single canonical set with clean names.

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{family}', [ProductController::class, 'family'])->name('products.family');
Route::get('/products/{family}/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::get('/applications/{slug}', [ApplicationController::class, 'show'])->name('applications.show');

Route::get('/cases', [CaseStudyController::class, 'index'])->name('cases.index');
Route::get('/cases/{slug}', [CaseStudyController::class, 'show'])->name('cases.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/events', [NewsController::class, 'events'])->name('events.index');
Route::get('/events/{slug}', [NewsController::class, 'show'])->name('events.show');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

// Catch-all for flexible CMS pages must be LAST.
// The reserved /admin prefix is excluded so it falls through to the Orchid
// dashboard routes instead of being treated as a CMS page slug.
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show')
    ->where('slug', '^(?!admin(?:\/|$))[a-zA-Z0-9\-_/]+$');
