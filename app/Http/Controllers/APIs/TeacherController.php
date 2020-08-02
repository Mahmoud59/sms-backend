<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\BackController;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\TeacherEducationLevel;
use Illuminate\Http\Request;

class TeacherController extends BackController
{
    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $teachers = $this->model::with('education_level')->get();
        return $this->APIResponse($teachers , null  ,  200);
    }

    public function store(Request $request)
    {
//        if (isset($request->validator) && $request->validator->fails())
//        {
//            return $this->APIResponse(null , $request->validator->messages() ,  400);
//        }

        $teacher = $this->model::create($request->all());
        foreach ($request->educationLevel as $value)
            TeacherEducationLevel::create([
                'teacher_id' => $teacher->id,
                'education_level_id' => $value]);

        return $this->APIResponse(null , null  ,  201);
    }

    public function update($id, Request $request)
    {
        $teacher = $this->model::find($id);
        $teacher->update($request->all());
        return $this->APIResponse(null , null  ,  200);
    }

    function with()
    {
        return ['education_level'];
    }
}
