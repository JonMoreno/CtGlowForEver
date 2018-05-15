<?php

use Illuminate\Database\Seeder;

class PurchaseDiscountTableSeeder extends Seeder
{
    /**   
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client\Purchase\Discount::class, 100)->create();
        
    }
}
