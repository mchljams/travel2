<?php

use Illuminate\Database\Seeder;
use App\Itinerary;

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
        Itinerary::truncate();


        $itineraries = factory(App\Itinerary::class, 50)->create();
    }
}
