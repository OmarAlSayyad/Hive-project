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
        Schema::create('seeker_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_id')->constrained('seekers');
            $table->foreignId('language_id')->constrained('languages');
            $table->timestamps();

            $table->index('seeker_id');
            $table->index('language_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeker_languages');
    }
};
