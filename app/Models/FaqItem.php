<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_category_id',
        'sort_order',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(FaqItemTranslation::class, 'faq_item_id');
    }

    public function getQuestionAttribute(): string
    {
        return $this->getTranslationValue('question');
    }

    public function getAnswerAttribute(): string
    {
        return $this->getTranslationValue('answer');
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
