<?php

use Illuminate\Database\Seeder;

class ConsultationEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client\Calendar\ConsultationEvent::class, 250)->create();
    }
}
