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
        'image_path',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(NewsItemTranslation::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'news_item_tag');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(NewsComment::class);
    }

    public function getTitleAttribute(): string
    {
        return $this->getTranslationValue('title');
    }

    public function getContentAttribute(): string
    {
        return $this->getTranslationValue('content');
    }

    private function getTranslationValue(string $field): string
    {
        $lang = app()->getLocale();
        $lang = in_array($lang, ['nl', 'en'], true) ? $lang : 'nl';

        $translations = $this->relationLoaded('translations')
            ? $this->translations
            : $this->translations()->get();

        $match = $translations->firstWhere('lang', $lang)
            ?: $translations->firstWhere('lang', 'nl')
            ?: $translations->first();

        return (string) ($match?->{$field} ?? '');
    }
}
