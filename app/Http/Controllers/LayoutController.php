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
        $background = "background-color: ".$inData['background'].";";
        $thisLayout = new Layout;
        $newLayoutId = $thisLayout->createBlankLayout($layoutName, $height, $width, $background);
        $thisCardInstance = new CardInstances;
        $newCardInstances = $thisCardInstance->getLayoutCardInstancesById($newLayoutId);
        return json_encode($newCardInstances);
    }
}
