<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Lead extends Model
{
    use AsSource;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'page_url',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
