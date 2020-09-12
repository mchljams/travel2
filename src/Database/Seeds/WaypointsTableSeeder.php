<?php

namespace Mchljams\TravelLog\Database\Seeds;

use Illuminate\Database\Seeder;
use Mchljams\TravelLog\Models\Waypoint;
use Illuminate\Support\Facades\DB;

class WaypointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Waypoint::truncate();

        $waypoints = factory(Waypoint::class, 30)->create();
    }
}
