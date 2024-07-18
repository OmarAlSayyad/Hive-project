<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('job_posts')->insert([

                'company_id' => $i,
                'category_id' => '1',

                'title' => 'Laravel framework',
                'description' => 'we need an expert developer in laravel framework',

                'job_requirement' =>'programming skills ',
                'address' => 'damascus',
                'gender' =>'Male' ,
                'min_age' =>'20' ,
                'max_age' => '40',
                'scientific_level' =>'Diploma',
                'job_type' =>'Full_time' ,
                'experience_years' =>'2',
                'min_salary' => '2000000',
                'max_salary' => '6000000',

            ]);
        }
    }
}
