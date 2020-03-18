<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6),
        'description' => $faker->text(100),
        'post_status' => $faker->randomElement($array = array('DRAFT','READY_FOR_REVIEW', 'PUBLISHED', 'DECLINED', 'REMOVED')),
        'created_at' =>$faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = null),
        'updated_at' =>$faker->dateTimeBetween($startDate = '-9 years', $endDate = 'now', $timezone = null),
        'image' => '',
        'relative_path_to_image' => '',
        'user_id' => $faker->numberBetween(1, 5000),
    ];
});
