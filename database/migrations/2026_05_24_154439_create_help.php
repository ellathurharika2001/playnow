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
        Schema::create('help_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->enum('sender_type', ['vendor', 'admin'])->default('vendor');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('reactions')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['sender_id', 'sender_type']);
            $table->index('created_at');
        });

        Schema::create('help_message_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_message_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type'); // 'vendor' or 'admin'
            $table->string('emoji', 10);
            $table->timestamps();

            $table->unique(['help_message_id', 'user_id', 'user_type', 'emoji'], 'unique_reaction');
        });

        Schema::create('help_conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->timestamp('last_message_at')->nullable();
            $table->unsignedBigInteger('last_message_by')->nullable();
            $table->string('last_message_by_type')->nullable();
            $table->integer('unread_vendor_count')->default(0);
            $table->integer('unread_admin_count')->default(0);
            $table->enum('status', ['active', 'closed', 'archived'])->default('active');
            $table->timestamps();

            $table->index('vendor_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_message_reactions');
        Schema::dropIfExists('help_messages');
        Schema::dropIfExists('help_conversations');
    }
};