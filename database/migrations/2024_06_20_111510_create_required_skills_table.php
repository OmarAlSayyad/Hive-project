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
        Schema::create('required_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained('skills');
            $table->foreignId('job_post_id')->nullable()->constrained('job_posts');
            $table->foreignId('freelance_post_id')->nullable()->constrained('freelance_posts');
            $table->timestamps();

            $table->index('skill_id');
            $table->index('job_post_id');
            $table->index('freelance_post_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('required_skills');
    }
};
