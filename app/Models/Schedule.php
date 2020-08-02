<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'from', 'to', 'teacher_id'];
}
