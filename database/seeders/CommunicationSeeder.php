<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('communications')->insert([
                'mobile_phone' => '0969234458',
                'line_phone' => '0155656070',
                'website' => 'https://www.google.com',
                'linkedin_account' => 'https://www.linkedin.com',
                'github_account' => 'https://www.github.com',
                'facebook_account' => 'https://www.facebook.com/omer.alsaeyad?mibextid=ZbWKwL'
            ]);
        }
    }
}

