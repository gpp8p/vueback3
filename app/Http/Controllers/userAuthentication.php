<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class userAuthentication extends Controller
{
    public function authenticate(Request $request)
    {
        $inData =  $request->all();
        $email = $inData['email'];
        $password = $inData['password'];
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
            return "ok";
        }
    }
}
