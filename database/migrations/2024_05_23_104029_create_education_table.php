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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_id')->constrained('seekers');
            $table->string('certificate');
            $table->string('field_of_study');
            $table->string('institution_name');
            $table->date('graduation_date');
            $table->string('degree');
            $table->string('specialization')->nullable();
            $table->enum('status', ['enrolled', 'graduated', 'dropped_out'])->default('enrolled');
            $table->enum('study_mode', ['full_time', 'part_time', 'online'])->default('full_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
