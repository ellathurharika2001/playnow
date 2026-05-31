<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'slot_date',
        'start_time',
        'end_time',
        'price_per_hour',
        'custom_price',
        'status',
        'is_blocked',
        'block_reason',
        'booking_id',
        'notes',
    ];

    protected $casts = [
        'slot_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'price_per_hour' => 'decimal:2',
        'custom_price' => 'decimal:2',
        'is_blocked' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the venue this slot belongs to
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * Get the booking if booked
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                    ->where('is_blocked', false);
    }

    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }

    public function scopeBlocked($query)
    {
        return $query->where('is_blocked', true);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('slot_date', $date);
    }

    public function scopeForVenue($query, $venueId)
    {
        return $query->where('venue_id', $venueId);
    }

    public function scopeFuture($query)
    {
        return $query->where('slot_date', '>=', today());
    }

    public function scopePast($query)
    {
        return $query->where('slot_date', '<', today());
    }

    /**
     * Check if slot is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && !$this->is_blocked;
    }

    /**
     * Book this slot
     */
    public function book(Booking $booking): void
    {
        $this->update([
            'status' => 'booked',
            'booking_id' => $booking->id,
        ]);
    }

    /**
     * Release this slot
     */
    public function release(): void
    {
        $this->update([
            'status' => 'available',
            'booking_id' => null,
        ]);
    }

    /**
     * Block this slot
     */
    public function block($reason = null): void
    {
        $this->update([
            'status' => 'blocked',
            'is_blocked' => true,
            'block_reason' => $reason,
        ]);
    }

    /**
     * Unblock this slot
     */
    public function unblock(): void
    {
        $this->update([
            'status' => 'available',
            'is_blocked' => false,
            'block_reason' => null,
        ]);
    }

    /**
     * Get the price for this slot
     */
    public function getPrice(): float
    {
        return (float) ($this->custom_price ?? $this->price_per_hour);
    }

    /**
     * Get duration in hours
     */
    public function getDurationHours(): float
    {
        $start = \Carbon\Carbon::createFromFormat('H:i', $this->start_time->format('H:i'));
        $end = \Carbon\Carbon::createFromFormat('H:i', $this->end_time->format('H:i'));

        return $end->diffInHours($start);
    }

    /**
     * Get total price for this slot
     */
    public function getTotalPrice(): float
    {
        return $this->getDurationHours() * $this->getPrice();
    }

    /**
     * Get time display
     */
    public function getTimeDisplayAttribute(): string
    {
        return "{$this->start_time->format('H:i')} - {$this->end_time->format('H:i')}";
    }

    /**
     * Get display status
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->is_blocked) {
            return $this->block_reason ?? 'Blocked';
        }

        return match($this->status) {
            'available' => 'Available',
            'booked' => 'Booked',
            'maintenance' => 'Maintenance',
            default => 'Unknown',
        };
    }
}