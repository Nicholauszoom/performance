<?php

namespace App\Http\Controllers;

use App\Models\EMPL;
use App\Models\PerformancePillar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeePerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['employees']=EMPL::whereNot('state',4)->latest()->whereNot('id',Auth::user()->id)->get();
        return view('new-performance.employees',$data);
    }


    // For Employee Performance History
    public function employee_performance(Request $request)
    {
        $employee=EMPL::where('emp_id',$request->empID)->first();
        $data['employee']=EMPL::where('emp_id',$request->empID)->first();
        return view('new-performance.employee-performance',$data);
        // dd($employee);
    }
    // end



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


    // For Add Employee Evaluation
    public function add_evaluation ($id)
    {
        $data['employee']=EMPL::where('emp_id',$id)->first();
        $data['strategy']=PerformancePillar::where('type','Strategy')->latest()->get();
        $data['behaviour']=PerformancePillar::where('type','Behaviour')->latest()->get();

        return view('new-performance.add-evaluation',$data);

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
