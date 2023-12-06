<?php

namespace App\Http\Controllers\API;

use DateTime;
use Carbon\Carbon;
use App\Models\EMPL;
use App\Models\Leaves;
use App\Models\Position;
use App\Models\LeaveType;
use App\Helpers\SysHelpers;
// use Illuminate\Support\Carbon;
use App\Models\LeaveSubType;
use Illuminate\Http\Request;
use App\Models\LeaveApproval;
use App\Models\AttendanceModel;
use App\Models\Payroll\Payroll;
use App\Models\PerformanceModel;
use Illuminate\Support\Facades\DB;
use App\Models\Payroll\ReportModel;
use App\Http\Controllers\Controller;
use App\Models\Payroll\ImprestModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Payroll\FlexPerformanceModel;

use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailRequests;
use Symfony\Component\Mailer\Exception\TransportException;


class LeaveController extends Controller
{

  protected $flexperformance_model;
  protected $attendance_model;



    public function __construct(Payroll $payroll_model, FlexPerformanceModel $flexperformance_model, ReportModel $reports_model, ImprestModel $imprest_model, PerformanceModel $performanceModel)
    {
      $this->flexperformance_model = new FlexPerformanceModel();
   
      $this->attendance_model = new AttendanceModel();
      session('agent', '');
      session('platform', '');
      session('ip_address', '');

    }

