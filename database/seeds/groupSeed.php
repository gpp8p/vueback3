<?php

use Illuminate\Database\Seeder;

class groupSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
// setting up All Users
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>'AllUsers',
            'description'=>'All Users',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'GuestUser')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
        $thisUserId = DB::table('users')->where('name', 'Billy Budd')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
        $thisUserId = DB::table('users')->where('name', 'Shirley Skyfall')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
        $thisUserId = DB::table('users')->where('name', 'Nancy Normal')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
        $thisUserId = DB::table('users')->where('name', 'George Pipkin')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);

//      Set up greoup for logged in Shannon Users
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>'ShannonUsers',
            'description'=>'Shannon Users',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'Shannon User2')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
        $thisUserId = DB::table('users')->where('name', 'Shannon User3')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
        $thisUserId = DB::table('users')->where('name', 'George Pipkin')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>true
        ]);

// set up personal group for George Pipkin
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>'gpp8pvirginia@gmail.com',
            'description'=>'George Pipkin',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'George Pipkin')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>true
        ]);

// set up greoup for Roads
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>'Roads',
            'description'=>'Roads Committee',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>true
        ]);
// set up group for Finance
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>'Finance',
            'description'=>'Finance Committee',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>true
        ]);
        $thisUserId = DB::table('users')->where('name', 'Billy Budd')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>'Communications',
            'description'=>'Communications Committee',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
        $thisUserId = DB::table('users')->where('name', 'Shirley Skyfall')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>true
        ]);
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>'Campaign',
            'description'=>'Campaign Committee',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'Shirley Skyfall')->first()->id;
        DB::table('usergroup')->insert([
           'user_id'=>$thisUserId,
           'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
        $thisGroupId = DB::table('groups')->insertGetId([
            'group_label'=>'Building',
            'description'=>'Building Committee',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisUserId = DB::table('users')->where('name', 'Nancy Normal')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>true
        ]);
/*
        $thisUserId = DB::table('users')->where('name', 'George Pipkin')->first()->id;
        DB::table('usergroup')->insert([
            'user_id'=>$thisUserId,
            'group_id'=>$thisGroupId,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'is_admin'=>false
        ]);
*/
    }
}
