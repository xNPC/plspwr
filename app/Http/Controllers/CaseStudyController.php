<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Page;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    public function index(): View
    {
        $cases = CaseStudy::where('is_active', true)->orderBy('is_featured', 'desc')->orderBy('sort')->get();

        return view('pages.cases', [
            'cases' => $cases,
            'page' => Page::where('section', 'cases')->first(),
            'seo' => $this->seoFor(null, ['title' => __('Case Studies')]),
        ]);
    }

    public function show(string $slug): View
    {
        $slugField = 'slug_'.app()->getLocale();
        $fallbackField = 'slug_'.config('locale.default');

        $case = CaseStudy::where('is_active', true)
            ->where(function ($q) use ($slug, $slugField, $fallbackField) {
                $q->where($slugField, $slug)->orWhere($fallbackField, $slug);
            })
            ->firstOrFail();

        return view('pages.case', [
            'case' => $case,
            'seo' => $this->seoFor($case, ['title' => $case->title]),
        ]);
    }
}
