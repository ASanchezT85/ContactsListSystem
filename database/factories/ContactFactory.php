<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    $first_name = $faker->firstName;
    $last_name = $faker->lastName;
    return [
        'user_id'           => null,
        'first_name'        => $first_name,
        'last_name'         => $last_name,
        'email'             => $faker->safeEmail,
        'contact_number'    => $faker->e164PhoneNumber,
    ];
});
