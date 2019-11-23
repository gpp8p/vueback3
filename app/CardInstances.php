<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CardInstances extends Model
{
    public function viewType()
    {
        return $this->belongsTo('App\ViewType');
    }

    public function params()
    {
        return $this->hasMany(InstanceParams::class);
    }

    public function getLayoutCardInstances($layoutName){
        $query = "select instance.id,parameter_key, parameter_value, card_component from card_instances as instance, instance_params as params, layouts as layouts ".
                "where params.card_instance_id = instance.id ".
                "and instance.layout_id = layouts.id ".
                "and layouts.menu_label = ? ".
                "order by instance.id";

        $retrievedCardInstances  =  DB::select($query, [$layoutName]);
        if(count($retrievedCardInstances)>0) {
            return $retrievedCardInstances;
        }else{
            return null;
        }
    }

    public function getLayoutCardInstancesById($layoutId){
        $query = "select instance.id,parameter_key, parameter_value, card_component from card_instances as instance, instance_params as params, layouts as layouts ".
            "where params.card_instance_id = instance.id ".
            "and instance.layout_id = layouts.id ".
            "and layouts.id = ? ".
            "order by instance.id";

        $retrievedCardInstances  =  DB::select($query, [$layoutId]);
        if(count($retrievedCardInstances)>0) {
            return $retrievedCardInstances;
        }else{
            return null;
        }
    }

    public function createCardInstance($layoutId, $cardParams){

        $thisCardInstance = new CardInstances;
        $thisCardInstance->layout_id = $layoutId;
        $thisCardInstance->view_type_id = App\ViewType::where('view_type_label', 'Web Browser')->first()->id;
        $thisCardInstance->card_component = "simpleCard";
        $thisCardInstance->save();
        foreach($cardParams as $thisParam){
            $thisInstanceParams = new InstanceParams;
            $thisInstanceParams->createInstanceParam();
        }

    }


}
