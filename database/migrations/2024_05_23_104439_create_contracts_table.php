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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_hire_id')->nullable()->constrained('companies');
            $table->foreignId('seeker_hire_id')->nullable()->constrained('seekers');

            $table->foreignId('freelancer_id')->constrained('seekers');

            $table->foreignId('freelance_id')->constrained('freelance_posts');

            $table->text('terms');
            $table->date('start_date');
            $table->date('end_date');

            $table->date('delivered_date')->nullable();

            $table->boolean('status')->default(false);

            $table->timestamps();

            $table->index('company_hire_id');
            $table->index('seeker_hire_id');
            $table->index('freelancer_id');
            $table->index('freelance_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
