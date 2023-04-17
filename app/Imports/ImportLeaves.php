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
use App\Models\AttendanceModel;
use App\Models\ProjectModel;
use App\Models\Leaves;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ImportLeaves implements ToCollection,WithHeadingRow
{

    protected $attendance_model;



    public function __construct()
    {

      $this->attendance_model = new AttendanceModel();

    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {




        foreach ($collection as $row)
        {

            if($row['empid']){

            $result = DB::table('employee')->where('emp_id',$row['empid'])->select('hire_date','mobile')->first();
            if(!empty($result)){
                $leave_balance = $this->attendance_model->getLeaveBalance($row['empid'],$result->hire_date, '2023-03-31');

                $leaves=new Leaves();
                $emp=$row['empid'];

                $leaves->empID = $emp;
                $leaves->start =Date('Y-m-d') ;
                $leaves->end=Date('Y-m-d') ;
                $leaves->leave_address="auto";
                $leaves->mobile = $result->mobile;
                $leaves->nature = 1;
                $leaves->remaining=$row['leaves'];
                $leaves->days=$leave_balance - $row['leaves'];
                $leaves->reason="Automatic applied!";
                $leaves->position="Default Apllication";
                $leaves->status=3;
                $leaves->state=0;
                $leaves->save();



            }







        }
    }

}
}
