<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CardInstances;
use App\InstanceParams;
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
        if($thisLayoutCardInstances==null){
            $layoutProperties =array('description'=>$thisLayoutDescription, 'menu_label'=>$thisLayoutLabel, 'height'=>$thisLayoutHeight, 'width'=>$thisLayoutHeight);
            $returnData = array('cards'=>[], 'layout'=>$layoutProperties);
            return json_encode($returnData);
        }
        $thisCardInstanceId = $thisLayoutCardInstances[0]->id;
        $allCardInstances = array();
        $thisCardInstanceParameter = array();
        $thisCardInstanceProperty = array();
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
                $allProperties = "";
                foreach($thisCardInstanceParameter as $index => $value){
//                    $allCssParams = $allCssParams.$index.':'.$value.';';
                      $allCssParams = $allCssParams.$value;
                }
                foreach($thisCardInstanceProperty as $index => $value){
                    $allProperties = $allProperties.$index.chr(30).$value.chr(28);
                }
                $cardParams['style']=$allCssParams;
                $cardParams['properties']=$allProperties;
                $cardPos = array($thisRow,$thisCol,$thisHeight,$thisWidth);
                $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_parameters'=>$cardParams, 'card_position'=>$cardPos);
                array_push($allCardInstances, $newCardInstance);
                $thisRow = $thisLayoutCardInstances[$i]->row;
                $thisCol = $thisLayoutCardInstances[$i]->col;
                $thisHeight = $thisLayoutCardInstances[$i]->height;
                $thisWidth = $thisLayoutCardInstances[$i]->width;

                $thisCardInstanceParameter = array();
                $thisCardInstanceProperty = array();
                $thisCardInstanceText = "";
                $thisCardInstanceComponent = $thisLayoutCardInstances[$i]->card_component;
                $instancesAdded++;
                $thisCardInstanceId = $thisLayoutCardInstances[$i]->id;
/*
                if($thisLayoutCardInstances[$i]->isCss){
                    $thisCardInstanceParameter[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;
                }else{
                    $thisCardInstanceProperty[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;
                }
*/
            }else{
                if($thisLayoutCardInstances[$i]->isCss){
                    $thisCardInstanceParameter[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;

                }else{
                    $thisCardInstanceProperty[$thisLayoutCardInstances[$i]->parameter_key]=$thisLayoutCardInstances[$i]->parameter_value;

                }
            }
        }
        $allCssParams = $this->computeGridCss($thisRow, $thisCol, $thisHeight, $thisWidth).";";
        foreach($thisCardInstanceParameter as $index => $value){
            $allCssParams = $allCssParams.$value;
        }
        $allProperties = '';
        foreach($thisCardInstanceProperty as $index => $value){
            $allProperties = $allProperties.$index.chr(30).$value.chr(28);
        }
        $cardParams['style']=$allCssParams;
        $cardParams['properties']=$allProperties;
        $cardPos = array($thisRow,$thisCol,$thisHeight,$thisWidth);
        $newCardInstance = array('id'=>$thisCardInstanceId, 'card_component'=>$thisCardInstanceComponent, 'card_parameters'=>$cardParams, 'toDelete'=>false, 'card_position'=>$cardPos);
        array_push($allCardInstances, $newCardInstance);
        $layoutProperties =array('description'=>$thisLayoutDescription, 'menu_label'=>$thisLayoutLabel, 'height'=>$thisLayoutHeight, 'width'=>$thisLayoutHeight);
        $returnData = array('cards'=>$allCardInstances, 'layout'=>$layoutProperties);
        return json_encode($returnData);
    }
    public function saveCardOnly(Request $request){
        $inData =  $request->all();
        $layoutId = $inData['layoutId'];
        $cardTitle = $inData['cardTitle'];
        $cardType = $inData['cardType'];
        $topLeftRow = $inData['topLeftRow'];
        $topLeftCol = $inData['topLeftCol'];
        $bottomRightRow = $inData['bottomRightRow'];
        $bottomRightCol = $inData['bottomRightCol'];
        $background = '#7FDBFF';
        $cardParams = [['background-color', $background, true],['color','blue', true]];
        $thisCardInstance = new CardInstances();
        $cardWidth = ($bottomRightCol-$topLeftCol)+1;
        $cardHeight = ($bottomRightRow-$topLeftRow)+1;
        $thisCardInstance->createCardInstance($layoutId, $cardParams, $topLeftRow,$topLeftCol, $cardHeight, $cardWidth,$cardType);
        return $this->getLayoutById($request);

    }

    public function saveCard(Request $request){
        $inData =  $request->all();
        $layoutId = $inData['layoutId'];
        $cardTitle = $inData['cardTitle'];
        $cardType = $inData['cardType'];
        $topLeftRow = $inData['topLeftRow'];
        $topLeftCol = $inData['topLeftCol'];
        $bottomRightRow = $inData['bottomRightRow'];
        $bottomRightCol = $inData['bottomRightCol'];

        $query1 = "select id from card_instances  where col >= ? and row >= ? and col <= ? and row <= ? and layout_id = ?";
        $retrievedCardInstances  =  DB::select($query1, [$topLeftCol, $topLeftRow, $bottomRightCol, $bottomRightRow, $layoutId]);
        $retrievedIds = array();
        $blanksToDelete = '';
        foreach($retrievedCardInstances as $thisRetrievedId){
            array_push($retrievedIds, $thisRetrievedId->id);
            $blanksToDelete = $blanksToDelete."'".$thisRetrievedId->id."',";
        }
        $blanksToDelete = substr($blanksToDelete, 0, strlen($blanksToDelete)-1);
        $query2 = "delete from instance_params where card_instance_id in (".$blanksToDelete.")";
        $deletedParams = DB::select($query2);
        $query3 = "delete from card_instances where id in(".$blanksToDelete.")";
        $deletedCards = DB::select($query3);

        $background = '#7FDBFF';
        $cardParams = [['background-color', $background, true],['color','blue', true]];
        $thisCardInstance = new CardInstances();
        $cardWidth = ($bottomRightCol-$topLeftCol)+1;
        $cardHeight = ($bottomRightRow-$topLeftRow)+1;
        $thisCardInstance->createCardInstance($layoutId, $cardParams, $topLeftRow,$topLeftCol, $cardHeight, $cardWidth,$cardType);



        return $layoutId;
    }

    public function saveCardParameters(Request $request){
        $inData =  $request->all();
        $decodedPost = json_decode($inData['cardParams']);
        $thisInstanceParams = new InstanceParams;
        foreach ($decodedPost[1] as $key => $value) {
            $thisInstanceParams->createInstanceParam($key,$value,$decodedPost[0], true);
//            print "$key => $value\n";
        }
        foreach ($decodedPost[2] as $key => $value) {
            $thisInstanceParams->createInstanceParam($key,$value,$decodedPost[0], false);
//            print "$key => $value\n";
        }

        return "Ok";
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
