<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Resolve an image value (array from Orchid upload / path / url) to a public URL.
     */
    public static function url(mixed $image, string $fallback = null): ?string
    {
        // Orchid Upload stores attachment IDs (int or numeric string). Resolve to a public URL.
        if ((is_int($image) || is_string($image) && ctype_digit($image)) && (int) $image > 0) {
            if ($attachment = \Orchid\Attachment\Models\Attachment::find((int) $image)) {
                return self::resolvePath($attachment->url());
            }

            return $fallback ? self::resolvePath($fallback) : null;
        }

        if (is_string($image) && $image) {
            // Guard against JS garbage / Orchid Upload artifacts leaking into storage
            // columns (e.g. "undefined"). Without this we'd render /storage/undefined.
            if (in_array($image, ['undefined', 'null', 'false', 'NaN', '[object Object]'], true)) {
                return $fallback ? self::resolvePath($fallback) : null;
            }

            return self::resolvePath($image);
        }

        if (is_array($image)) {
            // Supports: {url}, {path}, {name,disk,path}
            foreach (['url'] as $key) {
                if (isset($image[$key])) {
                    return self::resolvePath($image[$key]);
                }
            }

            if (isset($image['path'])) {
                $path = $image['path'];

                // If a thumb size variant is requested via query, Orchid keeps @files
                if (is_array($path) && isset($path[0])) {
                    $path = $path[0];
                }

                return self::resolvePath((string) $path);
            }
        }

        return $fallback ? self::resolvePath($fallback) : null;
    }

    private static function resolvePath(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        // Rewrite our own storage URLs to host-neutral relative paths, so images
        // render on whatever host the site is served from (not the hard-coded APP_URL).
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            $appUrl = rtrim((string) config('app.url'), '/');
            $appHost = parse_url($appUrl, PHP_URL_HOST);

            if ($appHost && str_starts_with($path, $appUrl.'/storage')) {
                return '/storage'.substr($path, strlen($appUrl.'/storage'));
            }

            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        try {
            return Storage::disk('public')->url($path);
        } catch (\Throwable) {
            return '/storage/'.$path;
        }
    }
}
