<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MessageValue;
use Faker\Generator as Faker;

$factory->define(MessageValue::class, function (Faker $faker) {
    return [
        'value' => $faker->sentence,
    ];
});
