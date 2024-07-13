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
        Schema::create('freelance_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('seeker_id')->nullable()->constrained('seekers')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories');

            $table->string('title');
            $table->text('description');
            $table->dateTime('delivery_date');
            $table->decimal('min_budget', 10, 2);
            $table->decimal('max_budget', 10, 2);
            $table->enum('post_status',['open','close'])->default('open');
            $table->timestamps();

            $table->index('company_id');
            $table->index('seeker_id');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelance_posts');
    }
};
