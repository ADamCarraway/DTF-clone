<?php

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

$factory->define(\App\Models\Post::class, function (Faker $faker) {
    $title = $faker->sentence(6,true);

    return [
        'title' => $title,
        'intro' => '',
        'slug'  => Str::slug($title),
        'category_id' => \App\Models\Category::query()->inRandomOrder()->first()->id,
        'blocks'  => '[{"data": {"text": "'.$faker->sentence(30, $variableNbWords = true).'"}, "type": "paragraph"}]',
        'is_block' => 0,
        'is_publish' => 1,
        'user_id' => factory(\App\Models\User::class)->create()->id,
    ];
});
