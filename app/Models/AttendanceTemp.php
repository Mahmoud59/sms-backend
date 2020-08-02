<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceTemp extends Model
{
    protected $fillable = ['attendance', 'leave', 'day' ,'teacher_id'];
}
