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
            $table->foreignId('communication_id')->constrained('communications')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');

            $table->enum('rating',[1,2,3,4,5])->default(null);
            $table->string('cv')->nullable();
            $table->enum('level',['Beginner','Middle','Advanced','Expert'])->default('Beginner');
            $table->decimal('on_time_percentage', 5, 2)->nullable();
            $table->text('bio')->nullable();
            $table->enum('gender',['Male','Female','Not_determined'])->default('Not_determined');
            $table->string('picture')->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('communication_id');
            $table->index('location_id');

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
