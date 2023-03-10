<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use App\Models\ImportsEmployee;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\PerformanceModel;
use App\Models\ProjectModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ImportPension implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        foreach ($collection as $row)
        {
            $date = $row['year'].'-'.$row['month'].'-'.'20';
            $result = DB::table('employee')->where('emp_id',$row['emp_id'])->select('department','position')->first();
            $department  = !empty($result)?$result->department:1;
            $position  = !empty($result)?$result->position:1;
           $data = [
            'empID'=>$row['emp_id'],
            'salary'=>$row['salary'],
            'pension_employer'=>$row['pension_employer'],
            'pension_employee'=>$row['pension_employee'],
            'payroll_date'=>$date,
            'department'=>$department,
            'position'=>$position,
            'pension_fund'=>2,
            'membership_no'=>$row['membership_no'],
            'sdl'=>0,
            'wcf'=>0,
            'rate'=>1,
            'currency'=>'TZS',
            'years'=>$row['year'],
            'receipt_no'=>$row['receipt_no'],
            'receipt_date'=>$row['receipt_date'],
            'actual_salary'=>$row['salary'],

           ];

          DB::table('payroll_logs')->insert($data);




        }
    }
}
