<?php

use Illuminate\Database\Seeder;
use App\CardInstances;

class CardInstancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\CardInstances', 5)->create();
    }
}
