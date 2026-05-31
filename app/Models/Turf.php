<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turf extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'turf_name',
        'owner_name',
        'mobile',
        'email',
        'full_address',
        'area_city',
        'google_maps_link',
        'landmark',
        'sport_type',
        'turf_size',
        'indoor_outdoor',
        'price_per_hour',
        'slot_duration',
        'opening_time',
        'closing_time',
        'photos',
        'status',
        'registration_date',
    ];

    protected $casts = [
        'photos' => 'array',          // automatically decode JSON to array
        'price_per_hour' => 'decimal:2',
        'registration_date' => 'date',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];


public function getAvailableSlots($date)
    {
        // Logic to get available time slots for a specific date
        // Based on opening/closing times and existing bookings
    }
 
    public function isAvailable($date, $startTime, $endTime)
    {
        // Check if venue is available for given date and time
        return $this->bookings()
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function($q2) use ($startTime, $endTime) {
                      $q2->where('start_time', '<=', $startTime)
                         ->where('end_time', '>=', $endTime);
                  });
            })
            ->doesntExist();
    }
    
public function helpConversation()
{
    return $this->hasOne(HelpConversation::class, 'vendor_id');
}

    /**
     * Help Messages
     */
    public function helpMessages()
    {
        return $this->hasMany(HelpMessage::class, 'sender_id')
            ->where('sender_type', 'vendor');
    }

    /**
     * Latest Help Message
     */
    public function latestHelpMessage()
    {
        return $this->hasOne(HelpMessage::class, 'sender_id')
            ->where('sender_type', 'vendor')
            ->latestOfMany();
    }

    /**
     * Unread Help Messages
     */
    public function unreadHelpMessages()
    {
        return $this->hasMany(HelpMessage::class, 'sender_id')
            ->where('sender_type', 'vendor')
            ->where('is_read', false);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Vendor Initials
     */
    public function initials(): string
    {
        return collect(explode(' ', $this->full_name ?? $this->shop_name))
            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
            ->join('');
    }

    /**
     * Check Active Conversation
     */
    public function hasActiveConversation(): bool
    {
        return $this->helpConversation()
            ->where('status', 'active')
            ->exists();
    }

    /**
     * Get Unread Message Count
     */
    public function unreadMessagesCount(): int
    {
        return $this->unreadHelpMessages()->count();
    }

    /**
     * Last Message
     */
    public function lastMessage()
    {
        return $this->latestHelpMessage;
    }


}