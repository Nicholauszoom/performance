<?php

namespace App\Http\Controllers;

use App\Models\EMPL;
use App\Models\EmployeeEvaluation;
use App\Models\EmployeePerformance;
use App\Models\PerformancePillar;
use App\Models\PerformanceEvaluation;
use App\Models\Payroll\FlexPerformanceModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class EmployeePerformanceController extends Controller
{
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $flexperformance_model;
    public function __construct( FlexPerformanceModel $flexperformance_model)
    {
        $this->flexperformance_model = $flexperformance_model;

    }


    public function index()
    {

        $data['employees']=EMPL::whereNot('state',4)->latest()->whereNot('id',Auth::user()->id)->get();
        return view('new-performance.employees',$data);
    }


    // For Employee Performance History
    public function employee_performance(Request $request)
    {
        // $employee=EMPL::where('emp_id',$request->empID)->first();
        $data['evaluations']=EmployeeEvaluation::where('empID',$request->empID)->latest()->get();
        $data['employee']=EMPL::where('emp_id',$request->empID)->first();
        return view('new-performance.employee-performance',$data);
        // dd($employee);
    }
    // end

    //delete evaluation
    public function deleteEvaluation($id){
        $evaluation = EmployeeEvaluation::find($id);
    }



    // For All Performance Pillars
    public function performance_pillars()
    {
        $data['pillars']=PerformancePillar::latest()->get();
        return view('new-performance.pillars',$data);
    }

    // For Add New Pillar View
    public function add_pillar()
    {
        return view('new-performance.add-pillar');
    }

    // For Save Employee Performance
    public function save_pillar(Request $request)
    {
        $pillar=new PerformancePillar();
        $pillar->name=$request->name;
        $pillar->type=$request->type;
        $pillar->status=$request->status == true ? '1' : '0';
        $pillar->save();

        $msg='Pillar Saved Successfully!';

        return redirect('/flex/performance-pillars');
    }


    // Delete Performance pillar
    public function delete_pillar( $id)
    {
        $pillar=PerformancePillar::find($id);
        $pillar->delete();
        $msg='Pillar deleted successfully!';
        return back()->with('msg',$msg);
    }


    // For Edit Pillar
    public function edit_pillar($id )
    {
        $data['pillar']=PerformancePillar::find($id);
        return view('new-performance.edit-pillar',$data);
    }

    // For Update Pillar
    public function update_pillar(Request $request)
    {
        $pillar=PerformancePillar::find($request->pillar_id);
        $pillar->name=$request->name;
        $pillar->type=$request->type;
        $pillar->status=$request->status == true ? '1' : '0';
        $pillar->update();

        $msg='Pillar Was Updated Successfully!';

        return redirect('/flex/performance-pillars')->with('msg',$msg);

    }


    // For Save Employee Evaluation
    public function save_evaluation ($id)
    {
        $evaluation=new EmployeeEvaluation();
        $evaluation->empID=$id;
        $evaluation->name= now();
        $evaluation->save();

        return redirect('flex/add-evaluation/'.$evaluation->id);
    }

    public function modal(Request $request){
        $data['id'] = $request->id;
        if($request->type == 'behaviour'){
            return view('new-performance.add-score-behaviour',$data);
        }else
        return view('new-performance.add-score',$data);
    }

    public function addScore(Request $request){
        $id = $request->id;
       $performance = PerformanceEvaluation::find($id);
        $data['actions'] = $request->actions;
        $data['measures'] = $request->measures;
        $data['results'] = $request->measures;
        $data['weighting'] = $request->weighting;
        $data['number'] = $request->number;
        $data['score'] =$request->score;
        $data['rating'] =  ($data['score']/$data['weighting'])+2;

      $performance->update($data);

      return redirect('flex/show_evaluation/'.$performance->evaluation_id);

    }
    // For Add Employee Evaluation
    public function add_evaluation($id)
    {
        $evaluation=EmployeeEvaluation::where('id',$id)->first();


        $data['evaluation']=EmployeeEvaluation::where('id',$id)->first();
        $data['employee']=EMPL::where('emp_id',$evaluation->empID)->first();
        $result = $this->flexperformance_model->addEvaluation($evaluation,$id);


        $data['strategy'] = PerformanceEvaluation::all()->where('strategy_type','Strategy')->where('evaluation_id',$evaluation->id);

        //$data['strategy']=PerformancePillar::where('type','Strategy')->latest()->get();
        //$data['behaviour']=PerformancePillar::where('type','Behaviour')->latest()->get();
        $data['behaviour'] = PerformanceEvaluation::all()->where('strategy_type','Behaviour')->where('evaluation_id',$evaluation->id);


        return redirect('flex/show_evaluation/'.$evaluation->id);

        //return view('new-performance.add-evaluation',$data);
    }
    public function show_evaluation($id)
    {
        $evaluation=EmployeeEvaluation::where('id',$id)->first();

        $data['id'] = $id;

        $data['evaluation']=EmployeeEvaluation::where('id',$id)->first();
        $data['employee']=EMPL::where('emp_id',$evaluation->empID)->first();
        //$result = $this->flexperformance_model->addEvaluation($evaluation,$id);
        $data['strategy'] = PerformanceEvaluation::all()->where('strategy_type','Strategy')->where('evaluation_id',$evaluation->id);
        //$data['strategy']=PerformancePillar::where('type','Strategy')->latest()->get();
        //$data['behaviour']=PerformancePillar::where('type','Behaviour')->latest()->get();
        $data['behaviour'] = PerformanceEvaluation::all()->where('strategy_type','Behaviour')->where('evaluation_id',$evaluation->id);




        return view('new-performance.add-evaluation',$data);
    }

    public function show_employee_performance($id)
    {
        // $employee=EMPL::where('emp_id',$request->empID)->first();
        $data['evaluations']=EmployeeEvaluation::where('empID',$id)->latest()->get();
        $data['employee']=EMPL::where('emp_id',$id)->first();
        return view('new-performance.employee-performance',$data);
        // dd($employee);
    }

    public function submit_performance(Request $request){

        $id = $request->evaluation_id;

        $emp_performance = EmployeeEvaluation::find($id);

        $emp_performance->status = 1;
        $emp_performance->save();


        return redirect('flex/show_employee_performance/'.$emp_performance->empID);
    }

    // For Save Employee Evaluation Criterias
    public function save_criterias(Request $request)
    {
        $data = $request->input('data'); // assuming the form input name for the data is "data"

        foreach ($data as $entry) {
            $pillar_id = $entry['pillar_id'];
            $target = $entry['target'];

            // insert the data into the database
            DB::table('users')->insert([
                'pillar_id' => $pillar_id,
                'target' => $target
            ]);
        }
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
