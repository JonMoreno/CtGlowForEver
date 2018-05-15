<?php

use Illuminate\Database\Seeder;

class TreatmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        factory(App\Client\Products\Treatment::class, 100)->create();
        
    }
}
