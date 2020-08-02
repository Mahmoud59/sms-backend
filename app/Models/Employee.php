<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name_ar' ,'name_en', 'salary', 'phone', 'fingerprint'];
}
