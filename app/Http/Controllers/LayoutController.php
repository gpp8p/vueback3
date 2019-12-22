<?php

namespace App\Http\Controllers;

use App\Layout;
use Illuminate\Http\Request;
use App\CardInstances;

class LayoutController extends Controller
{
    public function createBlankLayout(Request $request){
        $inData =  $request->all();
        $layoutName = $inData['name'];
        $height = $inData['height'];
        $width = $inData['width'];
//        $background = $inData['background'];
        $background = '#DBAA6E';
        $cardParams = [['background-color', $background, true],['color','blue', true]];
        $thisLayout = new Layout;
        $testLayoutDescription = "New Layout for test purposes";
        $newLayoutId = $thisLayout->createBlankLayout($layoutName, $height, $width, $cardParams, $testLayoutDescription);
        $thisCardInstance = new CardInstances;
        $newCardInstances = $thisCardInstance->getLayoutCardInstancesById($newLayoutId);
        return json_encode($newCardInstances);
    }

    public function getLayoutList(Request $request){
        $returnList = array();
        $layoutInstance = new Layout;
        $allLayouts = $layoutInstance->all();
//        foreach($allLayouts as $thisLayout){
//            array_push($returnList, [$thisLayout->id,$thisLayout->menu_label,$thisLayout->description,$thisLayout->height, $thisLayout->width]);
//        }
        return json_encode($allLayouts);
    }
}
