<?php

namespace App\Http\Controllers\LearningDevelopment;

use App\Http\Controllers\Controller;
use DB;

use Illuminate\Http\Request;
use App\Models\LearningDevelopment\Skill;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function skill()
    {

        return view('LearningDevelopment.skill');
    }
    public function Skills(Request $request){
    
        $skill = $request->input('skill');
        $budget = $request->input('budget');
     
        $data=array(

        "skill"=>$skill,
        "budget"=>$budget
    );
        DB::table('skill')->insert($data);
        echo "Record inserted successfully.<br/>";
        return view('LearningDevelopment.skill');
        }
        public function skillsList(){
            $users = DB::select('select * from skill');
            return view('LearningDevelopment.skillsList',['users'=>$users]);
            } 
}