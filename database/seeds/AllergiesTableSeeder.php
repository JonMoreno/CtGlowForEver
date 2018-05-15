<?php

use Illuminate\Database\Seeder;

class AllergiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(App\Client\Allergie::class , 100)->create();
       
    }
}
