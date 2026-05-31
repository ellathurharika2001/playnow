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
        Schema::create('products', function (Blueprint $table) {
    $table->bigIncrements('product_id');
    $table->string('name', 200);
    $table->text('description')->nullable();
    $table->unsignedBigInteger('category_id')->nullable();
    $table->unsignedBigInteger('vendor_id')->nullable(); // Keep column name vendor_id
    $table->decimal('base_price', 10, 2)->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();

    // Foreign keys
    $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('set null');
    $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null'); // <--- reference vendors.id
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
