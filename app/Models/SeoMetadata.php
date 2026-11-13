<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMetadata extends Model
{
    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'title_ru',
        'title_en',
        'description_ru',
        'description_en',
        'keywords_ru',
        'keywords_en',
        'canonical_ru',
        'canonical_en',
        'og_image',
        'robots',
        'noindex',
    ];

    protected $casts = [
        'og_image' => 'array',
        'noindex' => 'boolean',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    public function localizedTitle(): ?string
    {
        return $this->{'title_'.app()->getLocale()};
    }

    public function localizedDescription(): ?string
    {
        return $this->{'description_'.app()->getLocale()};
    }
}
