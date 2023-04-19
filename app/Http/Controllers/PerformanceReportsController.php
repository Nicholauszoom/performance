<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\ProjectTask;
use Illuminate\Http\Request;
use App\Models\AccelerationTask;
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
        $data['count']=1;
        // dd($start);
        $data['start'] = $request->start_date;
        $data['end'] = $request->end_date;
        $data['performances'] = DB::table('employee')
        ->select('projects.name'
        , DB::raw('AVG(employee_performances.performance) as performance'),
        DB::raw('AVG(project_tasks.time) as time'),
        DB::raw('AVG(employee_performances.behaviour) as behaviour')
        )
        ->groupBy('projects.id')
        ->distinct('projects.id')
        ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
        
        ->whereNotNull('employee_performances.performance')
        
        ->join('project_tasks', 'employee_performances.task_id', '=', 'project_tasks.id')
        ->join('projects', 'project_tasks.project_id', '=', 'project_tasks.project_id')
        // ->whereBetween('project.start_date', [$start, $end])
        ->where('employee_performances.type','=','project')
        ->get();

//   return($data['performances']);

        return view('performance-reports.organisation-report',$data);
    }


    public function project_report(Request $request)
    {
        
        $start = $request->start_date;
        $end = $request->end_date;
        $data['count']=1;
        // dd($request->project_id);
        $data['start'] = $request->start_date;
        $data['end'] = $request->end_date;
        $data['name'] =ProjectTask::where('project_id',$request->project_id)->first();

        $data['performances'] =ProjectTask::where('project_id',$request->project_id)->get();
        $data['tasks'] =ProjectTask::where('project_id',$request->project_id)->avg('performance');
        $data['behaviour'] =ProjectTask::where('project_id',$request->project_id)->avg('behaviour');


        // $data['performances'] = DB::table('project_tasks')
        // ->select('projects.name'
        // , DB::raw('AVG(employee_performances.performance) as performance'),
        // DB::raw('AVG(project_tasks.time) as time'),
        // DB::raw('AVG(employee_performances.behaviour) as behaviour')
        // )
        // ->groupBy('projects.id')
        // ->distinct('projects.id')
        // ->join('project_tasks', ' projects.id', '=','project_tasks.project_id')
        // ->where('projects.id','=',$request->project_id)
        // ->where('project_tasks.project_id','=',$request->project_id)
        // ->where('employee_performances.type','=','project')
        // ->join('projects','project_tasks.project_id' ,'=',' projects.id')
        
        // ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
        // ->join('employee_performances', 'project_tasks.id', '=', 'employee_performances.task_id')
        // ->whereNotNull('employee_performances.performance')
        
        // ->join('project_tasks', 'employee_performances.task_id', '=', 'project_tasks.id')
    
        

        // ->whereBetween('project.start_date', [$start, $end])
       
        // ->get();

//   return($data['performances']);

        return view('performance-reports.project-report',$data);

    }


    // For Department Report
    public function department_report(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;
        $data['count']=1;
        // dd($start);
        $data['start'] = $request->start_date;
        $data['name'] =Department::where('id',$request->dept_id)->first() ;

        $data['end'] = $request->end_date;
        $data['performances'] = DB::table('employee')
        ->select('projects.name'
        , DB::raw('AVG(employee_performances.performance) as performance'),
        DB::raw('AVG(project_tasks.time) as time'),
        DB::raw('AVG(employee_performances.behaviour) as behaviour')
        )
        ->groupBy('projects.id')
        ->distinct('projects.id')
        ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
        
        ->whereNotNull('employee_performances.performance')
        
        ->join('project_tasks', 'employee_performances.task_id', '=', 'project_tasks.id')
        ->join('projects', 'project_tasks.project_id', '=', 'project_tasks.project_id')
        // ->whereBetween('project.start_date', [$start, $end])
        ->where('employee_performances.type','=','project')
        ->where('projects.id','=',$request->project_id)
        ->where('employee.department','=',$request->dept_id)

        ->get();


        return view('performance-reports.department-report',$data);

    }

    public function acceleration_report(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;
        $data['count']=1;
        // dd($request->project_id);
        $data['start'] = $request->start_date;
        $data['end'] = $request->end_date;
        $data['name'] =AccelerationTask::where('acceleration_id',$request->project_id)->first();

        $data['performances'] =AccelerationTask::where('acceleration_id',$request->project_id)->get();
        $data['tasks'] =AccelerationTask::where('acceleration_id',$request->project_id)->avg('performance');
        $data['behaviour'] =AccelerationTask::where('acceleration_id',$request->project_id)->avg('behaviour');

//   return($data['performances']);

        return view('performance-reports.acceleration-report',$data);
    }

}
