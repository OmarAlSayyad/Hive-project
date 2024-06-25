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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('category_id')->constrained('categories');

            $table->string('title');
            $table->text('description');
            $table->text('job_requirement');
            $table->string('address');

            $table->enum('gender',['Male','Female','Undefined'])->default('undefined');

            $table->smallInteger('min_age');
            $table->smallInteger('max_age');

            $table->enum('scientific_level',['High School','Diploma','Bachelor_degree','Master','Ph.D','not_required']);
            $table->enum('job_type',['Full_time','Part_time','Remotely']);
            $table->smallInteger('experience_years');
            $table->decimal('min_salary', 10, 2);
            $table->decimal('max_salary', 10, 2);
            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->index('company_id');
            $table->index('category_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
