<?php

use Faker\Generator as Faker;

use App\Client\Surgery;
use App\Client\Medical;


$factory->define(Surgery::class, function (Faker $faker) {
    return [
        'medical_id' => function() {
            $values = (Medical::all()->keys())->random();
            if ($values != 0){
                return $values;
            }else {
                return 1;
            }
       
        },
        'name' => $faker->word,
        'location' => $faker->word,
    ];
});
