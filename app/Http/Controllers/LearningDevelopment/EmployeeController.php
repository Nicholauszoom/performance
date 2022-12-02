<?php

namespace App\Http\Controllers\LearningDevelopment;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\LearningDevelopment\Employee;
use App\Models\AccessControll\SystemModule;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        //
        
        $employee = employee::all();

        return view('LearningDevelopment.employee.index',Compact('employee'));
    }
}