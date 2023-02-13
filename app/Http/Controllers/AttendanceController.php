<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;

use DateTime;
use Carbon\Carbon;
use App\Models\EMPL;
use App\Models\Leaves;
use App\Models\LeaveType;
use App\Helpers\SysHelpers;
use App\Models\LeaveSubType;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use App\Http\Middleware\Leave;
use App\Models\AttendanceModel;
use App\Models\Payroll\Payroll;
use App\Models\PerformanceModel;
use App\CustomModels\PayrollModel;
use App\CustomModels\ReportsModel;
use App\Models\Payroll\ReportModel;
use App\Models\Payroll\ImprestModel;
use Illuminate\Support\Facades\Auth;
use App\CustomModels\flexFerformanceModel;
use App\Models\Payroll\FlexPerformanceModel;

class AttendanceController extends Controller
{


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

  public function leave() {
      $data['myleave'] =Leaves::where('empID',Auth::user()->emp_id)->get();

      if(session('appr_leave')){
        $data['otherleave'] = $this->attendance_model->leave_line(session('emp_id'));
      }else{
        $data['otherleave'] = $this->attendance_model->other_leaves(session('emp_id'));
      }
      $data['leave_types'] =LeaveType::all();
      $data['employees'] =EMPL::all();

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

  //  for fetching sub categories of leave
      // fetching employee department's positions
      public function getDetails($id = 0)
      {
          $data = LeaveSubType::where('category_id', $id)->get();
          // dd($data);
          return response()->json($data);
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
//sick leave
elseif($nature == 5)
{
 $leave_balance =   $this->attendance_model->get_sick_leave_balance($empID,$nature,$year);

}
elseif($nature == 6)
{
 $leave_balance =   $this->attendance_model->get_sick_leave_balance($empID,$nature,$year);

}
elseif($nature == 7)
{
//  $leave_balance =   $this->attendance_model-> ($empID,$nature,$year,$today);

}



    return json_encode($year);
   }


// start of save leave Function

      public function savelLeave(Request $request) {
     
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
       
        // For  Requested days
        $start = $request->start;
        $end = $request->end;

        $date1=date('d-m-Y', strtotime($start));
        $date2=date('d-m-Y', strtotime($end));
        $start_date = Carbon::createFromFormat('d-m-Y', $date1);
        $end_date = Carbon::createFromFormat('d-m-Y', $date2);
        $different_days = $start_date->diffInDays($end_date);


       
        // For Total Leave days
         $total_remaining=$leaves+$different_days;

        // For Working days
        $d1 = new DateTime (Auth::user()->hire_date);
        $d2 = new DateTime();
        $interval = $d2->diff($d1);
        $day=$interval->days;
        // $working_month=$interval->format('%months');

// dd($interval);
        // For Redirection Url
        $url = redirect('flex/attendance/leave');

        if($day <= 365)
        {

            //  For Checking sub Category
            if($request->sub_cat > 0){

              // For Sub Cart
              $sub_cat=$request->sub_cat;
              $sub=LeaveSubType::where('id',$sub_cat)->first();

              $total_leave_days=$leaves+$different_days;
              $maximum=$sub->max_days;
              // Case hasnt used all days
              if ($total_leave_days < $maximum) {
                $leaves=new Leaves();
                $empID=Auth::user()->emp_id;
                $leaves->empID = $empID;
                $leaves->start = $request->start;
                $leaves->end=$request->end;
                $leaves->leave_address=$request->address;
                $leaves->mobile = $request->mobile;
                dd($different_days);
                $leaves->days = $different_days;
                if($request->nature!=5)
                {
                  $leaves->nature = $request->nature;
                }
                else
                {
                    dd("Iam 5 !");
                }
                $leaves->reason = $request->reason;
                $leaves->sub_category = $request->sub_cat;
                $leaves->remaining = $request->sub_cat;
                $leaves->application_date = date('Y-m-d');
              // START
              if ($request->hasfile('image')) {

              $newImageName = $request->image->hashName();
              $request->image->move(public_path('storage/leaves'), $newImageName);
              // $employee->photo = $newImageName;
              $leaves->attachment =  $newImageName;
              }
             
          
                $leaves->save();

                $msg="Leave Request  Has been Requested Successfully!";
                return $url->with('msg', $msg);

              }
              //  Case has used up all days
              else
              {

                $msg="You have finished Your Leave Days";

                return $url->with('msg', $msg);
              }
      


            }

            else
            {
              // $days=$different_days;

              $total_leave_days=$leaves+$different_days;

              if($total_leave_days<$max_leave_days)
              {
                $remaining=$max_leave_days-($leave_balance+$different_days);

                // dd($leave_balance);
                $leaves=new Leaves();
                $empID=Auth::user()->emp_id;
                $leaves->empID = $empID;
                $leaves->start = $request->start;
                $leaves->end=$request->end;
                $leaves->leave_address=$request->address;
                $leaves->mobile = $request->mobile;
                $leaves->nature = $request->nature;
                if($request->nature != 5)
                {
                 
                  $leaves->days = $different_days;
                }
                else
                {

                  
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
                          if($different_days<$max_days)
                          {
                            dd('wait');
                            $leaves->days = $different_days;
                          }
                          else
                          {
                            dd('Maximum 7 days');
                          }
                         
                        }
                        else
                        {
                          dd('All leave days are used up!');
                      
                        
                        }

                    }
                      else
                      {
                        
                        $leaves->days = $different_days;
                        dd('less than 4 months');
                      }
                    }
                    else
                    {
                      $leaves->days = $different_days;
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
                  // $employee->photo = $newImageName;
                  $leaves->attachment =  $newImageName;
                }
                 
          
                $leaves->save();
                           
              $msg="Request is submitted successfully!";
              return $url->with('msg', $msg);
              }
              else
              {
              $msg="Sorry, You have finished your leave days!";
              return $url->with('msg', $msg);

              }

            }

        }
        else 
        {

          
          $total_leave_days=$leaves+$different_days;

          if($total_leave_days<$max_leave_days)
          {
            $remaining=$max_leave_days-($leave_balance+$different_days);

            // dd($leave_balance);
            $leaves=new Leaves();
            $empID=Auth::user()->emp_id;
            $leaves->empID = $empID;
            $leaves->start = $request->start;
            $leaves->end=$request->end;
            $leaves->leave_address=$request->address;
            $leaves->mobile = $request->mobile;
            $leaves->nature = $request->nature;
            if($request->nature != 5)
            {
             
              $leaves->days = $different_days;
            }
            else
            {

                $paternity=Leaves::where('empID',$empID)->where('nature',5)->where('sub_category',$request->sub_cat)->whereYear('created_at',date('Y'))->orderBy('created_at','desc')->first();
                // dd($paternity);
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
                            dd('Maximum 7 days');
                          }
                         
                        }
                        // case All Paternity days have been used up
                        else
                        {

                          $excess=$total_leave_days-$max_days;
                          // dd($excess);
                          dd('You requested for '.$excess.' extra days!');
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
                        dd('You requested for '.$excess.' extra days!');
                      }
                    }
                  }
                  else
                  {
                    // $max_days=10;
                    $leaves->days = $different_days;
                    dd('wait');
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
              // $employee->photo = $newImageName;
              $leaves->attachment =  $newImageName;
            }
             
      
            $leaves->save();
                       
          $msg="Request is submitted successfully!";
          return $url->with('msg', $msg);
          }
          else
          {
          $msg="Sorry, You have finished your leave days!";
          return $url->with('msg', $msg);

          }
 
          
        }
 

      // for Annual Leave
       if($nature == 1){
          $type="Annual";
          }
      // For Sick Leave
        elseif($nature == 2)
        {
          $type="Sick";
          // $leave_balance =   $this->attendance_model->get_sick_leave_balance($empID,$nature,$year);

        }
      // For Compassionate
        elseif($nature == 3)
        {
          $type="Compassionate";
        
        }
        // For Maternity
        elseif($nature == 4)
        {
          $type="Maternity";
        }
        // For Paternity
        elseif($nature == 5)
        {
          $type="Paternity";
          // $leave_balance =   $this->attendance_model->get_pertenity_leave_balance($empID,$nature,$year,$today);
        
        }
        // For Study
        elseif($nature == 6)
        {
          $type="Study";
        // $leave_balance =   $this->attendance_model->get_sick_leave_balance($empID,$nature,$year);
        
        }



      }


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

                dd($data);
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

        // $result = $this->attendance_model->deleteLeave($leaveID);
        // if($result ==true){
        //   echo "<p class='alert alert-warning text-center'>Leave Cancelled Successifully</p>";
        // } else {
        //   echo "<p class='alert alert-danger text-center'>Leave Not Deleted, Please Try Again</p>";
        // }

        $msg="Leave Was Deleted Successfully !";
    
        return redirect('flex/attendance/leave')->with('msg', $msg);
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

    public function holdLeave()
      {

          if($this->uri->segment(3)!=''){

        $leaveID = $this->uri->segment(3);
        $data = array(
                 'status' =>3,
                 'notification' => 1
            );
          $this->attendance_model->update_leave($data, $leaveID);
          echo "<p class='alert alert-warning text-center'>Leave Held Successifully</p>";
          }
   }

    public function approveLeave($id)
      {

          if($id!=''){

        $leaveID = $id;
        $todate = date('Y-m-d');
        $data = array(
                 'status' =>2,
                 'notification' => 1
            );

          $result = $this->attendance_model->approve_leave($leaveID, session('emp_id'), $todate);
          if($result==true){
              echo "<p class='alert alert-success text-center'>Leave Approved Successifully</p>";
          } else {
              echo "<p class='alert alert-warning text-center'>Leave NOT Approved, Please Try Again</p>";
          }

          }
   }

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
      $data['my_leave'] =  $this->attendance_model->my_leavereport($empID);

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







}?>
