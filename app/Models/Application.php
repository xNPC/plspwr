<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\DeletesOrphanedContent;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasTranslatableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Screen\AsSource;

class Application extends Model
{
    use DeletesOrphanedContent;
    use HasSlug;
    use HasTranslatableAttributes;
    use AsSource;

    protected $fillable = [
        'slug_ru',
        'slug_en',
        'title_ru',
        'title_en',
        'intro_ru',
        'intro_en',
        'description_ru',
        'description_en',
        'image',
        'icon',
        'sort',
        'is_active',
    ];

    protected $casts = [
        'image' => 'array',
        'icon' => 'array',
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public $localizedFields = ['title', 'intro', 'description'];

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMetadata::class, 'seoable');
    }

    protected function urlPrefix(): string
    {
        return 'applications';
    }
}
