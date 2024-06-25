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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->foreignId('seeker_id')->nullable()->constrained('seekers');
            $table->foreignId('receiver_id')->constrained('seekers');
            $table->foreignId('freelance_id')->constrained('freelance_posts');


            $table->enum('coin_type',['Dollar','Euro','Syrian_pound'])->default('Syrian_pound');
            $table->decimal('amount', 10, 2);
            $table->enum('status',['Payed','Saved_balance','Canceled'])->default('Saved_balance');
            $table->enum('payment_method', ['Hive_wallet','Credit_card', 'Paypal', 'Bank_transfer', 'Cash'])->default('Hive_wallet');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('company_id');
            $table->index('seeker_id');
            $table->index('receiver_id');
            $table->index('freelance_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
