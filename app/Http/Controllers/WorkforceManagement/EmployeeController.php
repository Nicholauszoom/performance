<?php

namespace App\Http\Controllers\WorkforceManagement;

use App\Helpers\SysHelpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\workforceManagement\Employee;

class EmployeeController extends Controller
{
    public function activeMembers()
    {
        return view('workforce-management.active-employee');
    }

    public function createEmployee()
    {
        $parent = 'Employee';
        $child = 'Create';

        return view('workforce-management.add-employee', compact('parent', 'child'));
    }

    public function storeEmployee(Request $request)
    {

        dd($request->all());

        // array:26 [
        //     "fname" => null
        //     "mname" => null
        //     "lname" => null
        //     "birthdate" => null
        //     "email" => null
        //     "photo" => null
        //     "emp_id" => null
        //     "department" => "1"
        //     "position" => "1"
        //     "line_manager" => "AZ"
        //     "branch" => "AZ"
        //     "salary" => null
        //     "contract_start" => null
        //     "contract_end" => null
        //     "pension_fund" => "AZ"
        //     "pf_membership_no" => null
        //     "bank" => "1"
        //     "banck_branch" => "1"
        //     "account_no" => null
        //     "mobile" => null
        //     "postal_address" => null
        //     "postal_city" => null
        //     "home" => null
        //     "tin" => null
        //     "level" => null
        // ]

        // $request->validate([
        //     'fname' => 'required|max:255',
        //     'mname' => 'max:255',
        //     'lname' => 'required|max:255',
        // ]);

        Employee::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
        ]);

        SysHelpers::AuditLog(3, 'Employee Created', $request);


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

    public function suspendedEmployee()
    {
        $parent = 'Employee';
        $child = 'Suspended';

        return view('workforce-management.suspended-employee', compact('parent', 'child'));
    }

    public function overtime()
    {
        # code...
    }


}
