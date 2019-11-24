<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CardInstances;
use Faker\Generator as Faker;

$factory->define(\App\CardInstances::class, function (Faker $faker) {
    return [
        'layout_id'=>factory('App\Layout')->create()->id,
        'view_type_id'=>App\ViewType::where('view_type_label', 'Web Browser')->first()->id,
        'card_component'=>'simpleCard',
        'row'=>0,
        'col'=>0,
        'height'=>0,
        'width'=>'0'
    ];
});
