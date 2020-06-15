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
        return $personalGroupId;
    }

    public function addNewPersonalGroup($userId, $userName, $userEmail){

    }
}
