<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('APIs')->group(function () {
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('upload-file', 'AuthController@uploadImage');
    });
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');

        Route::get('education/level', 'HomeController@educationLevel');
        Route::resource('teacher', 'TeacherController');

        Route::resource('schedule', 'ScheduleController');
        Route::get('schedule/teacher/{id}', 'ScheduleController@singleTeacherSchedule');
        Route::get('all-schedule/teacher/{id}', 'ScheduleController@teacherSchedule');

        Route::get('configuration', 'ConfigurationController@get_configuration');
        Route::put('configuration', 'ConfigurationController@configuration');

        Route::resource('employee', 'EmployeeController');

        Route::get('report', 'ReportController@report');

        Route::get('excel', 'ReportController@excel');

        Route::get('attendance/report', 'ReportController@attendanceReport');

        Route::get('all-employee', 'EmployeeController@teacherAndEmployee');
    });



});

