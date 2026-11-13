<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\DeletesOrphanedContent;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasTranslatableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use DeletesOrphanedContent;
    use HasSlug;
    use HasTranslatableAttributes;
    use AsSource;

    protected $fillable = [
        'product_family_id',
        'slug_ru',
        'slug_en',
        'code',
        'title_ru',
        'title_en',
        'intro_ru',
        'intro_en',
        'description_ru',
        'description_en',
        'specifications',
        'gallery',
        'documents',
        'sort',
        'is_active',
    ];

    protected $casts = [
        'specifications' => 'array',
        'gallery' => 'array',
        'documents' => 'array',
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public $localizedFields = ['title', 'intro', 'description'];

    public function family(): BelongsTo
    {
        return $this->belongsTo(ProductFamily::class, 'product_family_id');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMetadata::class, 'seoable');
    }

    public function familySlug(): ?string
    {
        return $this->family?->getLocalizedSlug();
    }

    public function getUrlAttribute(): ?string
    {
        $familySlug = $this->family?->getLocalizedSlug();
        $productSlug = $this->getLocalizedSlug();

        if (! $familySlug || ! $productSlug) {
            return null;
        }

        return \locale_path("/products/{$familySlug}/{$productSlug}");
    }
}
