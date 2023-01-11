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



class ImportEmployee implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $flexperformance_model = new FlexPerformanceModel();
        $project_model = new ProjectModel();
        
        foreach ($collection as $row) 
        {  
            //check status of employee
        //     if($row['status'] == 'InActive'){
        //         $state = 4;
        //         $todate = date('Y-m-d');
        //         $datalog = array(
        //             'state' => 4,
        //             'current_state' => 4,
        //             'empID' => $row['empno'],
        //             'author' => session('emp_id'),
        //         );
        // //        echo json_encode($datalog);
        
        //         $flexperformance_model->deactivateEmployee($row['empno'], $datalog, '', $todate);
        //     }
            
        //     else
        //     $state=1;

            //check position
            //  if($row['position']!= NULL){
            // $data  =  DB::table('position')
            //  ->where('name',$row['position'])
            //  ->select('id')
            //  ->first();
            //  if($data!= NULL){
            //     $data = [
            //     'position'=>$data->id,];
            //     $recordID = ImportsEmployee::where('emp_id',$row['empno'])->update($data);

            //  }else{
            //     dd($row['position']);
            //  }

             //check department
            //if($row['department']!= NULL){
            // $data  =  DB::table('department')
            //  ->where('name',$row['department'])
            //  ->select('id')
            //  ->first();
            //  if($data!= NULL){
            //     $data = [
            //     'job_title'=>$row['jobtitle'],];
            //     $recordID = ImportsEmployee::where('emp_id',$row['empno'])->update($data);

            //  }else{
            //     dd($row['department']);
            //  }

      //       $branch  =  DB::table('branch')
      //         ->where('name',$row['branch'])
      //         ->select('id')->first();
      //         if($branch == null)
      //         dd($row['branch']);
      // $values = explode(',', $row['name']);
      //   $values2 = explode(' ', $values[0]);
      //   $fname = $values2[0];
      //   $mname = count($values2) == 2? $values2[1]:'';
      //   $lname = $values[1];
		
      //   $department = DB::table('department')->where('name',$row['department'])->select('*')->first();

      //   $position = DB::table('position')->where('name',$row['job'])->select('id')->first();
      //    if($position == null){
      //     DB::table('position')->insert(['name'=>$row['job'],'dept_id'=>$department->id]);
      //     $position = DB::table('position')->where('name',$row['job'])->select('id')->first();

      //    }

         $data = [
      //   'payroll_no'=>$row['payroll'],
        
	    // 'name'=>$row['name'],
      //    'fname'=>$fname,
      //    'mname'=>$mname,
      //    'lname'=>$lname,
	 	  // 'emp_level'=>$row['grade'], 	 	
	 	  // 'job_title'=>$row['job'], 		
	 	  // 'cost_center'=>$row['center'], 
         // 'position'=>$position->id, 		
	 	  // 'department'=>$department->id, 	
     	//   'salary'=>$row['salary'], 	
	 	  // 'pf_membership_no'=>$row['pension'], 
	 	  // 'account_no'=>$row['account_no'], 
	 	  // 'tin'=>$row['tin'], 
      //      'state'=>1, 	
	 	//   'form_iV_index'=>$row['form_4_index'], 	
	 	//   'heslb'=>$row['heslb'], 
            // 'department'=>!empty($data)?$data->id:100,
             'emp_id'=>$row['payroll'],
            // 'emp_code'=>$row['codeno'],
            // 'company'=>$row['company'],
            // 'state'=>$state,
            //  'emp_level'=>$row['grade'],
            //  'branch'=>$row['branch'],
            //    'job_title'=>$row['job'],
            //   'leave_days_entitled'=>$row['leave'],
            //   'accrual_rate'=>$row['accrual'],
            //   'branch'=>$branch->id,
            //'pf_membership_no'=>$row['nssf'],
            // 'emp_level'=>4,
            //'leave_days_entitled'=>$row['leavedaysentitle'],
            // 'bank'=>1,
            // 'bank_branch'=>1,
            // 'pension_fund'=>1,
            // 'email'=>$row['email'],
            // 'fname'=>$row['fname'],
            // 'mname'=>$row['pname'],
            // 'lname'=>$row['lname'],
            //  'birthdate'=>$row['birth'],
            //    'gender'=>$row['gender']=='F'?'Female':'Male',
            //    'email'=>$row['email'],
            //   'hire_date'=>$row['join'],
            //   'contract_end'=>$row['contract_end'],
            //   'contracted_month'=>$row['contracted_month'],
            //   'contract_type'=>$row['contract_type'] == 'Permanent'? 3:2,
            //   'heslb_balance'=>$row['heslb_balance'],
            //   'form_4_index'=>$row['form_4_index'],
            //   'national_id'=>$row['nida'],
            // 'salary'=>$row['basicpay'],
            // 'currency'=>$row['currency'],
            // 'username'=>$row['empno'],
            // 'password'=>"$2y$10$"."cuAOvfpGSYPLmwONROf9J.WpmZf0.sIq/si7gkSZZSjr7KmV5SrXG",

          ];

          //DB::table('employee_clean')->where('payroll_no',$row['payroll'])->update($data);
           $recordID = ImportsEmployee::where('payroll_no',$row['payroll'])->update($data);
        //   $data2 = [
        //     'state'=>1,
        //   ];
          

          //$record = DB::table('employee_clean')->insert($data);
        //   $emp = DB::table('employee')->where('payroll_no',$row['payroll'])->select('id')->first();
        //  if(!empty($emp))
        //  $recordID = ImportsEmployee::where('payroll_no',$row['payroll'])->update($data);
        //  else{
        //  $data['emp_id'] = $row['payroll'];
        //  $recordID = ImportsEmployee::insert($data);
        // }
         //$recordID = ImportsEmployee::create($data);
        //}
          
        //   $data = array(
        //     'empID' => $row['empno'],
        //     'activity_code' => 'AC0018',
        //     'grant_code' => 'VSO',
        //     'percent' => 100.00,
        // );
        // $project_model->allocateActivity($data);

        //   $empID = $row['empno'];

        //   $property = array(
        //       'prop_type' => "Employee Package",
        //       'prop_name' => "Employee ID, Health Insuarance Card, Email Address and System Access",
        //       'serial_no' => $empID,
        //       'given_by' => session('emp_id'),
        //       'given_to' => $empID,
        //   );
        //   $datagroup = array(
        //       'empID' => $empID,
        //       'group_name' => 1,
        //   );

        //   //$result = $flexperformance_model->updateEmployeeID($recordID, $empID, $property, $datagroup);
        //   $data_transfer = array(
        //     'empID' => $row['empno'],
        //     'parameter' => 'New Employee',
        //     'parameterID' => 5,
        //     'old' => 0,
        //     'new' => $row['basicpay'],
        //     'old_department' => 0,
        //     'new_department' => 1,
        //     'old_position' => 0,
        //     'new_position' => 1,
        //     'status' => 5, //new employee
        //     'recommended_by' => session('emp_id'),
        //     'approved_by' => '',
        //     'date_recommended' => date('Y-m-d'),
        //     'date_approved' => '',
        // );
        // $flexperformance_model->employeeTransfer($data_transfer);

       


        }

    }
}
