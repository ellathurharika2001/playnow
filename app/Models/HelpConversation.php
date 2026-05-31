<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'last_message_at',
        'last_message_by',
        'last_message_by_type',
        'unread_vendor_count',
        'unread_admin_count',
        'status',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the vendor
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Update conversation after new message
     */
    public function updateAfterMessage($message)
    {
        $this->update([
            'last_message_at' => $message->created_at,
            'last_message_by' => $message->sender_id,
            'last_message_by_type' => $message->sender_type,
        ]);

        // Increment unread count for the recipient
        if ($message->sender_type === 'vendor') {
            $this->increment('unread_admin_count');
        } else {
            $this->increment('unread_vendor_count');
        }
    }

    /**
     * Mark messages as read for a user type
     */
    public function markAsReadFor($userType)
    {
        if ($userType === 'vendor') {
            $this->update(['unread_vendor_count' => 0]);
        } else {
            $this->update(['unread_admin_count' => 0]);
        }
    }
}