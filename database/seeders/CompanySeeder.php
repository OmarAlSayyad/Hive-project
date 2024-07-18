<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $j=2;
        for ($i = 51; $i <= 100; $i++) {
            DB::table('companies')->insert([

                'user_id' => $j,
                'communication_id'=>$i,
                'location_id' => $i,
                'picture' => 'iufoiadhfadlkfjasdlkfj',
                'rating' =>'2',
                'approved' =>true,
                'industry' => 'IT',
                'description' =>'my company is great',
            ]);
            $j+=3;
        }
    }
}
