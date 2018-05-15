<?php 

use Faker\Generator as Faker;

/*
 |--------------------------------------------------------------------------
 | Client Model Factories
 |--------------------------------------------------------------------------
 | Seed a Client model. 
 |
 */

$factory->define(App\Client\Client::class, function (Faker $faker){
    return [
        'first_name' => $faker->firstName($gender = null),//2
        'last_name' => $faker->lastName,//3
        'mid_initial' => $faker->randomLetter,//4
        'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),//5
        'street' => $faker->buildingNumber . ' ' .$faker->streetName,//6
        'apt_floor' => $faker->numerify('apt ###'),
        'city' => $faker->city,//7
        'state' => $faker->state,//8
        'zip' => $faker->postcode,//9
        'work_phone' => $faker->phoneNumber,//10
        'emergency_phone' =>$faker->phoneNumber,//11
        'cellular' => $faker->phoneNumber,//12
        'occupation' => $faker->jobTitle,//13
        'gender' => $faker->randomElement(['male', 'female']),//14       
        'image' => 'temp_user.png', //15
        'first_facial' => $faker->boolean(50),//16
        'visit_reason' => $faker->sentence(8, true),//17
        'complete' =>  $faker->boolean(50),
        
    ];
});







