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
        $thisCardInstanceParameter = array();
        $thisCardInstanceText = "";
        $thisCardInstanceComponent = $thisLayoutCardInstances[0]->card_component;
        $lastCard = count($thisLayoutCardInstances)-1;
        $instancesAdded = 0;
        for($i =0; $i< count($thisLayoutCardInstances); $i++){
            if($thisLayoutCardInstances[$i]->id != $thisCardInstanceId){
                $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_parameters'=>$thisCardInstanceParameter);
                $thisCardInstanceParameter = array();
                $thisCardInstanceText = "";
                $thisCardInstanceComponent = $thisLayoutCardInstances[$i]->card_component;
                array_push($allCardInstances, $newCardInstance);
                $instancesAdded++;
                $thisCardInstanceId = $thisLayoutCardInstances[$i]->id;
                $thisCardInstanceParameter[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;
            }else{
                $thisCardInstanceParameter[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;
            }
        }
        $thisCardInstanceParameter[$thisLayoutCardInstances[$i-1]->parameter_key]=$thisLayoutCardInstances[$i-1]->parameter_value;
        $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_parameters'=>$thisCardInstanceParameter);
        array_push($allCardInstances, $newCardInstance);



        return json_encode($allCardInstances);
    }

    public function getLayoutById(Request $request){
        $inData =  $request->all();
        $layoutId = $inData['layoutId'];
        $thisCardInstance = new CardInstances;
        $thisLayoutCardInstances = $thisCardInstance->getLayoutCardInstancesById($layoutId);
        $thisCardInstanceId = $thisLayoutCardInstances[0]->id;
        $allCardInstances = array();
        $thisCardInstanceParameter = array();
//        $gridCss=$this->computeGridCss($thisLayoutCardInstances[0]->row, $thisLayoutCardInstances[0]->col, $thisLayoutCardInstances[0]->height, $thisLayoutCardInstances[0]->height);
        $thisCardInstanceText = "";
        $thisCardInstanceComponent = $thisLayoutCardInstances[0]->card_component;
        $lastCard = count($thisLayoutCardInstances)-1;
        $instancesAdded = 0;
        for($i =0; $i< count($thisLayoutCardInstances); $i++){
            if($thisLayoutCardInstances[$i]->id != $thisCardInstanceId){
                if(array_key_exists ( 'style' ,$thisCardInstanceParameter )){
                    $gridCss=$this->computeGridCss($thisLayoutCardInstances[$i]->row, $thisLayoutCardInstances[$i]->col, $thisLayoutCardInstances[$i]->height, $thisLayoutCardInstances[$i]->width);
                }
                $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_parameters'=>$thisCardInstanceParameter);
                $gridCss=$this->computeGridCss($thisLayoutCardInstances[$i]->row, $thisLayoutCardInstances[$i]->col, $thisLayoutCardInstances[$i]->height, $thisLayoutCardInstances[$i]->width);
                $thisCardInstanceParameter = array();
                $thisCardInstanceText = "";
                $thisCardInstanceComponent = $thisLayoutCardInstances[$i]->card_component;
                array_push($allCardInstances, $newCardInstance);
                $instancesAdded++;
                $thisCardInstanceId = $thisLayoutCardInstances[$i]->id;
                $thisCardInstanceParameter[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;
            }else{
                if(!array_key_exists ( 'style' ,$thisCardInstanceParameter )){
                    $gridCss=$this->computeGridCss($thisLayoutCardInstances[$i]->row, $thisLayoutCardInstances[$i]->col, $thisLayoutCardInstances[$i]->height, $thisLayoutCardInstances[$i]->width);
                }
                $thisCardInstanceParameter[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;

            }
        }
        $thisCardInstanceParameter[$thisLayoutCardInstances[$i-1]->parameter_key]=$thisLayoutCardInstances[$i-1]->parameter_value;
        $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_parameters'=>$thisCardInstanceParameter);
        array_push($allCardInstances, $newCardInstance);



        return json_encode($allCardInstances);
    }

    private function computeGridCss($row, $col, $height, $width){
        $startRow = $row;
        $startColumn = $col;
        $endRow=0;
        $endCol = 0;

        if($height==1){
            $endRow = $row;
        }else{
            $endRow = $row+$height;
        }
        $endCol=$startColumn+$width;
        $thisCss = "grid-area:".$startRow."/".$startColumn."/".$endRow."/".$endCol.";";
        return $thisCss;

    }


}
