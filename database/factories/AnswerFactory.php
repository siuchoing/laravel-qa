<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraphs(rand(3,7), true),
        'votes_count' => rand(0,5),
        'user_id' => App\User::pluck('id')->random(),       // get any id from an collection
        //'user_id' => array_random(App\User::pluck('id')->all()),
    ];
});
