<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Payroll\ReportModel;
use App\Models\Payroll\ImprestModel;
use App\Helpers\SysHelpers;
use App\Models\PerformanceModel;
use App\CustomModels\PayrollModel;
use App\CustomModels\flexFerformanceModel;
use App\CustomModels\ReportsModel;
use App\Models\AttendanceModel;
use App\Models\ProjectModel;

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
      $data['myleave'] = $this->attendance_model->myleave(session('emp_id'));
      
      if(session('appr_leave')){
        $data['otherleave'] = $this->attendance_model->leave_line(session('emp_id'));
      }else{
        $data['otherleave'] = $this->attendance_model->other_leaves(session('emp_id'));
      }
      
      $data['title'] = 'Leave';
      $data['leaveBalance'] = $this->attendance_model->getLeaveBalance(session('emp_id'), session('hire_date'), date('Y-m-d'));
      $data['leave_type'] = $this->attendance_model->leave_type();
      return view('app.leave', $data);

   }
    
    public function apply_leave() { 
        // echo "<p class='alert alert-success text-center'>Record Added Successifully</p>";
        
        if ($_POST) {
            
                // DATE MANIPULATION
            $start = $this->input->post("start");
            $end =$this->input->post("end");
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
    
            $limit=$this->input->post("limit");
            $date1=date_create($dates);
            $date2=date_create($datee);
            $date_today=date_create(date('Y-m-d'));
        
            $diff=date_diff($date1, $date2); 
            $diff2=date_diff($date_today, $date1);
            
            // START
            
            if ($this->input->post("start")==$this->input->post("end")) {
                echo "<p class='alert alert-warning text-center'>Invalid Start date or End date Selection</p>";
            } elseif ($this->input->post("nature")==1 && ($diff->format("%R%a"))>($limit)) {
                echo "<p class='alert alert-warning text-center'>Days Requested Exceed the Allowed Days</p>";
            }  elseif ($diff2->format("%R%a")<0 || $diff->format("%R%a")<0) {
                echo "<p class='alert alert-danger text-center'>Invalid Start date or End date Selection, Choose The Correct One</p>";
            } else {

                $data = array(
                    'empID' =>session('emp_id'),
                    'start' =>$dates,
                    'end' =>$datee,
                    'leave_address' =>$this->input->post("address"),
                    'mobile' =>$this->input->post("mobile"),
                    'nature' =>$this->input->post("nature"),
                    'reason' =>$this->input->post("reason"),
                    'application_date' =>date('Y-m-d')
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
    public function cancelLeave()  { 
          
      if($this->uri->segment(3)!=''){              
        $leaveID = $this->uri->segment(3); 

        $result = $this->attendance_model->deleteLeave($leaveID);
        if($result ==true){
          echo "<p class='alert alert-warning text-center'>Leave Cancelled Successifully</p>";
        } else {
          echo "<p class='alert alert-danger text-center'>Leave Not Deleted, Please Try Again</p>";
        }
      }
   } 
      
    public function recommendLeave()  
      { 
          
          if($this->uri->segment(3)!=''){
              
        $leaveID = $this->uri->segment(3);
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
      
    public function approveLeave()  
      { 
          
          if($this->uri->segment(3)!=''){
              
        $leaveID = $this->uri->segment(3);
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



    public function leave_remarks()  
      {    
        $id = $this->input->get('id');

      
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

  public function leave_application_info() {    
    $id = $this->input->get('id');   
    $empID = $this->input->get('empID'); 
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