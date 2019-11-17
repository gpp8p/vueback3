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


        return json_encode($thisLayoutCardInstances);
    }

}
