<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Block extends Model
{
    use AsSource;

    public const TYPES = [
        'hero' => 'Hero',
        'intro' => 'Intro',
        'products' => 'Products',
        'applications' => 'Applications',
        'stats' => 'Stats',
        'technology' => 'Technology',
        'cases' => 'Cases',
        'news' => 'News',
        'timeline' => 'Timeline',
        'cta' => 'CTA',
        'text' => 'Text',
        'features' => 'Features',
        'gallery' => 'Gallery',
        'faq' => 'FAQ',
        'form' => 'Form',
        'media' => 'Media',
    ];

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? (string) $this->type;
    }

    public function summary(): string
    {
        $content = $this->content;

        if (! is_array($content) || $content === []) {
            return '—';
        }

        $branch = $content[config('locale.default', 'ru')] ?? null;

        if (! is_array($branch)) {
            $branch = $content['ru'] ?? $content['en'] ?? $content;
        }

        $head = null;

        foreach (['title', 'eyebrow', 'badge', 'subtitle', 'description', 'text', 'body'] as $key) {
            $value = is_array($branch) ? ($branch[$key] ?? null) : null;

            if (is_string($value) && trim(strip_tags($value)) !== '') {
                $head = mb_substr((string) preg_replace('/\s+/u', ' ', trim(strip_tags($value))), 0, 90);

                break;
            }
        }

        $parts = [];

        if ($head !== null) {
            $parts[] = $head;
        }

        $counts = [
            'stats' => ['stats', 'Показатели'],
            'timeline' => ['items', 'Этапы'],
            'features' => ['items', 'Пункты'],
            'faq' => ['items', 'Вопросы'],
            'technology' => ['points', 'Пункты'],
            'gallery' => ['images', 'Изображения'],
        ];

        if (isset($counts[$this->type]) && is_array($branch)) {
            [$key, $noun] = $counts[$this->type];

            $count = count($branch[$key] ?? []);

            if ($count > 0) {
                $parts[] = $noun.': '.$count;
            }
        }

        if (in_array($this->type, ['media', 'gallery'], true) && is_array($branch)) {
            $hasImage = ! empty($branch['image'] ?? null) || count($branch['images'] ?? []) > 0;

            if ($hasImage) {
                $parts[] = 'фото';
            }
        }

        return $parts !== [] ? implode(' • ', $parts) : '—';
    }

    protected $fillable = ['page_id', 'type', 'content', 'sort', 'is_active'];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
