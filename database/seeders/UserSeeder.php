<?php

namespace Database\Seeders;

use App\Models\User;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i<=50; $i++){
            DB::table('users')->insert([
                'name' => "Omar$i",
                'email' => "Omar$i@gmail.com",
                'password'=>Hash::make('theseafood'),
                'email_verified_at' => now(),
                'role'=>'seeker',
                'remember_token' => Str::random(10),

            ]);


            DB::table('users')->insert([
                'name' => "Hasan$i",
                'email' => "Hasan$i@gmail.com",
                'password'=>Hash::make('theseafood'),
                'email_verified_at' => now(),
                'role'=>'company',
                'remember_token' => Str::random(10),

            ]);

            DB::table('users')->insert([
                'name' => "Grizz$i.0 ",
                'email' => "Grizz$i.0 @gmail.com",
                'password'=>Hash::make('theseafood'),
                'email_verified_at' => now(),
                'role'=>'admin',
                'remember_token' => Str::random(10),

            ]);


        }





    }

}
