<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformanceReportsController extends Controller
{
    //For All Reports Page

    public function index()
    {
        # code...

        return view('performance-reports.index');
    }


    public function organization_report(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        // dd($start);
        $data['start'] = $request->start_date;
        $data['end'] = $request->end_date;
        $data['performances'] = DB::table('employee')
        ->select('projects.name', DB::raw('SUM(employee_performances.performance as performances)'))
        ->groupBy('projects.name', 'employee_performances.performance')
        // // ->distinct('projects.id')
        ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
        ->where('employee_performances.type','=','project')
        ->whereNotNull('employee_performances.performance')
        
        ->join('project_tasks', 'employee_performances.task_id', '=', 'project_tasks.id')
        ->join('projects', 'project_tasks.id', '=', 'project_tasks.project_id')
        ->whereBetween('employee_performances.created_at', [$start, $end])
        ->get();

  return($data['performances']);

        // return view('performance-reports.organisation-report',$data);
    }



}
