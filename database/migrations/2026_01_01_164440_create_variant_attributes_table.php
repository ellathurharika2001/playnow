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
        Schema::create('variant_attributes', function (Blueprint $table) {
    $table->unsignedBigInteger('variant_id');
    $table->unsignedBigInteger('attribute_value_id');

    $table->primary(['variant_id','attribute_value_id']);

    $table->foreign('variant_id')->references('variant_id')->on('product_variants')->onDelete('cascade');
    $table->foreign('attribute_value_id')->references('value_id')->on('attribute_values')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_attributes');
    }
};
