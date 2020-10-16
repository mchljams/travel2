<?php

namespace Mchljams\TravelLog\Database\Seeds;

use Illuminate\Database\Seeder;
use Mchljams\TravelLog\Models\City;
use Mchljams\TravelLog\Imports\CitiesImport;
use Maatwebsite\Excel\Facades\Excel;


class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        City::truncate();
        Excel::import(new CitiesImport, 'uscities.csv');
    }
}