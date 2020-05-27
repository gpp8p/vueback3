<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Org extends Model
{
    public function getOrgId($orgName){

        try {
            $thisOrgId = DB::table('org')->where('org_label', $orgName)->first()->value('id');
        } catch (\Exception $e) {
            throw new Exception('org not found');
        }

    }
}
