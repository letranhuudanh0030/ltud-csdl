<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'customer_id' => Customer::get(['id'])->random()->id,
        'time_start' => now(),
        'time_end' => now(),
        'summary' => $faker->text,
        'result' => $faker->text,
        'status' => $faker->numberBetween(0,2),
    ];
});
