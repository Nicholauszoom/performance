<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;

use DateTime;
use Carbon\Carbon;
use App\Models\EMPL;
use App\Models\Leaves;
use App\Models\Position;
use App\Models\LeaveType;
use App\Helpers\SysHelpers;
use App\Models\LeaveSubType;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use App\Models\LeaveApproval;
use App\Http\Middleware\Leave;
use App\Models\AttendanceModel;
use App\Models\Payroll\Payroll;
use App\Models\PerformanceModel;
use App\CustomModels\PayrollModel;
use Illuminate\Support\Facades\Notification;
use App\Models\EmailNotification;
use App\Notifications\EmailRequests;


use App\CustomModels\ReportsModel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Payroll\ReportModel;
use App\Models\Payroll\ImprestModel;
use Illuminate\Support\Facades\Auth;
use App\CustomModels\flexFerformanceModel;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Level1;
use App\Models\level2;
use App\Models\Level3;

class AttendanceController extends Controller
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
      $this->flexperformance_model = new FlexPerformanceModel();
      $this->imprest_model = new ImprestModel();
      $this->reports_model = new ReportModel();
      $this->attendance_model = new AttendanceModel();
      $this->project_model = new ProjectModel();
      $this->performanceModel = new PerformanceModel();
      $this->payroll_model = new Payroll;

    }

  public function attendance()
    {

      if(session('emp_id')!='' && $this->input->post('state')=='due_in'){
      $data = array(
             'empID' => session('emp_id'),
             'due_in' => date('Y-m-d h:i:s'),
             'due_out' => date('Y-m-d h:i:s'),
             'state' => 1
        );
      $this->attendance_model->attendance($data);

      echo '<form method ="post"  id = "attendance" >  <button class="btn btn-round btn-default">  <span id = "resultAttendance"></span>Attended <span class="badge bg-green"><i class="fa fa-check-square-o"></i></span> </span></button></form>';

      }

      if(session('emp_id')!='' && $this->input->post('state')=='due_out'){
      $this->attendance_model->attend_out( session('emp_id'), date('Y-m-d'), date('Y-m-d h:i:s'));
      echo '<span><button class="btn btn-round btn-default">Attended Out <span class="badge bg-grey"><i class="fa fa-check"></i></span></button></span>';

      }
   }

  public function attendees()
      {
    //   $id = session('emp_id');
          if( session('mng_paym') || session('recom_paym') || session('appr_paym')){
              $date = date('Y-m-d');
              $data['attendee'] =  $this->attendance_model->attendees($date);
              $data['title']="Attendances";
              return view('app.attendees', $data);
          }else{
              echo 'Unauthorized Access';
          }


      }

   function attendeesFetcher(){

        $date = $this->input->post('due_date');
        $day = str_replace('/', '-', $date);
        $customday = date('Y-m-d', strtotime($day));

        $attendees = $this->attendance_model->attendees($customday);

        // echo $customday;

    if($attendees) {
        // INIT

    echo '<table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th><b>S/N</b></th>
                  <th><b>Name</b></th>
                  <th><b>Department</b></th>
                  <th><b>Sign IN</b></th>
                  <th><b>Sign OUT</b></th>
                </tr>
              </thead>
              <tbody>';
        // INIT

     foreach ($attendees as $row){

    echo  '<tr>
            <td width="1px">'.$row->SNo.'</td>
            <td>'. $row->name.'</td>
            <td> <b>Department: </b>'.$row->DEPARTMENT.'<br><b>Position: </b>'.$row->POSITION.'</td>
            <td>'. $row->time_in.'</td>
            <td>'.$row->time_out.'</td>
          </tr>';
        }
        echo '</tbody>
                    </table>';
      }
      else{
        echo 'No Attendees In This Date';
    }

   }

  public function leave()
   {
      $data['myleave'] =Leaves::where('empID',Auth::user()->emp_id)->get();

      if(session('appr_leave')){
        $data['otherleave'] = $this->attendance_model->leave_line(session('emp_id'));
      }else{
        $data['otherleave'] = $this->attendance_model->other_leaves(session('emp_id'));
      }
      $data['leave_types'] =LeaveType::all();
      // $data['employees'] =EMPL::where('line_manager',Auth::user()->emp_id)->get();
      $data['leaves'] =Leaves::whereNot('state',0)->orderBy('id','DESC')->get();

      $data['approved_leaves'] =Leaves::where('state',0)->orderBy('id','DESC')->get();




    //   $data['leaves'] =  $this->attendance_model->all_leave_line();
      $data['leaveBalance'] = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id, Auth::user()->hire_date, date('Y-m-d'));

      // Start of Escallation
      // $leaves=Leaves::get();
      // if ($leaves) {

      //   foreach($leaves as $item)
      //   {
      //       $today= new DateTime();
      //       $applied =$item->updated_at;
      //       $diff= $today->diff($applied);
      //       $range=$diff->days;
      //       $approval=LeaveApproval::where('empID',$item->empID)->first();
      //       if ($approval) {
      //         if ($range>$approval->escallation_time) {
      //           $leave=Leaves::where('id' ,$item->id)->first();
      //           $status=$leave->status;

      //           if ($status == 0) {
      //             if ($approval->level2 != null) {
      //               $leave->status=1;
      //               $leave->updated_at=$today;
      //               $leave->update();

      //             }

      //           }
      //           elseif ($status == 1)
      //           {
      //             if ($approval->level3 != null) {
      //               $leave->status=2;
      //               $leave->updated_at=$today;
      //               $leave->update();
      //             }
      //             else
      //             {
      //               $leave->status=0;
      //               $leave->updated_at=$today;
      //               $leave->update();
      //             }
      //           }
      //           elseif ($status == 2)
      //           {
      //             if ($approval->level1 != null) {
      //               $leave->status=0;
      //               $leave->updated_at=$today;
      //               $leave->update();
      //             }
      //           }
      //         }
      //       }
      //   }
      // }
      // End of Escallation


      // Start of Auto apply leave

      $employ=EMPL::whereNot('state',4)->get();

      foreach($employ as $item)
      {
            $balance= $this->attendance_model->getLeaveBalance($item->emp_id, $item->hire_date, date('Y-m-d'));
            $total_leave=Leaves::where('empID',$item->emp_id)->where('nature',1)->sum('days');

            $remaining=$balance-$total_leave-6.99;
            // $date="03-01";
            // if($date==Date('m-d'))
            // {
            //   if ($balance>6.99) {

            //     // For Saving Leave
            //     $leaves=new Leaves();
            //     $empID=$item->emp_id;
            //     $leaves->empID = $empID;
            //     $leaves->start =Date('Y-m-d') ;
            //     $leaves->end=Date('Y-m-d') ;
            //     $leaves->leave_address="auto";
            //     $leaves->mobile = $item->phone;
            //     $leaves->nature = 1;
            //     $leaves->remaining=6.99;
            //     $leaves->days=$remaining;
            //     $leaves->reason="Did not go for Annual leave !";
            //     $leaves->position="Unused Annual";
            //     $leaves->status=3;
            //     $leaves->state=0;
            //     $leaves->save();


            //   }


            // }

      }


      // End of auto apply leave

      // For Working days
      $d1 = new DateTime (Auth::user()->hire_date);
      $d2 = new DateTime();
      $interval = $d2->diff($d1);
      $data['days']=$interval->days;
      $data['title'] = 'Leave';

      $data['leave_type'] = $this->attendance_model->leave_type();
      return view('app.leave', $data);

   }


     // For My Leaves
     public function myLeaves()
     {
           $data['myleave'] =Leaves::where('empID',Auth::user()->emp_id)->orderBy('id','desc')->get();
            $id = Auth::user()->emp_id;

            $level1 = DB::table('leave_approvals')->Where('level1',$id)->count();
            $level2 = DB::table('leave_approvals')->Where('level2',$id)->count();
            $level3 = DB::table('leave_approvals')->Where('level3',$id)->count();

            $data['deligate']= $level1 + $level2 + $level3;
            $data['leave_types'] =LeaveType::all();
            $data['employees'] =EMPL::where('emp_id','!=',Auth::user()->emp_id)->whereNot('state',4)->get();
            $data['leaves'] =Leaves::get();


            // Start of Escallation
            // $leaves=Leaves::get();
            // if ($leaves) {

            //   foreach($leaves as $item)
            //   {
            //       $today= new DateTime();
            //       $applied =$item->updated_at;
            //       $diff= $today->diff($applied);
            //       $range=$diff->days;
            //       $approval=LeaveApproval::where('empID',$item->empID)->first();

            //       if ($approval) {
            //         if ($range>$approval->escallation_time) {
            //           $leave=Leaves::where('id' ,$item->id)->first();
            //           $status=$leave->status;

            //           if ($status == 0) {
            //             if ($approval->level2 != null) {
            //               $leave->status=1;
            //               $leave->updated_at=$today;
            //               $leave->update();

            //             }

            //           }
            //           elseif ($status == 1)
            //           {
            //             if ($approval->level3 != null) {
            //               $leave->status=2;
            //               $leave->updated_at=$today;
            //               $leave->update();
            //             }
            //             else
            //             {
            //               $leave->status=0;
            //               $leave->updated_at=$today;
            //               $leave->update();
            //             }
            //           }
            //           elseif ($status == 2)
            //           {
            //             if ($approval->level1 != null) {
            //               $leave->status=0;
            //               $leave->updated_at=$today;
            //               $leave->update();
            //             }
            //           }
            //         }
            //       }

            //   }
            // }
            // End of Escallation

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
         return view('my-services/leaves', $data);
     }

   //  for fetching sub categories of leave
      public function getDetails($uid = 0)
      {

        $par=$uid;


        $raw=explode('|',$par);
        $id=$raw[0];
        $start=$raw[1];
        $end=$raw[2];

        if ($start==null || $end==null ) {
          $total_days=0;
        }
        else
        {
          $days= SysHelpers::countWorkingDays($start,$end);
          $holidays=SysHelpers::countHolidays($start,$end);
          $total_days=$days-$holidays;
        }



                //For Gender
        $gender=Auth::user()->gender;
        if($gender=="Male"){$gender=1; }else { $gender=2;  }
        // For Male Employees
        if ($gender==1) {
          $data['data'] = LeaveSubType::where('category_id', $id)->Where('sex',0)->get();
          // return response()->json($data);
          return json_encode($data);
        }
        // For Female Employees
        else
        {
          $data = LeaveSubType::where('category_id', $id)->get();
          // return json_encode($data);
              return response()->json(['data'=>$data,'days'=>$total_days]);
        }


      }


  public  function check_leave_balance(Request $request){
    $today = date('Y-m-d');
    $arryear = explode('-',$today);
    $year = $arryear[0];
   $nature  = $request->nature;
   $empID  = $request->empID;

   if($nature == 1){

   }elseif($nature == 2)
          {

          }
          elseif($nature == 3)
          {

          }
          elseif($nature == 4)
          {

          }
          elseif($nature == 5)
          {
          $leave_balance =   $this->attendance_model->get_sick_leave_balance($empID,$nature,$year);

          }
          elseif($nature == 6)
          {
          $leave_balance =   $this->attendance_model->get_sick_leave_balance($empID,$nature,$year);

}
// elseif($nature == 7)
// {
//  $leave_balance =   $this->attendance_model-> ($empID,$nature,$year,$today);

// }



    return json_encode($year);
   }


