<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\DeletesOrphanedContent;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasTranslatableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Screen\AsSource;

class CaseStudy extends Model
{
    use DeletesOrphanedContent;
    use HasSlug;
    use HasTranslatableAttributes;
    use AsSource;

    protected $table = 'cases';

    protected $fillable = [
        'slug_ru',
        'slug_en',
        'title_ru',
        'title_en',
        'intro_ru',
        'intro_en',
        'body_ru',
        'body_en',
        'image',
        'sort',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'image' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort' => 'integer',
    ];

    public $localizedFields = ['title', 'intro', 'body'];

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMetadata::class, 'seoable');
    }

    protected function urlPrefix(): string
    {
        return 'cases';
    }
}
