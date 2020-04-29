<?php

namespace Mchljams\TravelLog\Database\Seeds;

use Illuminate\Database\Seeder;
use Mchljams\TravelLog\Models\Itinerary;
use Illuminate\Support\Facades\DB;

class ItinerariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        DB::statement("SET foreign_key_checks=0");
        Itinerary::truncate();
        DB::statement("SET foreign_key_checks=1");

        $itineraries = factory(Itinerary::class, 50)->create();
    }
}
