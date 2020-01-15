<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Sale;
use Faker\Generator as Faker;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'gateway'=>'mercadopago',
        'transaction'=>$faker->uuid,
        'total'=>$faker->randomFloat(2, 0, 100),
        'status'=>'approved',
        'client_name'=>$faker->name,
        'client_email'=>$faker->email,
        'client_phone'=>$faker->phoneNumber,
        'client_address'=>$faker->address,
        'carrier'=>'Carta Registrada',
        'shipping_code'=>null
    ];
});
