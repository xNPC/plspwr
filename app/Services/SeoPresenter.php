<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SeoMetadata;
use Illuminate\Support\Str;

class SeoPresenter
{
    private ?SeoMetadata $model;

    private mixed $content;

    private array $defaults;

    public function __construct($model, array $defaults = [])
    {
        $this->model = $model instanceof SeoMetadata ? $model : ($model?->seo ?? null);
        $this->content = $model instanceof SeoMetadata ? null : $model;
        $this->defaults = $defaults;
    }

    public function title(): string
    {
        if ($seo = $this->localized('title')) {
            return $seo;
        }

        if ($contentTitle = $this->contentField('title')) {
            return $contentTitle;
        }

        if ($default = $this->defaults['title'] ?? null) {
            return $default;
        }

        if ($configured = $this->localizedDefault('title')) {
            return $configured;
        }

        return config('app.name');
    }

    public function description(): string
    {
        if ($seo = $this->localized('description')) {
            return $seo;
        }

        if ($contentDescription = $this->contentField('description')) {
            return $contentDescription;
        }

        if ($contentIntro = $this->contentField('intro')) {
            return Str::limit($contentIntro, 160);
        }

        if ($default = $this->defaults['description'] ?? null) {
            return $default;
        }

        if (Str::of($this->defaults['intro'] ?? '')->isNotEmpty()) {
            return Str::limit($this->defaults['intro'], 160);
        }

        if ($tagline = $this->tagline()) {
            return Str::limit($tagline, 160);
        }

        if ($configured = $this->localizedDefault('description')) {
            return $configured;
        }

        return '';
    }

    public function keywords(): ?string
    {
        $value = $this->model?->{'keywords_'.app()->getLocale()};

        if (! $value) {
            $value = $this->model?->{'keywords_'.config('locale.default')};
        }

        return $value;
    }

    public function canonical(): string
    {
        $canonical = $this->model?->{'canonical_'.app()->getLocale()}
            ?? $this->model?->{'canonical_'.config('locale.default')};

        if ($canonical) {
            return $canonical;
        }

        if ($default = $this->defaults['canonical'] ?? null) {
            return $default;
        }

        return $this->currentCanonical();
    }

    public function ogImage(): ?string
    {
        if ($this->model?->og_image) {
            return ImageHelper::url($this->model->og_image);
        }

        foreach (['banner_image', 'image', 'gallery', 'icon'] as $field) {
            if ($value = $this->content?->{$field} ?? null) {
                $url = ImageHelper::url($value);

                if ($url) {
                    return $url;
                }
            }
        }

        if ($default = $this->defaults['og_image'] ?? null) {
            return $default;
        }

        return config('seo.og_image');
    }

    public function noindex(): bool
    {
        return $this->model?->noindex ?? false;
    }

    public function robots(): string
    {
        // Global switch: hide the whole site from search engines while it is
        // still being filled with content (see config/seo.php "indexable").
        if (! config('seo.indexable', false)) {
            return 'noindex, nofollow';
        }

        $parts = [];

        if ($this->noindex()) {
            $parts[] = 'noindex';
        }

        if ($this->model?->robots) {
            $parts[] = $this->model->robots;
        }

        return $parts ? implode(', ', $parts) : 'index, follow';
    }

    public function hreflangUrls(): array
    {
        $urls = [];
        $current = url()->current();

        foreach (array_keys(config('locale.available')) as $locale) {
            $alternate = $this->urlForLocale($locale);
            $urls[$locale] = $alternate ?: $current;
        }

        return $urls;
    }

    /**
     * Normalise a relative asset URL to an absolute one, pinned to the
     * configured scheme in host-based (production) mode.
     */
    public function absoluteUrl(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if ($this->isPathMode()) {
            return url($path);
        }

        $scheme = config('locale.scheme', request()->getScheme());

        return $scheme.'://'.request()->getHost().(str_starts_with($path, '/') ? $path : '/'.$path);
    }

    private function localized(string $attribute): ?string
    {
        $value = $this->model?->{$attribute.'_'.app()->getLocale()};

        if (! $value) {
            $value = $this->model?->{$attribute.'_'.config('locale.default')};
        }

        return $value ?: null;
    }

    private function localizedDefault(string $attribute): ?string
    {
        $defaults = config('seo.defaults', []);
        $locale = app()->getLocale();

        foreach ([$locale, config('locale.default')] as $candidate) {
            if (isset($defaults[$candidate][$attribute]) && $defaults[$candidate][$attribute] !== '') {
                return $defaults[$candidate][$attribute];
            }
        }

        return null;
    }

    private function tagline(): ?string
    {
        $settings = app(\App\Services\SiteSettings::class);
        $locale = app()->getLocale();
        $default = config('locale.default');

        $value = $settings->get('brand.tagline_'.$locale);
        if (! is_string($value) || $value === '') {
            $value = $settings->get('brand.tagline_'.$default);
        }

        return is_string($value) && $value !== '' ? $value : null;
    }

    private function currentCanonical(): string
    {
        $locale = app()->getLocale();
        $current = url()->current();

        if ($this->isPathMode()) {
            // Path-mode (dev): non-default locales live under /{locale}, which the
            // SetLocaleFromDomain middleware strips before routing. Re-add the prefix
            // so each language version carries its own canonical URL.
            if ($locale !== config('locale.default')) {
                $prefix = '/'.$locale;

                if (! str_ends_with($current, $prefix)) {
                    $path = request()->getPathInfo();
                    $path = str_starts_with($path, '/') ? $path : '/'.$path;

                    return url($prefix.$path);
                }
            }

            return $current;
        }

        // Host-based (production): pin the URL to the configured scheme so canonical
        // stays https even when the protocol seen by the app differs (proxy/TLS).
        $scheme = config('locale.scheme', request()->getScheme());
        $parsed = parse_url($current);

        if ($parsed && isset($parsed['scheme'], $parsed['host'])) {
            return $scheme.'://'.$parsed['host']
                .($parsed['path'] ?? '')
                .(isset($parsed['query']) ? '?'.$parsed['query'] : '');
        }

        return $current;
    }

    private function isPathMode(): bool
    {
        $host = request()->getHost();

        foreach (config('locale.domains', []) as $domain) {
            if ($domain && str_ends_with($host, $domain)) {
                return false;
            }
        }

        return true;
    }

    private function contentField(string $attribute): ?string
    {
        if (! $this->content || ! method_exists($this->content, 'hasLocalizedField')) {
            return null;
        }

        $value = $this->content->getTranslation($attribute);

        return is_string($value) && $value ? $value : null;
    }

    private function urlForLocale(string $locale): ?string
    {
        $alternate = \locale_alternate($locale);

        if (! $alternate) {
            return null;
        }

        // hreflang requires absolute URLs; absolutize relative paths (path-mode dev).
        if (! str_starts_with($alternate, 'http')) {
            return url($alternate);
        }

        return $alternate;
    }
}