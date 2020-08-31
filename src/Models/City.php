<?php

namespace Mchljams\TravelLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
    //    use SoftDeletes;
    //    use LogsActivity;
    //

    protected $fillable = [
        'city',
        'city_ascii',
        'state_id',
        'state_name',
        'county_fips',
        'county_name',
        'county_fips_all',
        'county_name_all',
        'lat',
        'lng',
        'population',
        'density',
        'source',
        'military',
        'incorporated',
        'timezone',
        'ranking',
        'zips',
        'simple_maps_id',
    ];

    public static function cities($state_id)
    {
        $collection = self::select('city', 'city_ascii', 'state_id', 'state_name', 'county_name', 'lat', 'lng', 'zips')
            ->where('state_id', $state_id)
            ->orderBy('city', 'asc')
            ->get();

        return $collection;
    }

    public static function counties($state_id)
    {
        $collection = self::select('state_id', 'state_name', 'county_name')
            ->where('state_id', $state_id)
            ->groupBy('county_name', 'asc')
            ->get();

        return $collection;
    }

    public static function states()
    {
        $collection = self::select('state_id', 'state_name')
            ->distinct()
            ->orderBy('state_id', 'asc')
            ->get();

        return $collection;
    }
}
