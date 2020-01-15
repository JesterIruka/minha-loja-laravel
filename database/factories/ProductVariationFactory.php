<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\ProductVariation::class, function (Faker $faker) {
    return [
        'name'=>$faker->randomLetter,
        'price'=>$faker->randomFloat(2, 1, 50),
        'stock'=>rand(0, 100)
    ];
});
