<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('attendance');
            $table->time('leave');
            $table->date('day');

            $table->bigInteger('education_level_id')->unsigned()->nullable();
            $table->foreign('education_level_id')->references('id')->on('education_levels')->onDelete('cascade');

            $table->bigInteger('teacher_id')->unsigned()->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_teachers');
    }
}
