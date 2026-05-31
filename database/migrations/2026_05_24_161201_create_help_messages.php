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
        // Main messages table
        Schema::create('help_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->enum('sender_type', ['vendor', 'admin'])->default('vendor');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['sender_id', 'sender_type']);
            $table->index('created_at');
            $table->index('is_read');
        });

        // Reactions table
        Schema::create('help_message_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_message_id')
                  ->constrained('help_messages')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type', 20);
            $table->string('emoji', 10);
            $table->timestamps();

            // Unique constraint to prevent duplicate reactions
            $table->unique(
                ['help_message_id', 'user_id', 'user_type', 'emoji'], 
                'unique_message_user_reaction'
            );
            
            $table->index(['user_id', 'user_type']);
        });

        // Conversations table - tracks conversation state
        Schema::create('help_conversations', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to vendors table (adjust table name if needed)
            $table->foreignId('vendor_id')
                  ->constrained('vendors') // Change to 'users' if needed
                  ->onDelete('cascade');
            
            $table->timestamp('last_message_at')->nullable();
            $table->unsignedBigInteger('last_message_by')->nullable();
            $table->string('last_message_by_type', 20)->nullable();
            $table->integer('unread_vendor_count')->default(0);
            $table->integer('unread_admin_count')->default(0);
            $table->enum('status', ['active', 'closed', 'archived'])->default('active');
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('last_message_at');
            $table->index(['vendor_id', 'status']);
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