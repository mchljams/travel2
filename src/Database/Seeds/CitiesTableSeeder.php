<?php

namespace Mchljams\TravelLog\Database\Seeds;

use Illuminate\Database\Seeder;
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
        Excel::import(new CitiesImport, 'uscities.csv');
    }
}
