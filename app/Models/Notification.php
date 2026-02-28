<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'icon',
        'title',
        'message',
        'link',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * User yang menerima notifikasi
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope untuk notifikasi user tertentu atau global
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhereNull('user_id'); // Global notifications
        });
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Get type color classes
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'success' => 'bg-green-100 text-green-600',
            'warning' => 'bg-yellow-100 text-yellow-600',
            'danger' => 'bg-red-100 text-red-600',
            default => 'bg-blue-100 text-blue-600',
        };
    }

    /**
     * Create notification helper
     */
    public static function send($userId, $title, $message, $type = 'info', $icon = 'fa-bell', $link = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'icon' => $icon,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }

    /**
     * Send notification to all users
     */
    public static function broadcast($title, $message, $type = 'info', $icon = 'fa-bell', $link = null)
    {
        return self::create([
            'user_id' => null, // null = untuk semua user
            'type' => $type,
            'icon' => $icon,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }
}
