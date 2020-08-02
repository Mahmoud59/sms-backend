<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\BackController;
use App\Models\Configuration;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends BackController
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }

    public function store(Request $request)
    {
//        if (isset($request->validator) && $request->validator->fails())
//        {
//            return $this->APIResponse(null , $request->validator->messages() ,  400);
//        }

        $this->model::create($request->all());

        return $this->APIResponse(null , null  ,  201);
    }

    public function update($id, Request $request)
    {
        $schedule = $this->model::find($id);
        $schedule->update($request->all());
        return $this->APIResponse(null , null  ,  200);
    }


    public function singleTeacherSchedule($id)
    {
        $schedule = $this->model::where('teacher_id', $id)->latest('created_at')->first();

        return $this->APIResponse($schedule , null  ,  200);
    }

    public function teacherSchedule($id)
    {
        $schedules = $this->model::where('teacher_id', $id)->latest('created_at')->get();

        return $this->APIResponse($schedules , null  ,  200);
    }



}
