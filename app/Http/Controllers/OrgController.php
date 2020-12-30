<?php

namespace App\Http\Controllers;

use App\Group;
use App\Org;
use Illuminate\Http\Request;
use App\Layout;
use App\User;
use Illuminate\Support\Facades\DB;

class OrgController extends Controller
{
    public function getOrgIdFromName(Request $request){
        $inData = $request->all();
        $orgName = $inData['orgName'];
        $thisOrg = new Org();
        try {
            $thisOrgId = $thisOrg->getOrgId($orgName);
            return response()->json([
                'orgId'=>$thisOrgId,
                'result'=>'ok'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'result'=>'error',
                'errorDescription'=>$e>getMessage()
            ]);
        }
    }
    public function getOrgHomeFromName(Request $request){
        $inData = $request->all();
        $orgName = $inData['orgName'];
        $userId = $inData['userId'];
        $thisOrg = new Org();
        try {
            $thisOrgInfo = $thisOrg->getOrgHome($orgName);
        } catch (\Exception $e) {
            return response()->json([
                'result'=>'error',
                'errorDescription'=>$e>getMessage()
            ]);
        }
        $thisLayout = new Layout;
        try {
            $layoutPerms = $thisLayout->summaryPermsForLayout($userId, $thisOrgInfo[0]->id, $thisOrgInfo[0]->top_layout_id);
            return response()->json([
                'orgHome'=>$thisOrgInfo[0]->top_layout_id,
                'orgId'=>$thisOrgInfo[0]->id,
                'perms'=>$layoutPerms,
                'result'=>'ok',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result'=>'error',
                'errorDescription'=>$e>getMessage()
            ]);
        }
    }


    public function getOrgList(Request $request){
        $thisOrg = new Org();
        $allOrgs = $thisOrg->getOrgList();
        return json_encode($allOrgs);

    }

    public function getOrgUsers(Request $request){
        $inData = $request->all();
        $orgId = $inData['orgId'];
        $thisOrg = new Org();
        $allOrgUsers = $thisOrg->getOrgUsers($orgId);
        return json_encode($allOrgUsers);

    }
    public function getAvailableOrgUsers(Request $request){
        $inData = $request->all();
        $orgId = $inData['orgId'];
        $groupId = $inData['groupId'];
        $thisOrg = new Org();
        $allOrgUsers = $thisOrg->getAvailableOrgUsers($groupId, $orgId);
        return json_encode($allOrgUsers);

    }
     public function getAllUsers(Request $request){
         if(auth()->user()==null){
             abort(401, 'Unauthorized action.');
         }else{
             $userId = auth()->user()->id;
         }
        $thisUser = new User;
        $allUsers = $thisUser->getAllUsers();
         return json_encode($allUsers);

     }

     public function getAvailableUsers(Request $request){
         if(auth()->user()==null){
             abort(401, 'Unauthorized action.');
         }else{
             $userId = auth()->user()->id;
         }
         $inData = $request->all();
         $orgId = $inData['orgId'];
         $thisOrg = new Org();
         $availableUsers = $thisOrg->getAvailableUsers($orgId);
         return json_encode($availableUsers);

     }


     public function userOrgPerms(Request $request){
         $inData = $request->all();
         $orgId = $inData['orgId'];
         if(auth()->user()==null){
             abort(401, 'Unauthorized action.');
         }else{
             $userId = auth()->user()->id;
         }
         $thisOrg = new Org();
         try {
             $orgHome = $thisOrg->getOrgHomeFromOrgId($orgId);
         } catch (\Exception $e) {
             abort(500, 'Error looking up organization home');
         }
         $layoutInstance = new Layout;
         try {
             $thisLayoutPerms = $layoutInstance->summaryPermsForLayout($userId, $orgId, $orgHome[0]->top_layout_id);
         } catch (\Exception $e) {
             abort(500, 'Error getting admin perms for organization home');
         }
         return json_encode($thisLayoutPerms);


     }
     public function newOrg(Request $request){
         $inData = $request->all();
         $name = $inData['params']['name'];
         $description = $inData['params']['description'];
         $height = $inData['params']['height'];
         $width = $inData['params']['width'];
         $backgroundColor = $inData['params']['backgroundColor'];
         $adminUserId = $inData['params']['adminUserId'];
         $adminUserEmail = $inData['params']['adminUserEmail'];
         $adminUserName = $inData['params']['adminUserName'];
         $backgroundType = $inData['params']['backgroundType'];
         if($backgroundType=='I'){
             $backgroundColor = '';
             $backgroundImage = $inData['params']['backgroundImage'];
         }else{
             $backgroundImage = '';
         }
         $layoutInstance = new Layout;
         $orgInstance = new Org;
         DB::beginTransaction();
         try {
             $newLayoutId = $layoutInstance->createLayoutWithoutBlanks($name, $height, $width, $description, $backgroundColor, $backgroundImage, $backgroundType);
             try {
                 $newOrgId = $orgInstance->createNewOrg($name, $description, $newLayoutId);
             } catch (\Exception $e) {
                 throw $e;
             }
             try {
                 $orgInstance->addUserToOrg($newOrgId, $adminUserId);
             } catch (\Exception $e) {
                 throw $e;
             }
             $thisGroup = new Group;
             $up = $thisGroup->returnPersonalGroupId($adminUserId);
             if($up==null){
                 throw new \Exception('no personal group');
             }
             try {
                 $allUserGroupId = $thisGroup->returnAllUserGroupId();
             } catch (\Exception $e) {
                 throw new \Exception('error identifying all user group');
             }
             if($allUserGroupId==null){
                 throw new \Exception('no all user group');
             }
             try {
                 $thisGroup->addOrgToGroup($newOrgId, $up);
             } catch (\Exception $e) {
                 throw $e;
             }
             try {
                 $newLayoutGroupId = $thisGroup->addNewLayoutGroup($newLayoutId, $name, $description);
             } catch (\Exception $e) {
                 throw $e;
             }
             try {
                 $thisGroup->addOrgToGroup($newOrgId, $newLayoutGroupId);
             } catch (\Exception $e) {
                 throw $e;
             }
             try {
                 $thisGroup->addOrgToGroup($newOrgId, $allUserGroupId);
             } catch (\Exception $e) {
                 throw $e;
             }

             try {
                 $thisGroup->addUserToGroup($adminUserId, $newLayoutGroupId);
             } catch (\Exception $e) {
                 throw $e;
             }
             try {
                 $layoutInstance->editPermForGroup($newLayoutGroupId, $newLayoutId, 'view', 1);
             } catch (\Exception $e) {
                 throw $e;
             }
             try {
                 $layoutInstance->editPermForGroup($allUserGroupId, $newLayoutId, 'view', 1);
             } catch (\Exception $e) {
                 throw $e;
             }
             $userPersonalGroupId = $up;
             try {
                 $layoutInstance->editPermForGroup($userPersonalGroupId, $newLayoutId, 'view', 1);
                 $layoutInstance->editPermForGroup($userPersonalGroupId, $newLayoutId, 'author', 1);
                 $layoutInstance->editPermForGroup($userPersonalGroupId, $newLayoutId, 'admin', 1);
             } catch (\Exception $e) {
                 throw $e;
             }

             DB::commit();
             return json_encode($newOrgId);
         } catch (\Exception $e) {
             DB::rollBack();
             return response()->json([
                 'result'=>'error',
                 'errorDescription'=>$e>getMessage()
             ]);
         }

     }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function show(Org $org)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function edit(Org $org)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Org $org)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function destroy(Org $org)
    {
        //
    }
}
