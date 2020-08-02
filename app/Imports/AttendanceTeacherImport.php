<?php

namespace App\Imports;

use App\Models\AttendanceTemp;
use Maatwebsite\Excel\Concerns\ToModel;

class AttendanceTeacherImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AttendanceTemp([
            'attendance'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0])->format('H:i:s'),
            'leave'          => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])->format('H:i:s'),
            'day'            => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2])->format('Y-m-d'),
            'teacher_id'     => $row[3],
        ]);
    }
}
