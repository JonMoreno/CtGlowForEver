<?php

use Illuminate\Database\Seeder;

class MedicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
        factory(App\Client\Medication::class, 100)->create();
        
    }
}
