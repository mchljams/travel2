<?php

namespace Mchljams\TravelLog\Imports;

use Mchljams\TravelLog\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CitiesImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $city = new City([
            //
            'city' => $row['city'],
            'city_ascii' => $row['city_ascii'],
            'state_id' => $row['state_id'],
            'state_name' => $row['state_name'],
            'county_fips' => $row['county_fips'],
            'county_name' => $row['county_name'],
            'county_fips_all' => $row['county_fips_all'],
            'county_name_all' => $row['county_name_all'],
            'lat' => $row['lat'],
            'lng' => $row['lng'],
            'population' => $row['population'],
            'density' => $row['density'],
            'source' => $row['source'],
            'military' => $row['military'] == "TRUE" ? true : false,
            'incorporated' => $row['incorporated'] == "TRUE" ? true : false,
            'timezone' => $row['timezone'],
            'ranking' => $row['ranking'],
            'zips' => $row['zips'],
            'simple_maps_id' => $row['id'],
        ]);

        return $city;
    }

    public function chunkSize(): int
    {
        return 250;
    }
}
