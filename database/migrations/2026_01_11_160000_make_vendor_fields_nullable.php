<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            // Make business_type nullable
            $table->string('business_type')->nullable()->change();
            
            // Make shop_type nullable
            $table->string('shop_type')->nullable()->change();
            
            // Make bank fields nullable
            $table->string('account_holder')->nullable()->change();
            $table->string('bank_name')->nullable()->change();
            $table->string('account_number')->nullable()->change();
            $table->string('ifsc')->nullable()->change();
            $table->string('pan')->nullable()->change();
            $table->string('pan_image')->nullable()->change();
            $table->string('bank_proof')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('business_type')->nullable(false)->change();
            $table->string('shop_type')->nullable(false)->change();
            $table->string('account_holder')->nullable(false)->change();
            $table->string('bank_name')->nullable(false)->change();
            $table->string('account_number')->nullable(false)->change();
            $table->string('ifsc')->nullable(false)->change();
            $table->string('pan')->nullable(false)->change();
            $table->string('pan_image')->nullable(false)->change();
            $table->string('bank_proof')->nullable(false)->change();
        });
    }
};
