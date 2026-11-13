<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\ProductFamily;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Attachment\Models\Attachment;

class ProductController extends Controller
{
    public function index(): View
    {
        $families = ProductFamily::where('is_active', true)->orderBy('sort')->get();

        return view('pages.catalog', [
            'families' => $families,
            'page' => Page::where('section', 'products')->first(),
            'seo' => $this->seoFor(null, [
                'title' => __('Products'),
            ]),
        ]);
    }

    public function family(string $family): View
    {
        $familyModel = $this->findBySlug(ProductFamily::where('is_active', true), $family);

        $products = $familyModel->products()->where('is_active', true)->get();

        return view('pages.family', [
            'family' => $familyModel,
            'products' => $products,
            'seo' => $this->seoFor($familyModel, ['title' => $familyModel->title]),
        ]);
    }

    public function show(string $family, string $product): View
    {
        $familyModel = $this->findBySlug(ProductFamily::where('is_active', true), $family);

        $productModel = $this->findBySlug(
            $familyModel->products()->where('is_active', true),
            $product
        );

        return view('pages.product', [
            'product' => $productModel,
            'family' => $familyModel,
            'documents' => $this->resolveDocuments($productModel->documents),
            'seo' => $this->seoFor($productModel, ['title' => $productModel->title]),
        ]);
    }

    /**
     * Resolve stored attachment IDs into Attachment models, preserving upload order.
     *
     * @return Collection<int, Attachment>
     */
    private function resolveDocuments(mixed $ids): Collection
    {
        $ids = array_values(array_filter(
            is_array($ids) ? $ids : [],
            fn ($id) => $id !== null && $id !== ''
        ));

        if ($ids === []) {
            return collect();
        }

        $byId = Attachment::whereIn('id', $ids)->get()->keyBy('id');

        return collect($ids)
            ->map(fn ($id) => $byId->get((int) $id))
            ->filter()
            ->values();
    }

    private function findBySlug($query, string $slug)
    {
        $slugField = 'slug_'.app()->getLocale();
        $fallbackField = 'slug_'.config('locale.default');

        return $query
            ->where(function ($q) use ($slug, $slugField, $fallbackField) {
                $q->where($slugField, $slug)->orWhere($fallbackField, $slug);
            })
            ->firstOrFail();
    }
}
