<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Language;
use Faker\Generator as Faker;

$factory->define(Language::class, function (Faker $faker) {
    return [
        'code' => $faker->locale,
        'name' => $faker->country,
        'flag' => $faker->countryCode,
        'plural_forms' => $faker->randomElements(array_keys(Language::PLURAL_FORMS), random_int(1, 6)),
    ];
});
