<?php

use Faker\Generator as Faker;

/*
 |--------------------------------------------------------------------------
 | Medical Model Factory
 |--------------------------------------------------------------------------
 |
 | Seed a Medical model with a matching Client model.
 |
 */


$factory->define(App\Client\Medical::class, function (Faker $faker){
    return [
        'client_id' => function() {
            $values = (App\Client\Client::all()->keys())->random();
            if ($values != 0){
                return $values;
            }else {
                return 1;
            }
        },
        'dermatologist' => $faker->boolean(50),
        'pregnant' => $faker->boolean(50),
        'glasses' => $faker->boolean(50),
        'smoke' => $faker->boolean(50),
        ];
});
