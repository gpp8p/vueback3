<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Layout;
use Faker\Generator as Faker;

$factory->define(Layout::class, function (Faker $faker) {
    return [
        'menu_label'=>'Front_Page',
        'height'=>3,
        'width'=>5,
        'description'=>'table used for testiong'
    ];
});