    /**
     * Display a listing of all leaves.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Print the value of auth()->check()
    

    $id=auth()->user()->emp_id;
    $today = date('Y-m-d');
    $arryear = explode('-',$today);
    $year = $arryear[0];

    $employeeHiredate = explode('-', Auth::user()->hire_date);
    $employeeHireYear = $employeeHiredate[0];
    $employeeDate =  '';

    if($employeeHireYear == $year  ){
        $employeeDate = Auth::user()->hire_date;

    }else{
        $employeeDate = $year.('-01-01');
    }
   

    $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,auth()->user()->hire_date, date('Y-m-d'));
    $active_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->whereNot('reason','Automatic applied!')->get();
 
  //   $data['otherleave'] = $this->attendance_model->other_leaves($id);
  //   $data['otherleaves'] = $this->attendance_model->leave_line($id);
  //  //dd($data);
    $data = json_decode($active_leaves, true); // Decode the JSON data into an array
    $data= array_reverse($data); 
    $annualleaveBalance2 = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id,$employeeDate, date('Y-m-d'));
   
    // Loop through each object in the array
    foreach ($data as &$object) {
        // Add the accrued days data to the current object
    
        
        $object['accrued_days'] = $annualleaveBalance2;
    }
    
    // Encode the modified array as JSON and return it as the API response
  //  return response()->json($data);
    
   
  

    return response(
        [
 
            'active_leaves'=>$data,
           
           
        ],200 );
}

    // public function index()
    // {
    //     $id=auth()->user()->emp_id;

    //     $pending_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->where('state','1')->get();
        
    //     $sub_category=LeaveSubType::all();
    //     // $data['employees'] =EMPL::where('line_manager',Auth::user()->emp_id)->get();
    //     // $data['leaves'] =Leaves::get();

    //     $active_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->get();
    //     return response(
    //         [
    //             'pending_leaves'=>$pending_leaves,
    //             'active_leaves'=>$active_leaves,
    //             'sub_category'=>$sub_category
    //         ],200 );
    // }
    public function saveLeave(Request $request) {
      $start = $request->start;
      $end = $request->end;

 if($start < $end){
   
      //For Gender 
      $gender=Auth::user()->gender;
      if($gender=="Male"){$gender=1; }else { $gender=2;  }
      // for checking balance
      $today = date('Y-m-d');
      $arryear = explode('-',$today);
      $year = $arryear[0];
      $nature  = $request->nature;
      $empID  = Auth::user()->emp_id;

      // Checking used leave days based on leave type and sub type
      $leaves=Leaves::where('empID',$empID)->where('nature',$nature)->where('sub_category',$request->sub_cat)->whereYear('created_at',date('Y'))->sum('days');
      $leave_balance=$leaves;
      // For Leave Nature days
      $type=LeaveType::where('id',$nature)->first();
      $max_leave_days= $type->max_days;

      // Annual leave accurated days
      $annualleaveBalance = $this->attendance_model->getLeaveBalance(session('emp_id'), session('hire_date'), date('Y-m-d'));

      // For  Requested days
 
      $holidays=SysHelpers::countHolidays($start,$end);
      $different_days = SysHelpers::countWorkingDays($start,$end)-$holidays;
     
      // For Total Leave days
       $total_remaining=$leaves+$different_days;

      // For Working days
      $d1 = new DateTime (Auth::user()->hire_date);
      $d2 = new DateTime();
      $interval = $d2->diff($d1);
      $day= SysHelpers::countWorkingDays($d1,$d2);



      // For Redirection Url
      // $url = redirect('flex/attendance/my-leaves');

      // For Employees with less than 12 months of employement
      if($day <= 365)
      {

          //  For Leaves with sub Category
          if($request->sub_cat > 0)
          {

            // For Sub Category details
            $sub_cat=$request->sub_cat;
            $sub=LeaveSubType::where('id',$sub_cat)->first();

            $total_leave_days=$leaves+$different_days;
            $maximum=$sub->max_days;
            // Case hasnt used all days
            if ($total_leave_days < $maximum) 
            {
                $leaves=new Leaves();
                $empID=Auth::user()->emp_id;
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
                //For Compassionate and Maternity 
                else{
                  $leaves->days = $different_days;
                }
                $leaves->reason = $request->reason;
                $leaves->sub_category = $request->sub_cat;
                $leaves->remaining = $request->sub_cat;
                $leaves->application_date = date('Y-m-d');
                // For Leave Attachments
                  if ($request->hasfile('image')) {

                  $newImageName = $request->image->hashName();
                  $request->image->move(public_path('storage/leaves'), $newImageName);
                  $leaves->attachment =  $newImageName;
                  }
                $leaves->save();
                $leave_type=LeaveType::where('id',$nature)->first();
                $type_name=$leave_type->type;

                $msg=$type_name." Leave Request  Has been Requested Successfully!";
                return response( [ 'msg'=>$msg ],200 );

            }
            //  Case has used up all days or has less remaining leave days balance
            else
            {

              $leave_type=LeaveType::where('id',$nature)->first();
              $type_name=$leave_type->type;
              $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance";
              return response( [ 'msg'=>$msg ],202 );
            }
    
          }
         // For Leaves with no sub Category 
          else
          {

            $total_leave_days=$leaves+$different_days;

            if($total_leave_days<$max_leave_days || $request->nature==1)
            {
              $remaining=$max_leave_days-($leave_balance+$different_days);
              $leaves=new Leaves();
              $empID=Auth::user()->emp_id;
              $leaves->empID = $empID;
              $leaves->start = $request->start;
              $leaves->end=$request->end;
              $leaves->leave_address=$request->address;
              $leaves->mobile = $request->mobile;
              $leaves->nature = $request->nature;
              $leaves->deligated=$request->deligate;



              // For Deligation


              // for annual leave
              if ($request->nature==1) {
                  $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,auth()->user()->hire_date, date('Y-m-d'));
                  // checking annual leave balance
                  if($different_days<$annualleaveBalance)
                  {                     
                    $leaves->days=$different_days;
                    $remaining=$annualleaveBalance-$different_days;
                  }
                  else
                  {
                    // $leaves->days=$annualleaveBalance;  
                    $msg='You Have Insufficient Annual  Accrued Days';
                    return response( [ 'msg'=>$msg ],202 );
                  }                        
              }              

              // For Paternity
              if($request->nature != 5 && $request->nature!=1)
              {
               
                $leaves->days = $different_days;
              }
              if ($request->nature==5)
              {

                // Incase the employee had already applied paternity before
                  $paternity=Leaves::where('empID',$empID)->where('nature',$nature)->where('sub_category',$request->sub_cat)->first();
                  if ( $paternity) 
                  {
                    $d1 = $paternity->created_at;
                    $d2 = new DateTime();
                    $interval = SysHelpers::countWorkingDays($d1,$d2);
                    $range=SysHelpers::countWorkingDays($d1,$d2);
                    
                    $month=SysHelpers::countWorkingDays($d1,$d2);
                    // Incase an Employee has less than four working month since the last applied paternity
                    if ($month <112) {
                      $max_days=7;
                      if($total_leave_days < $max_days)
                      {
                        // Case reqested days are less than the balance
                        if($different_days<=$max_days)
                        {
                          $leaves->days = $different_days;
                        }
                        // Case requested days are more than the balance
                        else
                        {
                          $msg="Sorry, You have Insufficient  Leave Days Balance";
                          return response( [ 'msg'=>$msg ],202 );
                       // return $url->with('msg', $msg);
                        }
                       
                      }
                      else
                      {
                       
                        $leave_type=LeaveType::where('id',$nature)->first();
                        $type_name=$leave_type->type;
                        $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance";
                        return response( [ 'msg'=>$msg ],202 );
                    
                      
                      }

                    }
                    // For Employees who have attained 4 working months
                    else
                    {
                      $max_days=10;

                      if($different_days<$max_days)
                      {
                        $leaves->days = $different_days;
                      }
                      else
                      {
                        $msg="Sorry, You have Insufficient  Leave Days Balance";
                        return response( [ 'msg'=>$msg ],202 );
                      }
                    
                    }
                  }
                // Incase an employee is applying for paternity for the first time
                  else
                  {
                    // Checking if employee has less than 4 working months
                    if ($day < 112 ) 
                    {
                      $max_days=7;
                      if($total_leave_days < $max_days)
                      {
                        if($different_days<=$max_days)
                        {
                          $leaves->days = $different_days;
                        }
                        else
                        {
                          $msg="Sorry, You have Insufficient  Leave Days Balance";
                          return response( [ 'msg'=>$msg ],202 );
                        }
                       
                      }
                      else
                      {
                       
                        $leave_type=LeaveType::where('id',$nature)->first();
                        $type_name=$leave_type->type;
                        $msg="Sorry, You have Insufficient  ".$type_name." Leave Days Balance";
                        return response( [ 'msg'=>$msg ],202 );
                    
                      
                      }

                    }
                    // For Employee with more than 4 working months
                    else
                    {
                      $max_days=10;

                      if($different_days<$max_days)
                      {
                        $leaves->days = $different_days;
                      }
                      else
                      {
                        $msg="Sorry, You have Insufficient  Leave Days Balance";
                        return response( [ 'msg'=>$msg ],202 );
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
              $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance";
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
          $empID=Auth::user()->emp_id;
          $leaves->empID = $empID;
          $leaves->start = $request->start;
          $leaves->end=$request->end;
          $leaves->leave_address=$request->address;
          $leaves->mobile = $request->mobile;
          $leaves->nature = $request->nature;
          $leaves->deligated=$request->deligate;


          // for annual leave
          if ($request->nature==1) 
          {
                    $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,auth()->user()->hire_date, date('Y-m-d'));
  
                    // checking annual leave balance
                    if($different_days < $annualleaveBalance)
                    {
                      $leaves->days=$different_days;
                      $remaining=$annualleaveBalance-$different_days;
  
                    }
                    else
                    { 
                      $msg='You Have Insufficient Annual  Accrued Days';
                      return response( [ 'msg'=>$msg ],202 );
                    }
                           
          }
                  
          if($request->nature != 5 && $request->nature != 1)
          {
           
            $leaves->days = $different_days;
          }
          // For Paternity leabe
          if ($request->nature==5) 
          {

              $paternity=Leaves::where('empID',$empID)->where('nature',5)->where('sub_category',$request->sub_cat)->whereYear('created_at',date('Y'))->orderBy('created_at','desc')->first();
              // Case an Employee has ever applied leave before
              if ( $paternity) 
              {
                $d1 = $paternity->created_at;
                $d2 = new DateTime();
                $interval = SysHelpers::countWorkingDays($d1,$d2);
                
                $month=$interval;
                  // For Employee With Less Than 4 month of service and last application
                  if ($month <112 )
                  {
          
                      $max_days=7;
                    // Case Requested days are less than max-days
                      if($total_leave_days <= $max_days)
                      {
                        if($different_days<$max_days)
                        {
                          $leaves->days = $different_days;
                        }
                        else
                        {
                          $msg="Sorry, You have Insufficient Leave Days Balance";
                          return response( [ 'msg'=>$msg ],202 );
                        }
                       
                      }
                      // case All Paternity days have been used up
                      else
                      {

                        $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance";
                        return response( [ 'msg'=>$msg ],202 );
                      }
                      
                  }
                    // For Employee who as attained more than 4 working days
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
                        $msg="Sorry, You have Insufficient Leave Days Balance";
                        return response( [ 'msg'=>$msg ],202 );
                      }
                     
                    }
                    // case All Paternity days have been used up
                    else
                    {

                      $excess=$total_leave_days-$max_days;
                      // dd($excess);
                      $msg='You requested for '.$excess.' extra days!';

                      return response( [ 'msg'=>$msg ],202 );
                    }
                  }
              }
              // Case an employee is applying paternity for the first time
              else
              {
                // Checking if employee has less than 4 working months
                if ($day < 112 ) 
                {
                  $max_days=7;
                  if($total_leave_days < $max_days)
                  {
                    if($different_days<=$max_days)
                    {
                      $leaves->days = $different_days;
                    }
                    else
                    {
                      $msg="Sorry, You have Insufficient  Leave Days Balance";
                      return response( [ 'msg'=>$msg ],202 );
                    }
                   
                  }
                  else
                  {
                   
                    $leave_type=LeaveType::where('id',$nature)->first();
                    $type_name=$leave_type->type;
                    $msg="Sorry, You have Insufficient  ".$type_name." Leave Days Balance";
                    return response( [ 'msg'=>$msg ],202 );
                
                  
                  }

                }
                // For Employee with more than 4 working months
                else
                {
                  $max_days=10;

                  if($different_days<$max_days)
                  {
                    $leaves->days = $different_days;
                  }
                  else
                  {
                    $msg="Sorry, You have Insufficient  Leave Days Balance";
                    return response( [ 'msg'=>$msg ],202 );
                  }
                
                }
              }
          
          }
        
            $leaves->reason = $request->reason;
            $leaves->remaining = $remaining;
            $leaves->sub_category = $request->sub_cat;
            $leaves->application_date = date('Y-m-d');
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
              $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance";
              return response( [ 'msg'=>$msg ],202 );

            }

        
         }
     
        }else{
             $msg=" Sorry, You have Insufficient Leave Days Balance";
             return response( [ 'msg'=>$msg ],400 );
        }

    }

 //approve leave
 public function approveLeave(Request $request)
      {
        $id=$request->id;

       // $employee=$request->employee;
        $leave=Leaves::find($id);
     
        $empID=$leave->empID;
        $approval=LeaveApproval::where('empID',$empID)->first();
      //  dd($approval);
        $approver=Auth()->user()->emp_id;
        $employee=Auth()->user()->position;
      //  dd($approver);

        $position=Position::where('id',$employee)->first();


        // chacking level 1
     
      if($leave->state==1){
        if ($approval->level1==$approver) {

                // For Deligation
            if($leave->deligated!=null){
                $id=Auth::user()->emp_id;
                $this->attendance_model->save_deligated($leave->empID);


              $level1=DB::table('leave_approvals')->Where('level1',$empID)->update(['level1'=>$leave->deligated]);
              $level2=DB::table('leave_approvals')->Where('level2',$empID)->update(['level2'=>$leave->deligated]);
              $level3=DB::table('leave_approvals')->Where('level3',$empID)->update(['level3'=>$leave->deligated]);
              // dd($request->deligate);

            }




            $leave->status=2;
            $leave->state=0;
            $leave->level1=Auth()->user()->emp_id;
            $leave->position='Approved by '. $position->name;
            $leave->updated_at= new DateTime();
            $leave->update();


        }
        elseif($approval->level2==$approver)
        {

              // For Deligation
            if($leave->deligated!=null){
                $id=Auth::user()->emp_id;
                $this->attendance_model->save_deligated($leave->empID);



              $level1=DB::table('leave_approvals')->Where('level1',$id)->update(['level1'=>$leave->deligated]);
              $level2=DB::table('leave_approvals')->Where('level2',$id)->update(['level2'=>$leave->deligated]);
              $level3=DB::table('leave_approvals')->Where('level3',$id)->update(['level3'=>$leave->deligated]);
              // dd($request->deligate);

            }
            $leave->status=3;
            $leave->state=0;
            $leave->level2=Auth()->user()->emp_id;
            $leave->position='Approved by '. $position->name;
            $leave->updated_at= new DateTime();
            $leave->update();
          }

        elseif($approval->level3==$approver)
        {

            // For Deligation
            if($leave->deligated!=null){
                $id=Auth::user()->emp_id;
                $this->attendance_model->save_deligated($leave->empID);



              $level1=DB::table('leave_approvals')->Where('level1',$id)->update(['level1'=>$leave->deligated]);
              $level2=DB::table('leave_approvals')->Where('level2',$id)->update(['level2'=>$leave->deligated]);
              $level3=DB::table('leave_approvals')->Where('level3',$id)->update(['level3'=>$leave->deligated]);
              // dd($request->deligate);

            }
          $leave->status=3;
          $leave->state=0;
          $leave->level3=Auth()->user()->emp_id;
          $leave->position=$position->name;
          $leave->updated_at= new DateTime();
          $leave->update();
        }
        else
        {

            $msg='Sorry, You are Not Authorized';

           // return redirect('flex/attendance/leave')->with('msg', $msg);
           return response(['msg'=>$msg,
          'status'=>'error'
          ],400);
        }
        $emp_data = SysHelpers::employeeData($empID);
        $email_data = array(
            'subject' => 'Employee leave Approval',
            'view' => 'emails.linemanager.approved_leave',
            'email' => $emp_data->email,
            'full_name' => $emp_data->fname,' '.$emp_data->mname.' '.$emp_data->lname,
        );

        try {
          PushNotificationController::bulksend("Leave Approval",
        "Your Leave request is successful granted",
      "",$empID);

            Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));

        } catch (TransportException $exception) {

        $msg = "Leave Request Has been Approved Successfully But Email is not sent(SMPT problem) !";
        // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
        return redirect('flex/attendance/leave')->with('msg', $msg);
        }




        $msg = "Leave Request Has been approved Successfully !";
        // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
       // return redirect('flex/attendance/leave')->with('msg', $msg);
       
               return response(['msg'=>$msg,
              'status'=>'success'
              ],200);

              
      }

      // dd()
      else if($leave->state==0)
      {
        $msg='Leave Request Already Approved';
        return response(['msg'=>$msg,],202);

      }




    }

    public function rejectLeave(Request $request)
      {
        $leaveID = $request->id;
        $leave=Leaves::find($leaveID);
     
        // if($this->uri->segment(3)!=''){
          
          if($leave->state==1){
      
        $leave=Leaves::find($leaveID);
        $data = array(
                 'status' =>5,
                 'notification' => 1
            );
          $this->attendance_model->update_leave($data, $leaveID);
         $msg = "Leave Request Has been Rejected Successfully !";
          return response(['msg'=>$msg,], 200);
          }
          else if($leave->status==5){
            $msg='Leave Request Already Rejected';
            return response(['msg'=>$msg,],202);
          }
          else{
            $msg='Leave Request cannot be rejected';
            return response(['msg'=>$msg,],400);
          }
   }

   public function cancelLeave(Request $request)  {
    $id=$request->id;
    $message = $request ->message;

    $data=   $id.'|'.$message;
    $result = explode('|', $data);
    if (count($result) > 1) {
      $id = $result[0];
      $info = $result[1];
  } else {
      $id = $data;
      $info = '';
  }

    $leaveID = $id;

    $leave=Leaves::where('id',$leaveID)->first();
    if($leave != null) {
   
    if($id!=''  && $leave -> state == 1){
      if($info != ''){
        $leave->position = 'Denied by '. SysHelpers::getUserPosition(Auth::user()->position);
        $leave->state = 5;
        $leave->level1 = Auth::user()->id;
        $leave->revoke_reason = $info;
        $leave->save();
        $employee_data = SysHelpers::employeeData($leave->empID);
        $fullname = $employee_data['full_name'];

        $email_data = array(
            'subject' => 'Employee Leave Disapproval',
            'view' => 'emails.linemanager.leave-rejection',
            'email' => $employee_data['email'],
            'full_name' => $fullname,
            'info' => $info,
        );
        //dd($employee_data['email']);
        try {
  
            Notification::route('mail', $employee_data['email'])->notify(new EmailRequests($email_data));
  
        } catch (TransportException $exception) {
          $msg=" Leave Denial is successful but Email is not sent";
          return response( [ 'msg'=>$msg ],202 );
             
        }
         }
    }
    else if ($info == ''){
      $leave->state = 4;
      $leave->position = 'Cancelled by you';
      $leave->save();
      $msg="Leave cancellation is successfully!";
      return response(['msg'=>$msg],200);
    }
  
   else{
  $msg="Leave cancellation failed!";
  return response(['msg'=>$msg],400);
}
    }
    else{
      $msg="That leave does not exist";
  return response(['msg'=>$msg],400);
    }
}

public function cancelUserLeave(Request $request)  {
  $id=$request->id;
  $leaveID = $id;

  $leave=Leaves::where('id',$leaveID)->first();
  if($leave != null) {
 
if($id!=''  && $leave -> state == 1 ){



$leave->delete();


$msg="Leave is Deleted Successfully !";

return response(['msg'=>$msg],200);
}else{
$msg="Leave cancellation failed!";
return response(['msg'=>$msg],400);
}
  }
  else{
    $msg="That leave does not exist";
return response(['msg'=>$msg],400);
  }
}


  // start of leave approval
  public function approvLeave(Request $request)
    { 
      //session('mng_emp') || session('appr_leave');
      $id = $request->empID;
      // $this->session->set_userdata('vw_emp', $this->flexperformance_model->getpermission($empID, '4'));
      // $this->session->set_userdata('mng_emp', $this->flexperformance_model->getpermission($empID, '5'));

      // dd(session());     dd( session($id));
      // $leave=Leaves::find($id);
      $data['otherleave'] = $this->attendance_model->other_leaves(session('emp_id'));
     // dd($data);
      $leave=Leaves::where('empID',$id)->first();
      
      if($leave!=null){
        $empID=$leave->empID;
        $approval=LeaveApproval::where('empID',$empID)->first();



        $approver=Auth()->user()->emp_id;
        //dd($approver);
        $employee=Auth()->user()->position;
      
        $position=Position::where('id',$employee)->first();
        // dd($position);
  
        // chacking level 1
        if ($approval->level1==$approver) {
  
                // For Deligation
            if($leave->deligated!=null){
  
              $id=Auth::user()->emp_id;
              $level1=DB::table('leave_approvals')->Where('level1',$id)->update(['level1'=>$leave->deligated]);
              $level2=DB::table('leave_approvals')->Where('level2',$id)->update(['level2'=>$leave->deligated]);
              $level3=DB::table('leave_approvals')->Where('level3',$id)->update(['level3'=>$leave->deligated]);
              // dd($request->deligate);
  
            }
       
            
     
      
            $leave->status=3;
            $leave->state=0;
            $leave->level1=Auth()->user()->emp_id;
            $leave->position='Recommended by '. $position->name;
            $leave->updated_at= new DateTime();
            $leave->update();
          
  
        }
        elseif($approval->level2==$approver)
        {
              // For Deligation
            if($leave->deligated!=null){
  
              $id=Auth::user()->emp_id;
              $level1=DB::table('leave_approvals')->Where('level1',$id)->update(['level1'=>$leave->deligated]);
              $level2=DB::table('leave_approvals')->Where('level2',$id)->update(['level2'=>$leave->deligated]);
              $level3=DB::table('leave_approvals')->Where('level3',$id)->update(['level3'=>$leave->deligated]);
              // dd($request->deligate);
  
            }
            $leave->status=3;
            $leave->state=0;
            $leave->level2=Auth()->user()->emp_id;
            $leave->position='Recommended by '. $position->name;
            $leave->updated_at= new DateTime();
            $leave->update();
          }
        
        elseif($approval->level3==$approver)
        {
            // For Deligation
            if($leave->deligated!=null){
  
              $id=Auth::user()->emp_id;
              $level1=DB::table('leave_approvals')->Where('level1',$id)->update(['level1'=>$leave->deligated]);
              $level2=DB::table('leave_approvals')->Where('level2',$id)->update(['level2'=>$leave->deligated]);
              $level3=DB::table('leave_approvals')->Where('level3',$id)->update(['level3'=>$leave->deligated]);
              // dd($request->deligate);
  
            }
          $leave->status=3;
          $leave->state=0;
          $leave->level3=Auth()->user()->emp_id;
          $leave->position=$position->name;
          $leave->updated_at= new DateTime();
          $leave->update();
        }
      
  
  
  
  
        $msg = "Leave Request Has been approved Successfully !";
        // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
        //return redirect('flex/attendance/leave')->with('msg', $msg);
        return response( [ 'msg'=>$msg ],200 );
      }
      else{
        $msg = "Sorry, Leave Request Not Found !";
        return response( [ 'msg'=>$msg ],401 );
       // return redirect('flex/attendance/leave')->with('msg', $msg);
      }
     

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
            $start = $request->start;
            $end = $request->end;
            if($gender=="Male"){$gender=1; }else { $gender=2;  }
            // for checking balance
            $today = date('Y-m-d');
            $arryear = explode('-',$today);
            $year = $arryear[0];
            $nature  = $request->nature;
            $empID  =auth()->user()->emp_id;

            $pendingLeave = Leaves::where('empId', $empID)
            ->where('state', 1)
            ->whereDate('start', '<=', $start)
            ->whereDate('end', '>=', $start)
            ->first();

            $approvedLeave = Leaves::where('empId', $empID)
            ->where('state', 0)
            ->whereDate('start', '<=', $start)
            ->whereDate('end', '>=', $start)
            ->first();


        if ($pendingLeave || $approvedLeave) {
            $message = 'You have a ';

            if ($pendingLeave) {
                $message .= 'pending ' . $pendingLeave->type->type . ' application ';
            }

            if ($approvedLeave) {
                $message .= ($pendingLeave ? 'and ' : '') . 'approved ' . $approvedLeave->type->type . ' application ';
            }

            $message .= 'within the requested leave time';

            return response([ 'msg'=>$message ],202);
        }
    
            // Checking used leave days based on leave type and sub type
             $leaves = Leaves::where('empID', $empID)->where('nature', $nature)->where('sub_category', $request->sub_cat)->whereNot('reason', 'Automatic applied!')->whereYear('created_at', date('Y'))->sum('days');
            $leave_balance=$leaves;
            // For Leave Nature days
            $type=LeaveType::where('id',$nature)->first();
            $max_leave_days= $type->max_days;
    
            // Annual leave accurated days
            $employeeHiredate = explode('-', Auth::user()->hire_date);
            $employeeHireYear = $employeeHiredate[0];
            $employeeDate = '';

            if ($employeeHireYear == $year) {
                $employeeDate = Auth::user()->hire_date;

            } else {
                $employeeDate = $year . ('-01-01');
            }
    
            $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,auth()->user()->hire_date, date('Y-m-d'));
            // $annualleaveBalance =10;
            // dd($annualleaveBalance);
            if ($nature == 1) {
              $holidays = SysHelpers::countHolidays($start, $end);
              $different_days = SysHelpers::countWorkingDays($start, $end) - $holidays;

          } else {

              // $holidays=SysHelpers::countHolidays($start,$end);
              // $different_days = SysHelpers::countWorkingDays($start,$end)-$holidays;
              $different_days = SysHelpers::countWorkingDaysForOtherLeaves($start, $end);

              // $startDate = Carbon::parse($start);
              // $endDate = Carbon::parse($end);
              // $different_days = $endDate->diffInDays($startDate);
          }
           
            // For  Requested days
           


            
    
            $date1=date('d-m-Y', strtotime($start));
            $date2=date('d-m-Y', strtotime($end));
            $start_date = Carbon::createFromFormat('d-m-Y', $date1);
            $end_date = Carbon::createFromFormat('d-m-Y', $date2);
            $different_days = $start_date->diffInDays($end_date);
    
    // dd( $different_days);
           
            // For Total Leave days
             $total_remaining=$leaves+$different_days;
    
            // For Working days
            $d1 = new DateTime ($employeeDate);
            $d2 = new DateTime();
            $interval = $d2->diff($d1);
            $day = SysHelpers::countWorkingDays($d1, $d2);
            
  
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
                  $leaves->attachment= $newImageName;
                  }
                 
              
                    $leaves->save();
                    $leave_type=LeaveType::where('id',$nature)->first();
                    $type_name=$leave_type->type;
    
                    $msg=$type_name." Leave Request  Has been Requested Successfully!";
                    $linemanager =  LeaveApproval::where('empID',$empID)->first();
                    $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                    $employee_data = SysHelpers::employeeData($empID);
                    $fullname = $linemanager_data['full_name'];
                    $email_data = array(
                        'subject' => 'Employee Leave Approval',
                        'view' => 'emails.linemanager.leave-approval',
                        'email' => $linemanager_data['email'],
                        'full_name' => $fullname,
                        'employee_name'=>$employee_data['full_name'],
                        'next' => parse_url(route('attendance.leave'), PHP_URL_PATH)
                    );
     
                    try {
                      $msg=$type_name." Leave Request is submitted successfully!";
                     Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));
                     return response( [ 'msg'=>$msg ],202 );
     
                 } catch (TransportException $exception) {
                     $msg=$type_name." Leave Request  Has been Requested But Email is not sent(SMTP Problem)!";
                     return response( [ 'msg'=>$msg ],202 );
                 }

                    return response( [ 'msg'=>$msg ],202 );
                  }
                  //  Case has used up all days
                  else
                  {
    
                    $leave_type=LeaveType::where('id',$nature)->first();
                    $type_name=$leave_type->type;
                    $msg="Sorry, You have Insufficient ".$type_name." Leave Days";
    
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
                    $leaves->deligated=$request->deligate;
                    // for annual leave
                    if ($request->nature==1) {



                      
                      $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,$employeeDate, date('Y-m-d'));
    
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
                        $msg='You Have Insufficient Annual  Accrued Days';
                        return response( [ 'msg'=>$msg ],202 );
                      }
                             
                    }
                    
    
                    // For Paternity
                    if($request->nature != 5 && $request->nature != 1)
                    {
                     
                      $leaves->days = $different_days;
                    }
                    if ($request->nature==5)
                    {
    
                      // Incase the employee had already applied paternity before
                        $paternity=Leaves::where('empID',$empID)->where('nature',$nature)->where('sub_category',$request->sub_cat)->first();
                        if ( $paternity) {
                          $d1 = $paternity->created_at;
                          $d2 = new DateTime();
                          $interval = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
                          $range = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
    
                          // dd($total_leave_days);
                          $month = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
                          if ($month < 112) {
                            $max_days = 7;
                            if ($total_leave_days < $max_days) {
                                // Case reqested days are less than the balance
                                if ($different_days <= $max_days) {
                                    $leaves->days = $different_days;
                                }
                                // Case requested days are more than the balance
                                else {
                                    $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                    return response( [ 'msg'=>$msg ],202 );
                                }

                            } else {

                                $leave_type = LeaveType::where('id', $nature)->first();
                                $type_name = $leave_type->type;
                                $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance";
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
                              $msg = "Sorry, You have Insufficient  Leave Days Balance";
                               return response( [ 'msg'=>$msg ],202 );
                              // dd('You need '.$extra.' days.');
                            }
                          
                          }
                        }
                      // Incase an employee is applying for paternity for the first time
                      else {
                        // Checking if employee has less than 4 working months
                        if ($day < 112) {
                            $max_days = 7;
                            if ($total_leave_days < $max_days) {
                                if ($different_days <= $max_days) {
                                    $leaves->days = $different_days;
                                } else {
                                    $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                    return response( [ 'msg'=>$msg ],202 );
                                }

                            } else {

                                $leave_type = LeaveType::where('id', $nature)->first();
                                $type_name = $leave_type->type;
                                $msg = "Sorry, You have Insufficient  " . $type_name . " Leave Days Balance";
                                return response( [ 'msg'=>$msg ],202 );

                            }

                        }
                        // For Employee with more than 4 working months
                        else {
                            $max_days = 10;

                            if ($different_days < $max_days) {
                                $leaves->days = $different_days;
                            } else {
                                $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                return response( [ 'msg'=>$msg ],202 );
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
                    $linemanager =  LeaveApproval::where('empID',$empID)->first();
                    $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                    $employee_data = SysHelpers::employeeData($empID);
                    $leave_type = LeaveType::where('id', $nature)->first();
                    $type_name = $leave_type->type;
                    $fullname = $linemanager_data['full_name'];
                    $email_data = array(
                        'subject' => 'Employee Leave Approval',
                        'view' => 'emails.linemanager.leave-approval',
                        'email' => $linemanager_data['email'],
                        'full_name' => $fullname,
                        'employee_name'=>$employee_data['full_name'],
                        'next' => parse_url(route('attendance.leave'), PHP_URL_PATH)
                    );
     
                    try {
                      Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));
                  } catch (TransportException $exception) {
                      $msg = $type_name . " Leave Request has been requested, but the email was not sent (SMTP Problem)!";
                      return response(['msg' => $msg], 202);
                  }
                     
                  $leave_type=LeaveType::where('id',$nature)->first();
            
                  $type_name=$leave_type->type;
                  $msg=$type_name." Leave Request is submitted successfully!";
                  return response( [ 'msg'=>$msg ],202 );
                  }
                  else
                  {
    
                    $leave_type=LeaveType::where('id',$nature)->first();
                    $type_name=$leave_type->type;
                    $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance";
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
                $leaves->deligated=$request->deligate;

                     // for annual leave
                     if ($request->nature==1) {
                      $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id, $employeeDate, date('Y-m-d'));
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
                    
                    if ($paternity) {
                      $d1 = $paternity->created_at;
                      $d2 = new DateTime();
                      $interval = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);

                      $month = $interval;
                      // For Employee With Less Than 4 month of service and last application
                      if ($month < 112) {

                          $max_days = 7;
                          // Case Requested days are less than max-days
                          if ($total_leave_days <= $max_days) {
                              if ($different_days < $max_days) {
                                  $leaves->days = $different_days;
                              } else {
                                  $msg = "Sorry, You have Insufficient Leave Days Balance";
                                  return response( [ 'msg'=>$msg ],202 );
                              }

                          }
                          // case All Paternity days have been used up
                          else {

                              $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance4";
                              return response( [ 'msg'=>$msg ],202 );
                          }

                      }
                      // For Employee who as attained more than 4 working days
                      else {
                          $max_days = 10;
                          if ($total_leave_days <= $max_days) {
                              if ($different_days < $max_days) {
                                  $leaves->days = $different_days;
                              } else {
                                  $msg = "Sorry, You have Insufficient Leave Days Balance";
                                  return response( [ 'msg'=>$msg ],202 );
                              }

                          }
                          // case All Paternity days have been used up
                          else {

                              $excess = $total_leave_days - $max_days;
                              // dd($excess);
                              $msg = 'You requested for ' . $excess . ' extra days!';

                              return response( [ 'msg'=>$msg ],202 );
                          }
                      }
                  }
                  else {
                    // Checking if employee has less than 4 working months
                    if ($day < 112) {
                        $max_days = 7;
                        if ($total_leave_days < $max_days) {
                            if ($different_days <= $max_days) {
                                $leaves->days = $different_days;
                            } else {
                                $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                return response( [ 'msg'=>$msg ],202 );
                            }

                        } else {

                            $leave_type = LeaveType::where('id', $nature)->first();
                            $type_name = $leave_type->type;
                            $msg = "Sorry, You have Insufficient  " . $type_name . " Leave Days Balance";
                            return response( [ 'msg'=>$msg ],202 );

                        }

                    }
                    // For Employee with more than 4 working months
                    else {
                        $max_days = 10;

                        if ($different_days < $max_days) {
                            $leaves->days = $different_days;
                        } else {
                            $msg = "Sorry, You have Insufficient  Leave Days Balance";
                            return response( [ 'msg'=>$msg ],202 );
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
                $linemanager =  LeaveApproval::where('empID',$empID)->first();
                $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                $employee_data = SysHelpers::employeeData($empID);
                $fullname = $linemanager_data['full_name'];
                $email_data = array(
                    'subject' => 'Employee Leave Approval',
                    'view' => 'emails.linemanager.leave-approval',
                    'email' => $linemanager_data['email'],
                    'full_name' => $fullname,
                    'employee_name'=>$employee_data['full_name'],
                    'next' => parse_url(route('attendance.leave'), PHP_URL_PATH)
                );
 
                try {
 
                 Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));
 
             } catch (TransportException $exception) {
                 $msg=$type_name." Leave Request  Has been Requested But Email is not sent(SMTP Problem)!";
                 return response( [ 'msg'=>$msg ],202 );
 
             }
    
              $msg=$type_name." Leave Request is submitted successfully!";
              return response( [ 'msg'=>$msg ],202 );
              }
              
             
     
              
            } else
            {
              $leave_type=LeaveType::where('id',$nature)->first();
              $type_name=$leave_type->type;
              $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance";
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
    public function myLeaves()
    {
          $data =Leaves::where('empID',Auth::user()->emp_id)->orderBy('id','desc')->get();
           $id = Auth::user()->emp_id;
           $data['deligate']=DB::table('leave_approvals')->Where('level1',$id)->orWhere('level2',$id)->orWhere('level3',$id)->count();
           $data['deligates']=DB::table('leave_approvals')->Where('level1',$id)->orWhere('level2',$id)->orWhere('level3',$id)->get();
           $data['leave_types'] =LeaveType::all();
           $data['employees'] =EMPL::where('emp_id','!=',Auth::user()->emp_id)->whereNot('state',4)->get();
           $data['leaves'] =Leaves::get();
           // For Working days
           $d1 = new DateTime (Auth::user()->hire_date);
           $d2 = new DateTime();
           $interval = $d2->diff($d1);
           $data['days']=$interval->days;
           $data['title'] = 'Leave';
           $data['leaveBalance'] = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id, Auth::user()->hire_date, date('Y-m-d'));

           // dd($data['leaveBalance']);
           $data['leave_type'] = $this->attendance_model->leave_type();
         

           $data['parent'] = 'My Services';
           $data['child'] = 'Leaves';
           return response(
            [
     
                'active_leaves'=>$data,
               
               
            ],200 );
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
    public function leave() {
      $data['myleave'] =Leaves::where('empID',Auth::user()->emp_id)->get();

      if(session('appr_leave')){
        $data['otherleave'] = $this->attendance_model->leave_line(session('emp_id'));
      }else{
        $data['otherleave'] = $this->attendance_model->other_leaves(session('emp_id'));
      }
      $data['leave_types'] =LeaveType::all();
      $data['employees'] =EMPL::where('line_manager',Auth::user()->emp_id)->get();
      $data['leaves'] =Leaves::get();


      // For Working days
      $d1 = new DateTime (Auth::user()->hire_date);
      $d2 = new DateTime();
      $interval = $d2->diff($d1);
      $data['days']=$interval->days;
      $data['title'] = 'Leave';
      $data['leaveBalance'] = $this->attendance_model->getLeaveBalance(session('emp_id'), session('hire_date'), date('Y-m-d'));
      $data['leave_type'] = $this->attendance_model->leave_type();
      return view('app.leave', $data);


      
   }

    public function annualLeaveSummary ($year){
  
      $annualleavesummary = app('App\Http\Controllers\AttendanceController')->annuaLeaveSummary($year);
    

      return response(
        [
 
            'summary'=>$annualleavesummary->original
           
           
        ],200 );
    }

    public function store2(Request $request){
      $myurl="";
     $this->saveLeaveMain($request,$myurl);
  }

  public function saveLeaveMain($request,$return_parameter)
  {
   
      request()->validate(
          [

              // start of name information validation

              //'mobile' => 'required|numeric',
              // 'leave_address' => 'nullable|alpha',
              // 'reason' => 'required|alpha',

          ]);
      $start = $request->start;
      $end = $request->end;
      // For Redirection Url
      $url = redirect('flex/attendance/my-leaves');

      $employeee = EMPL::where('emp_id', Auth::user()->emp_id)->first();

      $linemanager = $employeee->line_manager;
      $leaveApproval = new LeaveApproval();
      $leaveApproval = $leaveApproval::where('empID', Auth::user()->emp_id)->first();

      if(!$leaveApproval){
         $leaveApproval =  new LeaveApproval();
         $leaveApproval->empID = Auth::user()->emp_id;
         $leaveApproval->level1 = $linemanager;
         $leaveApproval->save();
      }

      if ($start <= $end) {

          //For Gender
          $gender = Auth::user()->gender;
          if ($gender == "Male") {$gender = 1;} else { $gender = 2;}
          // for checking balance
          $today = date('Y-m-d');
          $arryear = explode('-', $today);
          $year = $arryear[0];
          $nature = $request->nature;
          $empID = Auth::user()->emp_id;

          // Check if there is a pending leave in the given number of days (start,end)
          // $pendingLeave = Leaves::where('empId', $empID)
          //     ->where('state', 1)
          //     ->whereDate('end', '>=', $start)
          //     ->first();
          $pendingLeave = Leaves::where('empId', $empID)
          ->where('state', 1)
          ->whereDate('start', '<=', $start)
          ->whereDate('end', '>=', $start)
          ->first();

          $approvedLeave = Leaves::where('empId', $empID)
          ->where('state', 0)
          ->whereDate('start', '<=', $start)
          ->whereDate('end', '>=', $start)
          ->first();


          if ($pendingLeave || $approvedLeave) {
              $message = 'You have a ';

              if ($pendingLeave) {
                  $message .= 'pending ' . $pendingLeave->type->type . ' application ';
              }

              if ($approvedLeave) {
                  $message .= ($pendingLeave ? 'and ' : '') . 'approved ' . $approvedLeave->type->type . ' application ';
              }

              $message .= 'within the requested leave time';
            if($return_parameter=="webUrl"){
              return $url->with('error', $message);
            }else{
              return response([ 'msg'=>$message ],202);
            }
              
          }

          // Checking used leave days based on leave type and sub type
          $leaves = Leaves::where('empID', $empID)->where('nature', $nature)->where('sub_category', $request->sub_cat)->whereNot('reason', 'Automatic applied!')->whereYear('created_at', date('Y'))->sum('days');

          $leave_balance = $leaves;
          // For Leave Nature days
          $type = LeaveType::where('id', $nature)->first();
          $max_leave_days = $type->max_days;

          //$max_leave_days = 10000;

          $employeeHiredate = explode('-', Auth::user()->hire_date);
          $employeeHireYear = $employeeHiredate[0];
          $employeeDate = '';

          if ($employeeHireYear == $year) {
              $employeeDate = Auth::user()->hire_date;

          } else {
              $employeeDate = $year . ('-01-01');
          }

          // Annual leave accurated days
          $annualleaveBalance = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id, Auth::user()->hire_date, date('Y-m-d'));
          // dd($annualleaveBalance);
          // For  Requested days
          if ($nature == 1) {
              $holidays = SysHelpers::countHolidays($start, $end);
              $different_days = SysHelpers::countWorkingDays($start, $end) - $holidays;

          } else {

              // $holidays=SysHelpers::countHolidays($start,$end);
              // $different_days = SysHelpers::countWorkingDays($start,$end)-$holidays;
              $different_days = SysHelpers::countWorkingDaysForOtherLeaves($start, $end);

              // $startDate = Carbon::parse($start);
              // $endDate = Carbon::parse($end);
              // $different_days = $endDate->diffInDays($startDate);
          }

          // For Total Leave days
          $total_remaining = $leaves + $different_days;

          // For Working days
          $d1 = new DateTime($employeeDate);
          $d2 = new DateTime();
          $interval = $d2->diff($d1);
          $day = SysHelpers::countWorkingDays($d1, $d2);

          // For Employees with less than 12 months of employement
          if ($day <= 365) {

              //  For Leaves with sub Category
              if ($request->sub_cat > 0) {

                  // For Sub Category details
                  $sub_cat = $request->sub_cat;
                  $sub = LeaveSubType::where('id', $sub_cat)->first();

                  $total_leave_days = $leaves + $different_days;
                  $maximum = $sub->max_days;
                  // Case hasnt used all days
                  if ($total_leave_days < $maximum) {
                      $leaves = new Leaves();
                      $empID = Auth::user()->emp_id;
                      $leaves->empID = $empID;
                      $leaves->status = 1;
                      $leaves->start = $request->start;
                      $leaves->end = $request->end;
                      $leaves->leave_address = $request->address;
                      $leaves->mobile = $request->mobile;
                      $leaves->nature = $request->nature;

                      // For Study Leave
                      if ($request->nature == 6) {
                          $leaves->days = $different_days;
                      }
                      //For Compassionate and Maternity
                      else {
                          $leaves->days = $different_days;
                      }
                      $leaves->reason = $request->reason;
                      $leaves->sub_category = $request->sub_cat;
                      $leaves->remaining = $request->sub_cat;
                      $leaves->application_date = date('Y-m-d');
                      // For Leave Attachments
                      if ($request->hasfile('image')) {
                          $request->validate([
                              //  'image' => 'required|clamav',
                          ]);
                          $request->validate([
                              'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                          ]);
                          $newImageName = $request->image->hashName();
                          $request->image->move(public_path('storage/leaves'), $newImageName);
                          $leaves->attachment = $newImageName;

                      }
                      $leaves->save();
                      $leave_type = LeaveType::where('id', $nature)->first();
                      $type_name = $leave_type->type;

                      //fetch Line manager data from employee table and send email
                      $linemanager = LeaveApproval::where('empID', $empID)->first();
                      $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                      $employee_data = SysHelpers::employeeData($empID);
                      $fullname = $linemanager_data['full_name'];
                      $email_data = array(
                          'subject' => 'Employee Leave Approval',
                          'view' => 'emails.linemanager.leave-approval',
                          'email' => $linemanager_data['email'],
                          'full_name' => $fullname,
                          'employee_name' => $employee_data['full_name'],
                          'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                      );

                      try {

                          Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                      } catch (Exception $exception) {
                          $msg = $type_name . " Leave Request  Has been Requested But Email is not sent(SMTP Problem)!";
                          if($return_parameter=="webUrl")
                          {
                          return $url->with('msg', $msg);}
                          else{
                              return response([ 'msg'=>$msg ],202);
                          }

                      }
                      $msg = $type_name . " Leave Request  Has been Requested Successfully!";
                      if($return_parameter=="webUrl"){
                      return $url->with('msg', $msg);}
                      else{
                          return response([ 'msg'=>$msg ],202);
                      }

                  }
                  //  Case has used up all days or has less remaining leave days balance
                  else {

                      $leave_type = LeaveType::where('id', $nature)->first();
                      $type_name = $leave_type->type;
                      $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance1";
                      if($return_parameter=="webUrl"){
                      return $url->with('msg', $msg);}
                      else{
                          return response([ 'msg'=>$msg ],202); 
                      }
                  }

              }
              // For Leaves with no sub Category
              else {

                  $total_leave_days = $leaves + $different_days;

                  if ($total_leave_days < $max_leave_days || $request->nature == 1) {
                      $remaining = $max_leave_days - ($leave_balance + $different_days);
                      $leaves = new Leaves();
                      $empID = Auth::user()->emp_id;
                      $leaves->empID = $empID;
                      $leaves->start = $request->start;
                      $leaves->end = $request->end;
                      $leaves->leave_address = $request->address;
                      $leaves->status = 1;
                      $leaves->mobile = $request->mobile;
                      $leaves->nature = $request->nature;
                      $leaves->deligated = $request->deligate;

                      // for annual leave
                      if ($request->nature == 1) {
                          $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id, $employeeDate, date('Y-m-d'));

                          // checking annual leave balance
                          if ($different_days < $annualleaveBalance) {
                              $leaves->days = $different_days;
                              $remaining = $annualleaveBalance - $different_days;
                          } else {
                              // $leaves->days=$annualleaveBalance;
                              $msg = 'You Have Insufficient Annual  Accrued Days';
                             if($return_parameter=="webUrl"){
                              return $url->with('msg', $msg);
                             }else{
                              return response([ 'msg'=>$msg ],202);
                             }
                          }
                      }

                      // For Paternity
                      if ($request->nature != 5 && $request->nature != 1) {

                          $leaves->days = $different_days;
                      }
                      if ($request->nature == 5) {

                          // Incase the employee had already applied paternity before
                          $paternity = Leaves::where('empID', $empID)->where('nature', $nature)->where('sub_category', $request->sub_cat)->first();
                          if ($paternity) {
                              $d1 = $paternity->created_at;
                              $d2 = new DateTime();
                              $interval = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
                              $range = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);

                              $month = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
                              // Incase an Employee has less than four working month since the last applied paternity
                              if ($month < 112) {
                                  $max_days = 7;
                                  if ($total_leave_days < $max_days) {
                                      // Case reqested days are less than the balance
                                      if ($different_days <= $max_days) {
                                          $leaves->days = $different_days;
                                      }
                                      // Case requested days are more than the balance
                                      else {
                                          $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                          if($return_parameter=="webUrl"){ return $url->with('msg', $msg);}else{
                                              return response([ 'msg'=>$message ],202);
                                          }
                                      }

                                  } else {

                                      $leave_type = LeaveType::where('id', $nature)->first();
                                      $type_name = $leave_type->type;
                                      $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance2";
                                      if($return_parameter=="webUrl"){
                                          return $url->with('msg', $msg);
                                      }else{
                                          return response([ 'msg'=>$msg ],202);
                                      }
                                     

                                  }

                              }
                              // For Employees who have attained 4 working months
                              else {
                                  $max_days = 10;

                                  if ($different_days < $max_days) {
                                      $leaves->days = $different_days;
                                  } else {
                                      $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                     if($return_parameter=="webUrl"){

                                     return $url->with('msg', $msg);

                                     }else{
                                      return response([ 'msg'=>$msg ],202);
                                     }
                                  }

                              }
                          }
                          // Incase an employee is applying for paternity for the first time
                          else {
                              // Checking if employee has less than 4 working months
                              if ($day < 112) {
                                  $max_days = 7;
                                  if ($total_leave_days < $max_days) {
                                      if ($different_days <= $max_days) {
                                          $leaves->days = $different_days;
                                      } else {
                                          $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                         if($return_parameter=="webUrl"){
                                           return $url->with('msg', $msg);
                                          }
                                           else{
                                              return response([ 'msg'=>$msg ],202);
                                          }
                                      }

                                  } else {

                                      $leave_type = LeaveType::where('id', $nature)->first();
                                      $type_name = $leave_type->type;
                                      $msg = "Sorry, You have Insufficient  " . $type_name . " Leave Days Balance";
                                      if($return_parameter=="webUrl"){
                                      return $url->with('msg', $msg);
                                      }else{
                                          return response([ 'msg'=>$msg ],202);
                                      }

                                  }

                              }
                              // For Employee with more than 4 working months
                              else {
                                  $max_days = 10;

                                  if ($different_days < $max_days) {
                                      $leaves->days = $different_days;
                                  } else {
                                      
                                      $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                     if($return_parameter=="webUrl"){
                                      return $url->with('msg', $msg);
                                     }else{
                                      return response([ 'msg'=>$msg ],202);
                                     }
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
                          $request->validate([
                              // 'image' => 'required|clamav',
                          ]);
                          $request->validate([
                              'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                          ]);

                          $newImageName = $request->image->hashName();
                          $request->image->move(public_path('storage/leaves'), $newImageName);
                          $leaves->attachment = $newImageName;

                      }

                      $leaves->save();

                      //fetch Line manager data from employee table and send email
                      $linemanager = LeaveApproval::where('empID', $empID)->first();
                      $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                      $employee_data = SysHelpers::employeeData($empID);
                      $fullname = $linemanager_data['full_name'];
                      $email_data = array(
                          'subject' => 'Employee Leave Approval',
                          'view' => 'emails.linemanager.leave-approval',
                          'email' => $linemanager_data['email'],
                          'full_name' => $fullname,
                          'employee_name' => $employee_data['full_name'],
                          'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                      );
                      try {

                          Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                      } catch (Exception $exception) {
                          $leave_type = LeaveType::where('id', $nature)->first();
                          $type_name = $leave_type->type;
                          $msg = $type_name . " Leave Request is submitted successfully But Email not sent(SMTP Problem)!";
                      
                          if($return_parameter=="webUrl"){
                          return $url->with('msg', $msg);
                         }else{
                          return response([ 'msg'=>$msg ],202);
                         }
                      }

                      $leave_type = LeaveType::where('id', $nature)->first();
                      $type_name = $leave_type->type;
                      $msg = $type_name . " Leave Request is submitted successfully!";
                      if($return_parameter=="webUrl"){
                      return $url->with('msg', $msg);
                      }else{
                          return response([ 'msg'=>$msg ],202);
                      }
                  } else {

                      $leave_type = LeaveType::where('id', $nature)->first();
                      $type_name = $leave_type->type;
                      $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance3";
                      if($return_parameter=="webUrl"){
                      return $url->with('msg', $msg);
                      }else{
                          return response([ 'msg'=>$msg ],202);
                      }

                  }

              }

          }
          // For Employee with more than 12 Month
          else {

              $total_leave_days = $leaves + $different_days;

              if ($total_leave_days < $max_leave_days) {
                  $remaining = $max_leave_days - ($leave_balance + $different_days);
                  $leaves = new Leaves();
                  $empID = Auth::user()->emp_id;
                  $leaves->empID = $empID;
                  $leaves->start = $request->start;
                  $leaves->end = $request->end;
                  $leaves->status = 1;
                  $leaves->leave_address = $request->address;
                  $leaves->mobile = $request->mobile;
                  $leaves->nature = $request->nature;
                  $leaves->deligated = $request->deligate;

                  // for annual leave
                  if ($request->nature == 1) {

                      $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id, $employeeDate, date('Y-m-d'));

                      // checking annual leave balance
                      if ($different_days < $annualleaveBalance) {
                          $leaves->days = $different_days;
                          $remaining = $annualleaveBalance - $different_days;

                      } else {
                          $msg = 'You Have Insufficient Annual  Accrued Days';
                          
                          return response(['msg' => $msg], 202);
                      }

                  }

                  if ($request->nature != 5 && $request->nature != 1) {

                      $leaves->days = $different_days;
                  }
                  // For Paternity leabe
                  if ($request->nature == 5) {

                      $paternity = Leaves::where('empID', $empID)->where('nature', 5)->where('sub_category', $request->sub_cat)->whereYear('created_at', date('Y'))->orderBy('created_at', 'desc')->first();
                      // Case an Employee has ever applied leave before
                      if ($paternity) {
                          $d1 = $paternity->created_at;
                          $d2 = new DateTime();
                          $interval = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);

                          $month = $interval;
                          // For Employee With Less Than 4 month of service and last application
                          if ($month < 112) {

                              $max_days = 7;
                              // Case Requested days are less than max-days
                              if ($total_leave_days <= $max_days) {
                                  if ($different_days < $max_days) {
                                      $leaves->days = $different_days;
                                  } else {
                                      $msg = "Sorry, You have Insufficient Leave Days Balance";
                                    
                                      if($return_parameter=="webUrl")
                                      { 
                                           return $url->with('msg', $msg);
                                      
                                      }
                                      else{
                                          return response([ 'msg'=>$msg ],202);
                                      };
                                  }

                              }
                              // case All Paternity days have been used up
                              else {

                                  $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance4";
                                  if($return_parameter=="webUrl"){
                                  return $url->with('msg', $msg);
                                  }else{
                                      return response([ 'msg'=>$msg ],202);
                                  }
                              }

                          }
                          // For Employee who as attained more than 4 working days
                          else {
                              $max_days = 10;
                              if ($total_leave_days <= $max_days) {
                                  if ($different_days < $max_days) {
                                      $leaves->days = $different_days;
                                  } else {
                                      $msg = "Sorry, You have Insufficient Leave Days Balance";
                                      if($return_parameter=="webUrl"){
                                      return $url->with('msg', $msg);
                                      }else{
                                          return response([ 'msg'=>$msg ],202);
                                      }
                                  }

                              }
                              // case All Paternity days have been used up
                              else {

                                  $excess = $total_leave_days - $max_days;
                                  // dd($excess);
                                  $msg = 'You requested for ' . $excess . ' extra days!';
                                  if($return_parameter=="webUrl"){
                                  return $url->with('msg', $msg);
                                  }else{
                                      return response([ 'msg'=>$msg ],202);
                                  }
                              }
                          }
                      }
                      // Case an employee is applying paternity for the first time
                      else {
                          // Checking if employee has less than 4 working months
                          if ($day < 112) {
                              $max_days = 7;
                              if ($total_leave_days < $max_days) {
                                  if ($different_days <= $max_days) {
                                      $leaves->days = $different_days;
                                  } else {
                                      $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                      if($return_parameter=="webUrl")
                                      {
                                            return $url->with('msg', $msg);}
                                            else{
                                          return response([ 'msg'=>$msg ],202);
                                      }
                                  }

                              } else {

                                  $leave_type = LeaveType::where('id', $nature)->first();
                                  $type_name = $leave_type->type;
                                  $msg = "Sorry, You have Insufficient  " . $type_name . " Leave Days Balance";
                                  if($return_parameter=="webUrl"){

          
                                  return $url->with('msg', $msg);}
                                  else{
                                      return response([ 'msg'=>$msg ],202);
                                  }

                              }

                          }
                          // For Employee with more than 4 working months
                          else {
                              $max_days = 10;

                              if ($different_days < $max_days) {
                                  $leaves->days = $different_days;
                              } else {

                                  $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                  if($return_parameter=="webUrl"){
                                  return $url->with('msg', $msg);}else{
                                      return response([ 'msg'=>$msg ],202);
                                  }
                              }

                          }
                      }

                  }

                  $leaves->reason = $request->reason;
                  $leaves->remaining = $remaining;
                  $leaves->sub_category = $request->sub_cat;
                  $leaves->application_date = date('Y-m-d');
                  if ($request->hasfile('image')) {
                      $request->validate([
                          // 'image' => 'required|clamav',
                      ]);
                      $request->validate([
                          'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                      ]);
                      $newImageName = $request->image->hashName();
                      $request->image->move(public_path('storage/leaves'), $newImageName);
                      $leaves->attachment = $newImageName;

                  }

                  $leaves->save();
                  $leave_type = LeaveType::where('id', $nature)->first();
                  $type_name = $leave_type->type;

                  //fetch Line manager data from employee table and send email
                  $linemanager = LeaveApproval::where('empID', $empID)->first();
                  $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                  $employee_data = SysHelpers::employeeData($empID);
                  $fullname = $linemanager_data['full_name'];
                  $email_data = array(
                      'subject' => 'Employee Leave Approval',
                      'view' => 'emails.linemanager.leave-approval',
                      'email' => $linemanager_data['email'],
                      'full_name' => $fullname,
                      'employee_name' => $employee_data['full_name'],
                      'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                  );
                  try {

                      Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                  } catch (Exception $exception) {
                      $msg = $type_name . " Leave Request is submitted successfully but email not sent(SMTP Problem)!";
                      if($return_parameter=="webUrl"){
                      return $url->with('msg', $msg);}else{
                          return response([ 'msg'=>$msg ],202);
                      }
                  }
                  $msg = $type_name . " Leave Request is submitted successfully!";
                  if($return_parameter=="webUrl"){
                  return $url->with('msg', $msg);}else{
                      return response([ 'msg'=>$msg ],202);
                  }
              } else {

                  $leave_type = LeaveType::where('id', $nature)->first();
                  $type_name = $leave_type->type;
                  $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance";
               
               if($return_parameter=="webUrl"){

                 return $url->with('msg', $msg);}
                 else{
                  return response([ 'msg'=>$msg ],202);
                 }

              }

          }
      } else {
          $msg = "Error!! start date should be less than end date!";
           if($return_parameter=="webUrl") {
              return redirect()->back()->with('msg', $msg);}else{
              return response([ 'msg'=>$message ],202);
          }
      }

  }
  public function revokeApprovedLeave(Request $request)
  {
      $id = $request->input('terminationid');
      $message = $request->input('comment');
      $expectedDate = $request->input('expectedDate');

      $particularLeave = Leaves::where('id', $id)->first();
      $linemanager = LeaveApproval::where('empID', $particularLeave->empID)->first();
      $linemanager_position = EMPL::where('emp_id',$linemanager->level1)->value('position');
      $position = Position::where('id', $linemanager_position)->first();
      $positionName = $position->name;

       if( $particularLeave->state == '0'){
      if ($particularLeave) {
          $particularLeave->state = 2;
          $particularLeave->revoke_reason = $message;
          $particularLeave->enddate_revoke = $expectedDate;
          $particularLeave->revoke_status = 0;
          $particularLeave->status = 4;
          $particularLeave->revok_escalation_status = 1;
          $particularLeave->position = 'Pending Approve Revoke by '. $positionName;
          $particularLeave->revoke_created_at = now();
          $particularLeave->save();
      }
      

      $leave_type = LeaveType::where('id', $particularLeave->nature)->first();
      $type_name = $leave_type->type;

      //fetch Line manager data from employee table and send email
      $linemanager_data = EMPL::where('emp_id',$linemanager->level1)->first();
      $employee_data =  EMPL::where('emp_id',$particularLeave->empID)->first();
      $fullname = $linemanager_data['fname'];
      $email_data = array(
          'subject' => 'Employee Leave Revoke',
          'view' => 'emails.linemanager.leave-revoke',
          'email' => $linemanager_data['email'],
          'full_name' => $fullname,
          'employee_name' => $employee_data['fname'],
          'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
      );

      try {

          Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

      } catch (TransportException $exception) {
          $msg =" Leave Revoke Request  Has been Requested But Email is not sent(SMTP Problem)!";
        return response(['msg'=>$msg],202);

      }
      $msg =" Leave Revoke Request  Has been Requested Successfully!";
      return response(['msg'=>$msg],200);
    }else{
      $msg ="leave can not be revoked";
      return response(['msg'=>$msg],202);
    }

  }
  public function revokeApprovedLeaveAdmin(Request $request)
  {
      $id=$request->id;
      $particularLeave = Leaves::where('id', $id)->first();

         if(   $particularLeave->state == '2' ){
     if ($particularLeave) {
          $particularLeave->state = 3;
          $particularLeave->revoke_status = 1;
          $particularLeave->status = 5;
          if ($particularLeave->enddate_revoke) {
                $days = SysHelpers::countWorkingDays($particularLeave->start, $particularLeave->enddate_revoke);

                $particularLeave->remaining = $particularLeave->remaining + $days;

              $particularLeave->end = $particularLeave->enddate_revoke;
          }
          $position = Position::where('id', EMPL::where('emp_id', Auth()->user()->emp_id)->value('position'))->value('name');
          $particularLeave->position = 'Leave Revoke Approved by ' . $position;
          $particularLeave->level3 = Auth()->user()->emp_id;
          $particularLeave->revoke_created_at = now();
          $particularLeave->save();

          $emp_data = SysHelpers::employeeData($particularLeave->empID);

          $email_data = array(
              'subject' => 'Employee Leave Revoke Approval',
              'view' => 'emails.linemanager.approved_revoke_leave',
              'email' => $emp_data->email,
              'full_name' => $emp_data->fname, ' ' . $emp_data->mname . ' ' . $emp_data->lname,
          );

          try {

              Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));
             $msg= 'Revoke Leave Request Has been Approved Successfully';
              PushNotificationController::bulksend("Leave Revoke",
                  "Your Revoke Leave request is successful granted",
                  "", $particularLeave->empID);
                  return response( [ 'msg'=>$msg ],200 );
          } catch (TransportException $exception) {
              $msg = " Revoke Leave Request Has been Approved Successfully But Email is not sent(SMPT problem) !";
              // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
              return response( [ 'msg'=>$msg ],202 );
          }
      }
    }
    else if( $particularLeave->state == '3'){
      return response( [ 'msg'=>"Leave revoke is already approved" ],202 );
    }

      return response( [ 'msg'=>"Not found" ],202 );
   
   
   
    }
  public function revokeCancelLeaveAdmin(Request $request)
    {
      $id=$request->id;
      $particularLeave = Leaves::where('id', $id)->first();

          if($particularLeave->state != '3'){
        if ($particularLeave) {
            $particularLeave->state = 0;
            $particularLeave->revoke_status = 3;
            $particularLeave->status = 3;
            $position = Position::where('id', EMPL::where('emp_id', Auth()->user()->emp_id)->value('position'))->value('name');
             
            $particularLeave->position = 'Leave Revoke Requesy Cancelled by ' . $position;
             if($particularLeave ->empID == Auth()->user()->emp_id ){
              $particularLeave->position = 'Leave Revoke Request Cancelled by you ';
             }else{
              $particularLeave->position = 'Leave Revoke Requesy Cancelled by ' . $position;
             }
            $particularLeave->level3 = Auth()->user()->emp_id;
            $particularLeave->revoke_created_at = now();
            $particularLeave->save();

            $emp_data = SysHelpers::employeeData($particularLeave->empID);

            $email_data = array(
                'subject' => 'Employee Leave Revoke Canceled',
                'view' => 'emails.linemanager.approved_revoke_leave',
                'email' => $emp_data->email,
                'full_name' => $emp_data->fname, ' ' . $emp_data->mname . ' ' . $emp_data->lname,
            );

            try {
                  
                Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));

                PushNotificationController::bulksend("Leave Revoke",
                    "Your Revoke Leave request is not granted",
                    "", $particularLeave->empID);

                    $msg= 'Revoke Leave Reques has been denied Successfully';
                    return response( [ 'msg'=>$msg ],200 );


            } catch (TransportException $exception) {
                $msg = " Revoke Leave Request Has been denied Successfully But Email is not sent(SMPT problem) !";
                // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
                return response( [ 'msg'=>$msg ],202 );
            }
        }
      }
      else if($particularLeave->state == '3'){
        return response( [ 'msg'=>"you Cannot deny approved revoke" ],202 );
      }

        return response( [ 'msg'=>"Not found" ],202 );
    }

  public function myRevokes(Request $request)
  {
   
      $data['leaves'] = Leaves::whereNot('reason', 'Automatic applied!')->orderBy('id', 'desc')->get();
      $line_manager = auth()->user()->emp_id;
      if ($data['leaves']->isNotEmpty()) {
          foreach ($data['leaves'] as $key => $leave) {
              $uniqueLeaveID = $leave['id'];

              // Fetch 'appliedBy' value from 'sick_leave_forfeit_days' based on the unique 'leaveID'
              $appliedByValue = DB::table('sick_leave_forfeit_days')
                  ->where('leaveID', $uniqueLeaveID)
                  ->value('appliedBy');

              // Fetch 'forfeit_days' value from 'sick_leave_forfeit_days' based on the unique 'leaveID'
              $forfeitDaysValue = DB::table('sick_leave_forfeit_days')
                  ->where('leaveID', $uniqueLeaveID)
                  ->value('forfeit_days');

              if ($appliedByValue !== null) {
                  // Fetch 'full_name' from 'EMPL' model based on 'emp_id'
                  $full_name = EMPL::where('emp_id', $appliedByValue)->value('full_name');

                  // Add the 'appliedBy' attribute to the leave item
                  $data['leaves'][$key]['appliedBy'] = $full_name;

                  // Add the 'forfeit_days' attribute to the leave item
                  $data['leaves'][$key]['forfeit_days'] = $forfeitDaysValue;
              }
          }
      }

      $filteredLeaves = [];
      
      foreach ($data['leaves'] as $leave) {
          $level1 = LeaveApproval::where('empID', $leave->empID)
              ->where('level1', $line_manager)
              ->first();
         
          $level2 = LeaveApproval::where('empID', $leave->empID)
              ->where('level2', $line_manager)
              ->first();
      
          $level3 = LeaveApproval::where('empID', $leave->empID)
              ->where('level3', $line_manager)
              ->first();
      
          $approval = LeaveApproval::where('empID', $leave->empID)->first();
      
          if (
              auth()->user()->emp_id == $approval->level1 ||
              (auth()->user()->emp_id == $approval->level2 && $leave->status == 2) ||
              (auth()->user()->emp_id == $approval->level3 && $leave->status == 3) ||
              (auth()->user()->emp_id == $leave->deligated && $leave->status == 3)
          ) {
              $filteredLeaves[] = $leave;
          }
      }
      
     
      
     


      $numberOfLeaves = count($filteredLeaves);
      $data['leaves']=$filteredLeaves;
      return response( [ 'data'=>$data ],200);

  }



}
