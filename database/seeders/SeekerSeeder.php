<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeekerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $j=1;

        for ($i = 1; $i <= 50; $i++) {
            DB::table('seekers')->insert([
                'user_id' => $j,
                'communication_id'=>$i,
                'location_id' => $i,
                'cv' => 'ajflkadfgkjhfglhdagl',
                'level' => 'Beginner',
                'picture' => 'iufoiadhfadlkfjasdlkfj',
                'bio' =>'Laravel Framework',
                'gender' => 'Male',
                'hourly_rate' => 90.0,
                'birth_date' => '2003-02-22',

            ]);
            $j+=3;
        }
    }
}
