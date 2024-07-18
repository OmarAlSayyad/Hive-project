<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeelancePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('freelance_posts')->insert([

                'seeker_id' => $i,
                'category_id' => '1',
                'title' => 'Laravel framework',
                'description' => 'we need an expert developer in laravel framework',
                'delivery_date' =>'2024-08-30 18:00:00',
                'min_budget' => '4000',
                'max_budget' => '6300',

            ]);
        }


        $j=1;
        for ($i = 51; $i <= 100; $i++) {
            DB::table('freelance_posts')->insert([

                'company_id' => $j,
                'category_id' => '3',
                'title' => 'flutter framework',
                'description' => 'we need an expert developer in flutter framework',
                'delivery_date' =>'2024-08-20 16:00:00',
                'min_budget' => '2000',
                'max_budget' => '4300',

            ]);
            $j+=1;
        }

    }
}
