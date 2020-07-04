<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupsController extends Controller
{
    public function getGroupMembers(Request $request){
        if(auth()->user()==null){
            abort(401, 'Unauthorized action.');
        }else{
            $userId = auth()->user()->id;
        }
        $inData =  $request->all();
        $thisGroupId = $inData['groupId'];
        $groupInstance = new Group;
        $members = $groupInstance->getUsersInGroup($thisGroupId[0]);
        return json_encode($members);
    }
}
