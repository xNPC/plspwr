<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\ProductFamily;
use App\Orchid\Layouts\Product\ProductFamilyListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductFamilyListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'families' => ProductFamily::orderBy('sort')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Product Families');
    }

    public function description(): ?string
    {
        return __('Manage product families (catalog sections).');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.products'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('bs.plus-circle')
                ->route('platform.content.product-families.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            ProductFamilyListLayout::class,
        ];
    }

    public function remove(int $id): RedirectResponse
    {
        ProductFamily::findOrFail($id)->delete();

        Toast::info(__('Product family was removed.'));

        return redirect()->route('platform.content.product-families');
    }
}
