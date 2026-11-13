<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Orchid\Layouts\Product\ProductListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'products' => Product::with('family')->orderBy('sort')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Products');
    }

    public function description(): ?string
    {
        return __('Manage products within families.');
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
                ->route('platform.content.products.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            ProductListLayout::class,
        ];
    }

    public function remove(int $id): RedirectResponse
    {
        Product::findOrFail($id)->delete();

        Toast::info(__('Product was removed.'));

        return redirect()->route('platform.content.products');
    }
}
