<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;

class SiteSettings
{
    private array $cache = [];

    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        }

        $value = Setting::get($key, $default);
        $this->cache[$key] = $value;

        return $value;
    }

    public function localized(string $key, mixed $default = null): mixed
    {
        $locale = app()->getLocale();

        return $this->get($key.'.'.$locale, $this->get($key, $default) ?? $default);
    }

    /**
     * Resolve an image setting (orchestra-style array) to a public URL.
     */
    public function image(string $key): ?string
    {
        $value = $this->get($key);

        if (is_null($value)) {
            return null;
        }

        if (is_string($value) && $value) {
            // Could be a raw path or a full URL already stored as string.
            return $this->resolvePath($value);
        }

        if (is_array($value)) {
            if (isset($value['url'])) {
                return $value['url'];
            }

            if (isset($value['path'])) {
                return $this->resolvePath($value['path']);
            }

            if (isset($value['name']) && isset($value['disk']) && isset($value['path'])) {
                return $this->resolvePath($value['path']);
            }
        }

        return null;
    }

    private function resolvePath(string $path): ?string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        $disk = 'public';

        try {
            return \Illuminate\Support\Facades\Storage::disk($disk)->url($path);
        } catch (\Throwable) {
            return '/storage/'.$path;
        }
    }
}
