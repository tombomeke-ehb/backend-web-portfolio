<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'sort_order',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(FaqCategoryTranslation::class, 'faq_category_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(FaqItem::class, 'faq_category_id');
    }

    public function getNameAttribute(): string
    {
        $lang = request()?->cookie('portfolio_lang', 'nl') ?? 'nl';
        $lang = in_array($lang, ['nl', 'en'], true) ? $lang : 'nl';

        $translations = $this->relationLoaded('translations')
            ? $this->translations
            : $this->translations()->get();

        $match = $translations->firstWhere('lang', $lang)
            ?: $translations->firstWhere('lang', 'nl')
            ?: $translations->first();

        return (string) ($match?->name ?? '');
    }
}
