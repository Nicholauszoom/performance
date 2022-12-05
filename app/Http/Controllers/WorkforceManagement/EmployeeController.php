<?php

namespace App\Http\Controllers\WorkforceManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
