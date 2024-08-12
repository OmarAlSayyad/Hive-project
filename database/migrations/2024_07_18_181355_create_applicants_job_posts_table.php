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
        Schema::create('applicants_job_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_post_id')->constrained('job_posts')->cascadeOnDelete();
            $table->foreignId('seeker_id')->constrained('seekers')->cascadeOnDelete();

          //  $table->boolean('Accepted')->default(false);
            $table->enum('status',['Accepted','Refused','Pending'])->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants_job_posts');
    }
};
