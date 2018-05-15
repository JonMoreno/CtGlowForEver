<?php

use Illuminate\Database\Seeder;

class ConsultationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client\Consultation::class, 100)->create();

    }
      
}
