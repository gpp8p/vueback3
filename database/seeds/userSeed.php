<?php

use Illuminate\Database\Seeder;

class userSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lastRcd=DB::table('users')->insertGetId([
            'name'=>    'George Pipkin',
            'email'=>   'gpp8pvirginia@gmail.com',
            'password'=> Hash::make('n1tad0g'),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $lastRcd =DB::table('users')->insertGetId([
            'name'=>    'Billy Budd',
            'email'=>   'budd@gmail.com',
            'password'=> Hash::make('n1tad0g'),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $lastRcd =DB::table('users')->insertGetId([
            'name'=>    'Nancy Normal',
            'email'=>   'normal@gmail.com',
            'password'=> Hash::make('n1tad0g'),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        $lastRcd =DB::table('users')->insertGetId([
            'name'=>    'Shirley Skyfall',
            'email'=>   'shirley@gmail.com',
            'password'=> Hash::make('n1tad0g'),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
