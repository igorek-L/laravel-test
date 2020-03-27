<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'created_at' =>$faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = null),
        'updated_at' =>$faker->dateTimeBetween($startDate = '-9 years', $endDate = 'now', $timezone = null),
        'password' => Hash::make('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
        'phone' => '+375294443956',
        'address' => 'address'.Str::random(10),
    ];
});
