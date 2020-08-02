<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\BackController;
use App\Models\Employee;
use App\Models\Teacher;
use Illuminate\Http\Request;

class EmployeeController extends BackController
{
    public function __construct(Employee $model)
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
        $employee = $this->model::find($id);
        $employee->update($request->all());
        return $this->APIResponse(null , null  ,  200);
    }

    public function teacherAndEmployee()
    {
        $collection = new \Illuminate\Support\Collection();

        $employees = Employee::orderBy('created_at', 'DESC')
            ->get();

        $teachers = Teacher::orderBy('created_at', 'DESC')
            ->get();

        $sortedCollection = $collection->merge($employees)->merge($teachers)->sortByDesc('created_at');

        return $this->APIResponse($sortedCollection, null, 200);
    }
}
