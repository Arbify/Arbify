<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Arbify\Models\Message;
use Arbify\Models\Project;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'name' => Str::snake($faker->sentence),
        'description' => $faker->sentences(3, true),
        'type' => $faker->randomElement(array_keys(Message::TYPES)),
        'project_id' => factory(Project::class)->create()->id,
    ];
});
