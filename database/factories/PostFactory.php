<?php

use App\User;
use Faker\Generator as Faker;
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

$factory->define(\App\Post::class, function (Faker $faker) {
    $title = $faker->sentence(6,true);

    return [
        'title' => $title,
        'intro' => '',
        'slug'  => Str::slug($title),
        'category_id' => \App\Category::query()->inRandomOrder()->first()->id,
        'blocks'  => '[{"data": {"text": "'.$faker->sentence(30, $variableNbWords = true).'"}, "type": "paragraph"}]',
        'is_block' => 0,
        'is_publish' => 1,
        'user_id' => factory(User::class)->create()->id,
    ];
});
