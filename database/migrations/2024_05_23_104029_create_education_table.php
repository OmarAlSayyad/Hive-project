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

            $table->string('institution_name')->nullable();
             $table->string('field_of_study')->nullable();
             $table->date('start_date')->nullable();
             $table->date('graduation_date')->nullable();
            $table->decimal('graduation_degree')->nullable();
            $table->string('specialization')->nullable();
            $table->enum('status', ['enrolled', 'graduated', 'dropped_out'])->default('enrolled');
            $table->enum('study_mode', ['full_time', 'part_time', 'online'])->default('full_time');
            $table->enum('scientific_level',['High_School','Diploma','College_degree','Master','Ph.D','Training_course'])->default('High_School');

            $table->timestamps();

            $table->index('seeker_id');
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
