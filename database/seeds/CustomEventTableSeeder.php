<?php

use Illuminate\Database\Seeder;

class CustomEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client\Calendar\CustomEvent::class, 250)->create();
    }
}
