<?php

declare(strict_types=1);

namespace Database\Seeders\Concerns;

use App\Models\Page;

/**
 * Keeps images uploaded through the admin panel when a seeder recreates
 * page blocks. Without this, re-running db:seed silently replaces uploaded
 * photos with empty placeholders, because blocks are deleted and recreated.
 */
trait PreservesBlockImages
{
    /**
     * Collect the current block image per block type.
     *
     * @return array<string, string>
     */
    protected function blockImages(Page $page): array
    {
        $images = [];

        foreach ($page->blocks()->get() as $block) {
            $content = $block->content ?? [];
            $image = $content['ru']['image'] ?? $content['en']['image'] ?? null;

            if (is_string($image) && $image !== '') {
                $images[$block->type] = $image;
            }
        }

        return $images;
    }

    /**
     * Apply a preserved/default image to both locale branches of a block.
     *
     * @param  array<string, mixed>  $block
     * @param  array<string, string>  $images
     * @return array<string, mixed>
     */
    protected function withBlockImage(array $block, array $images): array
    {
        $image = $images[$block['type']] ?? null;

        if (! $image) {
            return $block;
        }

        foreach (['ru', 'en'] as $locale) {
            if (isset($block['content'][$locale]) && is_array($block['content'][$locale])) {
                $block['content'][$locale]['image'] = $image;
            }
        }

        return $block;
    }
}
