<?php

use Illuminate\Database\Seeder;

class MedicalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client\Medical::class, 50)->create();
        
    }
}
