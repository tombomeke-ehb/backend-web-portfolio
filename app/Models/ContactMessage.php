<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'read_at',
        'admin_reply',
        'replied_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function markRead(): void
    {
        if ($this->read_at === null) {
            $this->forceFill(['read_at' => now()])->save();
        }
    }

    public function markUnread(): void
    {
        $this->forceFill(['read_at' => null])->save();
    }

    public function markReplied(string $reply): void
    {
        $this->forceFill([
            'admin_reply' => $reply,
            'replied_at' => now(),
            'read_at' => $this->read_at ?? now(),
        ])->save();
    }
}
