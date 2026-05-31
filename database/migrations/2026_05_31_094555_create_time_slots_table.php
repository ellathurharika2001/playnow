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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('venue_id')
                  ->constrained('venues')
                  ->onDelete('cascade');
            
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->unsignedBigInteger('booking_id')->nullable();
            
            // Review Content
            $table->integer('rating')->min(1)->max(5);
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            
            // Review Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            
            // Helpful Count
            $table->integer('helpful_count')->default(0);
            $table->integer('unhelpful_count')->default(0);
            
            // Images
            $table->json('images')->nullable();
            
            // Verification
            $table->boolean('verified_purchase')->default(true);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('venue_id');
            $table->index('user_id');
            $table->index('rating');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};