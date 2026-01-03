<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'news_item_tag');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(NewsComment::class);
    }
}
