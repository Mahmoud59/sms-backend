<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call([
//            UserSeeder::class,
//
//        ]);
//        factory('App\Models\User', 10)->create();
        factory('App\Models\EducationLevel', 10)->create();
        factory('App\Models\Teacher', 10)->create();
        factory('App\Models\TeacherEducationLevel', 10)->create();
        factory('App\Models\Configuration', 1)->create();
        factory('App\Models\Employee', 10)->create();
        factory('App\Models\Schedule', 10)->create();
        factory('App\Models\ClassTime', 1)->create();
        factory('App\Models\AttendanceTemp', 10)->create();
        factory('App\Models\AttendanceTeacher', 10)->create();
        factory('App\Models\AttendanceEmployee', 10)->create();
    }
}
