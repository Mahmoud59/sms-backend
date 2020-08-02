<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first');
            $table->string('second');
            $table->string('third');
            $table->string('forth');
            $table->string('fifth');
            $table->string('sixth');
            $table->string('seventh');
            $table->string('eighth');
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
        Schema::dropIfExists('class_times');
    }
}
