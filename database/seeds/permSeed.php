<?php

use Illuminate\Database\Seeder;

class permSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thisGroupId = DB::table('groups')->where('group_label', 'Roads')->first()->id;
        $thisLayoutId = 24;
        DB::table('perms')->insert([
            'group_id'=>$thisGroupId,
            'layout_id'=>$thisLayoutId,
            'view'=>1,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisGroupId = DB::table('groups')->where('group_label', 'Finance')->first()->id;
        DB::table('perms')->insert([
            'group_id'=>$thisGroupId,
            'layout_id'=>$thisLayoutId,
            'view'=>1,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisGroupId = DB::table('groups')->where('group_label', 'gpp8pvirginia@gmail.com')->first()->id;
        DB::table('perms')->insert([
            'group_id'=>$thisGroupId,
            'layout_id'=>$thisLayoutId,
            'admin'=>1,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $thisGroupId = DB::table('groups')->where('group_label', 'Building')->first()->id;
        DB::table('perms')->insert([
            'group_id'=>$thisGroupId,
            'layout_id'=>$thisLayoutId,
            'admin'=>1,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);


    }
}
