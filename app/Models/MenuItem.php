<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class MenuItem extends Model
{
    use HasTranslatableAttributes;
    use AsSource;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'label_ru',
        'label_en',
        'title',
        'type',
        'url',
        'route_name',
        'page_id',
        'sort',
        'is_active',
        'target',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public $localizedFields = ['label'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    /**
     * Resolve the final URL of a menu item.
     */
    public function getUrlAttribute(): ?string
    {
        return match ($this->type) {
            'page' => $this->page?->url ? \locale_path($this->page->url) : null,
            'route' => $this->route_name ? \localized_route($this->route_name) : null,
            default => isset($this->attributes['url']) ? \locale_path($this->attributes['url']) : null,
        };
    }
}
