<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstanceParams extends Model
{
    function createInstanceParam($key, $value, $instanceId){
        $newParam = new InstanceParams;
        $newParam->card_instance_id = $instanceId;
        $newParam->parameter_key=$key;
        $newParam->parameter_value=$value;
        $newParam->save();
    }
}
