<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Calendar\CustomEvent::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(1, true),
        'time' => $faker->time($format='H:i:s', $max = null),
        'date' => $faker->dateTimeBetween( '-250 days', '+ 250 days'),
        'description' => $faker->sentence(8, true)
    ];
});
