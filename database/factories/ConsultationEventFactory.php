<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Calendar\ConsultationEvent::class, function (Faker $faker) {
    return [
        'client_id' => function(){
            $clientId = (App\Client\Client::all()->keys())->random();
            if($clientId != 0){
                return $clientId;
            }else{
                return 1;
            }
        },
        'time' => $faker->time($format='H:i:s', $max = null),
        'date' => $faker->dateTimeBetween('-250 days', '+ 250 days'),
        'description' => $faker->sentence(8, true),

    ];
});
