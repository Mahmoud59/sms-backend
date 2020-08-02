<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name_ar' ,'name_en', 'salary', 'phone', 'fingerprint', 'part_time'];

    public function education_level()
    {
        return $this->hasMany('App\Models\TeacherEducationLevel')->select(['education_level_id' ,'teacher_id']);
    }
}
