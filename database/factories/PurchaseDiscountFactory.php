<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Purchase\Discount::class, function (Faker $faker) {
    return [
        'service' =>  $faker->randomElement(['product', 'treatment']),
        'service_id' => $faker->numberBetween(1, 300),
        'discount_price' => $faker->numberBetween(0, 300),        
        'client_id' => function() {
            return (App\Client\Client::all()->keys())->random();

        },
        'invoice_id' => function() {
            $values = (App\Client\Invoices\Invoice::all()->keys())->random();
            if ($values != 0){
                return $values;
            }else {
                return 1;
            }
           
        },
        'discount_id' => function() {
            $values = (App\Client\Products\Discount::all()->keys())->random();
            if ($values != 0){
                return $values;
            }else {
                return 1;
            }
           
        },
      
        
    ];
});
