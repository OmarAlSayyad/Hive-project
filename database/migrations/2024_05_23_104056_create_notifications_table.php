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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key
            $table->string('type'); // Notification type (e.g., App\Notifications\YourNotification)
            $table->morphs('notifiable'); // Creates notifiable_id and notifiable_type columns
            $table->text('data'); // Stores the notification data in JSON format
            $table->timestamp('read_at')->nullable(); // Marks the notification as read
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
