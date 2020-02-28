<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Appointment;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        //
    ];
});

// $factory->define(App\User::class, function (Faker $faker) {
//     return [
//         'name' => $faker->name,
//         'phone_number' => $faker->unique()->numerify('09#########'),
//         'email' => $faker->safeEmail,
//         'national_number' => $faker->unique()->numerify('##########'),
//         'password' => Hash::make('1234'),
//     ];
// });

// $factory->define(\App\Book::class, function (Faker $faker) {

//     return [
//         'name' => $faker->name,
//         'pages' => $faker->randomNumber(4),
//         'ISBN' => $faker->unique()->numerify('###-###-#####-#-#'),
//         'price' => $faker->randomNumber(7),
//         'published_at' => $faker->date('Y-m-d'),
//     ];
// });
