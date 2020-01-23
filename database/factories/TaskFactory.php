<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $title = $faker->sentence(3);
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'details' => $faker->sentence(20),
    ];
});