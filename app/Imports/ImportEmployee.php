<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use App\Models\ImportsEmployee;
use App\Models\PerformanceModel;
use App\Models\ProjectModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ImportEmployee implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $flexperformance_model = new PerformanceModel();
        $project_model = new ProjectModel();
        
        foreach ($collection as $row) 
        {  
             

          $data = [
            'emp_id'=>$row['empno'],
            'emp_code'=>$row['codeno'],
            'emp_level'=>4,
            'bank'=>1,
            'bank_branch'=>1,
            'pension_fund'=>1,
            'email'=>$row['email'],
            'fname'=>$row['fname'],
            'mname'=>$row['pname'],
            'lname'=>$row['lname'],
            'birthdate'=>$row['dobirth'],
            'gender'=>$row['gender'],
            'email'=>$row['email'],
            'hire_date'=>$row['hiredate'],
            'salary'=>$row['basicpay'],
            'currency'=>$row['currency'],
            'username'=>$row['empno'],
            'password'=>"$2y$10$"."cuAOvfpGSYPLmwONROf9J.WpmZf0.sIq/si7gkSZZSjr7KmV5SrXG",

          ];
         $recordID = ImportsEmployee::where('emp_id',$row['empno'])->update($data);
          
          $data = array(
            'empID' => $row['empno'],
            'activity_code' => 'AC0018',
            'grant_code' => 'VSO',
            'percent' => 100.00,
        );
        $project_model->allocateActivity($data);

          $empID = $row['empno'];

          $property = array(
              'prop_type' => "Employee Package",
              'prop_name' => "Employee ID, Health Insuarance Card, Email Address and System Access",
              'serial_no' => $empID,
              'given_by' => session('emp_id'),
              'given_to' => $empID,
          );
          $datagroup = array(
              'empID' => $empID,
              'group_name' => 1,
          );

          $result = $flexperformance_model->updateEmployeeID($recordID, $empID, $property, $datagroup);
          $data_transfer = array(
            'empID' => $row['empno'],
            'parameter' => 'New Employee',
            'parameterID' => 5,
            'old' => 0,
            'new' => $row['basicpay'],
            'old_department' => 0,
            'new_department' => $request->input("department"),
            'old_position' => 0,
            'new_position' => $request->input("position"),
            'status' => 5, //new employee
            'recommended_by' => session('emp_id'),
            'approved_by' => '',
            'date_recommended' => date('Y-m-d'),
            'date_approved' => '',
        );
        $flexperformance_model->employeeTransfer($data_transfer);
        }

    }
}
