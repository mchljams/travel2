<?php

namespace Mchljams\Database\Factories;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Mchljams\TravelLog\Models\Itinerary;
use Mchljams\TravelLog\Models\User;
use Faker\Generator as Faker;

$factory->define(Itinerary::class, function (Faker $faker) {

    $users = User::pluck('id')->toArray();

    return [
        'name' => $faker->word(),
        'user_id' => $faker->randomElement($users)
    ];
});
