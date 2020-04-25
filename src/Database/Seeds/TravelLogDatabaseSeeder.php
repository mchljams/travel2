<?php

namespace Mchljams\TravelLog\Database\Seeds;

use Illuminate\Database\Seeder;
use Mchljams\TravelLog\Database\Seeds\AdminUsersTableSeeder;
use Mchljams\TravelLog\Database\Seeds\UsersTableSeeder;
use Mchljams\TravelLog\Database\Seeds\ItinerariesTableSeeder;

class TravelLogDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUsersTableSeeder::class,
            UsersTableSeeder::class,
            ItinerariesTableSeeder::class
        ]);
    }
}