// start of save leave Function


public function saveLeave(Request $request) {
        $start = $request->start;
        $end = $request->end;

     if($start <= $end){

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
        $leaves=Leaves::where('empID',$empID)->where('nature',$nature)->where('sub_category',$request->sub_cat)->whereNot('reason','Automatic applied!')->whereYear('created_at',date('Y'))->sum('days');

        $leave_balance=$leaves;
        // For Leave Nature days
        $type=LeaveType::where('id',$nature)->first();
        $max_leave_days= $type->max_days;

        //$max_leave_days = 10000;

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
        $url = redirect('flex/attendance/my-leaves');

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
                    $request->image->move(public_path('storage\leaves'), $newImageName);
                    $leaves->attachment =  $newImageName;

                    }
                  $leaves->save();
                  $leave_type=LeaveType::where('id',$nature)->first();
                  $type_name=$leave_type->type;

               //fetch Line manager data from employee table and send email
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
               );
               Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                  $msg=$type_name." Leave Request  Has been Requested Successfully!";
                  return $url->with('msg', $msg);

              }
              //  Case has used up all days or has less remaining leave days balance
              else
              {

                $leave_type=LeaveType::where('id',$nature)->first();
                $type_name=$leave_type->type;
                $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance1";

                return $url->with('msg', $msg);
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
                      return $url->with('msg',$msg);
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
                          return $url->with('msg', $msg);
                          }

                        }
                        else
                        {

                          $leave_type=LeaveType::where('id',$nature)->first();
                          $type_name=$leave_type->type;
                          $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance2";
                          return $url->with('msg', $msg);


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
                          return $url->with('msg', $msg);
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
                            return $url->with('msg', $msg);
                          }

                        }
                        else
                        {

                          $leave_type=LeaveType::where('id',$nature)->first();
                          $type_name=$leave_type->type;
                          $msg="Sorry, You have Insufficient  ".$type_name." Leave Days Balance";
                          return $url->with('msg', $msg);


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
                          return $url->with('msg', $msg);
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
                    $request->image->move(public_path('storage\leaves'), $newImageName);
                    $leaves->attachment =  $newImageName;

                  }


                $leaves->save();


               //fetch Line manager data from employee table and send email
               $linemanager =  LeaveApproval::where('empID',$empID)->first();
               $linemanager_data = SysHelpers::employeeData($linemanager->level1);
               $fullname = $linemanager_data['full_name'];
               $email_data = array(
                   'subject' => 'Employee Leave Approval',
                   'view' => 'emails.linemanager.leave-approval',
                   'email' => $linemanager_data['email'],
                   'full_name' => $fullname,
               );
               Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));



                $leave_type=LeaveType::where('id',$nature)->first();
                $type_name=$leave_type->type;
                $msg=$type_name." Leave Request is submitted successfully!";
                return $url->with('msg', $msg);
              }
              else
              {

                $leave_type=LeaveType::where('id',$nature)->first();
                $type_name=$leave_type->type;
                $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance3";
              return $url->with('msg', $msg);

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
                            return $url->with('msg', $msg);
                          }

                        }
                        // case All Paternity days have been used up
                        else
                        {

                          $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance4";
                          return $url->with('msg', $msg);
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
                          return $url->with('msg', $msg);
                        }

                      }
                      // case All Paternity days have been used up
                      else
                      {

                        $excess=$total_leave_days-$max_days;
                        // dd($excess);
                        $msg='You requested for '.$excess.' extra days!';

                        return $url->with('msg', $msg);
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
                        return $url->with('msg', $msg);
                      }

                    }
                    else
                    {

                      $leave_type=LeaveType::where('id',$nature)->first();
                      $type_name=$leave_type->type;
                      $msg="Sorry, You have Insufficient  ".$type_name." Leave Days Balance";
                      return $url->with('msg', $msg);


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
                      return $url->with('msg', $msg);
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


               //fetch Line manager data from employee table and send email
               $linemanager =  LeaveApproval::where('empID',$empID)->first();
               $linemanager_data = SysHelpers::employeeData($linemanager->level1);
               $fullname = $linemanager_data['full_name'];
               $email_data = array(
                   'subject' => 'Employee Leave Approval',
                   'view' => 'emails.linemanager.leave-approval',
                   'email' => $linemanager_data['email'],
                   'full_name' => $fullname,
               );
               Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

              $msg=$type_name." Leave Request is submitted successfully!";
              return $url->with('msg', $msg);
              }
              else
              {

                $leave_type=LeaveType::where('id',$nature)->first();
                $type_name=$leave_type->type;
                $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance5";
                return $url->with('msg', $msg);

              }


           }
          }else{
               $msg="Error!! start date should be less that end date!";
              return redirect()->back()->with('msg', $msg);
          }

      }


    // start of leave approval
    public function approveLeave($id)
      {
        $leave=Leaves::find($id);
        $empID=$leave->empID;
        $approval=LeaveApproval::where('empID',$empID)->first();
        $approver=Auth()->user()->emp_id;
        $employee=Auth()->user()->position;

        $position=Position::where('id',$employee)->first();


        // chacking level 1
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




            $leave->status=3;
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

            return redirect('flex/attendance/leave')->with('msg', $msg);
        }


        $emp_data = SysHelpers::employeeData($empID);
        $email_data = array(
            'subject' => 'Employee Overtime Approval',
            'view' => 'emails.linemanager.approved_leave',
            'email' => $emp_data->email,
            'full_name' => $emp_data->fname,' '.$emp_data->mname.' '.$emp_data->lname,
        );
        Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));





        $msg = "Leave Request Has been Approves Successfully !";
        // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
        return redirect('flex/attendance/leave')->with('msg', $msg);


      }

      public function revoke_authority(){
        $id=Auth::user()->emp_id;

        $del_level1 = Level1::all()->where('deligetor',$id);

        foreach($del_level1 as $row){
        $level1=DB::table('leave_approvals')->Where('empID',$row->line_employee)->update(['level1'=>$id]);

       // if($level1 > 0){
            Level1::where('line_employee',$row->line_employee)->delete();
       // }
        }

        $del_level2 = Level2::all()->where('deligetor',$id);

        foreach($del_level2 as $row){

        $level2=DB::table('leave_approvals')->Where('empID',$row->line_employee)->update(['level2'=>$id]);
       // if($level2 > 0){
            Level2::where('line_employee',$row->line_employee)->delete();
       // }
        }

        $del_level3 = Level3::all()->where('deligetor',$id);
        foreach($del_level3 as $row){
        $level3=DB::table('leave_approvals')->Where('empID',$row->line_employee)->update(['level3'=>$id]);
        //if($level3 > 0){
            Level3::where('line_employee',$row->line_employee)->delete();
        //}
        }

      return redirect()->back();

      }


    // For Cancel Leave

    // public function cancelLeave($id)
    // {

    // }

    public function apply_leave(Request $request) {
        // echo "<p class='alert alert-success text-center'>Record Added Successifully</p>";

        if ($request->method() == "POST") {

                // DATE MANIPULATION
            $start = $request->start;
            $end =$request->end;
            $datewells = explode("/",$start);
            $datewelle = explode("/",$end);
            $mms = $datewells[1];
            $dds = $datewells[0];
            $yyyys = $datewells[2];
            $dates = $yyyys."-".$mms."-".$dds;

            $mme = $datewelle[1];
            $dde = $datewelle[0];
            $yyyye = $datewelle[2];
            $datee = $yyyye."-".$mme."-".$dde;

            $limit=$request->limit;
            $date1=date_create($dates);
            $date2=date_create($datee);
            $date_today=date_create(date('Y-m-d'));

            $diff=date_diff($date1, $date2);
            $diff2=date_diff($date_today, $date1);

            // START
            if ($request->hasfile('image')) {

              $newImageName = $request->image->hashName();
              $request->image->move(public_path('storage/leaves'), $newImageName);
              // $employee->photo = $newImageName;
          }

            if ($request->start==$request->end) {
                echo "<p class='alert alert-warning text-center'>Invalid Start date or End date Selection</p>";
            } elseif ($request->nature==1 && ($diff->format("%R%a"))>($limit)) {
                echo "<p class='alert alert-warning text-center'>Days Requested Exceed the Allowed Days</p>";
            }  elseif ($diff2->format("%R%a")<0 || $diff->format("%R%a")<0) {
                echo "<p class='alert alert-danger text-center'>Invalid Start date or End date Selection, Choose The Correct One</p>";
            } else {

                $data = array(
                    'empID' =>session('emp_id'),
                    'start' =>$dates,
                    'end' =>$datee,
                    'leave_address' =>$request->address,
                    'mobile' =>$request->mobile,
                    'nature' =>$request->nature,
                    'reason' =>$request->reason,
                    'application_date' =>date('Y-m-d'),
                    'attachment'=>$newImageName
                );


                $result = $this->attendance_model->applyleave($data);
                if($result ==true){
                    echo "<p class='alert alert-success text-center'>Application Sent Added Successifully</p>";
                } else { echo "<p class='alert alert-danger text-center'>Application NOT Sent, Please Try Again</p>";}

            }
            // END

        }
   }

   ################## START LEAVE OPERATIONS ###########################
    public function cancelLeave($id)  {
          //dd($id);
      if($id!=''){
        $leaveID = $id;

        $leave=Leaves::where('id',$leaveID)->first();

        $leave->delete();


        $msg="Leave Was Deleted Successfully !";

        return redirect('flex/attendance/my-leaves')->with('msg', $msg);
      }
   }

    public function recommendLeave($id)
      {

          if($id!=''){

        $leaveID = $id;
        $data = array(

                 'approved_date_line' =>date('Y-m-d'),
                 'approved_by_line' =>session('emp_id'),
                 'status' =>1,
                 'notification' => 3
            );
          $this->attendance_model->update_leave($data, $leaveID);
          echo "<p class='alert alert-primary text-center'>Leave Recommended Successifully</p>";
          }
   }
   public function recommendLeaveByHod($id)
   {

       if($id!=''){

     $leaveID = $id;
     $data = array(

              'approved_date_hod' =>date('Y-m-d'),
              'approved_by_hod' =>session('emp_id'),
              'status' =>6,
              'notification' => 5
         );
       $this->attendance_model->update_leave($data, $leaveID);
       echo "<p class='alert alert-primary text-center'>Leave Recommended Successifully</p>";
       }
}

    public function holdLeave($leaveID)
      {

        $leave=Leaves::where('id',$leaveID)->first();


        $emp_data = SysHelpers::employeeData($leave->empID);
        $email_data = array(
            'subject' => 'Employee Overtime Approval',
            'view' => 'emails.linemanager.cancel_leave',
            'email' => $emp_data->email,
            'full_name' => $emp_data->fname,' '.$emp_data->mname.' '.$emp_data->lname,
        );
        Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));

        $leave->delete();

          echo "<p class='alert alert-warning text-center'>Leave Canceled Successifully</p>";

   }

  //   public function approveLeave1($id)
  //     {

  //         if($id!=''){

  //       $leaveID = $id;
  //       $todate = date('Y-m-d');
  //       $data = array(
  //                'status' =>2,
  //                'notification' => 1
  //           );

  //         $result = $this->attendance_model->approve_leave($leaveID, session('emp_id'), $todate);
  //         if($result==true){
  //             echo "<p class='alert alert-success text-center'>Leave Approved Successifully</p>";
  //         } else {
  //             echo "<p class='alert alert-warning text-center'>Leave NOT Approved, Please Try Again</p>";
  //         }

  //         }
  //  }

    public function rejectLeave()
      {

          if($this->uri->segment(3)!=''){

        $leaveID = $this->uri->segment(3);
        $data = array(
                 'status' =>5,
                 'notification' => 1
            );
          $this->attendance_model->update_leave($data, $leaveID);
          echo "<p class='alert alert-danger text-center'>Leave Disapproved!</p>";
          }
   }

   ######################## END LEAVE OPERATIONS##############################

   public function leavereport() {
      $empID = session('emp_id');
      // $data['my_leave'] =  $this->attendance_model->my_leavereport($empID);
      $data['leaves'] =Leaves::where('state',0)->latest()->get();


      if(session('conf_leave')!='' && session('line')!='' ){
        $data['other_leave'] =  $this->attendance_model->leavereport_hr();
      }elseif(session('line')!=''){
        $data['other_leave'] =  $this->attendance_model->leavereport_line($empID);
      }elseif(session('conf_leave')!=''){
        $data['other_leave'] =  $this->attendance_model->leavereport_hr();
      }
      $data['title']="Leaves";
      $data['today'] = date('Y-m-d');
      return view('app.leave_report', $data);

    }

  public function customleavereport()
      {
        if (isset($_POST['view'])) {

     // DATE MANIPULATION
        $start = $this->input->post("from");
        $end =$this->input->post("to");
        $datewells = explode("/",$start);
        $datewelle = explode("/",$end);
        $mms = $datewells[1];
        $dds = $datewells[0];
        $yyyys = $datewells[2];
        $dates = $yyyys."-".$mms."-".$dds;

        $mme = $datewelle[1];
        $dde = $datewelle[0];
        $yyyye = $datewelle[2];
        $datee = $yyyye."-".$mme."-".$dde;
        $today = date('Y-m-d');


        $target = $this->input->post("target");
        if($target == 1){
            $data['leave'] =  $this->attendance_model->leavereport1_all($dates, $datee);
        } elseif($target == 2){
            $data['leave'] =  $this->attendance_model->leavereport1_completed($dates, $datee, $today);
        } elseif($target == 3){
            $data['leave'] =  $this->attendance_model->leavereport1_progress($dates, $datee, $today);
        }

        $data['title']="Leave";
        $data['showbox'] = 1;
        return view('app.customleave_report', $data);
  }

  elseif (isset($_POST['print'])) {

     // DATE MANIPULATION
        $start = $this->input->post("from");
        $end =$this->input->post("to");
        $datewells = explode("/",$start);
        $datewelle = explode("/",$end);
        $mms = $datewells[1];
        $dds = $datewells[0];
        $yyyys = $datewells[2];
        $dates = $yyyys."-".$mms."-".$dds;

        $mme = $datewelle[1];
        $dde = $datewelle[0];
        $yyyye = $datewelle[2];
        $datee = $yyyye."-".$mme."-".$dde;
        $today = date('Y-m-d');
        $target = $this->input->post("target");

        $this->load->model("reports_model");
        $data['info']= $this->reports_model->company_info();

        if($target == 1){
            $data['leave'] =  $this->reports_model->leavereport_all($dates, $datee);
        } elseif($target == 2){
            $data['leave'] =  $this->reports_model->leavereport_completed($dates, $datee, $today);
        } elseif($target == 3){
            $data['leave'] =  $this->reports_model->leavereport_progress($dates, $datee, $today);
        }

        $data['title']="List of Employees Who went to Leave From ".$dates. " to ".$datee;
        return view('app.reports/general_leave', $data);
  }


  elseif(isset($_POST['printindividual'])){

      $id = $this->input->post("employee");

      $this->load->model("reports_model");
        $data['info']= $this->reports_model->company_info();
      $customleave =  $this->reports_model->customleave($id);
      foreach ($customleave as $key ) {
        $empname = $key->NAME;
      }
    $data['title']="List of Leaves for ".$empname;
      $data['leave'] =  $this->reports_model->leavereport2($id);
      return view('app.reports/general_leave', $data);

    }

  elseif(isset($_POST['viewindividual'])){

      $id = $this->input->post("employee");
      //



      $data['showbox'] = 0;
      if(session('viewconfmedleave')!=''){
      $data['customleave'] =  $this->attendance_model->customleave();
      } else {
      $data['customleave'] = $this->attendance_model->leavedropdown(session('emp_id'));}

      $data['leave'] =  $this->attendance_model->leavereport2($id);
      return view('app.customleave_report', $data);

    }

    $data['showbox'] = 0;
    $data['leave'] =  $this->attendance_model->leavereport2(session('emp_id'));
    $data['customleave'] =  $this->attendance_model->leave_employees();
    $data['title'] =  "Leave Reports";

    return view('app.customleave_report', $data);

    }



    public function leave_remarks($id)
      {



      $data['data'] =  $this->attendance_model->get_leave_application($id);
      $data['title']="Leave";
      return view('app.leave_remarks', $data);

      if (isset($_POST['edit_remarks'])) {

      $data = array(
            'remarks' =>$this->input->post("remarks")
            );

      $this->attendance_model->update_leave_application($data, $id);
      $reload = '/leave/leave';
                    redirect($reload, 'refresh');

    }
  }

  public function leave_application_info($id,$empID) {

    $hireDate = $this->flexperformance_model->employee_hire_date($empID);
    $data['data'] =  $this->attendance_model->get_leave_application($id);
    $data['leaveBalance'] = $this->attendance_model->getLeaveBalance($empID, $hireDate, date('Y-m-d'));

    $data['title']="Leave";
    $data['leave_type'] = $this->attendance_model->leave_type();
    return view('app.leave_application_info', $data);
   }



  public function updateLeaveReason() {
      if ($_POST && $this->input->post('leaveID')!='') {
        $leaveID = $this->input->post('leaveID');
        $updates = array(
              'reason' =>$this->input->post('reason'),
              'status' => 0,
              'notification' =>2
          );
        $result = $this->attendance_model->update_leave_application($updates, $leaveID);
        if($result==true) {
            echo "<p class='alert alert-success text-center'>Reason Updated Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
  }

  public function updateLeaveAddress() {
      if ($_POST && $this->input->post('leaveID')!='') {
        $leaveID = $this->input->post('leaveID');
        $updates = array(
              'leave_address' =>$this->input->post('address')
          );
        $result = $this->attendance_model->update_leave_application($updates, $leaveID);
        if($result==true) {
            echo "<p class='alert alert-success text-center'>Leave Address Updated Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
  }
  public function updateLeaveMobile() {
      if ($_POST && $this->input->post('leaveID')!='') {
        $leaveID = $this->input->post('leaveID');
        $updates = array(
              'mobile' =>$this->input->post('mobile')
          );
        $result = $this->attendance_model->update_leave_application($updates, $leaveID);
        if($result==true) {
            echo "<p class='alert alert-success text-center'>Mobile Updated Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
  }
  public function updateLeaveType() {
      if ($_POST && $this->input->post('leaveID')!='') {
        $leaveID = $this->input->post('leaveID');
        $updates = array(
              'nature' =>$this->input->post('type'),
              'status' => 0,
              'notification' =>2
          );
        $result = $this->attendance_model->update_leave_application($updates, $leaveID);
        if($result==true) {
            echo "<p class='alert alert-success text-center'>Leave Nature Updated Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
  }


  public function updateLeaveDateRange(){
    if ($_POST) {
      if($this->input->post('leaveID')!=''){
        $leaveID = $this->input->post('leaveID');
        $nature = $this->input->post("nature");
        $start =str_replace('/', '-', $this->input->post('start'));
        $end = str_replace('/', '-', $this->input->post('end'));

        $dateStart = date('Y-m-d', strtotime($start));
        $dateEnd = date('Y-m-d', strtotime($end));
        $date_today=date('Y-m-d');

        $limit=$this->input->post("limit");
        $date1=date_create($dateStart);
        $date2=date_create($dateEnd);

        $diff=date_diff($date1, $date2);

        if ($dateEnd < $dateStart) {
          echo "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
        }else{
          if($nature==1 && ($diff->format("%R%a"))>($limit)) {
            echo "<p class='alert alert-danger text-center'>You Have Exceeded The Maximum Days That You Can Apply For Annual Leave!</p>";
          }else{
            $updates = array(
              'start' =>$dateStart,
              'end' =>$dateEnd,
              'status' => 0,
              'notification' =>2
            );
            $result = $this->attendance_model->update_leave_application($updates, $leaveID);
            if($result == true){
                  echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
            } else { echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>"; }
          }
        }
      }else {
        echo "<p class='alert alert-danger text-center'>FAILED to Update, Reference Errors</p>";
      }
    }
  }

  public function current_leave_progress()  {
  $data['leaveBalance'] = $this->attendance_model->getLeaveBalance(session('emp_id'), session('hire_date'), date('Y-m-d'));
      $data['myleave'] = $this->attendance_model->myleave_current(session('emp_id'));
      $this->attendance_model-> update_leave_notification_staff(session('emp_id'));


      if(session('line')!='' && session('conf_leave')!='' ){

          $data['otherleave'] = $this->attendance_model->leave_line_hr_current(session('emp_id'));
          $this->attendance_model-> update_leave_notification_line_hr(session('emp_id'));
      } elseif (session('line')!=''){
          $data['otherleave'] = $this->attendance_model->leave_line_current(session('emp_id'));
          $this->attendance_model-> update_leave_notification_line(session('emp_id'));

      }
      elseif (session('conf_leave')!=''){
          $data['otherleave'] = $this->attendance_model->leave_hr_current();
          $this->attendance_model-> update_leave_notification_hr(session('emp_id'));

      }

      $data['title'] = 'Leave';
      $data['leave_type'] = $this->attendance_model->leave_type();
      return view('app.leave', $data);

   }


  function leave_notification(){

      if(session('line')!= 0 || session('confleave')!=0 ){
          if(session('confleave')!=0 && session('line')!= 0){
              $counts1 = $this->attendance_model->leave_notification_employee(session('emp_id'));
              $counts2 = $this->attendance_model->leave_notification_line_manager(session('emp_id'));
              $counts3 = $this->attendance_model->leave_notification_hr();
              $counts = $counts1+$counts2+$counts3;
               if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
          } elseif(session('line')!=0) {
              $counts1 = $this->attendance_model->leave_notification_line_manager(session('emp_id'));
              $counts2 = $this->attendance_model->leave_notification_employee(session('emp_id'));
              $counts = $counts1+$counts2;
              if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
          } elseif(session('confleave')!=0){

              $counts1 = $this->attendance_model->leave_notification_employee(session('emp_id'));
              $counts2 = $this->attendance_model->leave_notification_hr();
              $counts = $counts1+$counts2;
              if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
          }
        }else {
              $counts = $this->attendance_model->leave_notification_employee(session('emp_id'));
              if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
        }

   }







}
