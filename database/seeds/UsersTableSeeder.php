<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        User::truncate();

        $user = new User();
        $user->name = "Michael";
        $user->email = "mike.pisula@gmail.com";
        $user->password = Hash::make('password');
        $user->api_token = "5abdn5mtevQMbik60RRYsa083kGEOEX4mU6eOZ2JPp5y2Jgwvtvr5UUbE7Og";
        $user->save();

//        $faker = \Faker\Factory::create();

//        // Create users in the database
//        for ($i = 0; $i < 50; $i++) {
//            User::create([
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => Hash::make($faker->password),
//                'api_token' => Str::random(60),
//            ]);
//        }

        $users = factory(App\User::class, 50)->create();
    }
}
