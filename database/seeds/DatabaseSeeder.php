<?php

use Illuminate\Database\Seeder;
use App\CardInstances;
use App\InstanceParams;
use App\ViewType;
use App\Card;
use App\Layout;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ViewTypeTableSeeder::class);
        // Disable all mass assignment restrictions
        CardInstances::unguard();


        $this->call(CardInstancesTableSeeder::class);

        // Re enable all mass assignment restrictions
        CardInstances::reguard();
        InstanceParams::unguard();
        $this->call(InstanceParamsTableSeeder::class);
        InstanceParams::reguard();

    }
}
