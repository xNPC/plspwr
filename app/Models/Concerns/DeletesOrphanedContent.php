<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\MenuItem;

/**
 * Keep the database free of "dangling" references when a content model is removed.
 *
 * The real foreign keys (products.product_family_id, blocks.page_id, ...) already
 * cascade/null correctly via migrations. This trait covers the relations that have
 * no FK constraint:
 *
 * - any model with an `seo()` MorphOne removes its orphan SeoMetadata row;
 * - Page additionally nulls out menu_items.page_id (no FK on that column).
 */
trait DeletesOrphanedContent
{
    protected static function bootDeletesOrphanedContent(): void
    {
        static::deleting(function (self $model) {
            $model->deleteOrphanedContent();
        });
    }

    protected function deleteOrphanedContent(): void
    {
        if (method_exists($this, 'seo') && $this->seo()->exists()) {
            $this->seo()->delete();
        }

        if (static::class === \App\Models\Page::class) {
            MenuItem::where('page_id', $this->getKey())->update(['page_id' => null]);
        }
    }
}
