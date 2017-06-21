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
    $form_types = App\Form\Types::get();
    $total_form_types = count($form_types) - 1;
    $type = $form_types[rand(0,$total_form_types)];

    return [
        'user_id' => auth()->id() ?: factory('App\User')->create(),
        'type' => $type
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\FormField::class, function (Faker\Generator $faker) {
    $field_types = App\Form\FieldTypes::get();
    $total_field_types = count($field_types) - 1;
    $type = $field_types[rand(0,$total_field_types)];

    return [
        'form_id' => factory('App\Form')->create(),
        'name' => $faker->sentence,
        'type' => $type,
        'value' => 'fake_value',
        'final_value' => 'fake_final_value',
        'affects' => 'total',
    ];
});
