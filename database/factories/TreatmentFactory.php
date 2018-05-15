<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Products\Treatment::class, function (Faker $faker) {
    return [
        'name' =>  $faker->word,
        'price' => $faker->numberBetween(0, 300),
        
    ];
});