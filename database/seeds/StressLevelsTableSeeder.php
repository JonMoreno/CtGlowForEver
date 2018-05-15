<?php

use Illuminate\Database\Seeder;

class StressLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client\StressLevel::class, 100)->create();
        
    }
}
