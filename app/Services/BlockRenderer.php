<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Block;
use Illuminate\Support\Facades\View;

class BlockRenderer
{
    /**
     * Map of supported block types to blade partial paths.
     */
    private const VIEWS = [
        'hero' => 'blocks.hero',
        'intro' => 'blocks.intro',
        'products' => 'blocks.products',
        'applications' => 'blocks.applications',
        'stats' => 'blocks.stats',
        'technology' => 'blocks.technology',
        'cases' => 'blocks.cases',
        'news' => 'blocks.news',
        'timeline' => 'blocks.timeline',
        'cta' => 'blocks.cta',
        'text' => 'blocks.text',
        'features' => 'blocks.features',
        'gallery' => 'blocks.gallery',
        'faq' => 'blocks.faq',
        'form' => 'blocks.form',
        'media' => 'blocks.media',
    ];

    public function render(Block $block, array $data = []): string
    {
        $view = self::VIEWS[$block->type] ?? null;

        if (! $view || ! View::exists($view)) {
            return '';
        }

        $content = $block->content ?? [];

        if (is_array($content) && (isset($content['ru']) || isset($content['en']))) {
            $content = $this->localizedContent($content);
        }

        return view($view, array_merge(
            $data,
            ['block' => $block, 'content' => $content]
        ))->render();
    }

    private function localizedContent(array $content): array
    {
        $locale = app()->getLocale();
        $default = config('locale.default', 'ru');

        $selected = $content[$locale] ?? null;
        $fallback = $content[$default] ?? $content['ru'] ?? [];

        if (! is_array($selected)) {
            $selected = $fallback;
        }

        if (is_array($selected) && is_array($fallback)) {
            foreach ($fallback as $key => $value) {
                if (! array_key_exists($key, $selected) || $selected[$key] === null || $selected[$key] === '' || $selected[$key] === []) {
                    $selected[$key] = $value;
                }
            }
        }

        return $selected;
    }

    public function supports(string $type): bool
    {
        return isset(self::VIEWS[$type]) && View::exists(self::VIEWS[$type]);
    }
}
