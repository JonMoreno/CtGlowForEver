<?php

use Illuminate\Database\Seeder;

class SkinProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client\SkinProduct::class, 100)->create();
        
    }
}
