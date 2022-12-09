<?php

namespace App\Http\Controllers\WorkforceManagement;

use App\Helpers\SysHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\setting\Bank;
use App\Models\workforceManagement\Employee;

class EmployeeController extends Controller
{

    public function __construct(Employee $employee, $bankModel = null)
    {
        $this->employee = $employee;
        $this->bankModel = new Bank();
    }

    public function activeMembers()
    {
        $parent = 'Employee';
        $child = 'Active Employees';
        $employee = $this->employee->employeeData();

        return view('workforce-management.active-employee', compact('parent', 'child', 'employee'));
    }

    public function getPositionSalaryRange(Request $request)
    {

        $positionID = $request->positionID;

        $data = array(
            'state' => 0
        );

        $minSalary = $maxSalary = 0;

        $result = $this->employee->getPositionSalaryRange($positionID);

        foreach ($result as $value) {
            $minSalary = $value->minSalary;
            $maxSalary = $value->maxSalary;
        }

        if($result){
            //$response_array['status'] = "OK";
            $response_array['salary'] = "<input required='required'  class='form-control' type='number' min='".$minSalary."' step='0.01' max='".$maxSalary."'  name='salary'>";
        }else{
            $response_array['salary'] = "<input required='required'  class='form-control' type='text' readonly value = 'Salary was Set to 10000'><input hidden required='required' type='number' readonly value = '10000' name='salary'>";
        }

        header('Content-type: application/json');

        echo json_encode($response_array);

    }

    public function employeeProfile()
    {
        return view('workforce-management.employee-profile');
    }

    public function employeeExit()
    {
        $empID = $this->uri->segment(3);
        $datalog = array(
            'state' =>0,
            'empID' =>$empID,
            'author' =>$this->session->userdata('emp_id')
        );

        $this->employeeModel->employeestatelog($datalog);

        //  if($result ==true){
        //  $this->flexperformance_model->audit_log("Requested Deactivation of an Employee with ID =".$empID."");
        $response_array['status'] = "OK";
        $response_array['title'] = "SUCCESS";
        $response_array['message'] = "<p class='alert alert-success text-center'>Deactivation Request For This Employee Has Been Sent Successifully</p>";
        header('Content-type: application/json');
        return json_encode($response_array);
        //  } else {
        //    $response_array['status'] = "ERR";
        //    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Deactivation Request Not Sent</p>";
        //    header('Content-type: application/json');
        //    echo json_encode($response_array);
        //                }
    }



    public function createEmployee()
    {
        $parent = 'Employee';
        $child = 'Create';
        $banks = $this->bankModel->bank();
        $departments = DB::table('department')->get();
        $company_branch = DB::table('branch')->get();
        $contract = $this->employee->contractdrop();
        $pensiondrop = DB::table('pension_fund')->get();

        // dd($departments);

        return view('workforce-management.add-employee', compact('parent', 'child', 'banks', 'departments', 'company_branch', 'contract', 'pensiondrop'));
    }

    public function storeEmployee(Request $request)
    {

        dd($request->all());

        Employee::create([
            // 'emp_id' => "255002",
            // 'old_emp_id' => "0",
            // 'password_set' => "0",
            // 'fname' => $request->fname,
            // 'mname' => $request->mname,
            // 'lname' => $request->lname,
            // 'birthdate' => $request->birthdate, //date
            // 'gender' => $request->gender,
            // 'nationality' => $request->nationality,
            // 'merital_status' => $request->merital_status,
            // 'hire_date' => '2022-12-05', //date
            // 'department' => $request->department,
            // 'position' => $request->position,
            // 'branch' => '001',
            // 'shift' => 1,
            // 'organization' => 1,
            // 'line_manager' => 'Laison Marko',
            // 'contract_type' => 'PERMANENT',
            // 'contract_renewal_date' => '2022-12-05', //date
            // 'salary' => 100000, //DECIMALS
            // 'postal_address' => '15919',
            // 'postal_city' => 'MWANZA',
            // 'physical_address' => 'PHYSICAL ADDRESS',
            // 'mobile' => '656205600',
            // 'email' => 'fortunatusdouglas@gmail.com',
            // 'photo' => 'user.png',
            // 'is_expatriate' => 0,
            // 'home'=> 'Dar es salaam',
            // 'bank' => 1,
            // 'bank_branch' => 2,
            // 'account_no' => '01J89545495895',
            // 'pension_fund' => 1,
            // 'pf_membership_no' => 'pf_membership_no',
            // 'username' => 'Employee001',
            // 'password' => 'passoerd',
            // 'state' => 1,
            // 'login_user' => 0,
            // 'last_updated' => '2022-12-25', //date
            // 'last_login' => 'July 2022',
            // 'retired' => 1,
            // 'contract_end' => '2025-12-03', //date
            // 'tin' => '683683268328382',
            // 'national_id' => '21y2i1y2i1y2i3i'

            $request->all()
        ]);

        // SysHelpers::AuditLog(3, 'Employee Created', $request);

        return redirect( route('employee.active') );

    }

    public function updateEmployee(Request $request)
    {
        dd('Update employee');
    }

    public function employeeState()
    {
        /**
         * Activate and deactivate employees
         */
    }

    public function addKin()
    {
        # code...
    }

    public function destroyEmployee()
    {
        # code...
    }


    /**
     * Inactive employee
     *
     */
    public function inactiveEmployee()
    {
        $parent = 'Employee';
        $child = 'Suspended';

        $employee1 = $this->employee->inactive_employee1();
        $employee2 = $this->employee->inactive_employee2();

        // dd($employee2);

        return view('workforce-management.suspended-employee', compact('parent', 'child', 'employee1', 'employee2'));
    }


    /**
     * Overtime
     *
     */
    public function overtime()
    {
        $parent = 'Employee';
        $child = 'Overtime';

        $overtimeCategories = $this->employee->overtimeCategory();


        return view('workforce-management.overtime', compact('parent', 'child', 'overtimeCategories'));
    }


    /**
     * Imprest
     *
     */
    public function imprest()
    {
        $parent = 'Employee';
        $child = 'Imprest';

        return view('workforce-management.imprest', compact('parent', 'child'));
    }


    /**
     * Approval
     *
     */
    public function approveEmpoyee()
    {
        $parent = 'Employee';
        $child = 'Approve Employee';

        return view('workforce-management.approve.changes', compact('parent', 'child'));
    }

    public function approveRegister()
    {
        $parent = 'Employee';
        $child = 'Approve Employee';
        $transfer = $this->employee->employeeTransfers();

        dd($transfer);

        return view('workforce-management.approve.register', compact('parent', 'child', 'transfer'));
    }


}
