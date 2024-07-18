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
        Schema::create('applicants_freelance_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('freelance_post_id')->constrained('freelance_posts')->cascadeOnDelete();
            $table->foreignId('seeker_id')->constrained('seekers')->cascadeOnDelete();

            $table->boolean('Accepted')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants_freelance_posts');
    }
};
