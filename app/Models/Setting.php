<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        [$group, $item] = array_pad(explode('.', $key, 2), 2, null);

        $setting = static::where('group', $group)
            ->where('key', $item)
            ->first();

        return $setting?->value ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        [$group, $item] = array_pad(explode('.', $key, 2), 2, null);

        static::updateOrCreate(
            ['group' => $group, 'key' => $item],
            ['value' => $value]
        );
    }
}
