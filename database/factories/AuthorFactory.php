<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use App\User;
use Faker\Generator as Faker;

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

$factory->define(Author::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'blog_title' => $faker->word,
        'blog_body' => $faker->text,
    ];
});
