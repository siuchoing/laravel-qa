<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(rand(5, 10)), "."),
        'body' => $faker->paragraphs(rand(3, 7), true),
        'views' => rand(0, 10),
        //'answers_count' => rand(0, 10),
        'votes' => rand(-3, 10)
    ];
});

## rtrim('Hello~~~', '~~~');                   // 'Hello'
## rtrim($faker->sentence(rand(1, 2)))         // 'Ah Do.'
## $faker->paragraphs(1, true)                 // "Expea sed. Sint ams." Cum iua erat di omnis."
## $faker->paragraphs(2, true)                 // """
                                               // Aliitecto explicabo minus.\n
                                               // \n
                                               // In qui reminus. Illomnis ab. Quas mo magnam.
                                               // """

