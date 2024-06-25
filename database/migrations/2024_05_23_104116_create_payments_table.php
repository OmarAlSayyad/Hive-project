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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_payer_id')->nullable()->constrained('companies');
            $table->foreignId('seeker_payer_id')->nullable()->constrained('seekers');
            $table->foreignId('payee_id')->constrained('seekers');
            $table->foreignId('freelance_id')->constrained('freelance_posts');

            $table->decimal('amount', 10, 2);
            $table->string('status')->default('Retractable');
            $table->timestamps();

            $table->index('company_payer_id');
            $table->index('seeker_payer_id');
            $table->index('payee_id');
            $table->index('freelance_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
