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
        Schema::create('favorite_freelances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_id')->constrained('seekers');
            $table->foreignId('freelance_post_id')->constrained('freelance_posts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_freelances');
    }
};
