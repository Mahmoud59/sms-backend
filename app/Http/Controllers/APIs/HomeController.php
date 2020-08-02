<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\BackController;
use App\Models\EducationLevel;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends BackController
{
    public function __construct(EducationLevel $model)
    {
        parent::__construct($model);
    }

    public function educationLevel()
    {
        $educationLevel = $this->model::all();

        return $this->APIResponse($educationLevel , null ,  200);
    }
}
