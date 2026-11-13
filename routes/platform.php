<?php

declare(strict_types=1);

use App\Orchid\Screens\Lead\LeadListScreen;
use App\Orchid\Screens\Menu\MenuEditScreen;
use App\Orchid\Screens\Menu\MenuItemEditScreen;
use App\Orchid\Screens\Menu\MenuListScreen;
use App\Orchid\Screens\News\PostEditScreen;
use App\Orchid\Screens\News\PostListScreen;
use App\Orchid\Screens\Page\BlockEditScreen;
use App\Orchid\Screens\Page\PageEditScreen;
use App\Orchid\Screens\Page\PageListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Product\ProductEditScreen;
use App\Orchid\Screens\Product\ProductFamilyEditScreen;
use App\Orchid\Screens\Product\ProductFamilyListScreen;
use App\Orchid\Screens\Product\ProductListScreen;
use App\Orchid\Screens\CaseStudy\CaseStudyEditScreen;
use App\Orchid\Screens\CaseStudy\CaseStudyListScreen;
use App\Orchid\Screens\Application\ApplicationEditScreen;
use App\Orchid\Screens\Application\ApplicationListScreen;
use App\Orchid\Screens\Setting\SettingsScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Content > Pages
Route::screen('content/pages', PageListScreen::class)
    ->name('platform.content.pages')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Pages'), route('platform.content.pages')));

Route::screen('content/pages/create', PageEditScreen::class)
    ->name('platform.content.pages.create');

Route::screen('content/pages/{page}/edit', PageEditScreen::class)
    ->name('platform.content.pages.edit');

Route::screen('content/pages/{page}/blocks/create', BlockEditScreen::class)
    ->name('platform.content.pages.blocks.create');

Route::screen('content/blocks/{block}/edit', BlockEditScreen::class)
    ->name('platform.content.blocks.edit');

// Platform > Content > News & Events
Route::screen('content/news', PostListScreen::class)
    ->name('platform.content.news')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('News & Events'), route('platform.content.news')));

Route::screen('content/news/create', PostEditScreen::class)
    ->name('platform.content.news.create');

Route::screen('content/news/{post}/edit', PostEditScreen::class)
    ->name('platform.content.news.edit');

// Platform > Content > Cases
Route::screen('content/cases', CaseStudyListScreen::class)
    ->name('platform.content.cases')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Cases'), route('platform.content.cases')));

Route::screen('content/cases/create', CaseStudyEditScreen::class)
    ->name('platform.content.cases.create');

Route::screen('content/cases/{case}/edit', CaseStudyEditScreen::class)
    ->name('platform.content.cases.edit');

// Platform > Content > Applications
Route::screen('content/applications', ApplicationListScreen::class)
    ->name('platform.content.applications')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Applications'), route('platform.content.applications')));

Route::screen('content/applications/create', ApplicationEditScreen::class)
    ->name('platform.content.applications.create');

Route::screen('content/applications/{application}/edit', ApplicationEditScreen::class)
    ->name('platform.content.applications.edit');

// Platform > Content > Product families
Route::screen('content/product-families', ProductFamilyListScreen::class)
    ->name('platform.content.product-families')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Product Families'), route('platform.content.product-families')));

Route::screen('content/product-families/create', ProductFamilyEditScreen::class)
    ->name('platform.content.product-families.create');

Route::screen('content/product-families/{family}/edit', ProductFamilyEditScreen::class)
    ->name('platform.content.product-families.edit');

// Platform > Content > Products
Route::screen('content/products', ProductListScreen::class)
    ->name('platform.content.products')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Products'), route('platform.content.products')));

Route::screen('content/products/create', ProductEditScreen::class)
    ->name('platform.content.products.create');

Route::screen('content/products/{product}/edit', ProductEditScreen::class)
    ->name('platform.content.products.edit');

// Platform > Content > Menus
Route::screen('content/menus', MenuListScreen::class)
    ->name('platform.content.menus')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Menus'), route('platform.content.menus')));

Route::screen('content/menus/create', MenuEditScreen::class)
    ->name('platform.content.menus.create');

Route::screen('content/menus/{menu}/edit', MenuEditScreen::class)
    ->name('platform.content.menus.edit');

Route::screen('content/menus/{menu}/items/create', MenuItemEditScreen::class)
    ->name('platform.content.menus.items.create');

Route::screen('content/menus/items/{item}/edit', MenuItemEditScreen::class)
    ->name('platform.content.menus.items.edit');

// Platform > Content > Leads
Route::screen('content/leads', LeadListScreen::class)
    ->name('platform.content.leads')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Leads'), route('platform.content.leads')));

// Platform > Content > Settings
Route::screen('content/settings', SettingsScreen::class)
    ->name('platform.content.settings')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Settings'), route('platform.content.settings')));

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));
// Route::screen('idea', Idea::class, 'platform.screens.idea');
