<?php

namespace App\Http\Controllers\API;

use DateTime;
use Carbon\Carbon;
use App\Models\Leaves;
use App\Models\LeaveType;
use App\Models\LeaveSubType;
// use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\AttendanceModel;
use App\Models\Payroll\Payroll;
use App\Models\PerformanceModel;
use App\Models\Payroll\ReportModel;
use App\Http\Controllers\Controller;
use App\Models\Payroll\ImprestModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Payroll\FlexPerformanceModel;

class LeaveController extends Controller
{

  protected $flexperformance_model;
  protected $attendance_model;



    public function __construct(Payroll $payroll_model, FlexPerformanceModel $flexperformance_model, ReportModel $reports_model, ImprestModel $imprest_model, PerformanceModel $performanceModel)
    {
      $this->flexperformance_model = new FlexPerformanceModel();
   
      $this->attendance_model = new AttendanceModel();
   

    }

    /**
     * Display a listing of all leaves.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=auth()->user()->emp_id;

        $pending_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->where('state','1')->get();
        
        $sub_category=LeaveSubType::all();
        // $data['employees'] =EMPL::where('line_manager',Auth::user()->emp_id)->get();
        // $data['leaves'] =Leaves::get();

        $active_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->get();
        return response(
            [
                'pending_leaves'=>$pending_leaves,
                'active_leaves'=>$active_leaves,
                'sub_category'=>$sub_category
            ],200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
            //For Gender 
            $gender=auth()->user()->gender;
            if($gender=="Male"){$gender=1; }else { $gender=2;  }
            // for checking balance
            $today = date('Y-m-d');
            $arryear = explode('-',$today);
            $year = $arryear[0];
            $nature  = $request->nature;
            $empID  =auth()->user()->emp_id;
    
            // Checking used leave days based on leave type and sub type
            $leaves=Leaves::where('empID',$empID)->where('nature',$nature)->where('sub_category',$request->sub_cat)->whereYear('created_at',date('Y'))->sum('days');
            $leave_balance=$leaves;
            // For Leave Nature days
            $type=LeaveType::where('id',$nature)->first();
            $max_leave_days= $type->max_days;
    
            // Annual leave accurated days
    
            $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,auth()->user()->hire_date, date('Y-m-d'));
            // $annualleaveBalance =10;
            // dd($annualleaveBalance);
           
            // For  Requested days
            $start = $request->start;
            $end = $request->end;
    
            $date1=date('d-m-Y', strtotime($start));
            $date2=date('d-m-Y', strtotime($end));
            $start_date = Carbon::createFromFormat('d-m-Y', $date1);
            $end_date = Carbon::createFromFormat('d-m-Y', $date2);
            $different_days = $start_date->diffInDays($end_date);
    
    // dd( $different_days);
           
            // For Total Leave days
             $total_remaining=$leaves+$different_days;
    
            // For Working days
            $d1 = new DateTime (Auth::user()->hire_date);
            $d2 = new DateTime();
            $interval = $d2->diff($d1);
            $day=$interval->days;
            
  
            // For Employees with less than 12 months of employement
            if($day <= 365)
            {
    
                //  For Leaves with sub Category
                if($request->sub_cat > 0){
    
                  // For Sub Cart
                  $sub_cat=$request->sub_cat;
                  $sub=LeaveSubType::where('id',$sub_cat)->first();
    
                  $total_leave_days=$leaves+$different_days;
                  $maximum=$sub->max_days;
                  // Case hasnt used all days
                  if ($total_leave_days < $maximum) {
                    $leaves=new Leaves();
                    $empID=auth()->user()->emp_id;
                    $leaves->empID = $empID;
                    $leaves->start = $request->start;
                    $leaves->end=$request->end;
                    $leaves->leave_address=$request->address;
                    $leaves->mobile = $request->mobile;
                    $leaves->nature = $request->nature;       
               
                    // For Study Leave
                    if ($request->nature == 6) 
                    {
                      $leaves->days = $different_days;
                    }
                    //For Compassionate  
                    else{
                      $leaves->days = $different_days;
                    }
                    $leaves->reason = $request->reason;
                    $leaves->sub_category = $request->sub_cat;
                    $leaves->remaining = $request->sub_cat;
                    $leaves->application_date = date('Y-m-d');
                  // START
                  if ($request->hasfile('image')) {
    
                  $newImageName = $request->image->hashName();
                  $request->image->move(public_path('storage/leaves'), $newImageName);
                  $leaves->attachment =  $newImageName;
                  }
                 
              
                    $leaves->save();
                    $leave_type=LeaveType::where('id',$nature)->first();
                    $type_name=$leave_type->type;
    
                    $msg=$type_name." Leave Request  Has been Requested Successfully!";

                    return response( [ 'msg'=>$msg ],202 );
                  }
                  //  Case has used up all days
                  else
                  {
    
                    $leave_type=LeaveType::where('id',$nature)->first();
                    $type_name=$leave_type->type;
                    $msg="Sorry, You have finished Your ".$type_name." Leave Days";
    
                    return response( [ 'msg'=>$msg ],202 );
                  }
          
    
    
                }
               // For Leaves with no sub Category 
                else
                {
                  // $days=$different_days;
    
                  $total_leave_days=$leaves+$different_days;
    
                  if($total_leave_days<$max_leave_days || $request->nature==1)
                  {
                    $remaining=$max_leave_days-($leave_balance+$different_days);
    
                    // dd($leave_balance);
                    $leaves=new Leaves();
                    $empID=auth()->user()->emp_id;
                    $leaves->empID = $empID;
                    $leaves->start = $request->start;
                    $leaves->end=$request->end;
                    $leaves->leave_address=$request->address;
                    $leaves->mobile = $request->mobile;
                    $leaves->nature = $request->nature;
                    // for annual leave
                    if ($request->nature==1) {
                      $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,auth()->user()->hire_date, date('Y-m-d'));
    
                      // checking annual leave balance
                      if($different_days < $annualleaveBalance)
                      {
                        $leaves->days=$different_days;
                        $remaining=$annualleaveBalance-$different_days;
                        // dd($remaining);
    
                      }
                      else
                      {
                        // $leaves->days=$annualleaveBalance;  
                        $msg='You Have Finished Your Annual  Accrued Days';
                        return response( [ 'msg'=>$msg ],202 );
                      }
                             
                    }
                    
    
                    // For Paternity
                    if($request->nature != 5 && $request->nature != 1)
                    {
                     
                      $leaves->days = $different_days;
                    }
                    else
                    {
    
                      // Incase the employee had already applied paternity before
                        $paternity=Leaves::where('empID',$empID)->where('nature',$nature)->where('sub_category',$request->sub_cat)->first();
                        if ( $paternity) {
                          $d1 = $paternity->created_at;
                          $d2 = new DateTime();
                          $interval = $d2->diff($d1);
                          $range=$interval->days;
    
                          // dd($total_leave_days);
                          $month=$interval->format('%m months');
                          if ($month <= 4 ) {
                            $max_days=7;
                            if($total_leave_days < $max_days)
                            {
                              if($different_days<=$max_days)
                              {
                                // dd('wait');
                                $leaves->days = $different_days;
                              }
                              else
                              {
                                $leaves->days = $max_days;
                              }
                             
                            }
                            else
                            {
                             
                              $leave_type=LeaveType::where('id',$nature)->first();
                              $type_name=$leave_type->type;
                              $msg="Sorry, You have finished Your ".$type_name." Leave Days";
                              return response( [ 'msg'=>$msg ],202 );
                          
                            
                            }
    
                          }
                          else
                          {
                            $max_days=10;
    
                            if($different_days<$max_days)
                            {
                              $leaves->days = $different_days;
                              // dd('less than 4 months');
                            }
                            else
                            {
                              // $extra=$different_days-$max_days;
                              $leaves->days = $max_days;
                              // dd('You need '.$extra.' days.');
                            }
                          
                          }
                        }
                      // Incase an employee is applying for paternity for the first time
                        else
                        {
                          $month=$interval->format('%m months');
                             if ($month < 4 ) {
                            $max_days=7;
                            if($total_leave_days < $max_days)
                            {
                              if($different_days<=$max_days)
                              {
                                // dd('wait');
                                $leaves->days = $different_days;
                              }
                              else
                              {
                                $leaves->days = $max_days;
                              }
                             
                            }
                            else
                            {
                             
                              $leave_type=LeaveType::where('id',$nature)->first();
                              $type_name=$leave_type->type;
                              $msg="Sorry, You have finished Your ".$type_name." Leave Days";
                              return response( [ 'msg'=>$msg ],202 );
                          
                            
                            }
    
                          }
                          else
                          {
                            $max_days=10;
    
                            if($different_days<$max_days)
                            {
                              $leaves->days = $different_days;
                            }
                            else
                            {
                              // $extra=$different_days-$max_days;
                              $leaves->days = $max_days;
                              // dd('You need '.$extra.' days.');
                            }
                          
                          }
                        }
                    
                    }
                    $leaves->reason = $request->reason;
                    $leaves->remaining = $remaining;
                  
                    $leaves->sub_category = $request->sub_cat;
                    $leaves->application_date = date('Y-m-d');
                     // START
                    if ($request->hasfile('image')) {
    
                      $newImageName = $request->image->hashName();
                      $request->image->move(public_path('storage/leaves'), $newImageName);
                      $leaves->attachment =  $newImageName;
                    }
                     
              
                    $leaves->save();
                     
                  $leave_type=LeaveType::where('id',$nature)->first();
                  $type_name=$leave_type->type;
                  $msg=$type_name." Leave Request is submitted successfully!";
                  return response( [ 'msg'=>$msg ],202 );
                  }
                  else
                  {
    
                    $leave_type=LeaveType::where('id',$nature)->first();
                    $type_name=$leave_type->type;
                    $msg="Sorry, You have finished Your ".$type_name." Leave Days";
                    return response( [ 'msg'=>$msg ],202 );
    
                  }
    
                }
    
            }  
            // For Employee with more than 12 Month
            else 
            {
      
              $total_leave_days=$leaves+$different_days;
    
              if($total_leave_days<$max_leave_days)
              {
                $remaining=$max_leave_days-($leave_balance+$different_days);
                $leaves=new Leaves();
                $empID=auth()->user()->emp_id;
                $leaves->empID = $empID;
                $leaves->start = $request->start;
                $leaves->end=$request->end;
                $leaves->leave_address=$request->address;
                $leaves->mobile = $request->mobile;
                $leaves->nature = $request->nature;
                $leaves->sub_category = $request->sub_cat;

                     // for annual leave
                     if ($request->nature==1) {
                      $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,auth()->user()->hire_date, date('Y-m-d'));
                      // checking annual leave balance
                      if($different_days < $annualleaveBalance)
                      {
                        $leaves->days=$different_days;
                        $remaining=$annualleaveBalance-$different_days;
                        // dd($remaining);
    
                      }
                      else
                      {
                        // $leaves->days=$annualleaveBalance;  
                        $msg='You Have Finished Your Annual  Accrued Days';
                        return response( [ 'msg'=>$msg ],202 );
                      }
                             
                    }
                if($request->nature != 5 && $request->nature != 1)
                {
                 
                  
                  $leaves->days = $different_days;
                }
                else
                {
    
                    $paternity=Leaves::where('empID',$empID)->where('nature',5)->where('sub_category',$request->sub_cat)->whereYear('created_at',date('Y'))->orderBy('created_at','desc')->first();
                    
                    if ( $paternity) {
                      $d1 = $paternity->created_at;
                      $d2 = new DateTime();
                      $interval = $d2->diff($d1);
                      
                      $month=$interval->format('%m');
    
                        if ($month <= 4 ) {
                
                            $max_days=7;
                          
                            if($total_leave_days <= $max_days)
                            {
                              if($different_days<$max_days)
                              {
                                $leaves->days = $different_days;
                              }
                              else
                              {
                                $leaves->days = $max_days;
                              }
                             
                            }
                            // case All Paternity days have been used up
                            else
                            {
    
                              $excess=$total_leave_days-$max_days;
                              // dd($excess);
                              // dd('You requested for '.$excess.' extra days!');
                            }
                            
                          }
                          
                        else
                        {
                          $max_days=10;
                          if($total_leave_days <= $max_days)
                          {
                            if($different_days<$max_days)
                            {
                              $leaves->days = $different_days;
                            }
                            else
                            {
                              $leaves->days = $max_days;
                            }
                           
                          }
                          // case All Paternity days have been used up
                          else
                          {
    
                            $excess=$total_leave_days-$max_days;
                            // dd($excess);
                            // dd('You requested for '.$excess.' extra days!');
                          }
                        }
                      }
                      else
                      {
                        // $max_days=10;
                        $leaves->days = $different_days;
                        // dd('wait');
                      }
                    }
               
                
                
                $leaves->reason = $request->reason;
                $leaves->remaining = $remaining;
              
                $leaves->sub_category = $request->sub_cat;
                $leaves->application_date = date('Y-m-d');
                 // START
                if ($request->hasfile('image')) {
    
                  $newImageName = $request->image->hashName();
                  $request->image->move(public_path('storage/leaves'), $newImageName);
                  $leaves->attachment =  $newImageName;
                }
                 
          
                $leaves->save();
                       
                $leave_type=LeaveType::where('id',$nature)->first();
                $type_name=$leave_type->type;
    
              $msg=$type_name." Leave Request is submitted successfully!";
              return response( [ 'msg'=>$msg ],202 );
              }
              else
              {
                $leave_type=LeaveType::where('id',$nature)->first();
                $type_name=$leave_type->type;
                $msg="Sorry, You have finished Your ".$type_name." Leave Days";
                return response( [ 'msg'=>$msg ],202 );
    
              }
     
              
            }
    
          
    
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
