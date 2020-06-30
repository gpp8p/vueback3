<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Org;
use App\Layout;
use App\User;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{

    public function createUser(Request $request){
        $inData = $request->all();
        $userName = $inData['name'];
        $userEmail = $inData['email'];
        $userPassword = $inData['password'];
        $thisUserInstance = new User;
        try {
            try {
                $newUserId = $thisUserInstance->createUser($userEmail, $userName, $userPassword);
            } catch (Exception $e) {
                throw $e;
            }
/*
            $thisOrgInstance = new Org;
            try {
                $thisOrgInstance->addUserToOrg($orgId, $newUserId);
            } catch (Exception $e) {
                throw $e;
            }
*/
            $thisGroupInstance = new Group;
            try {
                $newPersonalGroupId = $thisGroupInstance->addNewPersonalGroup($userName, $userEmail);
            } catch (Exception $e) {
                throw $e;
            }
            try {
                $thisGroupInstance->addUserToGroup($newUserId, $newPersonalGroupId);
            } catch (Exception $e) {
                throw $e;
            }
            $allUserGroupId = DB::table('groups')->where('group_label', 'AllUsers')->first()->id;
            try {
                $thisGroupInstance->addUserToGroup($newUserId, $allUserGroupId);
            } catch (Exception $e) {
                throw $e;
            }
/*
            $loggedInUserGroupId = DB::table('groups')->where('group_label', 'loggedInUsers')->first()->id;
            try {
                $thisGroupInstance->addUserToGroup($newUserId, $loggedInUserGroupId);
            } catch (Exception $e) {
                throw $e;
            }
*/
            return response()->json([
                'result'=>'ok',
                'description'=>$userEmail,
                'userId'=>$newUserId,
                'userName'=>$userName
            ]);
        } catch (Exception $e) {
            return response()->json([
                'result'=>'error',
                'errorDescription'=>$e>getMessage()
            ]);
        }
    }

}
