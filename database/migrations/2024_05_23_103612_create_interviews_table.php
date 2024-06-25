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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('seeker_id')->constrained('seekers');

            $table->date('scheduled_at');
            $table->time('started_at');
            $table->time('ended_at');
            $table->string('address');
            $table->text('notes');
            $table->boolean('status')->default(false);
            $table->enum('result',['Accepted','Refused','Undefined'])->default('Undefined');
            $table->timestamps();

            $table->index('company_id');
            $table->index('seeker_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
