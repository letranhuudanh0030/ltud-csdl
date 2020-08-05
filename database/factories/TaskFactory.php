<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\Task;
use App\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'event_id' => Event::get(['id'])->random()->id,
        'user_id' => User::get(['id'])->random()->id,
        'content' => $faker->text,
        'task_start' => now(),
        'task_end' => now(),
        'status' => $faker->numberBetween(0,2)
    ];
});
