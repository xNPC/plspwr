<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Page;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $applications = Application::where('is_active', true)->orderBy('sort')->get();

        return view('pages.applications', [
            'applications' => $applications,
            'page' => Page::where('section', 'applications')->first(),
            'seo' => $this->seoFor(null, ['title' => __('Applications')]),
        ]);
    }

    public function show(string $slug): View
    {
        $slugField = 'slug_'.app()->getLocale();
        $fallbackField = 'slug_'.config('locale.default');

        $application = Application::where('is_active', true)
            ->where(function ($q) use ($slug, $slugField, $fallbackField) {
                $q->where($slugField, $slug)->orWhere($fallbackField, $slug);
            })
            ->firstOrFail();

        return view('pages.application', [
            'application' => $application,
            'seo' => $this->seoFor($application, ['title' => $application->title]),
        ]);
    }
}
