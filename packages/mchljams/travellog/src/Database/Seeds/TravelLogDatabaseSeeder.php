<?php

namespace Mchljams\Database\Seeds;

use Illuminate\Database\Seeder;
use Mchljams\Database\Seeds\AdminUsersTableSeeder;
use Mchljams\Database\Seeds\UsersTableSeeder;
use Mchljams\Database\Seeds\ItinerariesTableSeeder;

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
