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
        $faker = Faker::create();
        $instances = CardInstances::all();
        foreach($instances as $thisInstance){
            $instanceId = $thisInstance->id;
            $newParam = new InstanceParams;
            $newParam->card_instance_id = $instanceId;
            $newParam->parameter_key='height';
            $newParam->parameter_value='30vh;';
            $newParam->save();
            $newParam = new InstanceParams;
            $newParam->card_instance_id = $instanceId;
            $newParam->parameter_key='width';
            $newParam->parameter_value='30vw;';
            $newParam->save();
            $newParam = new InstanceParams;
            $newParam->card_instance_id = $instanceId;
            $newParam->parameter_key='message';
            $newParam->parameter_value=$faker->sentence($nbWords = 6, $variableNbWords = true);
            $newParam->save();
        }


    }
}
