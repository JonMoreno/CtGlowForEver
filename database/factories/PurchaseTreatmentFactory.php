<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Purchase\Treatment::class, function (Faker $faker) {
    return [
        'sold_price' => $faker->numberBetween(0, 300),
        
        'client_id' => function() {
            return (App\Client\Client::all()->keys())->random();

        },
        'invoice_id' => function() {
            return (App\Client\Invoices\Invoice::all()->keys())->random();
           
        },
        'treatment_id' => function() {
            return (App\Client\Products\Treatment::all()->keys())->random();
           
        },
      
        
    ];
});