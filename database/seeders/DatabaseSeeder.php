<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Seeker;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


    public function run()
    {
        // Create 100 Companies
        Company::factory(100)->create();

        // Create 100 Seekers
        Seeker::factory(100)->create();
        $this->call([
            CategorySkillSeeder::class,
        ]);
    }
//    public function run(): void
//    {
//        // User::factory(10)->create();
//        $this->call(CategorySeeder::class);
//        $this->call(UserSeeder::class);
//        $this->call(CommunicationSeeder::class);
//        $this->call(LocationsSeeder::class);
//        $this->call(SeekerSeeder::class);
//        $this->call(CompanySeeder::class);
//        $this->call(FeelancePostSeeder::class);
//        $this->call(JobPostSeeder::class);
//
//
//      // User::factory()->create([
//      //     'name' => 'Test User',
//      //     'email' => 'test@example.com',
//      // ]);
//    }
}
