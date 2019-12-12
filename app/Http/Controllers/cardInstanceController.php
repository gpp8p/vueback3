<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CardInstances;
use App\layout;
use Illuminate\Support\Facades\DB;

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
        $layoutInstance = new Layout;
        $layoutInfo = $layoutInstance->where('id', $layoutId)->get();
        $thisLayoutDescription = $layoutInfo[0]->description;
        $thisLayoutWidth = $layoutInfo[0]->width;
        $thisLayoutHeight = $layoutInfo[0]->height;
        $thisLayoutLabel = $layoutInfo[0]->menu_label;
        $thisCardInstance = new CardInstances;
        $thisLayoutCardInstances = $thisCardInstance->getLayoutCardInstancesById($layoutId);
        $thisCardInstanceId = $thisLayoutCardInstances[0]->id;
        $allCardInstances = array();
        $thisCardInstanceParameter = array();
//        $gridCss=$this->computeGridCss($thisLayoutCardInstances[0]->row, $thisLayoutCardInstances[0]->col, $thisLayoutCardInstances[0]->height, $thisLayoutCardInstances[0]->height);
        $thisCardInstanceText = "";
        $thisCardInstanceComponent = $thisLayoutCardInstances[0]->card_component;
        $thisRow = $thisLayoutCardInstances[0]->row;
        $thisCol = $thisLayoutCardInstances[0]->col;
        $thisHeight = $thisLayoutCardInstances[0]->height;
        $thisWidth = $thisLayoutCardInstances[0]->width;
        $lastCard = count($thisLayoutCardInstances)-1;
        $instancesAdded = 0;
        for($i =0; $i< count($thisLayoutCardInstances); $i++){
            if($thisLayoutCardInstances[$i]->id != $thisCardInstanceId){
                $allCssParams = $this->computeGridCss($thisRow, $thisCol, $thisHeight, $thisWidth).";";
                foreach($thisCardInstanceParameter as $index => $value){
                    $allCssParams = $allCssParams.$index.':'.$value.';';
                }
                $cardCssParameters['style']=$allCssParams;
                $cardPos = array($thisRow,$thisCol,$thisHeight,$thisWidth);
                $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_parameters'=>$cardCssParameters, 'card_position'=>$cardPos);
                array_push($allCardInstances, $newCardInstance);
                $thisRow = $thisLayoutCardInstances[$i]->row;
                $thisCol = $thisLayoutCardInstances[$i]->col;
                $thisHeight = $thisLayoutCardInstances[$i]->height;
                $thisWidth = $thisLayoutCardInstances[$i]->width;

                $thisCardInstanceParameter = array();
                $thisCardInstanceText = "";
                $thisCardInstanceComponent = $thisLayoutCardInstances[$i]->card_component;
                $instancesAdded++;
                $thisCardInstanceId = $thisLayoutCardInstances[$i]->id;
                if($thisLayoutCardInstances[$i]->isCss){
                    $thisCardInstanceParameter[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;
                }
            }else{
                if($thisLayoutCardInstances[$i]->isCss){
                    $thisCardInstanceParameter[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;
                }
            }
        }
        $allCssParams = $this->computeGridCss($thisRow, $thisCol, $thisHeight, $thisWidth).";";
        foreach($thisCardInstanceParameter as $index => $value){
            $allCssParams = $allCssParams.$index.':'.$value.';';
        }
        $cardCssParameters['style']=$allCssParams;
        $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_parameters'=>$cardCssParameters, 'card_parameters'=>$cardCssParameters, 'card_position'=>$cardPos);
        array_push($allCardInstances, $newCardInstance);
        $layoutProperties =array('description'=>$thisLayoutDescription, 'menu_label'=>$thisLayoutLabel, 'height'=>$thisLayoutHeight, 'width'=>$thisLayoutHeight);
        $returnData = array('cards'=>$allCardInstances, 'layout'=>$layoutProperties);
        return json_encode($returnData);
    }

    public function saveCard(Request $request){
        $inData =  $request->all();
        $layoutId = $inData['layoutId'];
        $cardTitle = $inData['cardTitle'];
        $topLeftRow = $inData['topLeftRow'];
        $topLeftCol = $inData['topLeftCol'];
        $bottomRightRow = $inData['bottomRightRow'];
        $bottomRightCol = $inData['bottomRightCol'];

        $query = "select id from card_instances  where col >= ? and row >= ? and col <= ? and row <= ? and layout_id = ?";
        $retrievedCardInstances  =  DB::select($query, [$topLeftCol, $topLeftRow, $bottomRightCol, $bottomRightRow, $layoutId]);
        $retrievedIds = array();
        foreach($retrievedCardInstances as $thisRetrievedId){
            array_push($retrievedIds, $thisRetrievedId->id);
        }


        return $retrievedIds;
    }

    public function getCsrf(){
        return csrf_token();
    }

    public function serveTest(){
        return view('serveCrsfTest');
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
        $thisCss = "grid-area:".$startRow."/".$startColumn."/".$endRow."/".$endCol;
        return $thisCss;

    }

    private function computeCssFromCoordinates($topLeftRow, $topLeftCol, $bottomRightRow, $bottomRightCol){
        $thisHeight=0;
        $thisWidth=0;
        if($topLeftRow = $bottomRightRow){
            $thisHeight = 1;
        }else{
            $thisHeight = $bottomRightRow-$topLeftRow;
        }
        $thisWidth = $bottomRightCol-$topLeftCol;
        return $this->computeGridCss($topLeftRow, $topLeftCol, $thisHeight, $thisWidth);
    }




}
