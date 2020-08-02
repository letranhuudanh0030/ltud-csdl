<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'level_role' => $faker->numberBetween(0,5),
        'status' => $faker->numberBetween(0,1),
    ];
});
