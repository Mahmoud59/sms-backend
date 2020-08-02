<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

function getTeacher()
{
    return App\Models\Teacher::pluck('id')->toArray();
}

function getEducationLevel()
{
    return App\Models\EducationLevel::pluck('id')->toArray();
}

function getEmployee()
{
    return App\Models\Employee::pluck('id')->toArray();
}
//$factory->define(User::class, function (Faker $faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'email_verified_at' => now(),
//        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//        'remember_token' => Str::random(10),
//    ];
//});

$factory->define(\App\Models\ClassTime::class, function (Faker $faker) {
    return [
        'first' => '[12:04:28 , 2:04:28]',
        'second' => '[12:04:28 , 2:04:28]',
        'third' => '[12:04:28 , 2:04:28]',
        'forth' => '[12:04:28 , 2:04:28]',
        'fifth' => '[12:04:28 , 2:04:28]',
        'sixth' => '[12:04:28 , 2:04:28]',
        'seventh' => '[12:04:28 , 2:04:28]',
        'eighth' => '[12:04:28 , 2:04:28]',
    ];
});

$factory->define(\App\Models\Configuration::class, function (Faker $faker) {
    return [
        'attendance' => $faker->time(),
        'leave' => $faker->time(),
        'type_of_change' => $faker->randomElement(['every week', 'every two week', 'every month']),
    ];
});

$factory->define(\App\Models\EducationLevel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(\App\Models\Teacher::class, function (Faker $faker) {
    return [
        'name_ar' => $faker->name,
        'name_en' => $faker->name,
        'salary' => $faker->randomDigit,
        'phone' => $faker->randomDigit,
        'fingerprint' => $faker->randomDigit,
        'part_time' => $faker->boolean,
    ];
});

$factory->define(\App\Models\Employee::class, function (Faker $faker) {
    return [
        'name_ar' => $faker->name,
        'name_en' => $faker->name,
        'salary' => $faker->randomDigit,
        'phone' => $faker->randomDigit,
        'fingerprint' => $faker->randomDigit,
    ];
});

$factory->define(\App\Models\Schedule::class, function (Faker $faker) {
    return [
        'saturday' => $faker->randomElement(['[1,2,7]', '[1,7,8]']),
        'sunday' => $faker->randomElement(['[1,2,7]', '[1,7,8]']),
        'monday' => $faker->randomElement(['[1,2,7]', '[1,7,8]']),
        'tuesday' => $faker->randomElement(['[1,2,7]', '[1,7,8]']),
        'wednesday' => $faker->randomElement(['[1,2,7]', '[1,7,8]']),
        'thursday' => $faker->randomElement(['[1,2,7]', '[1,7,8]']),
        'from' => $faker->date(),
        'to' => $faker->date(),
        'teacher_id' => $faker->randomElement(getTeacher())
    ];
});

$factory->define(\App\Models\TeacherEducationLevel::class, function (Faker $faker) {
    return [
        'teacher_id' => $faker->randomElement(getTeacher()),
        'education_level_id' => $faker->randomElement(getEducationLevel()),
    ];
});

$factory->define(\App\Models\AttendanceTemp::class, function (Faker $faker) {
    return [
        'attendance' => $faker->time(),
        'leave' => $faker->time(),
        'day' => $faker->date(),
        'teacher_id' => $faker->randomElement(getTeacher()),
    ];
});

$factory->define(\App\Models\AttendanceTeacher::class, function (Faker $faker) {
    return [
        'attendance' => $faker->time(),
        'leave' => $faker->time(),
        'day' => $faker->date(),
        'education_level_id' => $faker->randomElement(getEducationLevel()),
        'teacher_id' => $faker->randomElement(getTeacher()),
    ];
});

$factory->define(\App\Models\AttendanceEmployee::class, function (Faker $faker) {
    return [
        'attendance' => $faker->time(),
        'leave' => $faker->time(),
        'day' => $faker->date(),
        'employee_id' => $faker->randomElement(getEmployee()),
    ];
});
