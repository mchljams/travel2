<?php

namespace Mchljams\Database\Factories;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Mchljams\TravelLog\Models\Waypoint;
use Mchljams\TravelLog\Models\Itinerary;
use Mchljams\TravelLog\Models\User;
use Mchljams\TravelLog\Models\City;
use Faker\Generator as Faker;

$factory->define(Waypoint::class, function (Faker $faker) {

    $itinerary = Itinerary::all()->random();


    $cities = City::pluck('id')->toArray();

    $numberOfMonths = $faker->numberBetween(1, 24);
    $arrival = date('Y-m-d', strtotime('-' . $numberOfMonths . 'months'));
    $departure = date('Y-m-d', strtotime($arrival . ' + ' . $faker->randomDigit() . ' days'));


    return [
        'name' => $faker->word(),
        'city_id' => $faker->randomElement($cities),
        'arrival' => $arrival,
        'departure' => $departure,
        'itinerary_id' => $itinerary->id,
        'user_id' => $itinerary->user_id
    ];
});
