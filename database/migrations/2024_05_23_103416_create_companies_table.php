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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('location_id')->constrained('locations')->cascadeOnDelete();
            $table->foreignId('communication_id')->constrained('communications')->cascadeOnDelete();

            $table->enum('rating',[1,2,3,4,5])->default(null);
            $table->string('picture')->nullable();
            $table->string('industry')->nullable();
            $table->text('description')->nullable();
            $table->boolean('approved')->default(false);

            $table->timestamps();

            $table->index('user_id');
            $table->index('location_id');
            $table->index('communication_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
