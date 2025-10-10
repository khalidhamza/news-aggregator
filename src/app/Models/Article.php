<?php

namespace App\Models;

use App\Enums\NewsSource;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'author',
        'url',
        'image_url',
        'published_at',
        'source',
        'category',
        'external_id',
        'external_source',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'source' => NewsSource::class,
    ];
}
