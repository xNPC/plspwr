<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\DeletesOrphanedContent;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasTranslatableAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use DeletesOrphanedContent;
    use HasSlug;
    use HasTranslatableAttributes;
    use AsSource;

    protected $table = 'news';

    protected $fillable = [
        'slug_ru',
        'slug_en',
        'title_ru',
        'title_en',
        'intro_ru',
        'intro_en',
        'body_ru',
        'body_en',
        'category',
        'image',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'image' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public $localizedFields = ['title', 'intro', 'body'];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeOfCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMetadata::class, 'seoable');
    }

    protected function urlPrefix(): string
    {
        return $this->category === 'event' ? 'events' : 'news';
    }
}
