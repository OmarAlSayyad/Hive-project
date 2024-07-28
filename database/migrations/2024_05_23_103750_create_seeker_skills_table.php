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
        Schema::create('seeker_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_id')->constrained('seekers');
            $table->foreignId('skill_id')->constrained('skills');
            $table->enum('level',[1,2,3,4,5])->default(null);

            $table->timestamps();

            $table->index('seeker_id');
            $table->index('skill_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeker_skills');
    }
};
