<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Form::class, function (Faker\Generator $faker) {
    static $password;

    $form_types = App\Form\Types::get();
    $total_form_types = count($form_types) - 1;
    $type = $form_types[rand(0,$total_form_types)];

    return [
        'user_id' => auth()->id() ?: factory('App\User')->create(),
        'type' => $type
    ];
});
