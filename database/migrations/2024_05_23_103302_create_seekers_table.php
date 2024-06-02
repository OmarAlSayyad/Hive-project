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
        Schema::create('seekers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('communication_id')->constrained('communications');
            $table->foreignId('location_id')->constrained('locations');

            $table->decimal('rating', 3, 2)->nullable();
            $table->string('cv')->nullable();
            $table->string('level')->nullable();
            $table->text('bio')->nullable();
            $table->string('gender')->nullable();
            $table->string('picture')->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->date('birth_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seekers');
    }
};
