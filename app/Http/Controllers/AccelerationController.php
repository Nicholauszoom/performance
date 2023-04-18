<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\EMPL;
use App\Models\Acceleration;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use App\Models\Payroll\Payroll;
use App\Models\AccelerationTask;
use App\Models\PerformanceModel;
use App\Models\PerformanceRatio;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeePerformance;
use App\Models\Payroll\ReportModel;
use App\Models\Payroll\ImprestModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Payroll\FlexPerformanceModel;
use App\Http\Requests\StoreAccelerationRequest;
use App\Http\Requests\UpdateAccelerationRequest;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Accounting;

class AccelerationController extends Controller
{

    protected $flexperformance_model;
    protected $imprest_model;
    protected $reports_model;
    protected $attendance_model;
    protected $project_model;
    protected $performanceModel;
    protected $payroll_model;

    public function __construct(Payroll $payroll_model, FlexPerformanceModel $flexperformance_model, ReportModel $reports_model, ImprestModel $imprest_model, PerformanceModel $performanceModel)
    {
        $this->flexperformance_model = $flexperformance_model;
        $this->imprest_model = new ImprestModel();
        $this->reports_model = new ReportModel();
        // $this->attendance_model = new AttendanceModel();
        $this->project_model = new ProjectModel();
        $this->performanceModel = new PerformanceModel();
        $this->payroll_model = new Payroll;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['project'] = Acceleration::latest()->get();
        return view('acceleration.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('acceleration.add-acceleration');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAccelerationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Acceleration();
        $project->name = $request->name;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->created_by = Auth::user()->id;
        $project->save();

        return redirect('flex/acceleration');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Acceleration  $acceleration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Acceleration::where('id', $id)->first();
        $tasks = AccelerationTask::where('acceleration_id', $id)->get();
        return view('acceleration.single_acceleration', compact('project', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acceleration  $acceleration
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Acceleration::where('id', $id)->first();
        return view('acceleration.edit-acceleration', compact('project'));
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccelerationRequest  $request
     * @param  \App\Models\Acceleration  $acceleration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,)
    {
        $project = Acceleration::where('id', $request->id)->first();
        $project->name = $request->name;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->update();
        return redirect('flex/acceleration')->with('msg', 'Programme was updated Successfully !');
    }


    // For Adding Task
    public function add_acceleration_task($id)
    {
        $project = $id;
        $employees = EMPL::where('state', 1)->get();

        return view('acceleration.add-task', compact('project', 'employees'));
    }


    public function save_acceleration_task(Request $request)
    {
        $task = new AccelerationTask();
        $task->name = $request->name;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->acceleration_id = $request->project;
        $task->assigned = $request->assigned;
        $task->target = $request->target;
        $task->created_by = Auth::user()->emp_id;
        $task->save();

        return redirect('flex/view-acceleration/' . $request->project);
    }


    // For Delete Acceleration Task
    public function delete_acceleration_task($id)
    {
        $task = AccelerationTask::find($id);
        $performance = EmployeePerformance::where('task_id', $task->id)->first();
        //For Employee Performance Deletion
        if ($performance) {
            $performance->delete();
        }
        $id = $task->acceleration_id;
        $task->delete();

        return redirect('flex/view-acceleration/' . $id)->with('msg', 'Programme Task Was Deleted Successfully!');
    }


        // For Deleting  Project
        public function delete_project($id)
        {
            $project = Acceleration::find($id);
    
            $tasks = AccelerationTask::where('acceleration_id', $project->id)->get();
            foreach ($tasks as $item) {
                // $performance = EmployeePerformance::where('task_id', $item->id)->first();
                //For Employee Performance Deletion
                // if ($performance) {
                //     $performance->delete();
                // }
                $item->delete();
            }
    
            $project->delete();
    
            return redirect('flex/acceleration');
        }

        // For Complete Acceleration 
        
        public function completed_acceleration( $id)
        {
            $acceleration = Acceleration::where('id', $id)->first();
            $acceleration->status=1;
            $acceleration->update();

            return back();

        }
        // For Complete Acceleration Task
        public function completed_acceleration_task($id)
        {
            $task = AccelerationTask::where('id', $id)->first();
    
            $task->status = 1;
            $task->complete_date = Carbon::now();;
    
            $task->update();
    
            $performance = new EmployeePerformance();
            $performance->empID = $task->assigned;
            $performance->performance = $task->performance;
            $performance->behaviour = $task->behaviour;
            $performance->task_id = $task->id;
            $performance->target = $task->target;
            $performance->achieved = $task->achieved;
            $performance->type = 'pip';
            $performance->save();
    
    
            $tasks = AccelerationTask::where('acceleration_id', $task->project_id)->get();

            $project = Acceleration::where('id', $task->acceleration_id)->first();
            // return view('acceleration.single_acceleration', compact('project', 'tasks',));
            return back();
        }

        public function assess_task($id)
    {
        $task = AccelerationTask::where('id', $id)->first();
        return view('acceleration.asses_task', compact('task'));
    }

        // For Assessment
    public function save_assessment(Request $request)
    {
        $task = AccelerationTask::where('id', $request->id)->first();

        $task->remark = $request->remark;
        $task->achieved = $request->achievement;
        $task->behaviour = $request->behaviour;
        $task->remark = $request->remark;
        $task->time = $request->time;
        //For Task Performance'
        //For Ratio Variables
        $ratios = PerformanceRatio::first();
        $target_ratio = $ratios->target;
        $time_ratio = $ratios->time;
        $behaviour_ratio = $ratios->behaviour;
        // For Targets
        $target_reached = $task->achieved;
        $target_required = $task->target;
        // For Behaviour
        $behaviour = $task->behaviour;
        // For Time
        $d1 = new Carbon($task->start_date);
        $d2 = new Carbon($task->complete_date);
        $time_taken = $d2->diffInMinutes($d1);
        $d3 = new Carbon($task->end_date);
        $time_required = $d2->diffInMinutes($d1);

        $performance = (($target_reached / $target_required) * $target_ratio) + (($time_taken / $time_required) * $time_ratio) + (($behaviour / 100) * $behaviour_ratio);
        $task->performance = number_format($performance, 2);
        $task->update();

        $perf = EmployeePerformance::where('task_id', $task->id)->where('type','pip')->first();
        if ($perf) {
            $perf->performance = $task->performance;
            $perf->behaviour = $task->behaviour;
            $perf->target = $task->target;
            $perf->achieved = $task->achieved;
            $perf->update();
        } else {
            $perf = new EmployeePerformance();
            $perf->empID = $task->assigned;
            $perf->performance = $task->performance;
            $perf->behaviour = $task->behaviour;
            $perf->achieved = $task->achieved;
            $perf->target = $task->target;
            $perf->task_id = $task->id;
            $perf->type = 'pip';
            $perf->save();
        }



        return view('acceleration.asses_task', compact('task'));
    }


    // For Performance Matrix
    public function performance()
    {
         //$employee = EMPL::all();
        $employee = $this->flexperformance_model->employee();

        $item1 = 0;
        $item1_count = 0;
        $data['item1_data'] =  array();

        $item2 = 0;
        $item2_count = 0;
        $data['item2_data'] =  array();

        $item3 = 0;
        $item3_count = 0;
        $data['item3_data'] =  array();

        $item4 = 0;
        $item4_count = 0;
        $data['item4_data'] =  array();

        $item5 = 0;
        $item5_count = 0;
        $data['item5_data'] =  array();

        $item6 = 0;
        $item6_count = 0;
        $data['item6_data'] =  array();

        $item7 = 0;
        $item7_count = 0;
        $data['item7_data'] =  array();

        $item8 = 0;
        $item8_count = 0;
        $data['item8_data'] =  array();

        $item9 = 0;
        $item9_count = 0;
        $data['item9_data'] =  array();

        $item10 = 0;
        $item10_count = 0;
        $data['item10_data'] =  array();

        $item11 = 0;
        $item11_count = 0;
        $data['item11_data'] =  array();

        $item12 = 0;
        $item12_count = 0;
        $data['item12_data'] =  array();

        $item13 = 0;
        $item13_count = 0;
        $data['item13_data'] =  array();


        $item14 = 0;
        $item14_count = 0;
        $data['item14_data'] =  array();


        $item15 = 0;
        $item15_count = 0;
        $data['item15_data'] =  array();

        $item16 = 0;
        $item16_count = 0;
        $data['item16_data'] =  array();

        $item17 = 0;
        $item17_count = 0;
        $data['item17_data'] =  array();

        $item18 = 0;
        $item18_count = 0;
        $data['item18_data'] =  array();

        $item19 = 0;
        $item19_count = 0;
        $data['item19_data'] =  array();

        $item20 = 0;
        $item20_count = 0;
        $data['item20_data'] =  array();

        $item21 = 0;
        $item21_count = 0;
        $data['item21_data'] =  array();

        $item22 = 0;
        $item22_count = 0;
        $data['item22_data'] =  array();

        $item23 = 0;
        $item23_count = 0;
        $item23_data =  array();

        $item24 = 0;
        $item24_count = 0;
        $data['item24_data'] =  array();

        $item25 = 0;
        $item25_count = 0;
        $data['item25_data'] =  array();

        foreach ($employee as $item) {
            $performance = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.performance')
                ->where('employee_performances.type','=','pip')
                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.performance')
                // ->get()
            ;

            $behaviour = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.behaviour')
                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.behaviour');


            // For Behaviour Needs Improvement
            if ($behaviour > 0 && $behaviour < 20) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item1 = $item1 + $performance;
                    $item1_count++;
                    array_push($data['item1_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item2 = $item2 + $performance;
                    $item2_count++;
                    array_push($data['item2_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item3 = $item3 + $performance;
                    $item3_count++;
                    array_push($data['item3_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item4 = $item4 + $performance;
                    $item4_count++;
                    array_push($data['item4_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item5 = $item5 + $performance;
                    $item5_count++;
                    array_push($data['item5_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
            }

            // For Behaviour Good
            if ($behaviour >= 20 && $behaviour < 40) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item6 = $item6 + $performance;
                    $item6_count++;
                    array_push($data['item6_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item7 = $item7 + $performance;
                    $item7_count++;
                    array_push($data['item7_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item8 = $item8 + $performance;
                    $item8_count++;
                    array_push($data['item8_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item9 = $item9 + $performance;
                    $item9_count++;
                    array_push($data['item9_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item10 = $item10 + $performance;
                    $item10_count++;
                    array_push($data['item10_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
            }

            // For Behaviour Strong
            if ($behaviour >= 40 && $behaviour < 60) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item11 = $item11 + $performance;
                    $item11_count++;
                    array_push($data['item11_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item12 = $item12 + $performance;
                    $item12_count++;
                    array_push($data['item12_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item13 = $item13 + $performance;
                    $item13_count++;
                    array_push($data['item13_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item14 = $item14 + $performance;
                    $item14_count++;
                    array_push($data['item14_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item15 = $item15 + $performance;
                    $item15_count++;
                    array_push($data['item15_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
            }


            // For Behaviour Very Strong
            if ($behaviour >= 60 && $behaviour < 80) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item16 = $item16 + $performance;
                    $item16_count++;
                    array_push($data['item16_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item17 = $item17 + $performance;
                    $item17_count++;
                    array_push($data['item17_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item18 = $item18 + $performance;
                    $item18_count++;
                    array_push($data['item18_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item19 = $item19 + $performance;
                    $item19_count++;
                    array_push($data['item19_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item20 = $item20 + $performance;
                    $item20_count++;
                    array_push($data['item20_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
            }


            // For Behaviour Outstanding
            if ($behaviour >= 80 && $behaviour < 100) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item21 = $item21 + $performance;
                    $item21_count++;
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item22 = $item22 + $performance;
                    $item22_count++;
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item23 = $item23 + $performance;
                    $item23_count++;
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item24 = $item24 + $performance;
                    $item24_count++;
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item25 = $item25 + $performance;
                    $item25_count++;
                }
            }


            // var_dump($performance);
        }

        // For Colum 1
        $data['improvement'] = ($item1 > 0) ? $item1_count : 0;
        $data['improvement_good'] = ($item2 > 0) ? $item2_count : 0;
        $data['improvement_strong'] = ($item3 > 0) ? $item3_count : 0;
        $data['improvement_very_strong'] = ($item4 > 0) ? $item4_count : 0;
        $data['improvement_outstanding'] = ($item5 > 0) ? $item5_count : 0;

        // For Column 2
        $data['good_improvement'] = ($item6 > 0) ? $item6_count : 0;
        $data['good'] = ($item7 > 0) ? $item7_count : 0;
        $data['good_strong'] = ($item8 > 0) ? $item8_count : 0;
        $data['good_very_strong'] = ($item9 > 0) ? $item9_count : 0;
        $data['good_outstanding'] = ($item10 > 0) ? $item10_count : 0;

        // For Column 3
        $data['strong_improvement'] = ($item11 > 0) ? $item11_count : 0;
        $data['strong_good'] = ($item12 > 0) ? $item12_count : 0;
        $data['strong'] = ($item13 > 0) ? $item13_count : 0;
        $data['strong_very_strong'] = ($item14 > 0) ? $item14_count : 0;
        $data['strong_outstanding'] = ($item15 > 0) ? $item15_count : 0;

        // For Column 4
        $data['very_strong_improvement'] = ($item16 > 0) ? $item16_count : 0;
        $data['very_strong_good'] = ($item17 > 0) ? $item17_count : 0;
        $data['very_strong_strong'] = ($item18 > 0) ? $item18_count : 0;
        $data['very_strong'] = ($item19 > 0) ? $item19_count : 0;
        $data['very_strong_outstanding'] = ($item20 > 0) ? $item20_count : 0;

        // For Column 5
        $data['outstanding_improvement'] = ($item21 > 0) ? $item21_count : 0;
        $data['outstanding_good'] = ($item22 > 0) ? $item22_count : 0;
        $data['outstanding_strong'] = ($item23 > 0) ? $item23_count : 0;
        $data['outstanding_very_strong'] = ($item24 > 0) ? $item24_count : 0;
        $data['outstanding'] = ($item25 > 0) ? $item25_count : 0;


        // return  $data;




        return view('performance.report', $data);
    }


    // For Acceleration Details
    public function accelerationDetails($id){


        //$employee = EMPL::all();
        $employee = $this->flexperformance_model->employee();

        $item1 = 0;
        $item1_count = 0;
        $data['item1_data'] =  array();

        $item2 = 0;
        $item2_count = 0;
        $data['item2_data'] =  array();

        $item3 = 0;
        $item3_count = 0;
        $data['item3_data'] =  array();

        $item4 = 0;
        $item4_count = 0;
        $data['item4_data'] =  array();

        $item5 = 0;
        $item5_count = 0;
        $data['item5_data'] =  array();

        $item6 = 0;
        $item6_count = 0;
        $data['item6_data'] =  array();

        $item7 = 0;
        $item7_count = 0;
        $data['item7_data'] =  array();

        $item8 = 0;
        $item8_count = 0;
        $data['item8_data'] =  array();

        $item9 = 0;
        $item9_count = 0;
        $data['item9_data'] =  array();

        $item10 = 0;
        $item10_count = 0;
        $data['item10_data'] =  array();

        $item11 = 0;
        $item11_count = 0;
        $data['item11_data'] =  array();

        $item12 = 0;
        $item12_count = 0;
        $data['item12_data'] =  array();

        $item13 = 0;
        $item13_count = 0;
        $data['item13_data'] =  array();


        $item14 = 0;
        $item14_count = 0;
        $data['item14_data'] =  array();


        $item15 = 0;
        $item15_count = 0;
        $data['item15_data'] =  array();

        $item16 = 0;
        $item16_count = 0;
        $data['item16_data'] =  array();

        $item17 = 0;
        $item17_count = 0;
        $data['item17_data'] =  array();

        $item18 = 0;
        $item18_count = 0;
        $data['item18_data'] =  array();

        $item19 = 0;
        $item19_count = 0;
        $data['item19_data'] =  array();

        $item20 = 0;
        $item20_count = 0;
        $data['item20_data'] =  array();

        $item21 = 0;
        $item21_count = 0;
        $data['item21_data'] =  array();

        $item22 = 0;
        $item22_count = 0;
        $data['item22_data'] =  array();

        $item23 = 0;
        $item23_count = 0;
        $item23_data =  array();

        $item24 = 0;
        $item24_count = 0;
        $data['item24_data'] =  array();

        $item25 = 0;
        $item25_count = 0;
        $data['item25_data'] =  array();

        foreach ($employee as $item) {
            $performance = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.performance')
                ->where('employee_performances.type','=','pip')

                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.performance')
                // ->get()
            ;

            $behaviour = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.behaviour')
                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.behaviour');


            // For Behaviour Needs Improvement
            if ($behaviour > 0 && $behaviour < 20) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item1 = $item1 + $performance;
                    $item1_count++;
                    array_push($data['item1_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item2 = $item2 + $performance;
                    $item2_count++;
                    array_push($data['item2_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item3 = $item3 + $performance;
                    $item3_count++;
                    array_push($data['item3_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item4 = $item4 + $performance;
                    $item4_count++;
                    array_push($data['item4_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item5 = $item5 + $performance;
                    $item5_count++;
                    array_push($data['item5_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
            }

            // For Behaviour Good
            if ($behaviour >= 20 && $behaviour < 40) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item6 = $item6 + $performance;
                    $item6_count++;
                    array_push($data['item6_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item7 = $item7 + $performance;
                    $item7_count++;
                    array_push($data['item7_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item8 = $item8 + $performance;
                    $item8_count++;
                    array_push($data['item8_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item9 = $item9 + $performance;
                    $item9_count++;
                    array_push($data['item9_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item10 = $item10 + $performance;
                    $item10_count++;
                    array_push($data['item10_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
            }

            // For Behaviour Strong
            if ($behaviour >= 40 && $behaviour < 60) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item11 = $item11 + $performance;
                    $item11_count++;
                    array_push($data['item11_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item12 = $item12 + $performance;
                    $item12_count++;
                    array_push($data['item12_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item13 = $item13 + $performance;
                    $item13_count++;
                    array_push($data['item13_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item14 = $item14 + $performance;
                    $item14_count++;
                    array_push($data['item14_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item15 = $item15 + $performance;
                    $item15_count++;
                    array_push($data['item15_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
            }


            // For Behaviour Very Strong
            if ($behaviour >= 60 && $behaviour < 80) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item16 = $item16 + $performance;
                    $item16_count++;
                    array_push($data['item16_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item17 = $item17 + $performance;
                    $item17_count++;
                    array_push($data['item17_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item18 = $item18 + $performance;
                    $item18_count++;
                    array_push($data['item18_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item19 = $item19 + $performance;
                    $item19_count++;
                    array_push($data['item19_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item20 = $item20 + $performance;
                    $item20_count++;
                    array_push($data['item20_data'],['full_name'=>$item->NAME,'emp_id'=>$item->emp_id,'department'=>$item->DEPARTMENT,'performance'=>$performance,'behavior'=>$behaviour]);

                }
            }


            // For Behaviour Outstanding
            if ($behaviour >= 80 && $behaviour < 100) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item21 = $item21 + $performance;
                    $item21_count++;
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item22 = $item22 + $performance;
                    $item22_count++;
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item23 = $item23 + $performance;
                    $item23_count++;
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item24 = $item24 + $performance;
                    $item24_count++;
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item25 = $item25 + $performance;
                    $item25_count++;
                }
            }


            // var_dump($performance);
        }

        // For Colum 1
        $data['improvement'] = ($item1 > 0) ? $item1_count : 0;
        $data['improvement_good'] = ($item2 > 0) ? $item2_count : 0;
        $data['improvement_strong'] = ($item3 > 0) ? $item3_count : 0;
        $data['improvement_very_strong'] = ($item4 > 0) ? $item4_count : 0;
        $data['improvement_outstanding'] = ($item5 > 0) ? $item5_count : 0;

        // For Column 2
        $data['good_improvement'] = ($item6 > 0) ? $item6_count : 0;
        $data['good'] = ($item7 > 0) ? $item7_count : 0;
        $data['good_strong'] = ($item8 > 0) ? $item8_count : 0;
        $data['good_very_strong'] = ($item9 > 0) ? $item9_count : 0;
        $data['good_outstanding'] = ($item10 > 0) ? $item10_count : 0;

        // For Column 3
        $data['strong_improvement'] = ($item11 > 0) ? $item11_count : 0;
        $data['strong_good'] = ($item12 > 0) ? $item12_count : 0;
        $data['strong'] = ($item13 > 0) ? $item13_count : 0;
        $data['strong_very_strong'] = ($item14 > 0) ? $item14_count : 0;
        $data['strong_outstanding'] = ($item15 > 0) ? $item15_count : 0;

        // For Column 4
       //  $data['very_strong_improvement'] = ($item16 > 0) ? $item16_count : 0;
       //  $data['very_strong_good'] = ($item17 > 0) ? $item17_count : 0;
       //  $data['very_strong_strong'] = ($item18 > 0) ? $item18_count : 0;
       //  $data['very_strong'] = ($item19 > 0) ? $item19_count : 0;
       //  $data['very_strong_outstanding'] = ($item20 > 0) ? $item20_count : 0;

       //  // For Column 5
       //  $data['outstanding_improvement'] = ($item21 > 0) ? $item21_count : 0;
       //  $data['outstanding_good'] = ($item22 > 0) ? $item22_count : 0;
       //  $data['outstanding_strong'] = ($item23 > 0) ? $item23_count : 0;
       //  $data['outstanding_very_strong'] = ($item24 > 0) ? $item24_count : 0;
       //  $data['outstanding'] = ($item25 > 0) ? $item25_count : 0;

       $par = 'item'.$id.'_data';
       $data2['result'] = $data[$par];


       return view('performance.performance_details', $data2);

   }

}
