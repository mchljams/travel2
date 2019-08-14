<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Itinerary;
use App\User;
use Faker\Generator as Faker;

$factory->define(Itinerary::class, function (Faker $faker) {

    $users = User::pluck('id')->toArray();

    return [
        'name' => $faker->word(),
        'user_id' => $faker->randomElement($users)
    ];
});
