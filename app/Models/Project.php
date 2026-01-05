<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'category',
        'status',
        'image_path',
        'repo_url',
        'demo_url',
        'tech',
        'sort_order',
    ];

    protected $casts = [
        'tech' => 'array',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    protected function title(): Attribute
    {
        return Attribute::get(fn () => $this->getTranslationValue('title'));
    }

    protected function description(): Attribute
    {
        return Attribute::get(fn () => $this->getTranslationValue('description'));
    }

    protected function longDescription(): Attribute
    {
        return Attribute::get(fn () => $this->getTranslationValue('long_description'));
    }

    protected function features(): Attribute
    {
        return Attribute::get(function () {
            $value = $this->getTranslationValue('features');
            if (is_array($value)) {
                return $value;
            }
            if (is_string($value) && $value !== '') {
                $decoded = json_decode($value, true);
                return is_array($decoded) ? $decoded : [];
            }
            return [];
        });
    }

    private function getTranslationValue(string $field)
    {
        $lang = app()->getLocale();
        $lang = in_array($lang, ['nl', 'en'], true) ? $lang : 'nl';

        $translations = $this->relationLoaded('translations')
            ? $this->translations
            : $this->translations()->get();

        $match = $translations->firstWhere('lang', $lang)
            ?: $translations->firstWhere('lang', 'nl')
            ?: $translations->first();

        return $match?->{$field} ?? (str_ends_with($field, '_description') ? '' : '');
    }
}
