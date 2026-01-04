<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqItemTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_item_id',
        'lang',
        'question',
        'answer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(FaqItem::class, 'faq_item_id');
    }
}
