<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'booking_number',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'price_per_hour',
        'total_amount',
        'advance_payment',
        'remaining_payment',
        'status',
        'payment_status',
        'customer_name',
        'customer_phone',
        'customer_email',
        'special_requests',
        'admin_notes',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'cancelled_at' => 'datetime',
        'price_per_hour' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'advance_payment' => 'decimal:2',
        'remaining_payment' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_number = self::generateBookingNumber();
        });
    }

    /**
     * Generate unique booking number
     */
    public static function generateBookingNumber(): string
    {
        do {
            $number = 'BK' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        } while (self::where('booking_number', $number)->exists());

        return $number;
    }

    /**
     * Relationships
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function turf(): BelongsTo
    {
        return $this->belongsTo(Turf::class, 'vendor_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function timeSlot(): HasOne
    {
        return $this->hasOne(TimeSlot::class);
    }

    /**
     * Scopes
     */
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now()->toDateString())
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->orderBy('booking_date')
                    ->orderBy('start_time');
    }

    public function scopeToday($query)
    {
        return $query->where('booking_date', now()->toDateString());
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopeByVenue($query, $venueId)
    {
        return $query->where('venue_id', $venueId);
    }

    public function scopeByVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')
                    ->where('booking_date', '<', today());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Helpers
     */
    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) 
            && $this->booking_date >= now()->toDateString();
    }

    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'])
            && $this->booking_date > now()->toDateString();
    }

    public function isReviewable(): bool
    {
        return $this->status === 'completed'
            && $this->booking_date < today()
            && !$this->review;
    }

    public function isPastBooking(): bool
    {
        return $this->booking_date < today();
    }

    public function isUpcomingBooking(): bool
    {
        return $this->booking_date >= today();
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'confirmed' => 'badge-success',
            'cancelled' => 'badge-danger',
            'completed' => 'badge-info',
            'no_show' => 'badge-secondary',
            default => 'badge-light',
        };
    }

    public function getPaymentStatusBadgeClass(): string
    {
        return match($this->payment_status) {
            'pending' => 'badge-warning',
            'partial' => 'badge-info',
            'paid' => 'badge-success',
            'refunded' => 'badge-danger',
            default => 'badge-light',
        };
    }

    /**
     * Get booking display time
     */
    public function getDisplayTimeAttribute(): string
    {
        return "{$this->start_time->format('H:i')} - {$this->end_time->format('H:i')}";
    }

    /**
     * Get booking display date
     */
    public function getDisplayDateAttribute(): string
    {
        return $this->booking_date->format('d M Y');
    }

    /**
     * Get remaining payment percentage
     */
    public function getRemainingPaymentPercentageAttribute(): float
    {
        if ($this->total_amount == 0) {
            return 0;
        }

        return round(($this->remaining_payment / $this->total_amount) * 100, 2);
    }

    /**
     * Get paid percentage
     */
    public function getPaidPercentageAttribute(): float
    {
        return 100 - $this->remaining_payment_percentage;
    }

    /**
     * Check if fully paid
     */
    public function isFullyPaid(): bool
    {
        return $this->remaining_payment <= 0;
    }

    /**
     * Check if partially paid
     */
    public function isPartiallPaid(): bool
    {
        return $this->advance_payment > 0 && !$this->isFullyPaid();
    }

    /**
     * Get booking summary
     */
    public function getSummary(): array
    {
        return [
            'booking_number' => $this->booking_number,
            'venue' => $this->venue->name ?? 'N/A',
            'date' => $this->display_date,
            'time' => $this->display_time,
            'duration' => "{$this->duration_hours} hours",
            'status' => ucfirst($this->status),
            'payment_status' => ucfirst($this->payment_status),
            'total_amount' => "₹" . number_format($this->total_amount, 2),
            'paid_amount' => "₹" . number_format($this->advance_payment, 2),
            'remaining_amount' => "₹" . number_format($this->remaining_payment, 2),
        ];
    }
}