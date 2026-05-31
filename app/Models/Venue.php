<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'slug',
        'description',
        'full_address',
        'area_city',
        'state',
        'country',
        'pincode',
        'landmark',
        'latitude',
        'longitude',
        'google_maps_link',
        'sport_type',
        'turf_size',
        'indoor_outdoor',
        'price_per_hour',
        'slot_duration',
        'opening_time',
        'closing_time',
        'operating_days',
        'is_active',
        'is_verified',
        'verified_at',
        'registration_date',
        'registration_number',
        'contact_person',
        'contact_phone',
        'contact_email',
        'photos',
        'thumbnail',
        'amenities',
        'facilities',
        'average_rating',
        'total_reviews',
        'terms_conditions',
        'cancellation_policy',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
        'price_per_hour' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'registration_date' => 'date',
        'operating_days' => 'array',
        'photos' => 'array',
        'amenities' => 'array',
        'facilities' => 'array',
        'meta_keywords' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the vendor/owner of this venue
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Get all bookings for this venue
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all reviews for this venue
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all time slots for this venue
     */
    public function timeSlots(): HasMany
    {
        return $this->hasMany(TimeSlot::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('area_city', $city);
    }

    public function scopeBySportType($query, $type)
    {
        return $query->where('sport_type', $type);
    }

    public function scopeByVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    /**
     * Accessors & Mutators
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = \Str::slug($value ?: $this->name);
    }

    public function getFullLocationAttribute(): string
    {
        return "{$this->full_address}, {$this->area_city}, {$this->state} - {$this->pincode}";
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} - {$this->area_city}";
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset($this->thumbnail);
        }
        
        if ($this->photos && count($this->photos) > 0) {
            return asset($this->photos[0]);
        }

        return asset('images/venue-placeholder.jpg');
    }

    /**
     * Check if venue is open at given time
     */
    public function isOpenAt(\DateTime $dateTime): bool
    {
        $dayName = $dateTime->format('l');
        
        if (!in_array($dayName, $this->operating_days ?? [])) {
            return false;
        }

        $time = $dateTime->format('H:i');
        $openTime = $this->opening_time->format('H:i');
        $closeTime = $this->closing_time->format('H:i');

        return $time >= $openTime && $time < $closeTime;
    }

    /**
     * Get available slots for a date
     */
    public function getAvailableSlots($date): array
    {
        $slots = [];
        $current = \Carbon\Carbon::createFromFormat('Y-m-d H:i', "{$date} {$this->opening_time->format('H:i')}");
        $end = \Carbon\Carbon::createFromFormat('Y-m-d H:i', "{$date} {$this->closing_time->format('H:i')}");

        // Parse slot duration (e.g., "1 hour", "30 mins")
        $duration = 60; // default 1 hour
        if (str_contains($this->slot_duration, '30')) {
            $duration = 30;
        } elseif (str_contains($this->slot_duration, '2')) {
            $duration = 120;
        }

        while ($current->isBefore($end)) {
            $slotEnd = $current->copy()->addMinutes($duration);
            
            // Check if this slot is booked
            $isBooked = Booking::where('venue_id', $this->id)
                ->where('booking_date', $date)
                ->where('start_time', '<=', $current->format('H:i'))
                ->where('end_time', '>', $current->format('H:i'))
                ->where('status', '!=', 'cancelled')
                ->exists();

            $slots[] = [
                'start' => $current->format('H:i'),
                'end' => $slotEnd->format('H:i'),
                'is_available' => !$isBooked,
            ];

            $current->addMinutes($duration);
        }

        return $slots;
    }

    /**
     * Update rating
     */
    public function updateRating(): void
    {
        $this->update([
            'average_rating' => $this->reviews()->avg('rating') ?? 0,
            'total_reviews' => $this->reviews()->count(),
        ]);
    }
}