<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('vendors', function (Blueprint $table) {
        $table->id();

        // Account
        $table->string('full_name');
        $table->string('mobile');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('business_type');
        $table->integer('experience')->nullable();
        $table->string('referral_code')->nullable();

        // Shop
        $table->string('shop_name');
        $table->text('shop_address');
        $table->string('pincode')->nullable();
        $table->string('map_location')->nullable();
        $table->string('shop_type');
        $table->string('gstin')->nullable();
        $table->string('fssai')->nullable();
        $table->string('shop_photo')->nullable();
        $table->string('business_proof')->nullable();
        $table->boolean('home_delivery')->default(false);

        // Bank
        $table->string('account_holder');
        $table->string('bank_name');
        $table->string('account_number');
        $table->string('ifsc');
        $table->string('upi')->nullable();
        $table->string('pan');
        $table->string('pan_image');
        $table->string('bank_proof');

        $table->string('status')->default('pending'); // pending/approved/rejected

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
