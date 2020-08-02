<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\BackController;
use App\Models\Attendance;
use App\Models\AttendanceEmployee;
use App\Models\AttendanceTeacher;
use App\Models\AttendanceTemp;
use App\Models\Configuration;
use App\Models\Schedule;
use App\Imports\AttendanceTeacherImport;
use App\Models\Teacher;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends BackController
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }

    public function report(Request $request)
    {
        $attendance = AttendanceTeacher::where('teacher_id', $request->teacherId)
            ->whereBetween('day', [$request->startDate, $request->endDate])
            ->get();

        return $this->APIResponse($attendance , null  ,  200);
    }

    public function excel(Request $request)
    {
        if($request->educationLevelId)
        {
            $teacher = Teacher::find($request->teacherId);
            if($teacher->part_time == 0)
                $data = $this->fullTimeWorker($request->teacherId, $request->startDate, $request->endDate, $request->file, $request->educationLevelId);
        }
        else
        {
            $data = $this->fullTimeWorker($request->teacherId, $request->startDate, $request->endDate, $request->file, $request->educationLevelId);
        }

        return $this->APIResponse($data , null  ,  200);
    }

    public function attendanceReport(Request $request)
    {
        $data = $this->fullTimeWorker($request->teacherId, $request->startDate, $request->endDate, $request->file, $request->educationLevelId);
        $employees = array( 'employee' => $data);
        $pdf = PDF::loadView('employee', $employees)->setPaper('a4', 'portrait');
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);
        $fileName = 'report';
        return $pdf->stream($fileName . '.pdf');
    }

    public function fullTimeWorker($employeeId, $startDate, $endDate, $file, $educationLevelId = null)
    {
        Excel::import(new AttendanceTeacherImport, $file);

        $insertAttendances = AttendanceTemp::all();
        if($educationLevelId)
        {
            $originalAttendances = AttendanceTeacher::where('teacher_id', $employeeId)
                ->where('education_level_id', $educationLevelId)
                ->whereBetween('day', [$startDate, $endDate])
                ->get();

            AttendanceTemp::truncate();
            $delay = [];
            $exactly = [];
            $absent = [];
            $classes = 0;

            foreach ($insertAttendances as $insertAttendance)
            {
                $dayCompared = AttendanceTeacher::where('day', $insertAttendance->day)
                    ->where('teacher_id', $employeeId)
                    ->where('education_level_id', $educationLevelId)
                    ->whereBetween('day', [$startDate, $endDate])
                    ->first();

                if($dayCompared !== null)
                {
                    if(date($dayCompared->attendance) < date($insertAttendance->attendance) || date($dayCompared->leave) > date($insertAttendance->leave) && $dayCompared->day == $insertAttendance->day)
                        $delay[] = $insertAttendance;

                    elseif(date($dayCompared->attendance) == date($insertAttendance->attendance) && $dayCompared->day == $insertAttendance->day)
                        $exactly[] = $insertAttendance;

                }
            }

            foreach ($originalAttendances as $originalAttendance => $attendance)
            {
                foreach ($delay as $delayItem)
                {
                    if($attendance->day == $delayItem->day)
                        goto end;
                }
                foreach ($exactly as $exactlyItem)
                {
                    if($attendance->day == $exactlyItem->day)
                        goto end;
                    else
                    {
                        $absent[] = $attendance;
                    }
                }
                end:
            }

            if(empty($exactly) && empty($delay))
            {
                $absent = $originalAttendances;
            }

            $configuration = Configuration::first();

            if($configuration->type_of_change == 'every week')
            {
                $classes += $this->classesOfWeek($employeeId, $startDate, $endDate);
            }

            if($configuration->type_of_change == 'every two week')
            {
                for ($i = 0; $i < 2 ; $i++)
                {
                    $classes += $this->classesOfWeek($employeeId, $startDate, $endDate);
                }
            }

            if($configuration->type_of_change == 'every month')
            {
                for ($i = 0; $i < 4 ; $i++)
                {
                    $classes += $this->classesOfWeek($employeeId, $startDate, $endDate);
                }
            }

            $data = [];
            $data['attendance'] = count($delay) + count($exactly) ;
            $data['number of classes'] = $classes;
            $data['delay'] = $delay;
            $data['exactly'] = $exactly;
            $data['absent'] = $absent;

            return $data;
        }

        else
        {
            $originalAttendances = AttendanceEmployee::where('employee_id', $employeeId)
                ->whereBetween('day', [$startDate, $endDate])
                ->get();

            AttendanceTemp::truncate();
            $delay = [];
            $exactly = [];
            $absent = [];

            foreach ($insertAttendances as $insertAttendance)
            {
                $dayCompared = AttendanceEmployee::where('day', $insertAttendance->day)
                    ->where('employee_id', $employeeId)
                    ->whereBetween('day', [$startDate, $endDate])
                    ->first();

                if($dayCompared !== null)
                {
                    if(date($dayCompared->attendance) < date($insertAttendance->attendance) || date($dayCompared->leave) > date($insertAttendance->leave) && $dayCompared->day == $insertAttendance->day)
                        $delay[] = $insertAttendance;

                    elseif(date($dayCompared->attendance) == date($insertAttendance->attendance) && $dayCompared->day == $insertAttendance->day)
                        $exactly[] = $insertAttendance;

                }
            }

            foreach ($originalAttendances as $originalAttendance => $attendance)
            {
                foreach ($delay as $delayItem)
                {
                    if($attendance->day == $delayItem->day)
                        goto endAttendance;
                }
                foreach ($exactly as $exactlyItem)
                {
                    if($attendance->day == $exactlyItem->day)
                        goto endAttendance;

                    else
                    {
                        $absent[] = $attendance;
                    }
                }
                endAttendance:
            }

            if(empty($exactly) && empty($delay))
            {
                $absent = $originalAttendances;
            }

            $data = [];
            $data['attendance'] = count($delay) + count($exactly) ;
            $data['delay'] = $delay;
            $data['exactly'] = $exactly;
            $data['absent'] = $absent;

            return $data;
        }

    }

    public function classesOfWeek($teacherId, $startDate, $endDate)
    {
        $schedule = Schedule::where('teacher_id', $teacherId)
            ->whereBetween('from', [$startDate, $endDate])
            ->get();

        $count = 0;
        foreach ($schedule as $value)
        {
            $count = $this->countOfClasses($value->saturday);
            $count += $this->countOfClasses($value->sunday);
            $count += $this->countOfClasses($value->monday);
            $count += $this->countOfClasses($value->tuesday);
            $count += $this->countOfClasses($value->wednesday);
            $count += $this->countOfClasses($value->thursday);
        }
        return $count;
    }

    public function countOfClasses($day)
    {
        $classes = 0;
        $day = substr($day, 1, -1);
        $days = explode(",", $day);
        $classes += count($days);
        return $classes;
    }

}
