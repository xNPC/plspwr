<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::saving(function ($model) {
            $model->autoGenerateSlugs();
        });
    }

    protected function autoGenerateSlugs(): void
    {
        foreach (['ru' => 'title_ru', 'en' => 'title_en'] as $locale => $titleField) {
            $slugField = 'slug_'.$locale;

            $slug = trim((string) $this->getAttribute($slugField));
            if ($slug !== '') {
                continue;
            }

            $source = trim((string) $this->getAttribute($titleField));

            $otherLocale = $locale === 'ru' ? 'en' : 'ru';
            $otherField = 'title_'.$otherLocale;
            if ($source === '') {
                $source = trim((string) $this->getAttribute($otherField));
            }

            if ($source === '' && method_exists($this, 'getTranslation')) {
                $source = trim((string) $this->getTranslation('title'));
            }

            if ($source === '') {
                continue;
            }

            $this->setAttribute($slugField, $this->makeUniqueSlug($locale, Str::slug($source)));
        }
    }

    protected function makeUniqueSlug(string $locale, string $slug): string
    {
        $slugField = 'slug_'.$locale;
        $base = $slug;
        $suffix = 2;

        while (
            static::query()
                ->where($slugField, $slug)
                ->where($this->getKeyName(), '!=', $this->getKey() ?? 0)
                ->exists()
        ) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    public function getSlugForLocale(string $locale): ?string
    {
        return $this->{'slug_'.$locale} ?? null;
    }

    public function getLocalizedSlug(): ?string
    {
        $locale = app()->getLocale();

        return $this->getSlugForLocale($locale) ?? $this->getSlugForLocale(config('locale.default'));
    }

    public function getUrlAttribute(): ?string
    {
        $slug = $this->getLocalizedSlug();

        if (! $slug) {
            return null;
        }

        $prefix = method_exists($this, 'urlPrefix') ? $this->urlPrefix() : '';

        return \locale_path(($prefix ? $prefix.'/' : '').$slug);
    }

    /**
     * Build a URL keeping the same locale / domain.
     */
    protected function localizedUrlFor(string $locale): ?string
    {
        return $this->getUrlAttribute();
    }
}
