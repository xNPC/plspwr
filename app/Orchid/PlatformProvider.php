<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Lead;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make(__('Dashboard'))
                ->icon('bs.house')
                ->route(config('platform.index')),

            Menu::make(__('Pages'))
                ->icon('bs.files')
                ->route('platform.content.pages')
                ->permission('platform.content.pages')
                ->title(__('Content')),

            Menu::make(__('News & Events'))
                ->icon('bs.newspaper')
                ->route('platform.content.news')
                ->permission('platform.content.news'),

            Menu::make(__('Cases'))
                ->icon('bs.briefcase')
                ->route('platform.content.cases')
                ->permission('platform.content.cases'),

            Menu::make(__('Applications'))
                ->icon('bs.grid')
                ->route('platform.content.applications')
                ->permission('platform.content.applications'),

            Menu::make(__('Product Families'))
                ->icon('bs.collection')
                ->route('platform.content.product-families')
                ->permission('platform.content.products')
                ->title(__('Catalog')),

            Menu::make(__('Products'))
                ->icon('bs.box')
                ->route('platform.content.products')
                ->permission('platform.content.products'),

            Menu::make(__('Menu'))
                ->icon('bs.list-ul')
                ->route('platform.content.menus')
                ->permission('platform.content.menus')
                ->title(__('Structure')),

            Menu::make(__('Leads'))
                ->icon('bs.inbox')
                ->route('platform.content.leads')
                ->permission('platform.content.leads')
                ->badge(fn () => Lead::where('is_read', false)->count())
                ->title(__('Inbox')),

            Menu::make(__('Settings'))
                ->icon('bs.gear')
                ->route('platform.content.settings')
                ->permission('platform.content.settings')
                ->title(__('Configuration')),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            ItemPermission::group(__('Content'))
                ->addPermission('platform.content.pages', __('Pages'))
                ->addPermission('platform.content.news', __('News & Events'))
                ->addPermission('platform.content.cases', __('Cases'))
                ->addPermission('platform.content.applications', __('Applications'))
                ->addPermission('platform.content.products', __('Catalog'))
                ->addPermission('platform.content.menus', __('Menu'))
                ->addPermission('platform.content.leads', __('Leads'))
                ->addPermission('platform.content.settings', __('Settings')),
        ];
    }
}
