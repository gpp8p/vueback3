<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ViewType;

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
        $query = "select instance.id,parameter_key, parameter_value, card_component, isCss, ".
            "instance.col, instance.row, instance.height, instance.width ".
            "from card_instances as instance, instance_params as params, layouts as layouts ".
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

    public function createCardInstance($layoutId, $cardParams, $row, $column, $height, $width, $cardType){

        $thisCardInstance = new CardInstances;
        $thisCardInstance->layout_id = $layoutId;
        $thisCardInstance->view_type_id = ViewType::where('view_type_label', 'Web Browser')->first()->id;
        $thisCardInstance->card_component = $cardType;
        $thisCardInstance->row = $row;
        $thisCardInstance->col = $column;
        $thisCardInstance->height = $height;
        $thisCardInstance->width = $width;
        $thisCardInstance->save();
        $newCardInstanceId = $thisCardInstance->id;
        foreach($cardParams as $thisParam){
            $thisInstanceParams = new InstanceParams;
            $thisInstanceParams->createInstanceParam($thisParam[0], $thisParam[1], $thisCardInstance->id, $thisParam[2]);
        }
        return $newCardInstanceId;

    }




}
