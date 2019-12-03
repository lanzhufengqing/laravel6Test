<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
//注意： 引入对应的模型  App\Models\Status::class
$factory->define(App\Models\Status::class, function (Faker $faker) {
    $date_time = $faker->date.' '.$faker->time;
    return [
        'content'   =>  $faker->text(),
        'created_at' =>  $date_time,
        'updated_at' =>  $date_time,
    ];
});
