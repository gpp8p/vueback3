<?php

use Illuminate\Database\Seeder;
use App\CardInstances;
use App\InstanceParams;
use Faker\Factory as Faker;

class InstanceParamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $styles = array();
        array_push($styles, "grid-area: 1 / 1 / 1 / 3; background-color: crimson;");
        array_push($styles, "grid-area: 2 / 2 / 2 / 2; background-color: blue;");
        array_push($styles, "grid-area: 1 / 3 / 3 / 3; background-color: green;");
        array_push($styles, "grid-area: 2 / 1 / 2 / 1; background-color: coral;");
        $faker = Faker::create();
        $instances = CardInstances::all();
        foreach($instances as $thisInstance){
            $instanceId = $thisInstance->id;
            $newParam = new InstanceParams;
            $newParam->card_instance_id = $instanceId;
            $newParam->parameter_key='style';
            $newParam->parameter_value=$styles[$instanceId-1];
            $newParam->save();
            $newParam = new InstanceParams;
            $newParam->card_instance_id = $instanceId;
            $newParam->parameter_key='message';
            $newParam->parameter_value=$faker->sentence($nbWords = 6, $variableNbWords = true);
            $newParam->save();
         }
    }
}
