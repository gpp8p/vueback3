<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Org extends Model
{
    public function getOrgId($orgName){

        try {
            $thisOrgId = DB::table('org')->where('org_label', $orgName)->first()->value('id');
            return $thisOrgId;
        } catch (Exception $e) {
            throw new Exception('org not found');
        }

    }

    public function getOrgHomeOld($orgName){
        try {
            $thisOrgHome = DB::table('org')->where('org_label', $orgName)->value('top_layout_id');
            return $thisOrgHome;
        } catch (Exception $e) {
            throw new Exception('org not found');
        }

    }

    public function getOrgHome($orgName){
        $query = "select id, top_layout_id from org where org_label = ?";
        try {
            $orgInfo = DB::select($query, [$orgName]);
            return $orgInfo;
        } catch (Exception $e) {
            throw new Exception('error - org not found');
        }
    }
/*
    public function getOrgList(){
        $query = "select * from org ";
        try {
            $orgList = DB::select($query);
            return $orgList;
        } catch (Exception $e) {
            throw new Exception('error in orgList'.$e->getMessage());
        }
    }
*/
}
