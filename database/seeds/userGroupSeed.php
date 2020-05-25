<?php

use Illuminate\Database\Seeder;

class userGroupSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shannonId = DB::table('groups')->where('group_label', 'Roads')->first()->id;
        $thisUserId = DB::table('users')->where('name', 'George Pipkin')->first()->id;

    }
}
