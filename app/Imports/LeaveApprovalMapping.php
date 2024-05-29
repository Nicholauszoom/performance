<?php

namespace App\Imports;

use App\Models\LeaveApproval;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class LeaveApprovalMapping implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        Log::info('Processing row: ', $row);


            // Assuming $row contains your data from Excel
    $level1row = !empty($row['level_1']) ? trim($row['level_1']) : null;
    $level2row = !empty($row['level_2']) ? trim($row['level_2']) : null;
    $level3row = !empty($row['level_3']) ? trim($row['level_3']) : null;



    // Use DB::raw to concatenate fname and lname and compare with $level1row
    $level1payrollNumber = Employee::where(DB::raw("CONCAT(fname, ' ', lname)"), $level1row)->pluck('emp_id')->first();
    $level2payrollNumber = Employee::where(DB::raw("CONCAT(fname, ' ', lname)"), $level2row)->pluck('emp_id')->first();
    $level3payrollNumber = Employee::where(DB::raw("CONCAT(fname, ' ', lname)"), $level3row)->pluck('emp_id')->first();

        return new LeaveApproval([
            'empID' => $row['payroll_number'],
            'level1' => $level1payrollNumber,
            'level2' => $level2payrollNumber,
            'level3' => $level3payrollNumber,
            'escallation_time' => $row['escalation_time'],
            ]);
    }
}
