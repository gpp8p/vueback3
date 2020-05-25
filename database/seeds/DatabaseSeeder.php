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
        $this->call(userSeed::class);
        $this->call(orgSeed::class);
        $this->call(groupSeed::class);
        $this->call(permSeed::class);
    }
}
