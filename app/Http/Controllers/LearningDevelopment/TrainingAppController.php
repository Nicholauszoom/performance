<?php

namespace App\Http\Controllers\LearningDevelopment;

use App\Http\Controllers\Controller;

use DB;
use Illuminate\Http\Request;
use App\Models\LearningDevelopment\Training_application_form;


class TrainingAppController extends Controller
{
    public function trainingApp(Request $request)
    {
        return view('LearningDevelopment.trainingApp');
    }

    public function insert(Request $request){
        $fname = $request->input('fname');
        $mname = $request->input('mname');
        $lname = $request->input('lname');
        $skill = $request->input('skill');
        $location = $request->input('location');
        $reason = $request->input('reason');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $budget = $request->input('budget');
     
        $data=array(
        'fname'=>$fname,
        "mname"=>$mname,
        "lname"=>$lname,
        "skill"=>$skill,
        "location"=>$location,
        "reason"=>$reason,
        "start_date"=>$start_date,
        "end_date"=>$end_date,
        "budget"=>$budget
    );
        DB::table('training_application_form')->insert($data);
        echo "Record inserted successfully.<br/>";
        return view('LearningDevelopment.trainingApp');
        }
}