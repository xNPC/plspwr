<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Orchid\Layouts\Product\ProductEditLayout;
use App\Orchid\Layouts\Seo\SeoEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductEditScreen extends Screen
{
    /**
     * @var Product
     */
    public $product;

    public function query(Product $product): iterable
    {
        $product->load('seo');

        $specs = $this->decodeJson($product->specifications ?? []);
        $product->setAttribute('specifications_ru_rows', $this->specsToRows($specs, 'ru'));
        $product->setAttribute('specifications_en_rows', $this->specsToRows($specs, 'en'));

        return [
            'product' => $product,
            'seo' => $product->seo,
        ];
    }

    public function name(): ?string
    {
        return $this->product->exists ? __('Edit Product') : __('Create Product');
    }

    public function description(): ?string
    {
        return $this->product->exists ? $this->product->title_ru : __('Add a new product.');
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
                ->confirm(__('Delete this product?'))
                ->method('remove')
                ->canSee($this->product->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(ProductEditLayout::class)
                ->title(__('Product'))
                ->description(__('Localized fields for this product.')),

            Layout::block(SeoEditLayout::class)
                ->title(__('SEO'))
                ->description(__('Search engine metadata (optional).')),
        ];
    }

    public function save(Product $product, Request $request): RedirectResponse
    {
        $data = $request->collect('product')->toArray();
        $data['specifications'] = $this->rowsToSpecs(
            $data['specifications_ru_rows'] ?? [],
            $data['specifications_en_rows'] ?? []
        );
        $data['gallery'] = $this->normalizeGallery($data['gallery'] ?? null);
        $data['documents'] = $this->normalizeGallery($data['documents'] ?? null);
        unset($data['specifications_json'], $data['specifications_ru_rows'], $data['specifications_en_rows']);

        $product->fill($data)->save();

        $seoData = $request->collect('seo')->toArray();
        if (! empty($seoData['title_ru']) || ! empty($seoData['title_en']) || ! empty($seoData['description_ru'])) {
            $product->seo()->updateOrCreate([], $seoData);
        }

        Toast::info(__('Product was saved.'));

        return redirect()->route('platform.content.products.edit', $product->id);
    }

    public function remove(Product $product): RedirectResponse
    {
        $product->delete();

        Toast::info(__('Product was removed.'));

        return redirect()->route('platform.content.products');
    }

    private function decodeJson(mixed $value): ?array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && trim($value) !== '') {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : null;
        }

        return null;
    }

    /**
     * Convert stored specifications (list of {name_ru,value_ru,name_en,value_en}, legacy {name,value},
     * list of {key,value}, or flat object) into Matrix rows for a single locale.
     */
    private function specsToRows(mixed $specs, string $locale): array
    {
        if (is_string($specs) && trim($specs) !== '') {
            $decoded = json_decode($specs, true);
            $specs = is_array($decoded) ? $decoded : [];
        }

        if (! is_array($specs) || $specs === []) {
            return [];
        }

        $localeField = function (string $key) use ($locale): string {
            return $key.'_'.$locale;
        };

        $rows = [];
        foreach ($specs as $index => $value) {
            if (is_array($value)) {
                // Localized format {name_ru, value_ru, name_en, value_en}
                if (array_key_exists('name_ru', $value) || array_key_exists('name_en', $value)) {
                    $name = (string) ($value[$localeField('name')] ?? $value['name_' . ($locale === 'ru' ? 'en' : 'ru')] ?? '');
                    $val = (string) ($value[$localeField('value')] ?? $value['value_' . ($locale === 'ru' ? 'en' : 'ru')] ?? '');

                    if ($name !== '' && $val !== '') {
                        $rows[] = ['name' => $name, 'value' => $val];
                    }
                    continue;
                }

                // Legacy {name,value} / {key,value}
                $name = (string) ($value['name'] ?? $value['key'] ?? $index);
                $val = $value['value'] ?? '';
                if ($name !== '' && $val !== '') {
                    $rows[] = ['name' => $name, 'value' => (string) $val];
                }
            } else {
                $rows[] = ['name' => (string) $index, 'value' => (string) $value];
            }
        }

        return $rows;
    }

    /**
     * Build stored specifications (list of {name_ru,value_ru,name_en,value_en}) from two locale matrices.
     */
    private function rowsToSpecs(mixed $ruRows, mixed $enRows): array
    {
        $ruRows = is_array($ruRows) ? array_values($ruRows) : [];
        $enRows = is_array($enRows) ? array_values($enRows) : [];

        $count = max(count($ruRows), count($enRows));

        $specs = [];
        for ($i = 0; $i < $count; $i++) {
            $ru = $ruRows[$i] ?? [];
            $en = $enRows[$i] ?? [];

            $ruName = is_array($ru) ? trim((string) ($ru['name'] ?? '')) : '';
            $ruValue = is_array($ru) ? trim((string) ($ru['value'] ?? '')) : '';
            $enName = is_array($en) ? trim((string) ($en['name'] ?? '')) : '';
            $enValue = is_array($en) ? trim((string) ($en['value'] ?? '')) : '';

            if ($ruName === '' && $ruValue === '' && $enName === '' && $enValue === '') {
                continue;
            }

            $specs[] = [
                'name_ru' => $ruName,
                'value_ru' => $ruValue,
                'name_en' => $enName,
                'value_en' => $enValue,
            ];
        }

        return $specs;
    }

    private function normalizeGallery(mixed $value): array
    {
        if (is_array($value)) {
            $junk = ['undefined', 'null', 'false', 'NaN', '[object Object]'];

            return array_values(array_filter(
                $value,
                fn ($item) => $item !== null && $item !== '' && ! in_array($item, $junk, true)
            ));
        }

        if (is_string($value) && trim($value) !== '') {
            $decoded = json_decode($value, true);

            if (is_array($decoded)) {
                return $decoded;
            }

            return [$value];
        }

        return [];
    }
}
