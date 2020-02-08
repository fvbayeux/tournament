<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Game::class, function (Faker $faker) {
    return [
        'number' => function () {
            return \App\Game::max('number') + 1;
        },
    ];
});

$factory->state(\App\Game::class, 'withPlayers', function (Faker $faker) {
    return [
        'first_player_id' => function () {
            return factory(\App\Player::class);
        },
        'second_player_id' => function () {
            return factory(\App\Player::class);
        },
    ];
});

$factory->state(\App\Game::class, 'withPlayer', function (Faker $faker) {
    return [
        $faker->randomElement(['first_player_id', 'second_player_id']) => function () {
            return factory(\App\Player::class);
        },
    ];
});



