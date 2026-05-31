<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_id',
        'sender_type',
        'message',
        'is_read',
        'read_at',
        'reactions',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'reactions' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the sender (vendor or admin)
     */
    public function sender()
    {
        return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    }

    /**
     * Get reactions for this message
     */
    public function messageReactions()
    {
        return $this->hasMany(HelpMessageReaction::class);
    }

    /**
     * Get grouped reactions
     */
    public function getGroupedReactionsAttribute()
    {
        return $this->messageReactions()
            ->selectRaw('emoji, count(*) as count')
            ->groupBy('emoji')
            ->get()
            ->pluck('count', 'emoji')
            ->toArray();
    }

    /**
     * Mark message as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Scope for unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for messages by sender type
     */
    public function scopeBySenderType($query, $type)
    {
        return $query->where('sender_type', $type);
    }
}