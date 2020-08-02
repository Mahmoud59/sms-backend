<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceTeacher extends Model
{
    protected $fillable = ['attendance', 'leave', 'day' ,'teacher_id', 'education_level_id'];
}
