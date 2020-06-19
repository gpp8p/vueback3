<?php

use Illuminate\Database\Seeder;

class orgSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thisOrgId = DB::table('org')->insertGetId([
            'org_label'=>'Shannon',
            'description'=>'Shannon Farm Association',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'George Pipkin')->first()->id;
        DB::table('userorg')->insert([
            'org_id'=>$thisOrgId,
            'user_id'=>$thisUserId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'Shannon User2')->first()->id;
        DB::table('userorg')->insert([
            'org_id'=>$thisOrgId,
            'user_id'=>$thisUserId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'Shannon User3')->first()->id;
        DB::table('userorg')->insert([
            'org_id'=>$thisOrgId,
            'user_id'=>$thisUserId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'GuestUser')->first()->id;
        DB::table('userorg')->insert([
            'org_id'=>$thisOrgId,
            'user_id'=>$thisUserId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'Billy Budd')->first()->id;
        DB::table('userorg')->insert([
            'org_id'=>$thisOrgId,
            'user_id'=>$thisUserId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisOrgId = DB::table('org')->insertGetId([
            'org_label'=>'RVCC',
            'description'=>'Rockfish Valley Community Center',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'Nancy Normal')->first()->id;
        DB::table('userorg')->insert([
            'org_id'=>$thisOrgId,
            'user_id'=>$thisUserId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisOrgId = DB::table('org')->insertGetId([
            'org_label'=>'NCDC',
            'description'=>'Nelson County Democratic Committee',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'Shirley Skyfall')->first()->id;
        DB::table('userorg')->insert([
            'org_id'=>$thisOrgId,
            'user_id'=>$thisUserId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'George Pipkin')->first()->id;
        DB::table('userorg')->insert([
            'org_id'=>$thisOrgId,
            'user_id'=>$thisUserId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);




    }
}
