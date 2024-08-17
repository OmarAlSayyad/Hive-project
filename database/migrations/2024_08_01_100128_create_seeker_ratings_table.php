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
        Schema::create('seeker_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_id')->constrained('seekers')->cascadeOnDelete();

            $table->foreignId('rater_company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('rater_seeker_id')->nullable()->constrained('seekers')->cascadeOnDelete();

            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeker_ratings');
    }
};
