<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Products\Discount::class, function (Faker $faker) {
    return [
        'name' =>  $faker->word,
        'discount_value' => $faker->numberBetween(0, 100),
        'discount_type' => $faker->randomElement(['percentage', 'monetary']),
        
    ];
});
