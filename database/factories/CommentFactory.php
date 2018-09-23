<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    $user = factory(App\User::Class)->create();

    return [
        'user_id' => $user->id,
        'body' => $faker->sentence,
        'video_url' => 'https://photos.google.com/photo/AF1QipPNaEgsaodRSEMw8BjLKTmZw7HbNh5iknXaO0aQ',
    ];
});
