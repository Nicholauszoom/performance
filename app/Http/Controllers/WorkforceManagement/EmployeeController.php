<?php

namespace App\Http\Controllers\WorkforceManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function activeMembers()
    {
        return view('workforce-management.active-members');
    }

    public function createEmployee()
    {
        return view('workforce-management.add-employee');
    }
}
