<?php

use Faker\Generator as Faker;

$factory->define(App\Client\Purchase\Product::class, function (Faker $faker) {
    return [
        'sold_price' => $faker->numberBetween(0, 300),

        'client_id' => function() {
            return (App\Client\Client::all()->keys())->random();

        },
        'invoice_id' => function() {
            return (App\Client\Invoices\Invoice::all()->keys())->random();
           
        },
        'product_id' => function() {
            $values = (App\Client\Products\Product::all()->keys())->random();
            if ($values != 0){
                return $values;
            }else {
                return 1;
            }
           
        },
      
    
    ];
});
