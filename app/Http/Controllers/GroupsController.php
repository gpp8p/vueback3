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
        $members = $groupInstance->getUsersInGroup($thisGroupId);
        $groupInfo = $groupInstance->getGroupInfo($thisGroupId);
        $groupAdmin=FALSE;
        foreach($members as $thisMember){
            if($thisMember->id==$userId && $thisMember->is_admin==1) $groupAdmin=TRUE;
        }
        return json_encode(['members'=>$members, 'groupAdmin'=>$groupAdmin, 'groupDescription'=>$groupInfo[0]->description]);
    }

    public function getOrgGroups(Request $request){
        if(auth()->user()==null){
            abort(401, 'Unauthorized action.');
        }else{
            $userId = auth()->user()->id;
        }
        $inData =  $request->all();
        $thisOrgId = $inData['orgId'];
        $thisLayoutId = $inData['layoutId'];
        $groupInstance = new Group;
        $groups = $groupInstance->getOrganizationGroups($thisOrgId, $userId, $thisLayoutId);
        return json_encode($groups);
    }

    public function addUserToGroup(Request $request){
        if(auth()->user()==null){
            abort(401, 'Unauthorized action.');
        }else{
            $userId = auth()->user()->id;
        }
        $inData =  $request->all();
        $groupId = $inData['params']['groupId'];
        $selectedUserId = $inData['params']['selectedUserId'][0];
        $groupInstance = new Group;
        try {
            $groupInstance->addUserToGroup($selectedUserId, $groupId);
            return "ok";
        }catch (Throwable $e) {
            abort(500, 'Server error: '.$e->getMessage());
        }
    }
}
