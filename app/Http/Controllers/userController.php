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
    public function setupNewUser(Request $request){
        $inData = $request->all();
        $userName = $inData['params']['name'];
        $userEmail = $inData['params']['email'];
        $userPassword = $inData['params']['password'];
        $userOrg = $inData['params']['org'];
        $thisUserInstance = new User;
        try {
            $existingUser = $thisUserInstance->checkUserOrgMembership($userEmail);
        } catch (\Exception $e) {
            abort(500, 'Server error looking up user: '.$e->getMessage());
        }
        if(count($existingUser)>0){
            foreach($existingUser as $thisExistingUser){
                if($thisExistingUser->orgId==$userOrg){
                    $userFoundInfo = ['result'=>'userFound', 'userOrg'=>$thisExistingUser->description];
                    return json_encode($userFoundInfo);
                }
            }
            $thisOrg = new Org;
            try {
                $thisOrg->addUserToOrg($userOrg, $existingUser[0]->userId);
                $userFoundInfo = ['result'=>'userAddedToOrg'];
                return json_encode($userFoundInfo);
            } catch (\Exception $e) {
                abort(500, 'Server error adding user to org: '.$e->getMessage());
            }
        }
        $newUserId=null;
        DB::beginTransaction();
        try {
            try {
                $newUserId = $thisUserInstance->createUser($userEmail, $userName, $userPassword);
            } catch (Exception $e) {
                throw $e;
            }
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
        }catch (\Exception $e) {
            DB::rollback();
            abort(500, 'Server error creating user: '.$e->getMessage());
        }
        $thisOrg = new Org;

        try {
            $thisOrg->addUserToOrg($userOrg, $newUserId);
            DB::commit();
            return response()->json([
                'result' => 'ok',
                'description' => $userEmail,
                'userId' => $newUserId,
                'userName' => $userName
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            abort(500, 'Server error adding user to org: '.$e->getMessage());
        }


    }
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

    public function findUserByEmail(Request $request){
        $inData = $request->all();
        $userEmail = $inData['email'];

        $userInstance = new User;
        $userFound = $userInstance->findUserByEmail($userEmail);
        return json_encode($userFound);

    }

}
