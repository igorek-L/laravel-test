<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comments;
use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comments::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence($nbWords = 16, $variableNbWords = true),
        'comment_status' => $faker->randomElement($array = array('READY_FOR_REVIEW','PUBLISHED', 'REMOVED')),
        'created_at' =>$faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = null),
        'updated_at' =>$faker->dateTimeBetween($startDate = '-9 years', $endDate = 'now', $timezone = null),
        'user_id' => $faker->numberBetween(1,5000),
        'post_id' => $faker->numberBetween(1,10000),
    ];
});
