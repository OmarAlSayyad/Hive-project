<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->foreignId('seeker_id')->nullable()->constrained('seekers');
            $table->foreignId('job_post_id')->nullable()->constrained('job_posts');
            $table->foreignId('freelance_post_id')->nullable()->constrained('freelance_posts');
            $table->timestamps();


           // $table->unique(['seeker_id', DB::raw('CASE WHEN job_post_id IS NULL THEN freelance_post_id ELSE job_post_id END')]);
           // $table->unique(['company_id', DB::raw('CASE WHEN job_post_id IS NULL THEN freelance_post_id ELSE job_post_id END')]);

            $table->index('company_id');
            $table->index('seeker_id');
            $table->index('job_post_id');
           // $table->index('freelance_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
