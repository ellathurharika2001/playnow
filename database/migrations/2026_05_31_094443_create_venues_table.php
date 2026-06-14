<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to vendor
            $table->foreignId('vendor_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('full_address');
            $table->string('area_city');
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('pincode')->nullable();
            $table->string('landmark')->nullable();
            
            // Location Coordinates
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('google_maps_link')->nullable();
            
            // Venue Details
            $table->enum('sport_type', ['Cricket', 'Football', 'Multi-sport'])->default('Multi-sport');
            $table->string('turf_size')->nullable(); // e.g., "40x60", "30x40"
            $table->enum('indoor_outdoor', ['indoor', 'outdoor'])->default('outdoor');
            
            // Pricing
            $table->decimal('price_per_hour', 10, 2);
            $table->string('slot_duration')->nullable(); // e.g., "1 hour", "30 mins"
            
            // Operating Hours
            $table->time('opening_time')->default('06:00');
            $table->time('closing_time')->default('23:00');
            $table->json('operating_days')->nullable(); // ["Monday", "Tuesday", ...]
            
            // Venue Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            
            // Registration
            $table->date('registration_date')->nullable();
            $table->string('registration_number')->nullable();
            
            // Contact Information
            $table->string('contact_person')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_email')->nullable();
            
            // Media
            $table->json('photos')->nullable(); // Store array of photo paths
            $table->string('thumbnail')->nullable();
            
            // Amenities & Features
            $table->json('amenities')->nullable(); // ["parking", "restroom", "lighting", ...]
            $table->json('facilities')->nullable(); // ["equipment_rental", "coaching", ...]
            
            // Ratings & Reviews
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            
            // Additional Info
            $table->text('terms_conditions')->nullable();
            $table->text('cancellation_policy')->nullable();
            
            // SEO & Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('vendor_id');
            $table->index('sport_type');
            $table->index('area_city');
            $table->index('is_active');
            $table->index('is_verified');

            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['name', 'description', 'area_city']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};