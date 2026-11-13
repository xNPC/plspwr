<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Application;
use App\Models\CaseStudy;
use App\Models\Lead;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductFamily;
use App\Orchid\Layouts\Platform\RecentLeadsListLayout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'Pages'      => ['value' => Page::count()],
            'Products'   => ['value' => Product::count()],
            'Product Families' => ['value' => ProductFamily::count()],
            'News & Events' => ['value' => Post::count()],
            'Cases'      => ['value' => CaseStudy::count()],
            'Applications' => ['value' => Application::count()],
            'Leads'      => ['value' => Lead::count()],
            'Unread'     => ['value' => Lead::where('is_read', false)->count()],
            'recentLeads' => Lead::latest()->limit(5)->get(),
        ];
    }

    public function name(): ?string
    {
        return __('Dashboard');
    }

    public function description(): ?string
    {
        return __('Site content overview.');
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Pages' => 'Pages',
                'Products' => 'Products',
                'Product Families' => 'Product Families',
                'News & Events' => 'News & Events',
                'Cases' => 'Cases',
                'Applications' => 'Applications',
                'Leads' => 'Leads',
                'Unread' => 'Unread',
            ]),

            Layout::block(RecentLeadsListLayout::class)
                ->title(__('Recent leads'))
                ->description(__('Last received requests.')),
        ];
    }
}
