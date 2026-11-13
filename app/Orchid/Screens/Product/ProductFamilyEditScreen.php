<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\ProductFamily;
use App\Orchid\Layouts\Product\ProductFamilyEditLayout;
use App\Orchid\Layouts\Seo\SeoEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductFamilyEditScreen extends Screen
{
    /**
     * @var ProductFamily
     */
    public $family;

    public function query(ProductFamily $family): iterable
    {
        $family->load('seo');

        return [
            'family' => $family,
            'seo' => $family->seo,
        ];
    }

    public function name(): ?string
    {
        return $this->family->exists ? __('Edit Product Family') : __('Create Product Family');
    }

    public function description(): ?string
    {
        return $this->family->exists ? $this->family->title_ru : __('Add a new product family.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.products'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Delete this product family?'))
                ->method('remove')
                ->canSee($this->family->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(ProductFamilyEditLayout::class)
                ->title(__('Product Family'))
                ->description(__('Localized fields for this family.')),

            Layout::block(SeoEditLayout::class)
                ->title(__('SEO'))
                ->description(__('Search engine metadata (optional).')),
        ];
    }

    public function save(ProductFamily $family, Request $request): RedirectResponse
    {
        $data = $request->collect('family')->toArray();
        $data['image'] = $this->normalizeImage($data['image'] ?? null);

        $family->fill($data)->save();

        $seoData = $request->collect('seo')->toArray();
        if (! empty($seoData['title_ru']) || ! empty($seoData['title_en']) || ! empty($seoData['description_ru'])) {
            $family->seo()->updateOrCreate([], $seoData);
        }

        Toast::info(__('Product family was saved.'));

        return redirect()->route('platform.content.product-families.edit', $family->id);
    }

    public function remove(ProductFamily $family): RedirectResponse
    {
        $family->delete();

        Toast::info(__('Product family was removed.'));

        return redirect()->route('platform.content.product-families');
    }

    private function normalizeImage(mixed $value): ?string
    {
        $first = null;

        if (is_array($value)) {
            $flat = array_values(array_filter($value, fn ($item) => is_string($item) && trim($item) !== ''));
            $first = $flat[0] ?? null;
        } elseif (is_string($value) && trim($value) !== '') {
            $decoded = json_decode($value, true);

            if (is_array($decoded)) {
                $flat = array_values(array_filter($decoded, fn ($item) => is_string($item) && trim($item) !== ''));
                $first = $flat[0] ?? null;
            } else {
                $first = $value;
            }
        }

        return $first !== null ? (string) $first : null;
    }
}
