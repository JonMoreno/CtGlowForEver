<?php

use Illuminate\Database\Seeder;

class IllnessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client\Illness::class, 100)->create();
    
    }
}
