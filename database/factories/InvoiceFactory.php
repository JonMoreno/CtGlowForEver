<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Invoices\Invoice::class, function (Faker $faker) {
    return [
        'client_id' => function() {
            $values = ( App\Client\Client::all()->keys() )->random();
            if ($values != 0){
                return $values;
            }else {
                return 1;
            }

        },
        'consultation_id' => function() {
            return factory(App\Client\Consultation::class)->create()->id;
            
        },
        'total_price' => $faker->numberBetween(0, 500),
                        
    ];
});
