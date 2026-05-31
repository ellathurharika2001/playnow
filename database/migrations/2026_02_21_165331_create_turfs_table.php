<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('turfs', function (Blueprint $table) {
            $table->id();
            
            // Step 1 - Location Details
            $table->string('turf_name');
            $table->string('owner_name');
            $table->string('mobile', 10)->unique();
            $table->string('email')->unique();
            $table->text('full_address');
            $table->string('area_city');
            $table->string('google_maps_link', 500); // URL can be long
            $table->string('landmark')->nullable();
            
            // Step 2 - Sport & Pricing
            $table->enum('sport_type', ['Football', 'Cricket', 'Multi-sport']);
            $table->string('turf_size', 50); // e.g. "5s", "7s", "11s" or dimensions
            $table->enum('indoor_outdoor', ['Indoor', 'Outdoor']);
            $table->decimal('price_per_hour', 8, 2); // 8 digits total, 2 after decimal
            $table->integer('slot_duration'); // in minutes
            $table->time('opening_time');
            $table->time('closing_time');
            $table->json('photos'); // stores array of file paths
            
            // Status & timestamps
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('registration_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('turfs');
    }
};