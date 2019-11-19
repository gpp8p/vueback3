<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CardInstances;

class cardInstanceController extends Controller
{
    public function getLayoutCardInstances(Request $request){
        $inData =  $request->all();
        $thisLayoutName = $inData['layout_name'];
        $thisCardInstance = new CardInstances;
        $thisLayoutCardInstances = $thisCardInstance->getLayoutCardInstances($thisLayoutName);
        $thisCardInstanceId = $thisLayoutCardInstances[0]->id;
        $allCardInstances = array();
        $thisCardInstanceStyle = "";
        $thisCardInstanceText = "";
        $thisCardInstanceComponent = $thisLayoutCardInstances[0]->card_component;
        $lastCard = count($thisLayoutCardInstances)-1;
        for($i =0; $i< count($thisLayoutCardInstances); $i++){
            if($thisLayoutCardInstances[$i]->id != $thisCardInstanceId){
                $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_styling'=>$thisCardInstanceStyle, 'message'=>$thisCardInstanceText);
                $thisCardInstanceStyle = "";
                $thisCardInstanceText = "";
                $thisCardInstanceComponent = $thisLayoutCardInstances[$i]->card_component;
                array_push($allCardInstances, $newCardInstance);
                $thisCardInstanceId = $thisLayoutCardInstances[$i]->id;
                if(strcmp($thisLayoutCardInstances[$i]->parameter_key,'message')==0){
                    $thisCardInstanceText = $thisLayoutCardInstances[$i]->parameter_value;
                }else{
                    $thisKey = $thisLayoutCardInstances[$i]->parameter_key;
                    $thisValue = $thisLayoutCardInstances[$i]->parameter_value;
                    $thisCardInstanceStyle = $thisCardInstanceStyle.' '.$thisKey.':'.$thisValue.' ';
                }
            }else{
                if(strcmp($thisLayoutCardInstances[$i]->parameter_key,'message')==0){
                    $thisCardInstanceText = $thisLayoutCardInstances[$i]->parameter_value;
                }else{
                    $thisKey = $thisLayoutCardInstances[$i]->parameter_key;
                    $thisValue = $thisLayoutCardInstances[$i]->parameter_value;
                    $thisCardInstanceStyle = $thisCardInstanceStyle.' '.$thisKey.':'.$thisValue.' ';
                }
            }
        }
        if(strcmp($thisLayoutCardInstances[$lastCard]->parameter_key,'message')==0){
            $thisCardInstanceText = $thisLayoutCardInstances[$lastCard]->parameter_value;
        }else{
            $thisCardInstanceStyle = $thisCardInstanceStyle.$thisLayoutCardInstances[$lastCard]->parameter_key.':'.$thisLayoutCardInstances[$lastCard]->parameter_value.' ';
        }
        $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_styling'=>$thisCardInstanceStyle, 'message'=>$thisCardInstanceText);
        array_push($allCardInstances, $newCardInstance);



        return json_encode($allCardInstances);
    }

}
