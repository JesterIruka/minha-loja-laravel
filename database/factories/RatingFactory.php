<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Rating;
use Faker\Generator as Faker;

$factory->define(Rating::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'stars'=>rand(0, 5),
        'review'=>$faker->text
    ];
});
