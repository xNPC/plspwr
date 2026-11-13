<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\DeletesOrphanedContent;
use App\Models\Concerns\HasTranslatableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Screen\AsSource;

class Page extends Model
{
    use DeletesOrphanedContent;
    use HasTranslatableAttributes;
    use AsSource;

    protected $fillable = [
        'slug_ru',
        'slug_en',
        'title_ru',
        'title_en',
        'description_ru',
        'description_en',
        'banner_image',
        'is_home',
        'is_active',
        'template',
        'section',
    ];

    protected $casts = [
        'banner_image' => 'array',
        'is_home' => 'boolean',
        'is_active' => 'boolean',
    ];

    public $localizedFields = ['title', 'description'];

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class)->orderBy('sort');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMetadata::class, 'seoable');
    }

    public function getSlugForCurrentLocale(): ?string
    {
        $field = 'slug_'.app()->getLocale();

        return $this->{$field} ?? $this->{'slug_'.config('locale.default')};
    }

    public function getUrlAttribute(): ?string
    {
        $slug = $this->getSlugForCurrentLocale();

        if ($this->is_home || ! $slug) {
            return locale_path('/');
        }

        return locale_path('/'.$slug);
    }
}
