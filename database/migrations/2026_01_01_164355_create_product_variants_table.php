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
       Schema::create('product_variants', function (Blueprint $table) {
    $table->bigIncrements('variant_id');
    $table->unsignedBigInteger('product_id');
    $table->string('sku', 50)->unique();
    $table->decimal('price', 10, 2)->nullable();
    $table->integer('stock_quantity')->default(0);
    $table->decimal('weight', 8, 2)->nullable();
    $table->boolean('is_default')->default(false);
    $table->timestamps();

    $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
