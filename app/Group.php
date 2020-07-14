<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    public function addNewLayoutGroup($layoutId, $layoutLabel, $layoutDescription){
        $thisGroupDescription = "Permitted into ".$layoutLabel;
        $thisGroupLabel = $layoutLabel;
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>$thisGroupLabel,
            'description'=>$thisGroupDescription,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        return $thisGroupId;
    }

    public function returnPersonalGroupId($userId){
        $query = "select groups.id from groups, users, usergroup ".
                "where groups.group_label = users.email ".
                "and usergroup.group_id = groups.id ".
                "and usergroup.user_id = users.id ".
                "and users.id = ?";

        $personalGroupId  =  DB::select($query, [$userId]);
        return $personalGroupId[0]->id;
    }

    public function addUserToGroup($userId, $groupId){
        DB::table('usergroup')->insert([
            'group_id'=>$groupId,
            'user_id'=>$userId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }

    public function addNewPersonalGroup($userName, $userEmail){
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>$userEmail,
            'description'=>$userName." personal group",
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        return $thisGroupId;
    }

    public function addOrgToGroup($orgId, $groupId){
        DB::table('grouporg')->insert([
            'group_id'=>$groupId,
            'org_id'=>$orgId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }

    public function getUsersInGroup($groupId){
        $query = "select users.id, users.name, users.email from users, usergroup ".
                "where users.id = usergroup.user_id ".
                "and usergroup.group_id=?";
        $users  =  DB::select($query, [$groupId]);
        return $users;

    }

    public function getOrganizationGroups($orgId, $userId, $layoutId){
/*
        $query = "select group_label, description, groups.id from groups, grouporg ".
                "where grouporg.group_id = groups.id ".
                "and grouporg.org_id = ?";
*/
        $query = "select group_label, description, groups.id from groups, grouporg ".
            "where grouporg.group_id = groups.id ".
            "and grouporg.org_id = ? ".
            "and groups.id NOT IN ( ".
            "select groups.id ".
            "from groups, perms, users, usergroup, userorg, org ".
            "where groups.id = perms.group_id ".
            "and usergroup.group_id = groups.id  ".
            "and usergroup.user_id = users.id ".
            "and userorg.user_id = users.id ".
            "and userorg.org_id = org.id ".
            "and org.id = ? ".
            "and users.id=? ".
            "and perms.layout_id = ? ".
            ")";

        $groups  =  DB::select($query, [$orgId, $orgId, $userId, $layoutId]);
        return $groups;
    }
}
