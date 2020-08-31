<?php

namespace Mchljams\TravelLog\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mchljams\TravelLog\Database\Seeds\ActivityLogTableSeeder;
use Mchljams\TravelLog\Database\Seeds\AdminUsersTableSeeder;
use Mchljams\TravelLog\Database\Seeds\UsersTableSeeder;
use Mchljams\TravelLog\Database\Seeds\ItinerariesTableSeeder;
use Mchljams\TravelLog\Database\Seeds\CitiesTableSeeder;

class TravelLogDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->setFKCheckOff();

        $this->call([
            ActivityLogTableSeeder::class,
            AdminUsersTableSeeder::class,
            UsersTableSeeder::class,
            ItinerariesTableSeeder::class,
            CitiesTableSeeder::class
        ]);

        $this->setFKCheckOn();
        Model::reguard();
    }


    private function setFKCheckOff() {
        switch(DB::getDriverName()) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys = OFF');
                break;
        }
    }

    private function setFKCheckOn() {
        switch(DB::getDriverName()) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys = ON');
                break;
        }
    }
}
