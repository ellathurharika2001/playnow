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
       Schema::create('attributes', function (Blueprint $table) {
    $table->bigIncrements('attribute_id');
    $table->string('name', 100)->unique();
    $table->enum('type', ['text','number','select','boolean'])->default('text');
    $table->boolean('is_variant_attribute')->default(false);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
