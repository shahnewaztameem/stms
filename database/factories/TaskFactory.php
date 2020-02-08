<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $title = $faker->sentence(3);
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'details' => $faker->sentence(20),
        'project_manager_id' => function(){
            return User::whereUserType(2)->get()->random();
        },
        'client_id' => function(){
            return User::whereUserType(1)->get()->random();
        },
    ];
});