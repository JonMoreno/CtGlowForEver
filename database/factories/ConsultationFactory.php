<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Consultation::class, function (Faker $faker) {
    return [
        'client_id' => function() {
            $values = (App\Client\Client::all()->keys())->random();
            if ($values != 0){
                return $values;
            }else {
                return 1;
            }
        },
        'notes' => $faker->sentence(8, true),//17
        'stress_level' => $faker->numberBetween(0, 10),
        'next_appointment' => $faker->date($format = 'Y-m-d', $max = 'now'),//5
    ];
});
