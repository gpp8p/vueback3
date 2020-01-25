<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    function recieveFile(Request $request){
        $inData =  $request->all();
        $path = $request->file('file')->store('file');
        return $path;
    }
}
