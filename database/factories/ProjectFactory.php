<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'statuses' => App\Project::STATUS_PLANNED,
    ];
});
