<?php

use Illuminate\Database\Seeder;

class PurchaseProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(App\Client\Purchase\Product::class, 100)->create();
       
    }
}
