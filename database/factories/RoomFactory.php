<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    // Получить доступ к таблице room_types и извлечь id
	$roomTypes = DB::table('room_types')->pluck('id')->all();

    return [
        'number' => $faker->unique()->randomNumber(),
        'room_type_id' => $faker->randomElement($roomTypes),
    ];
});
