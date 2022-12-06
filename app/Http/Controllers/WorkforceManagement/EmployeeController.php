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

    public function __construct($employeeModel = null, $bankModel = null)
    {
        $this->employeeModel = new Employee();
        $this->bankModel = new Bank();
    }

    public function activeMembers()
    {
        $parent = 'Employee';
        $child = 'Active';
        $employee = $this->employeeModel->employeeData();

        dd($employee);


        return view('workforce-management.active-employee', compact('parent', 'child'));
    }

    public function createEmployee()
    {
        $parent = 'Employee';
        $child = 'Create';
        $banks = $this->bankModel->bank();

        // dd($banks);

        return view('workforce-management.add-employee', compact('parent', 'child', 'banks'));
    }

    public function storeEmployee(Request $request)
    {

        Employee::create([
            'emp_id' => "255002",
            'old_emp_id' => "0",
            'password_set' => "0",
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'birthdate' => $request->birthdate, //date
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'merital_status' => $request->merital_status,
            'hire_date' => '2022-12-05', //date
            'department' => $request->department,
            'position' => $request->position,
            'branch' => '001',
            'shift' => 1,
            'organization' => 1,
            'line_manager' => 'Laison Marko',
            'contract_type' => 'PERMANENT',
            'contract_renewal_date' => '2022-12-05', //date
            'salary' => 100000, //DECIMALS
            'postal_address' => '15919',
            'postal_city' => 'MWANZA',
            'physical_address' => 'PHYSICAL ADDRESS',
            'mobile' => '656205600',
            'email' => 'fortunatusdouglas@gmail.com',
            'photo' => 'user.png',
            'is_expatriate' => 0,
            'home'=> 'Dar es salaam',
            'bank' => 1,
            'bank_branch' => 2,
            'account_no' => '01J89545495895',
            'pension_fund' => 1,
            'pf_membership_no' => 'pf_membership_no',
            'username' => 'Employee001',
            'password' => 'passoerd',
            'state' => 1,
            'login_user' => 0,
            'last_updated' => '2022-12-25', //date
            'last_login' => 'July 2022',
            'retired' => 1,
            'contract_end' => '2025-12-03', //date
            'tin' => '683683268328382',
            'national_id' => '21y2i1y2i1y2i3i'
        ]);

        SysHelpers::AuditLog(3, 'Employee Created', $request);

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
    public function suspendedEmployee()
    {
        $parent = 'Employee';
        $child = 'Suspended';

        $employee1 = $this->employeeModel->inactive_employee1();
        $employee2 = $this->employeeModel->inactive_employee2();

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

        return view('workforce-management.overtime', compact('parent', 'child'));
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

        return view('workforce-management.approve.register', compact('parent', 'child'));
    }


}
