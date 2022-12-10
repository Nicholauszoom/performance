<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\CustomModels\PayrollModel;
use App\CustomModels\flexFerformanceModel;
use App\CustomModels\ReportsModel;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Payroll\ReportModel;
use App\Models\Payroll\ImprestModel;
use App\Models\AttendanceModel;
use App\Models\ProjectModel;
use App\Models\PerformanceModel;
use App\Helpers\SysHelpers;

class PerformanceController extends Controller
{

  public function __construct(Request $request) {
    // parent::__construct();


    // $this->load->helper('url');
    // $this->load->library('form_validation');
    // $this->load->library('encryption');
    // $this->load->library('Pdf');
    // $this->load->library('user_agent');
    // $this->load->model('project_model');


    $this->flexperformance_model = new FlexPerformanceModel();
    $this->imprest_model = new ImprestModel();
    $this->reports_model = new ReportModel();
    $this->attendance_model = new AttendanceModel();
    $this->project_model = new ProjectModel();
    $this->performance_model = new PerformanceModel();



      date_default_timezone_set('Africa/Dar_es_Salaam');

    if (session('emp_id')==''){
      if (isset($_POST['login'])) {
        $this->login();
      } elseif(isset($_POST['register'])) {
        $this->register();
      } else {
        session('error', 'Sorry! You Have to Login Before any Attempt');
        // redirect(base_url()."index.php/base_controller/",'refresh');
      }
    }

  }
  function output_info(Request $request)  {
    $pattern =  base64_decode($this->input->get('id')); 
    $reference =  explode("|",$pattern);
    $strategyID = $reference[0];
    $outcomeID = $reference[1];
    $outputID = $reference[2];
  //   exit($pattern);
    
    $data['output'] = $this->performance_model->output_info($outputID);
    $data['outputCost'] = $this->performance_model->outputCost($outputID);
    $data['outputResourceCost'] = $this->performance_model->outputResourceCost($outputID);      
    $data["outcome"] = $this->performance_model->strategyOutcomes($strategyID);

    
    $data['progressTask'] = $this->performance_model->outputTaskProgress($outputID);
    $data['notStartedTask'] = $this->performance_model->outputTaskNotStarted($outputID);
    $data['completeTask'] = $this->performance_model->outputTaskComplete($outputID);
    
    $data['employee'] =  $this->flexperformance_model->customemployee();
    $data['tasks'] = $this->performance_model->output_tasks($outputID);
    $data['outcomeDateRange'] = $this->performance_model->outcomeDateRange($outcomeID);
    $data['title']="Output";
    $data['strategyID']=$strategyID;
    $data['outcomeID']=$outcomeID;
    $data['outputID']=$outputID;
     return view('app.output_info', $data);
  }
   public function assign_output(Request $request)  {
      if ($_POST) {
         $outcomeref =  $request->input('employeeID');
        $outputID =  $request->input('outputID');
        // echo $outputID."<><>".$outcomeref; exit();
        if($outputID=='') {
            echo "Sorry! Output Not Assigned, either No Outcome selected or Outcome Reference Has Expired!, Please Reselect the Outcome which You want to add an output to";
            // return redirect('/flex/performance/outcome');
            
        } else{
            
            $data = array( 
                 'assigned_to' =>$request->input('employeeID'),
                 'isAssigned' =>1
            );   
          $this->performance_model->update_output($data, $outputID);
          echo "Output Assigned Successifully";
    //   return redirect('/flex/performance/outcome');
        }
            
        }
   }
      
     public function updateoutputDescription(Request $request)  {
      if ($_POST) {
          
          if($request->input('description')!='' && $request->input('outputID')!=''){
              
        $outputID = $request->input('outputID');
        $data = array( 
                 'description' =>$request->input('description')
            );   
          $this->performance_model->update_output($data, $outputID);
          echo "<p class='alert alert-success text-center'>Description Updated Successifully</p>";
          }
      }
   }
    public function updateOutputDateRange(Request $request)  {
    if ($_POST) {
      $outputID = $request->input('outputID');
      $start =str_replace('/', '-', $request->input('start'));
      $end = str_replace('/', '-', $request->input('end'));

      $dateStart = date('Y-m-d', strtotime($start));
      $dateEnd = date('Y-m-d', strtotime($end));
      $date_today=date('Y-m-d');

      if ($dateEnd < $dateStart||$outputID=='') {
        echo "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
      }else{
        $updates = array(
          'start' =>$dateStart,
          'end' =>$dateEnd
        );
        $result = $this->performance_model->update_output($updates, $outputID);
        if($result==true){
          echo "<p class='alert alert-success text-center'>Output Start Date and End Date Updated Successifully</p>";
        }else{
          echo "<p class='alert alert-danger text-center'>Failed To Update Output's Start Date and End Date, Please Contact Your System Admin</p>";
        }
      }
    }
  } 
   
   
  
   
    public function updateOutputTitle()  
      { 
          
      if ($_POST) {
          
          if($request->input('title')!='' && $request->input('outputID')!=''){
        $outputID = $request->input('outputID');
        $data = array( 
                 'title' =>$request->input('title')
            );   
          $this->performance_model->update_output($data, $outputID);
          echo "<p class='alert alert-success text-center'>Title Updated Successifully</p>";
          } else{
            echo "<p class='alert alert-danger text-center'>Title Not Updated, Please try Again </p>";
          }
      }
   }
  public function addOutcome(Request $request)  {
    if($_POST) { 
      $strategyID = $request->input('strategyID');
      $start =str_replace('/', '-', $request->input('start'));
      $end = str_replace('/', '-', $request->input('end'));

      $dateStart = date('Y-m-d', strtotime($start));
      $dateEnd = date('Y-m-d', strtotime($end));
      $date_today=date('Y-m-d');
      if ($request->input('employee')=='') {
        $employee =session('emp_id');
        $isAssigned = 0;
      } else {
        $employee = $request->input('employee');
        $isAssigned = 1;
      }

      if ($dateEnd < $dateStart||$strategyID=='') {        
          $response_array['status'] = "ERR";
          $response_array['message'] = "<p class='alert alert-danger text-center'>Please pick The apprpiate Date Range</p>";
          header('Content-type: application/json');            
          echo json_encode($response_array);
      }else{
        $data = array(  
            'title' => $request->input('name'),
            'strategy_ref' => $strategyID,
            'description' =>$request->input('description'), 
            'assigned_by' =>session('emp_id'),
            'assigned_to' =>$employee,
            'isAssigned' => $isAssigned,
            'start' =>$dateStart,
            'end' =>$dateEnd
        );   
        $result = $this->performance_model->add_outcome($data);
        if($result==true){
          $response_array['status'] = "OK";
          $response_array['message'] = "<p class='alert alert-success text-center'>Outcome Added Successifully</p>";
          header('Content-type: application/json');            
          echo json_encode($response_array);
        }else{
          $response_array['status'] = "ERR";
          $response_array['message'] = "<p class='alert alert-danger text-center'>Failed To Add Outcome, Please Contact Your System Admin</p>";
          header('Content-type: application/json');            
          echo json_encode($response_array);
        }
      }
    }
       
  }

  ######################  STRATEGY  ##############################

  function strategy(Request $request)  {

      $strategyID =session('current_strategy');
      $empID =session('emp_id');
      $data["outcomes"] = $this->performance_model->all_outcome($strategyID);
      $data["strategy"] = $this->performance_model->strategies();
      $data["funders"] = $this->performance_model->getFunders();
      $data['task'] = $this->performance_model->alltask($strategyID);
      $data['currentStrategy'] = $strategyID;
      $data['activeOutcomes'] = $this->performance_model->outcomes($strategyID); 
      $data["strategyID"] = $strategyID; //$this->performance_model->strategy_info($strategyID);
      $data['title']="Strategy";
       return view('app.strategy', $data);

     if(isset($_POST['addstrategy'])) {

      $start =str_replace('/', '-', $request->input('start'));
      $end = str_replace('/', '-', $request->input('end'));

      $dateStart = date('Y-m-d', strtotime($start));
      $dateEnd = date('Y-m-d', strtotime($end));
      $date_today=date('Y-m-d');

      if ($dateStart < $date_today || $dateEnd <= $dateStart) {
        session('note', "<p class='alert alert-danger text-center'>Invalid Date, Choose The correct Date and Try Again!</p>");
        return redirect('/flex/performance/strategy');
      } else { 

        $data = array(  
             'title' => $request->input('name'),
             'description' =>$request->input('description'),
             'funder' =>$request->input('funder'),
             'author' =>session('emp_id'),
             'type' =>$request->input('type'), 
             'start' =>$dateStart,
             'end' =>$dateEnd
        );   
          $result = $this->performance_model->addstrategy($data);
          if($result==true){
            session('note', "<p class='alert alert-success text-center'>Strategy Added Successifully</p>");
            return redirect('/flex/performance/strategy');
          } else {
            session('note', "<p class='alert alert-warning text-center'>Strategy NOT Added, Some Internal Errors Occured, Please Contact The System Administrator</p>");
          return redirect('/flex/performance/strategy');
          }
          
       
        } 
      }
    }

  public function funder(Request $request)  {  
    if(session('mng_paym') ||session('recom_paym') ||session('appr_paym')){  
          if(session('mng_paym')){
              $id =session('emp_id');
              $data['funders'] =  $this->performance_model->getFunders();
              $data['segments'] =  $this->performance_model->getProjectSegment();
              $data['categories'] =  $this->performance_model->getExpenseCategory();
              $data['exceptions'] =  $this->performance_model->getException();
              $data['requests'] =  $this->performance_model->getRequest();
              $data['country'] = $this->flexperformance_model->nationality();
              $data['projects'] = $this->project_model->allProjects();
              $data['title']="Project Funders";

               return view('app.funders', $data);
         }
    }else{
      echo "Unauthorized Access";
    }
  
  } 

  public function addFunder(Request $request)  {
    if($_POST) { 
      $data = array(  
          'name' => $request->input('name'),
          'email' =>$request->input('email'), 
          'phone' =>$request->input('phone'), 
          'description' =>$request->input('description'), 
          'createdBy' =>session('emp_id'),
          'country' => $request->input('nationality'),
          'type' => $request->input('type')
      );   
      $result = $this->performance_model->addFunder($data);
      if($result==true){
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Funder Registered Successifully</p>";
        header('Content-type: application/json');            
        echo json_encode($response_array);
      }else{
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>Funder Not Registered, Please Contact Your System Admin</p>";
        header('Content-type: application/json');            
        echo json_encode($response_array);
      }
    }       
  }

    public function addSegment(Request $request)  {
        if($_POST) {
            $data = array(
                'name' => $request->input('name'),
                'created_at' => date('Y-m-d'),
                'created_by' =>session('emp_id')
            );
            $result = $this->performance_model->addSegment($data);
            if($result==true){
                $response_array['status'] = "OK";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }else{
                $response_array['status'] = "ERR";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function addCategory(Request $request)  {
        if($_POST) {
            $data = array(
                'name' => $request->input('category_name'),
                'created_at' => date('Y-m-d'),
                'created_by' =>session('emp_id')
            );
            $result = $this->performance_model->addCategory($data);
            if($result==true){
                $response_array['status'] = "OK";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }else{
                $response_array['status'] = "ERR";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function addException(Request $request)  {
        if($_POST) {
            $data = array(
                'name' => $request->input('exception_name'),
                'created_at' => date('Y-m-d'),
                'created_by' =>session('emp_id')
            );
            $result = $this->performance_model->addException($data);
            if($result==true){
                $response_array['status'] = "OK";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }else{
                $response_array['status'] = "ERR";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function addRequest(Request $request)  {
        if($_POST) {
            $data = array(
                'funder' => $request->input('funder'),
                'project' => $request->input('project'),
                'activity' => $request->input('activity'),
                'mode' => "IN",
                'amount' => trim($request->input('amount')),
                'created_at' => date('Y-m-d'),
                'created_by' =>session('emp_id')
            );
            $result = $this->performance_model->addRequest($data);

            if($result==true){
                //get activity
                $grant_code = $this->performance_model->getGrantCode($request->input('activity'),$request->input('project'));
                if ($grant_code){
                    foreach ($grant_code as $item){
                        $new_grant = $request->input('amount') + $item->amount;
                        $data_ = array(
                            'amount' => $new_grant
                        );
                        $this->performance_model->updateGrant($item->grant_code, $data_);

                    }
                }
                $response_array['status'] = "OK";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }else{
                $response_array['status'] = "ERR";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

  public function updateStrategyDateRange(Request $request)  {
    if ($_POST) {
      $strategyID = $request->input('strategyID');
      $start =str_replace('/', '-', $request->input('start'));
      $end = str_replace('/', '-', $request->input('end'));

      $dateStart = date('Y-m-d', strtotime($start));
      $dateEnd = date('Y-m-d', strtotime($end));
      $date_today=date('Y-m-d');

      if ($dateEnd <= $dateStart||$strategyID=='') {
        echo "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
      }else{
        $updates = array(
          'start' =>$dateStart,
          'end' =>$dateEnd
        );
        $result = $this->performance_model->update_strategy($updates, $strategyID);
        if($result==true){
          echo "<p class='alert alert-success text-center'>Strategy Start Date and End Date Updated Successifully</p>";
        }else{
          echo "<p class='alert alert-danger text-center'>Failed To Update Strategy's Start Date and End Date, Please Contact Your System Admin</p>";
        }
      }
    }
  } 
     public function updateStrategy(Request $request)  {          
      if ($_POST) {          
          if($request->input('title')!='' && $request->input('strategyID')!='' && $request->input('attribute') == "title" ){
        $strategyID = $request->input('strategyID');
        // $dates = $request->input('start');
        // $dateStart = str_replace('/', '-', $dates);
        $data = array( 
                 'title' =>$request->input('title')
            );   
          $this->performance_model->update_strategy($data, $strategyID);
          echo "<p class='alert alert-success text-center'>Title Updated Successifully</p>";
          }
          
          if($request->input('description')!='' && $request->input('strategyID')!='' && $request->input('attribute') == "description" ){
        $strategyID = $request->input('strategyID');
        // $dates = $request->input('end');
        // $dateEnd = str_replace('/', '-', $dates);
        $data = array( 
                 'description' =>$request->input('description')
            );   
          $this->performance_model->update_strategy($data, $strategyID);
          echo "<p class='alert alert-success text-center'>Description Updated Successifully</p>";
          }
          
          if($request->input('end')!='' && $request->input('strategyID')!='' && $request->input('attribute') == "endDate" ){
        $strategyID = $request->input('strategyID');
        $dates = $request->input('end');
        $dateEnd = str_replace('/', '-', $dates);
        $data = array( 
                 'end' =>date('Y-m-d', strtotime($dateEnd))
            );   
          $this->performance_model->update_strategy($data, $strategyID);
          echo "<p class='alert alert-success text-center'>End Date Updated Successifully</p>";
          }
          
          if($request->input('start')!='' && $request->input('strategyID')!='' && $request->input('attribute') == "startDate" ){
        $strategyID = $request->input('strategyID');
        $dates = $request->input('start');
        $dateStart = str_replace('/', '-', $dates);
        $data = array( 
                 'start' =>date('Y-m-d', strtotime($dateStart))
            );   
          $this->performance_model->update_strategy($data, $strategyID);
          echo "<p class='alert alert-success text-center'>Start Date Updated Successifully</p>";
          }
      }
   }

  public function strategy_report(Request $request)  {
    if(isset($_POST['print'])) {
      $target = $request->input('target');
      $status = $request->input('status');
      $strategyID = $request->input('strategyID');
      $today = date('Y-m-d');

      
      $data['author'] =session('fname')." ".session('mname') ." ".session('lname');      
      $data['strategy_info'] = $this->performance_model->strategy_report_info($strategyID);
      $data["strategy_progress"] = $this->performance_model->strategyProgress($strategyID);

      
      if($status == 1){ //ALL
        if($target==1){
          $data['outcomeList'] = $this->performance_model-> all_all_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> all_all_output($strategyID);       
          $data['taskList'] = $this->performance_model-> all_all_task($strategyID);
          $data['report_name'] = "Overall Report";
           return view('app.reports/strategy_report', $data);

        } elseif ($target==2){
          $data['outcomeList'] = $this->performance_model-> all_fin_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> all_fin_output($strategyID);
          $data['taskList'] = $this->performance_model-> all_fin_task($strategyID);
          $data['report_name'] = "Overall Finencial Report";
           return view('app.reports/strategy_report', $data);

        }elseif($target==3){
          $data['outcomeList'] = $this->performance_model-> all_qty_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> all_qty_output($strategyID);
          $data['taskList'] = $this->performance_model-> all_qty_task($strategyID);
          $data['report_name'] = "Overall Quantitative Report";
           return view('app.reports/strategy_report', $data);
        }
      }elseif($status==2){ //PROGRESS
        if($target==1){
          $data['outcomeList'] = $this->performance_model-> progress_all_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> progress_all_output($strategyID);      
          $data['taskList'] = $this->performance_model-> progress_all_task($strategyID);
          $data['report_name'] = "General Progress Report";
           return view('app.reports/strategy_report', $data);

        } elseif ($target==2){
          $data['outcomeList'] = $this->performance_model-> progress_fin_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> progress_fin_output($strategyID);      
          $data['taskList'] = $this->performance_model-> progress_fin_task($strategyID);
          $data['report_name'] = "General Finencial Progress Report";
           return view('app.reports/strategy_report', $data);
        
        }elseif($target==3){
          $data['outcomeList'] = $this->performance_model-> progress_qty_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> progress_qty_output($strategyID);      
          $data['taskList'] = $this->performance_model-> progress_qty_task($strategyID);
          $data['report_name'] = "General Quantitative Progress Report";
           return view('app.reports/strategy_report', $data);
        }

      }elseif($status==3){ //COMPLETED
        if($target==1){
          $data['outcomeList'] = $this->performance_model-> completed_all_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> completed_all_output($strategyID);
          $data['taskList'] = $this->performance_model-> completed_all_task($strategyID);
          $data['report_name'] = "General Approved Report";
           return view('app.reports/strategy_report', $data);

        } elseif ($target==2){
          $data['outcomeList'] = $this->performance_model-> completed_fin_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> completed_fin_output($strategyID);
          $data['taskList'] = $this->performance_model-> completed_fin_task($strategyID);

          //TOTAL
          $data['total_outcome'] = $this->performance_model-> total_completed_fin_outcomes($strategyID);
          $data['total_output'] = $this->performance_model-> total_completed_fin_output($strategyID);
          $data['total_task'] = $this->performance_model-> total_completed_fin_task($strategyID);
          $data['report_name'] = "Approved Financial Report";
           return view('app.reports/strategy_report_approved', $data);
        
        }elseif($target==3){
          $data['outcomeList'] = $this->performance_model-> completed_qty_outcomes($strategyID);
          $data['outputList'] = $this->performance_model-> completed_qty_output($strategyID);
          $data['taskList'] = $this->performance_model-> completed_qty_task($strategyID);

          //TOTAL
          $data['total_outcome'] = $this->performance_model-> total_completed_qty_outcomes($strategyID);
          $data['total_output'] = $this->performance_model-> total_completed_qty_output($strategyID);
          $data['total_task'] = $this->performance_model-> total_completed_qty_task($strategyID);
          $data['report_name'] = "Approved Quantitative Report";
           return view('app.reports/strategy_report_approved', $data);
        }

      } elseif($status==4){ //OVERDUE
        if($target==1){
          $data['outcomeList'] = $this->performance_model-> overdue_all_outcomes($strategyID,$today);
          $data['outputList'] = $this->performance_model-> overdue_all_output($strategyID,$today);
          $data['taskList'] = $this->performance_model-> overdue_all_task($strategyID,$today);
          $data['report_name'] = "General Overdue Report";
           return view('app.reports/strategy_report', $data);

        } elseif ($target==2){
          $data['outcomeList'] = $this->performance_model-> overdue_fin_outcomes($strategyID,$today);
          $data['outputList'] = $this->performance_model-> overdue_fin_output($strategyID,$today);
          $data['taskList'] = $this->performance_model-> overdue_fin_task($strategyID,$today);

          $data['report_name'] = "Overdue Financial Report";
           return view('app.reports/strategy_report', $data);
        
        }elseif($target==3){
          $data['outcomeList'] = $this->performance_model-> overdue_qty_outcomes($strategyID,$today);
          $data['outputList'] = $this->performance_model-> overdue_qty_output($strategyID,$today);
          $data['taskList'] = $this->performance_model-> overdue_qty_task($strategyID,$today);
          $data['report_name'] = "Overdue Quantitative Report";
           return view('app.reports/strategy_report', $data);
        }

      } elseif($status==5){ //NOT STARTED
        if($target==1){
          $data['outcomeList'] = $this->performance_model-> not_started_all_outcomes($strategyID,$today);
          $data['outputList'] = $this->performance_model-> not_started_all_output($strategyID,$today);
          $data['taskList'] = $this->performance_model-> not_started_all_task($strategyID,$today);
          $data['report_name'] = "General Not Started Report";
           return view('app.reports/strategy_report', $data);

        } elseif ($target==2){
          $data['outcomeList'] = $this->performance_model-> not_started_fin_outcomes($strategyID,$today);
          $data['outputList'] = $this->performance_model-> not_started_fin_output($strategyID,$today);
          $data['taskList'] = $this->performance_model-> not_started_fin_task($strategyID,$today);

          $data['report_name'] = "Not Started Financial Report";
           return view('app.reports/strategy_report', $data);
        
        }elseif($target==3){
          $data['outcomeList'] = $this->performance_model-> not_started_qty_outcomes($strategyID,$today);
          $data['outputList'] = $this->performance_model-> not_started_qty_output($strategyID,$today);
          $data['taskList'] = $this->performance_model-> not_started_qty_task($strategyID,$today);

          $data['report_name'] = "Not Started Quantitative Report";
           return view('app.reports/strategy_report', $data);
        }

      }else{ //UNCLASSIFIED

      }     

    }
  }

   ##############################   END STRATEGY  ##########################################


   
  public function updateOutcomeDateRange(Request $request)  {
    if ($_POST) {
      $outcomeID = $request->input('outcomeID');
      $start =str_replace('/', '-', $request->input('start'));
      $end = str_replace('/', '-', $request->input('end'));

      $dateStart = date('Y-m-d', strtotime($start));
      $dateEnd = date('Y-m-d', strtotime($end));
      $date_today=date('Y-m-d');

      if ($dateEnd < $dateStart||$outcomeID=='') {
        echo "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
      }else{
        $updates = array(
          'start' =>$dateStart,
          'end' =>$dateEnd
        );
        $result = $this->performance_model->update_outcome($updates, $outcomeID);
        if($result==true){
          echo "<p class='alert alert-success text-center'>Outcome Start Date and End Date Updated Successifully</p>";
        }else{
          echo "<p class='alert alert-danger text-center'>Failed To Update Outcome's Start Date and End Date, Please Contact Your System Admin</p>";
        }
      }
    }
  } 
   
  public function updateOutcome(Request $request)  {           
    if ($_POST) {          
      if($request->input('title')!='' && $request->input('outcomeID')!='' && $request->input('attribute') == "title" ){
        $outcomeID = $request->input('outcomeID');
        // $dates = $request->input('start');
        // $dateStart = str_replace('/', '-', $dates);
        $data = array( 
                 'title' =>$request->input('title')
          );   
        $this->performance_model->update_outcome($data, $outcomeID);
        echo "<p class='alert alert-success text-center'>Title Updated Successifully</p>";
      }
          
      if($request->input('description')!='' && $request->input('outcomeID')!='' && $request->input('attribute') == "description" ){
        $outcomeID = $request->input('outcomeID');
        // $dates = $request->input('end');
        // $dateEnd = str_replace('/', '-', $dates);
        $data = array( 
                 'description' =>$request->input('description')
            );   
        $this->performance_model->update_outcome($data, $outcomeID);
        echo "<p class='alert alert-success text-center'>Description Updated Successifully</p>";
      }
          
      if($request->input('indicator')!='' && $request->input('outcomeID')!='' && $request->input('attribute') == "indicator" ){
        $outcomeID = $request->input('outcomeID');
        
        $data = array( 
                 'indicator' =>$request->input('indicator')
            );   
        $this->performance_model->update_outcome($data, $outcomeID);
        echo "<p class='alert alert-success text-center'>Title Updated Successifully</p>";
      }
    }
  }  
      
  public function updateOutcomeStrategy_ref(Request $request)  {
    if ($_POST) {        
      if($request->input('strategy_ref')!='' && $request->input('outcomeID')!=''){
            
        $outcomeID = $request->input('outcomeID');
        $data = array( 
               'strategy_ref' =>$request->input('strategy_ref')
          );   
        $this->performance_model->update_outcome($data, $outcomeID);
        echo "<p class='alert alert-success text-center'>Strategy Reference For this Outcome has Updated Successifully</p>";
      }
    }
  }
   
      
  public function updateOutcomeAssign(Request $request)  {
    if ($_POST) {        
      if($request->input('assigned_to')!='' && $request->input('outcomeID')!=''){
            
        $outcomeID = $request->input('outcomeID');
        $data = array( 
                 'assigned_to' =>$request->input('assigned_to'),
                 'isAssigned' =>1
            );   
        $this->performance_model->update_outcome($data, $outcomeID);
        echo "<p class='alert alert-success text-center'>Outcome assigned Successifully</p>";
      }
    }
  }
   
  
  public function reference_output(Request $request)  {        
    if ($_POST) {         
      $outcomeref =  $request->input('outcomeKEY');
      $outputID =  $request->input('outputID');        
      // echo $outputID."<><>".$outcomeref; exit();
      if($outputID=='') {
        echo "Sorry! Output Not Assigned, either No Outcome selected or Outcome Reference Has Expired!, Please Reselect the Outcome which You want to add an output to";
      } else {            
        $data = array( 
               'outcome_ref' =>$outcomeref
          );
        $dataTask = array( 
               'outcome_ref' =>$outcomeref
          );
        $this->performance_model->update_output($data, $outputID);
        $this->performance_model->updateTaskReference($dataTask, $outputID);
        echo "Outcome Reference For This Output changed Successifully";
      }
    }       
  }
      
      

  public function strategy_info(Request $request) {
              
    $strategyID = base64_decode($this->input->get('id'));
    $data["strategyProgress"] = $this->performance_model->strategyProgress($strategyID);
    $data["outcomes"] = $this->performance_model->outcomes($strategyID);
    $data["strategy_details"] = $this->performance_model->strategy_info($strategyID);
    $data['employee'] =  $this->flexperformance_model->customemployee();
            
    $data['title']="Output and Outcome";
    $data['strategyID'] = $strategyID;
    $data['mode'] = 1;
          
     return view('app.strategy_info', $data);
             
  }
      

  public function outcome_info(Request $request) {
        
    $pattern =  base64_decode($this->input->get('id')); 
    $reference =  explode("|",$pattern);
    $strategyID = $reference[0];
    $outcomeID = $reference[1];
    $data["outputs"] = $this->performance_model->outputs($outcomeID);
    $data['employee'] =  $this->flexperformance_model->customemployee();
    $data["strategyDateRange"] = $this->performance_model->strategyDateRange($strategyID);
    $data["outcome_details"] = $this->performance_model->outcome_info($outcomeID);

    $data['outcomeCost'] = $this->performance_model->outcomeCost($outcomeID);
    $data['outcomeResourceCost'] = $this->performance_model->outcomeResourceCost($outcomeID);

    $data['outcomeOutputCompleted'] = $this->performance_model->outcomeOutputCompleted($outcomeID);
    $data['outcomeOutputProgress'] = $this->performance_model->outcomeOutputProgress($outcomeID);
    $data['outcomeOutputNotStarted'] = $this->performance_model->outcomeOutputNotStarted($outcomeID); 
    
    
    $strategyInfo = $this->performance_model->strategy_info($strategyID);
    foreach ($strategyInfo as $key) {
      $strategyTitle = $key->title;
    }
      
    $data["strategyProgress"] = $this->performance_model->strategyProgress($strategyID);
      
    $data['strategyTitle'] = $strategyTitle;
            
    $data['title']="Output and Outcome";
    $data['outcomeID'] = $outcomeID;
    $data['strategyID'] = $strategyID;
    $data['mode'] = 2;
          
     return view('app.outcomeinfo', $data);
             
  }

  public function selectStrategy()
  {
    $strategyID = $this->uri->segment(3);
    $this->session->set_userdata('current_strategy', $strategyID);            
    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-success text-center'>Strategy Seleted Successifully!</p>";
    header('Content-type: application/json');            
    echo json_encode($response_array);
     
  }

  public function deleteStrategy()
  {
    $strategyID = $this->uri->segment(3);
    $this->performance_model->deleteStrategy($strategyID);
    $this->performance_model->clearStrategy();
    
    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-danger text-center'>Strategy Deleted Successifully!</p>";
    header('Content-type: application/json');            
    echo json_encode($response_array);
     
  }

  public function deleteOutcome()
  {
    $outcomeID = $this->uri->segment(3);
    $this->performance_model->deleteOutcome($outcomeID);
    $this->performance_model->clearStrategy();
    
    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-danger text-center'>Outcome Deleted Successifully!</p>";
    header('Content-type: application/json');            
    echo json_encode($response_array);
     
  }

  public function deleteOutput()
  {
    $outputID = $this->uri->segment(3);
    $this->performance_model->deleteOutput($outputID);
    
    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-danger text-center'>Output Deleted Successifully!</p>";
    header('Content-type: application/json');            
    echo json_encode($response_array);
     
      }

  public function deleteTask()
  {
    $taskID = $this->uri->segment(3);
    $this->performance_model->deleteTask($taskID);
    
    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-danger text-center'>Task Deleted Successifully!</p>";
    header('Content-type: application/json');            
    echo json_encode($response_array);
     
  }

  public function deleteResource()
  {
    $resourceID = $this->uri->segment(3);
    $this->performance_model->deleteResource($resourceID);
    
    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-danger text-center'>Resource Deleted Successifully!</p>";
    header('Content-type: application/json');            
    echo json_encode($response_array);
             
  }

  public function cancelTask()
  {
    $id = $this->uri->segment(3);
    
    $data = array(  
              'status' =>3,
              'notification' =>4
        );  
  
    $this->performance_model->updateTask($data, $id);
    
    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-warning text-center'>Task Cancelled!</p>";
    header('Content-type: application/json');            
    echo json_encode($response_array);
         
  }

  public function disapproveTask()
  {
    $id = $this->uri->segment(3);
    
    $data = array(  
              'status' =>5,
              'notification' =>4
        );  
  
    $this->performance_model->updateTask($data, $id);
    
    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-warning text-center'>Task Cancelled!</p>";
    header('Content-type: application/json');            
    echo json_encode($response_array);
         
  }

  public function comment(Request $request) {    
      $id = $request->input('id');
      $mode = $request->input('mode');    
      $data['funders'] =  $this->performance_model->getFunders(); 
      $data['activities'] =  $this->performance_model->getFunders();  
      $data['comment'] =  $this->performance_model->getcomments($id);
      $data['data'] =  $this->performance_model->gettaskbyid($id);
      $data['activities'] =  $this->performance_model->getActivities($id);
      $data['title']="Task";
      $data['mode']=$mode ; //1 for normal comments, 2 for Dissapproval comments, 3 for submission
       return view('app.task_comments', $data);
    }

  function addActivity(Request $request)  {          
    if($_POST){ 
      $response_array; 
      $dueDate =str_replace('/', '-', $request->input('activityDate'));
      $startTimeH = $request->input('startTimeH');
      $startTimeM = $request->input('startTimeM');
      $finishTimeH = $request->input('finishTimeH');
      $finishTimeM = $request->input('finishTimeM');
      $startTime = $startTimeH.":".$startTimeM;
      $finishTime = $finishTimeH.":".$finishTimeM;

      $activityDate = date('Y-m-d', strtotime($dueDate));
      $date_today=date('Y-m-d');

      if ($finishTimeH < $startTimeH) { 
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>Incorrect Time Range, Please Select Again</p>";            
      } else { 

        $data = array(  
             'activityDate' => $request->input('activityDate'),
             'name' =>$request->input('description'),
             'startTime' =>$startTime,
             'finishTime' =>$finishTime,
             'taskID' =>$request->input('taskID'),
             'activityDate' =>$activityDate,
             'createdBy' =>session('emp_id')
        ); 

        $result = $this->performance_model->addActivity($data);
        if($result ==true) { 
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Activity Added Successifully</p>";
          } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Activity Not Added</p>";
          }
        } 
      // }
    }else{
      $response_array['status'] = "ERR";
      $response_array['message'] = "<p class='alert alert-danger text-center'>Invalid Request of Resource</p>";
    }
    header('Content-type: application/json');            
    echo json_encode($response_array);
  }

  public function sendCommentOLd(Request $request) {
      if (isset($_POST['send']) && $request->input('taskID')!='' ) {  
        $taskID = $request->input('taskID');
        if($request->input('progress')!=''){
          $comment = $request->input('progress')."% =>>".$request->input('comment');
          $progress =$request->input('progress');
          $data = array(
            'comment' =>$comment,
            'taskID' =>$taskID,
            'staff' =>session('emp_id')
          );
          $result = $this->performance_model->progress_comment($data, $progress, $taskID);
        } else{

        $data = array(
              'comment' =>$request->input('comment'),
              'taskID' =>$taskID,
              'staff' =>session('emp_id')
            );
        $result = $this->performance_model->comment($data);

        }
        if($result ==true) { 
          session('note', "<p class='alert alert-success text-center'>Success.</p>");
        return redirect('/flex/performance/comment/?mode=1&id='.$taskID);           
          
        } else {
          session('note', "<p class='alert alert-danger text-center'>Submission Failed</p>");
          return redirect('/flex/performance/comment/?mode=1&id='.$taskID);
        }
        // return redirect('/flex/performance/comment/?id='.$taskID);

      } elseif (isset($_POST['reject']) && $request->input('taskID')!='' ) {  
        $taskID = $request->input('taskID');
        $comment = $request->input('comment');
        $taskUpdates = array(  
            'status' =>5,
            'notification' =>4
        ); 
        $comments = array(
          'comment' =>$comment,
          'comment_type' =>2,
          'taskID' =>$taskID,
          'staff' =>session('emp_id')
        );
        $result = $this->performance_model->reject_task($comments, $taskUpdates, $taskID);
        if($result ==true) {
          session('note', "<p class='alert alert-success text-center'>Success.</p>");
          return redirect('/flex/performance/comment/?id='.$taskID);
        } else {
          session('note', "<p class='alert alert-danger text-center'>Submission Failed, Try again.</p>");
          return redirect('/flex/performance/comment/?id='.$taskID);
        }
      } 
         
   }
  public function sendComment(Request $request) {
    if (Request::isMethod('post')&& $request->input('taskID')!='' ) {  
      $taskID = $request->input('taskID');
      $action = $request->input('action');
      if($action=="1"){
        if($request->input('progress')!=''){
          $comment = $request->input('progress')."% =>>".$request->input('comment');
          $progress =$request->input('progress');
          $data = array(
            'comment' =>$comment,
            'taskID' =>$taskID,
            'staff' =>session('emp_id')
          );
          $result = $this->performance_model->progress_comment($data, $progress, $taskID);
        } else{

        $data = array(
              'comment' =>$request->input('comment'),
              'taskID' =>$taskID,
              'staff' =>session('emp_id')
            );
        $result = $this->performance_model->comment($data);
        }
        if($result ==true) { 
          echo "<p class='alert alert-success text-center'>Success.</p>";           
          
        } else {
          echo "<p class='alert alert-danger text-center'>Submission Failed</p>";
        }

      } elseif($action=="2"){
        $taskID = $request->input('taskID');
        $comment = $request->input('comment');
        $taskUpdates = array(  
            'status' =>5,
            'notification' =>4
        ); 
        $comments = array(
          'comment' =>$comment,
          'comment_type' =>2,
          'taskID' =>$taskID,
          'staff' =>session('emp_id')
        );
        $result = $this->performance_model->rejectTask($comments, $taskUpdates, $taskID);
        if($result ==true) {
          echo "<p class='alert alert-success text-center'>Task Rejected</p>";
        } else {
          echo "<p class='alert alert-danger text-center'>FAILED:, Try again.</p>";
        }
      }
    }
  }

   public function assignCostValue()  
      {
          
      if (isset($_POST['assignValue']) && $request->input('taskID')!='' ) {
          $taskRef = $request->input('taskID');
          $outputID = $request->input('outputID'); 
        $data = array(
              'monetaryValue' =>$request->input('amount')
            );
        $this->performance_model->updateTask($data, $taskRef);
        session('note', "<p class='alert alert-success text-center'>The Cost Value For The Task was Assigned Successifully.</p>");

        return redirect('/flex/performance/output_info/?id='.base64_encode($outputID));

            } else  exit("REQUEST TYPE OF ACCESSING THIS FUNCTIONALITY HAS DENIED"); 
         
   }
   
   public function task_approval()  
      {    

        $taskID = $request->input('id');

        $data['task_details'] =  $this->performance_model->gettaskbyid($taskID);
        $data['behaviour'] =  $this->performance_model->getbehaviour();
        $data['marking'] =  $this->performance_model->get_task_marking_attributes();
        $data['totalResourceCost'] =  $this->performance_model->resource_cost($taskID); 
        $data['ratings'] =  $this->performance_model->get_task_ratings();

        if ($data['task_details']) {

          $data['title']="Task";
           return view('app.task_approval', $data);
        } 
        else { exit("REQUEST TYPE OF ACCESSING THIS FUNCTIONALITY HAS DENIED"); }
         
   }
     
     public function addTaskResources(Request $request)  {
      if ($_POST) {
          
          if($request->input('name')!='' && $request->input('taskID')!=''&& $request->input('cost')!=''){
              
        $taskID = $request->input('taskID');
        $data = array( 
                 'name' =>$request->input('name'),
                 'cost' =>$request->input('cost'),
                 'taskID' =>$request->input('taskID')
            );   
          $result = $this->performance_model->addTaskResource($data, $taskID);
          if($result ==true) { 
            $totalResourceCost =  $this->performance_model->resource_cost($taskID);            
            $response_array['status'] = "OK";
            $response_array['resourceCost'] = number_format($totalResourceCost,2);
            $response_array['message'] = "<p class='alert alert-success text-center'>Resource Added Successifully</p>";
            header('Content-type: application/json');            
            echo json_encode($response_array);
          } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>RESOURCE not Added</p>";
            header('Content-type: application/json');            
            echo json_encode($response_array);
          }
          // if($result ==true) { 
          //     echo "<p class='alert alert-success text-center'>Resource Added Successifully</p>"; 
              
          // } else { echo "<p class='alert alert-danger text-center'>RESOURCE not Added</p>"; }
          
          
          }
      }
         
   }
   
   public function task_marking()  
      { 
        if (Request::isMethod('post')&& $request->input('taskID')>0) {
          $taskID = $request->input('taskID');
          $sum =0;

          // START QUALITY MANIPULATION
        $percent_quantity = $request->input('percent_quantity');

        $required_duration = $request->input('required_duration');
        $submitted_duration = $request->input('submitted_duration');

        $required_quantity = $request->input('required_quantity');
        $submitted_quantity = $request->input('submitted_quantity');

        $final_quantity = 0;
        $excess_points = 0;

        $excess_duration = (($required_duration - $submitted_duration)/$required_duration);
        $excess_quantity = (($required_quantity - $submitted_quantity)/$required_quantity);

        if($excess_quantity==0) {

            if ($excess_duration<0) {
              $final_quantity = $percent_quantity*(1+$excess_duration);
              $excess_points = 0;
            }
            elseif ($excess_duration>=0) {
              $final_quantity = $percent_quantity;
              $excess_points = $excess_duration*$percent_quantity;
            }            
              // echo "SUBMITTED QUANTITY = REQUIRED QUANTITY<br>";
              
          }else if($excess_quantity<0){
            if ($excess_duration<0) {
              $partial_final_quantity = $percent_quantity*(1-$excess_quantity)+($excess_duration*$percent_quantity);
              if($partial_final_quantity>=$percent_quantity){
                $final_quantity = $percent_quantity;
                $excess_points = $partial_final_quantity-$percent_quantity;
              } else{
                $final_quantity = $partial_final_quantity;                
                $excess_points = 0;
              }
              
            }
            elseif ($excess_duration>=0) {
              $final_quantity = $percent_quantity;
              $excess_points = ($excess_duration*$percent_quantity) - ($excess_quantity*$percent_quantity);
            }            
              // echo "SUBMITTED QUANTITY IS GREATER THAN REQUIRED<br>";
              
          }elseif($excess_quantity>0) {

            if ($excess_duration<0) {

              $partial_final_quantity = $percent_quantity*(1-$excess_quantity)+ ($percent_quantity*$excess_duration);
              if($partial_final_quantity<=0){
                $final_quantity = 0;
                $excess_points = $partial_final_quantity;
              }else{
                $final_quantity = $partial_final_quantity;
                $excess_points = 0;
              }
            }
            elseif ($excess_duration>=0) {
              $final_quantity = $percent_quantity-($percent_quantity*$excess_quantity);
                $excess_points = 0;
            }

          }


          // END QUALITY MANIPULATION

          $countbehaviour =  $this->performance_model->count_behaviour();
          for($x=1;$x<=$countbehaviour; $x++){

             $sum+=$request->input('behaviour'.$x);
          } 
          $marks_behaviour = ($sum/100)*$request->input('marks_behaviour');

        //   exit("Behaviour".$marks_behaviour."<br>Quantity".$submitted_quantity."<br>Ratio".$percent_quantity.":".(100-$percent_quantity));
          $data = array(
                'quality' =>$marks_behaviour,
                'quantity' =>$final_quantity,//$request->input('quantity'),
                'excess_points' =>number_format($excess_points,2,".",""),
                'monetaryValue' =>$request->input('monetary_value'),
                'date_marked' =>date('Y-m-d'),
                'status' =>2,
                'submitted_quantity' => $submitted_quantity,
                'qb_ratio' =>$percent_quantity.":".(100-$percent_quantity),
                'notification' =>3,
                'remarks' =>$request->input('remarks')
              );          
          $result = $this->performance_model->updateTask($data, $taskID);
          if($result ==true) { 
              echo "<p class='alert alert-success text-center'>Tasked Approved Successifully</p>"; 
              
          } else { echo "<p class='alert alert-danger text-center'>Task Approval Failed, Please Try Again</p>"; }

        } else {
        exit("THE REQUEST TYPE OF ACCESSING THIS FUNCTIONALITY HAS DENIED"); } 
         
   }

   public function tasksettings(Request $request) { 
      
      $data['quantity'] =  $this->performance_model->tasksettings();
      $data['delay_percent'] =  $this->performance_model->tasksettings_delay_percent();
      $data['behaviour_info'] =  $this->performance_model->tasksettings_behaviour();
      $data['ratings'] =  $this->performance_model->tasksettings_ratings();
      $data['totalMarks'] =  $this->performance_model->totalMarksbehaviour();
      $data['title'] =  "Task Settings";
       return view('app.task_marking', $data);
               
   }


     
     public function updateTaskMarkingBasics(Request $request)  {
      if ($_POST) {
        $quantity = $request->input('quantity');
        $behaviour = $request->input('behaviour');
          
        if($quantity+$behaviour==100 ){
              
        $id = 1;
        $data = array(
              'behaviour' =>$request->input('behaviour'),
              'quantity' =>$request->input('quantity')
             
            );   
          $result = $this->performance_model->update_task_settings($data, $id);
          if($result ==true) { 
              echo "<p class='alert alert-success text-center'>Updated Successifully</p>"; 
              
          } else { echo "<p class='alert alert-danger text-center'>Update Failed, Please Try Again</p>"; }
          
          
          } else {
            echo "<p class='alert alert-warning text-center'>The Sum of Behaviour and Quantity Should be exactly equal to 100,  Updation Failed.</p>";
          }
      }
         
   }
     
     public function updateTaskTimeElapse(Request $request)  {
      if ($_POST) {
              
        $id = 2;
        $data = array( 'value' =>$request->input('percent') );   
          $result = $this->performance_model->update_task_settings($data, $id);
          if($result ==true) { 
              echo "<p class='alert alert-success text-center'>Updated Successifully</p>"; 
              
          } else { echo "<p class='alert alert-danger text-center'>Update Failed, Please Try Again</p>"; }
      }
         
   }
     
     public function deleteBehaviourParameter(Request $request)  { 
            $id = $this->uri->segment(3);  
            $result = $this->performance_model->deleteBehaviourParameter($id); 
            if($result ==true) {            
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Deleted Successifully</p>";
            header('Content-type: application/json');            
            echo json_encode($response_array);
          } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-warning text-center'>Delete Failed, Please Try Again</p>";
            header('Content-type: application/json');            
            echo json_encode($response_array);
          }
             
          }


     public function update_task_behaviour(Request $request)  {
      if ($_POST) {
        $sum = 0;
        $ids =  $this->performance_model->behaviour_ids();
        foreach ($ids as $key) {
          $sum+=$request->input('marks'.$key->id);        
          }

          if ($sum<100||$sum>100) {
            echo "<p class='alert alert-danger text-center'>Parameters Not Updated, Marks either are Less than 100% or Greater Than 100%, Please Review and Correct them Before Resubmission</p>";
          } else {

        foreach ($ids as $key) {
          $parameterID = $key->id;
          $marks = $request->input('marks'.$key->id);
          $title = $request->input('title'.$key->id);
          $description = $request->input('description'.$key->id);

          $data = array(
              'description' =>$description,
              'marks' =>$marks,
              'title' =>$title
             
            );
          $this->performance_model->update_task_behaviour($data, $parameterID);
         }
            echo "<p class='alert alert-success text-center'>Parameters  Updated, Successifully!</p>";

        }
      }
         
   }


     public function update_task_ratings(Request $request)  {
      if ($_POST) {
        $upper = 100;
          $category = 5;
          for ($i=1; $i <=$category ; $i++) {
            $upper_bound = $request->input("upper".$i);
            $contribution = $request->input("contr".$i);
            if($upper_bound>=100){
              $upper= 100.4;
            } else {
              $upper = $upper_bound;
            }
            $data = array(
              'lower_limit' =>$request->input('lower'.$i),
              'upper_limit' =>$upper,
              'title' =>$request->input('title'.$i),
              'contribution' => ($contribution/100)
             
            );
          $this->performance_model->update_task_ratings($data, $i);
          }
          echo "<p class='alert alert-success text-center'>Ratings  Updated, Successifully!</p>";

      }
         
   }

   public function update_task_behaviourSA(Request $request)   {

      if (isset($_POST['update'])) {
      $sum = 0;
      $ids =  $this->performance_model->behaviour_ids();
      foreach ($ids as $key) {
        $sum+=$request->input('marks'.$key->id);        
        }

        if ($sum<100||$sum>100) {
            session('note', "<p class='alert alert-danger text-center'>Parameters Not Updated, Marks either are Less than 100% or Greater Than 100%, Please Review and Correct them Before Resubmission</p>");

            $reload = '/flex/performance/tasksettings/';
            redirect($reload);
          } else{

        foreach ($ids as $key) {
          $parameterID = $key->id;
          $marks = $request->input('marks'.$key->id);
          $title = $request->input('title'.$key->id);
          $description = $request->input('description'.$key->id);

          $data = array(
              'description' =>$description,
              'marks' =>$marks,
              'title' =>$title
             
            );
          $this->performance_model->update_task_behaviour($data, $parameterID);
         }
            session('note', "<p class='alert alert-success text-center'>Parameters  Updated, Successifully!</p>");

            $reload = '/flex/performance/tasksettings/';
            redirect($reload);
        }
      }
               
   }

    public function add_behaviour(Request $request)  {
      if ($_POST) {
              
        $data = array(
                    'title' =>$request->input("title"),
                    'description' =>$request->input("description")
                  );      
          $result = $this->performance_model->add_task_parameter($data);
          if($result ==true) { 
              echo "<p class='alert alert-success text-center'>Behaviour Parameter Added Successifully</p>"; 
              
          } else { echo "<p class='alert alert-danger text-center'>Failed, Please Try Again</p>"; }
      }
         
   }

   
   public function productivity(Request $request)  { 

    $datestart = date("d/m/Y", strtotime("-12 months"));
    $dateend = date("d/m/Y");

    if (isset($_POST['show'])) {

      $datestart = $request->input('start');
      $dateend = $request->input('end');
    }
      $datesValue = str_replace('/', '-', $datestart);
      $dateeValue = str_replace('/', '-', $dateend);

      $start = date('Y-m-d', strtotime($datesValue));
      $end = date('Y-m-d', strtotime($dateeValue));  
       
      $data['emp_prod'] = $this->performance_model->employee_productivity($start, date("Y-m-t", strtotime($end)));
      $data['dept_prod'] = $this->performance_model->department_productivity($start, date("Y-m-t", strtotime($end)));
      $data['org_prod'] = $this->performance_model->organization_productivity($start, date("Y-m-t", strtotime($end)));
      $data['employee'] =  $this->flexperformance_model->customemployee();
      $data['departments'] = $this->performance_model->departmentChooser();
      $data['date_from'] = $datestart;
      $data['date_to'] = $dateend;
      $data['title']="Productivity";
       return view('app.productivity', $data);
   }
   
   
   public function productivity_report(Request $request)  { 
       
    if (isset($_POST['print'])) {

      $departmentRef = $request->input('deptID');
      $empReport = $request->input('employee');
      $deptReport = $request->input('department');
      $orgReport = $request->input('organization');
      $datestart = $request->input('start');
      $dateend = $request->input('end');
    
      $datesValue = str_replace('/', '-', $datestart);
      $dateeValue = str_replace('/', '-', $dateend);

      $start = date('Y-m-d', strtotime($datesValue));
      $end = date('Y-m-d', strtotime($dateeValue));

      if($departmentRef=="0"){
        $data['emp_prod'] = $this->performance_model->employee_productivity($start, date("Y-m-t", strtotime($end)));
        $data['dept_prod'] = $this->performance_model->department_productivity($start, date("Y-m-t", strtotime($end)));
        $data['org_prod'] = $this->performance_model->organization_productivity($start, date("Y-m-t", strtotime($end)));

      } else {
        $data['emp_prod'] = $this->performance_model->employee_productivity_sort($start, date("Y-m-t", strtotime($end)), $departmentRef);
        $data['dept_prod'] = $this->performance_model->department_productivity_sort($start, date("Y-m-t", strtotime($end)), $departmentRef);
        $data['org_prod'] = $this->performance_model->organization_productivity_sort($start, date("Y-m-t", strtotime($end)), $departmentRef);
      }
      $data['date_from'] = $start;
      $data['date_to'] = $end;
      $data['employeeReport'] = $empReport;
      $data['departmentReport'] = $deptReport;
      $data['organizationReport'] = $orgReport;
      $data['author'] =session('fname')." ".session('mname') ." ".session('lname');      

      $data['title']="Productivity";
       return view('app.reports/productivity_report', $data);
    }
   }

    


  public function selectTalent(Request $request)
      {
        $empID = $this->uri->segment(3);
        $score = $this->uri->segment(4);
        if($empID!='' && $score!=''){
        $data = array(  
                      'empID' =>$empID,
                      'score' =>$score,
                      'status' =>1,
                      'description' =>"N/A",
                     'due_date' => date('Y-m-d') 
                ); 
        
        $result = $this->performance_model->selectTalent($data);
        if($result ==true) { 
          $response_array['status'] = 1;
          $response_array['message'] = "Employee Selected Successifully!";
          header('Content-type: application/json');            
          echo json_encode($response_array);
              
          } else {
            $response_array['status'] = 2;
            $response_array['message'] = "Failed To Select Try Again";
            header('Content-type: application/json');            
            echo json_encode($response_array);
           }

        } else { 
        
        $response_array['status'] = 3;
        $response_array['message'] = "Some Data Are Missing";
        header('Content-type: application/json');            
        echo json_encode($response_array);
        }
         
  }

  public function talents(Request $request)  {

    $data["talents"] = $this->performance_model->talents($strategyID);  
    $data['title'] = 'Talents';
     return view('app.talents', $data);    
  } 

   public function submitTask(Request $request)  {  
        if ($_POST) {

          $taskID = $request->input('taskID');
          $remarks = trim($request->input('comment'));
          if (!empty($_FILES['userfile']['name']))  {
            $namefile = "report_".$taskID."_".date('YmdHis');            
            $config['upload_path']='./uploads/task/';
            $config['file_name'] = $namefile;
            $config['allowed_types']='pdf|jpeg|doc|ppt|docx|img|jpg|png';
            $config['overwrite'] = true;
            
            $this->load->library('upload',$config);
            if($this->upload->do_upload("userfile")){
                $data =  $this->upload->data();
                chmod($data["full_path"], 0777);
                $updates = array(
                        'attachment' =>$data["file_name"],
                        'submission_remarks' =>$remarks,
                        'status' =>1,
                        'notification' =>2,
                        'date_completed' => date('Y-m-d') 
                    );
                $result = $this->performance_model->updateTask($updates, $taskID);
                if($result==true) {
                  echo "<p class='alert alert-success text-center'>Task Submitted Successifully</p>";
                } else {
                echo "<p class='alert alert-danger text-center'>Task NOT Submitted, Please try Again</p>";  }
            } else {
                echo  "<p class='alert alert-danger text-center'>Attachment NOT Uploaded, Please try Again</p>"; 
            }
          }
        }  else { echo "INVALID ACCESS</p>"; }
         
      }

  public function addtask(Request $request) { 
    if ($_POST) {
      // DATE MANIPULATION
      $start =str_replace('/', '-', $request->input('start'));
      $end = str_replace('/', '-', $request->input('end'));

      $dateStart = date('Y-m-d', strtotime($start));
      $dateEnd = date('Y-m-d', strtotime($end));
      $date_today=date('Y-m-d');
      //exit($dateEnd."AND".$dateStart);      

      if ($request->input('employee')=='') {
        $employee =session('emp_id');
        $isAssigned = 0;
      } else {
        $employee = $request->input('employee');
        $isAssigned = 1;
      }

          
        // CONDITIONS
      if ($dateEnd < $dateStart) {
        echo "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
      } else {

        $data = array(
          'start' =>$dateStart,
          'end' =>$dateEnd,
          'output_ref' =>$request->input("outputID"),
          'outcome_ref' =>$request->input("outcomeID"),
          'strategy_ref' =>$request->input("strategyID"),
          'title' =>$request->input("title"),
          'initial_quantity' =>$request->input("quantity"),
          'description' =>$request->input("description"),
          'assigned_by' =>session('emp_id'),
          'assigned_to' =>$employee,
          'isAssigned' => $isAssigned,
          'quantity_type' =>$request->input('quantity_type'),
          'monetaryValue' =>$request->input('monetary_value'),
          'date_assigned' =>date('Y-m-d')
          );
        

        $result  = $this->performance_model->addtask($data);
        if($result == true){
            echo "<p class='alert alert-success text-center'>Task Added and Assigned Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>Task NOT Added Some Errors Occured, Please try Again</p>"; }
     
      }
    } 
  }  
 
 
 public function createNewTask(Request $request)  {
      if ($_POST) {
          
          // DATE MANIPULATION
        $erv = 3;
        $dates = $request->input('start');
        $datee = $request->input('end');
        $datesValue = str_replace('/', '-', $dates);
        $dateeValue = str_replace('/', '-', $datee);

        $dateStart = date('Y-m-d', strtotime($datesValue));
        $dateEnd = date('Y-m-d', strtotime($dateeValue ));
        $date_today=date('Y-m-d');

        if ($request->input('employee')=='') {
          $employee =session('emp_id');
          $isAssigned = 0;
        } else {
          $employee = $request->input('employee');
          $isAssigned = 1;
        }

        if ($dateEnd < $dateStart) {
          $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>".$dateStart."FAILED To Add Task, Invalid Start date or End date Selection, Choose The Correct One</p>";
              header('Content-type: application/json');            
              echo json_encode($response_array);
            } else { 
          

          $data = array(
            'start' =>$dateStart,
            'end' =>$dateEnd,
            'strategy_ref' =>$request->input("strategyID"),
            'output_ref' =>$request->input("outputID"),
            'outcome_ref' =>$request->input("outcomeID"),
            'title' =>$request->input("title"),
            'description' =>$request->input("description"),
            'assigned_by' =>session('emp_id'),
            'assigned_to' =>$employee,
            'quantity_type' =>$request->input('quantity_type'),
            'initial_quantity' =>$request->input('quantity'),
            'monetaryValue' =>$request->input('monetary_value'),
            'isAssigned'=>$isAssigned,
            'date_assigned' =>date('Y-m-d')
            );

          $result = $this->performance_model->addtask($data);
          if($result==true){
            $this->performance_model->audit_log("Created New Task");
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Task Added Successifully</p>";
              header('Content-type: application/json');            
              echo json_encode($response_array);
            }else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>Failed To Add Task, Please Contact Your System Admin</p>";
              header('Content-type: application/json');            
              echo json_encode($response_array);
          }
          
        }
      }
   }

  public function outcome(Request $request)  {

      $strategyID =session('current_strategy');
      $empID =session('emp_id');
      $data["outcomes"] = $this->performance_model->outcomes($strategyID);  
      $data['tag'] = ' All Outcomes';
      $data['title'] = 'Outcomes';
       return view('app.outcome', $data);    
  } 


 public function outcomecompleted(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');    
    $data['outcomes'] = $this->performance_model->pie_outcomescompleted($strategyID);
    $data['tag'] = 'Completed Outcomes';
    $data['title'] = 'Outcomes';
     return view('app.outcome', $data);   
 }



 public function outcomeontrack(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');
    $today = date('Y-m-d'); 
    $percentToAlert = $this->performance_model-> percentSetting();  
    $data['outcomes'] = $this->performance_model->pie_outcomesontrack($strategyID, $today, $percentToAlert);
    $data['tag'] = 'Outcomes On Track';
    $data['title'] = 'Outcomes';
     return view('app.outcome', $data);   
 }


 public function outcomedelayed(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');
    $today = date('Y-m-d'); 
    $percentToAlert = $this->performance_model-> percentSetting();  
    $data['outcomes'] = $this->performance_model->pie_outcomesofftrack($strategyID, $today, $percentToAlert);
    $data['tag'] = 'Delayed Outcomes';
    $data['title'] = 'Outcomes';
     return view('app.outcome', $data);   
 }


 public function outcomeoverdue(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id'); 
    $today = date('Y-m-d');   
    $data['outcomes'] = $this->performance_model->pie_outcomesoverdue($strategyID, $today);
    $data['tag'] = 'Overdue Outcomes';
    $data['title'] = 'Outcomes';
     return view('app.outcome', $data);   
 }

 //OUTPUTS
 public function addOutput(Request $request)  {
        
        if ($_POST) { 

        $outcomeref =  $request->input('outcomeKEY');
        $strategyID = $request->input('strategyID');

        $start =str_replace('/', '-', $request->input('start'));
        $end = str_replace('/', '-', $request->input('end'));

        $dateStart = date('Y-m-d', strtotime($start));
        $dateEnd = date('Y-m-d', strtotime($end));
        $date_today=date('Y-m-d');

        if ($request->input('employee')=='') {
        $employee =session('emp_id');
        $isAssigned = 0;
        } else {
          $employee = $request->input('employee');
          $isAssigned = 1;
        }
        if ($dateEnd < $dateStart||$strategyID=='') {
          $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
              header('Content-type: application/json');            
              echo json_encode($response_array);
        } else {

          if($outcomeref !='' && $strategyID != '') {
                    
            $data = array( 
                 'title' =>$request->input('title'),
                 'description' =>$request->input('description'), 
                 'strategy_ref' =>$request->input('strategyID'), 
                 'start' => $dateStart, 
                 'outcome_ref' =>$outcomeref,  
                 'author' =>session('emp_id'),  
                 'assigned_by' =>session('emp_id'),
                 'assigned_to' =>$employee,
                 'isAssigned' => $isAssigned, 
                   'end' =>$dateEnd
              );   
            $result = $this->performance_model->add_output($data);
            if($result==true){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Output Added Successifully</p>";
              header('Content-type: application/json');            
              echo json_encode($response_array);
            }else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>Failed To Add Output, Please Contact Your System Admin</p>";
              header('Content-type: application/json');            
              echo json_encode($response_array);
            }
          
              
            }else { 
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>Sorry! Output Not Added, either No Outcome selected or Outcome Reference Has Expired!, Please Reselect the Outcome which You want to add an output to</p>";
              header('Content-type: application/json');            
              echo json_encode($response_array);
            }
          }            
       
        }
    }
      
  public function output(Request $request)  {

      $strategyID =session('current_strategy');
      $empID =session('emp_id');
      $data["output"] = $this->performance_model->all_output($strategyID); 
      $data['tag'] = ' All Outputs';
      $data['title'] = 'Outputs';
       return view('app.output', $data);    
  } 


 public function outputcompleted(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');   
    $data['output'] = $this->performance_model->pie_outputscompleted($strategyID);
    $data['tag'] = 'Completed Output';
    $data['title'] = 'Output';
     return view('app.output', $data);   
 }


 public function outputontrack(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');
    $today = date('Y-m-d'); 
    $percentToAlert = $this->performance_model-> percentSetting();  
    $data['output'] = $this->performance_model->pie_outputsontrack($strategyID, $today, $percentToAlert);
    $data['tag'] = 'Outputs On Track';
    $data['title'] = 'Outputs';
     return view('app.output', $data);   
 }


 public function outputdelayed(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');
    $today = date('Y-m-d'); 
    $percentToAlert = $this->performance_model-> percentSetting();
    $data['output'] = $this->performance_model->pie_outputsofftrack($strategyID, $today, $percentToAlert);
    $data['tag'] = 'Delayed Outputs';
    $data['title'] = 'Outputs';
     return view('app.output', $data);   
 }


 public function outputoverdue(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');
    $today = date('Y-m-d');  
    $data['output'] = $this->performance_model->pie_outputsoverdue($strategyID, $today);
    $data['tag'] = 'Overdue Outputs';
    $data['title'] = 'Outputs';
     return view('app.output', $data);   
 }

//TASKS

 public function alltask(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');
    $data['othertask'] = $this->performance_model->alltask($strategyID);
    $data['tag'] = ' All Task';
    $data['title'] = 'Task';
    $data['active'] = 1; //Whether The Task is Active or Paused
     return view('app.task', $data);    
 } 

 public function task(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');
    $data['mytask'] = $this->performance_model->mytask($strategyID,session('emp_id') );
    $data['othertask'] = $this->performance_model->othertask($strategyID,session('emp_id') );
    $data['tag'] = ' All Task';
    $data['title'] = 'Task';
    $data['active'] = 1; //Whether The Task is Active or Paused
     return view('app.task', $data);    
 } 

 public function adhoc_task(Request $request)  {
    $empID =session('emp_id');
    $data['mytask'] = $this->performance_model->my_adhoc_task(session('emp_id'));
    $data['othertask'] = $this->performance_model->other_adhoc_task(session('emp_id'));
    $data['tag'] = ' All Task';
    $data['title'] = 'Adhoc Task';
    $data['active'] = 1; //Whether The Task is Active or Paused
     return view('app.task', $data);    
 } 

 public function paused_task(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');
    $data['mytask'] = $this->performance_model->my_paused_task($strategyID,session('emp_id'));
    $data['othertask'] = $this->performance_model->other_paused_task($strategyID,session('emp_id'));
    $data['tag'] = 'Paused Task';
    $data['active'] = 0;
    $data['title'] = 'Task';
     return view('app.task', $data);    
 }  

  public function pauseTask(Request $request)  { 
    $taskID = $this->uri->segment(3);
      
      if($taskID!=''){
            
          $taskID = $this->uri->segment(3);
          $todate = date('Y-m-d'); 
            
          $result = $this->performance_model->pauseTask($taskID, $todate);
              
          if($result==true){
                echo "<p class='alert alert-success text-center'>Task Paused Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Task NOT Paused, Please Try Again</p>";
            }
        
      } else {
        echo "<p class='alert alert-warning text-center'>Task NOT Pauseded</p>";
      }
  }

  public function resumeTask(Request $request)  { 
    $taskID = $this->uri->segment(3);
      
      if($taskID!=''){
            
          $taskID = $this->uri->segment(3);
          // $todate = date('Y-m-d'); 
            
          $result = $this->performance_model->resumeTask($taskID);
              
          if($result==true){
                echo "<p class='alert alert-success text-center'>Task RESUMED Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Task NOT RESUMED, Please Try Again</p>";
            }
        
      } else {
        echo "<p class='alert alert-warning text-center'>Task NOT RESUMED</p>";
      }
  }






 public function taskcompleted(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id');    
    $data['othertask'] = $this->performance_model->pie_taskcompleted($strategyID);
    $data['mytask'] = $this->performance_model->pie_taskcompleted($strategyID);
    $data['tag'] = 'Completed Task';
    $data['title'] = 'Task';
    $data['active'] = 1; //Whether The Task is Active or Paused
     return view('app.task', $data);   
 }

 public function taskoverdue(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id'); 
    $today = date('Y-m-d');   
    $data['othertask'] = $this->performance_model->pie_taskoverdue($strategyID, $today);
    $data['mytask'] = $this->performance_model->pie_taskoverdue($strategyID, $today);
    $data['tag'] = 'Overdue Tasks';
    $data['title'] = 'Task';
    $data['active'] = 1; //Whether The Task is Active or Paused
     return view('app.task', $data); 

   
 }

 public function taskontrack(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id'); 
    $today = date('Y-m-d');    
    $percentToAlert = $this->performance_model-> percentSetting();
    $data['othertask'] = $this->performance_model->pie_taskontrack($strategyID, $today, $percentToAlert);
    $data['mytask'] = $this->performance_model->pie_taskontrack($strategyID, $today, $percentToAlert);
    $data['tag'] = 'Task On Track';
    $data['title'] = 'Task';
    $data['active'] = 1; //Whether The Task is Active or Paused
     return view('app.task', $data); 

   
 }  

 public function taskdelayed(Request $request)  {
    $strategyID =session('current_strategy');
    $empID =session('emp_id'); 
    $today = date('Y-m-d');    
    $percentToAlert = $this->performance_model-> percentSetting();
    $data['othertask'] = $this->performance_model->pie_taskofftrack($strategyID, $today, $percentToAlert);
    $data['mytask'] = $this->performance_model->pie_taskofftrack($strategyID, $today, $percentToAlert);
    $data['tag'] = 'Task Off Track (Delayed)';
    $data['title'] = 'Task';
    $data['active'] = 1; //Whether The Task is Active or Paused
     return view('app.task', $data); 

   
 }  


 public function task_info(Request $request)  {
    $pattern =  base64_decode($this->input->get('id')); 
    $reference =  explode("|",$pattern);
    
    $taskID = $reference[0];
    $outputID = $reference[1];
    if($outputID==0){
      $data['task_details'] = $this->performance_model->adhoc_task_info($taskID);
    }else{
      $data['task_details'] = $this->performance_model->task_info($taskID);
    }

    $data['employee'] =  $this->flexperformance_model->customemployee(); 
    $data['totalResourceCost'] =  $this->performance_model->resource_cost($taskID); 
    $data['resource'] =  $this->performance_model->task_resources($taskID); 
    $data['output'] =  $this->performance_model->outputs_select(); 
    $data['title'] = 'Task';
     return view('app.task_info', $data); 
 }  

 public function adhoc_task_info(Request $request)  {
    $taskID = base64_decode($this->uri->segment(3));
    $data['task_details'] = $this->performance_model->adhoc_task_info($taskID); 
    $data['employee'] =  $this->flexperformance_model->customemployee(); 
    $data['totalResourceCost'] =  $this->performance_model->resource_cost($taskID); 
    $data['output'] =  $this->performance_model->outputs_select(); 
    $data['title'] = 'Task';
     return view('app.task_info', $data); 
 } 

 public function update_taskResource(Request $request) {   
    $taskID = $request->input('taskID');
    $resourceID = $request->input('resourceID');
    $outputID = $request->input('outputID');

    if (isset($_POST['update']) && $taskID!='' && $resourceID!='' ) {
      $updates = array(
          'name' =>$request->input('name'),
          'cost' =>$request->input('cost')
          );

    
     $result = $this->performance_model->update_taskResource($updates, $resourceID);
     if($result == true){
        session('note', "<p class='alert alert-success text-center'>Resource Updated Successifully</p>");
        return redirect('/flex/performance/task_info/?id='.base64_encode($taskID."|".$outputID));
      } else {
        session('note', "<p class='alert alert-danger text-center'>Resource Not Updated </p>");
        return redirect('/flex/performance/task_info/?id='.base64_encode($taskID."|".$outputID)); 
      }
    } else {
      session('note', "<p class='alert alert-success text-center'>Resource Not Updated, Some Errors Occured</p>");
        return redirect('/flex/performance/task_info/?id='.base64_encode($taskID."|".$outputID));
    }
   }

 public function assigntask(Request $request)  {
      $pattern =  base64_decode($this->input->get('id')); 
      $reference =  explode("|",$pattern);
      
      $strategyID = $reference[0];
      $outcomeID = $reference[1];
      $outputID = $reference[2];
      if ($outputID>=1) {        
        $data['taskDateRange'] = $this->performance_model->outputDateRange($outputID);
      } else {        
        $data['taskDateRange'] = $this->performance_model->strategyDateRange($strategyID);
      }
      $data['employee'] =  $this->flexperformance_model->customemployee(); 
      $data['tasks'] = $this->performance_model->output_tasks($outputID);
      $data['output'] = $this->performance_model->outputs_select();      
      $data['outputID'] = $outputID;
      $data['outcomeID'] =$outcomeID;
      $data['strategyID'] =$strategyID;
      $data['title'] = 'Task';
       return view('app.assign_task', $data);
   
 } 

  public function gettask()  
      {    
        $id = $request->input('id');

      
      $data['data'] =  $this->performance_model->gettaskbyid($id);
      $data['title']="Task";
      $data['subordinate'] = $this->performance_model->taskdropdown(session('emp_id'));
       return view('app.edittask', $data);}

  public function edittask()  
      {    
        $id = $request->input('id');

      if (isset($_POST['editdate'])) {   
        
        // DATE MANIPULATION
        $start = $request->input("start");
        $end =$request->input("end");
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

      $data = array(
            'start' =>$dates,
            'end' =>$datee );
    }
    elseif (isset($_POST['editsubordinate'])) { 
      $data = array(
            'assigned_to' =>$request->input("assigned_to"));
    }
    elseif (isset($_POST['editdesc'])) { 
      $data = array(
            'description' =>$request->input("description")
            ); }

      
        $this->performance_model->updateTask($data, $id);
         session('note', "<p class='alert alert-success text-center'>Task Updated Successifully</p>");
        return redirect('/flex/performance/task');
         
   } 
    
      
     public function updateTaskTitle(Request $request)  {
      if ($_POST) {
          
          if($request->input('title')!='' && $request->input('taskID')!=''){
              
        $taskID = $request->input('taskID');
        $data = array( 
                 'title' =>$request->input('title')
            );   
          $this->performance_model->updateTask($data, $taskID);
          echo "<p class='alert alert-success text-center'>Title Updated Successifully</p>";
          }
      }
   }
      
     public function updateTaskCost(Request $request)  {
      if ($_POST) {
          
          if($request->input('cost')!='' && $request->input('taskID')!=''){
              
        $taskID = $request->input('taskID');
        $data = array( 
                 'monetaryValue' =>$request->input('cost')
            );   
          $this->performance_model->updateTask($data, $taskID);
          echo "<p class='alert alert-success text-center'>Market Time Cost Updated Successifully</p>";
          }
      }
   }
      
     public function updateTaskDescription(Request $request)  {
      if ($_POST) {
          
          if($request->input('description')!='' && $request->input('taskID')!=''){
              
        $taskID = $request->input('taskID');
        $data = array( 
                 'description' =>$request->input('description')
            );   
          $this->performance_model->updateTask($data, $taskID);
          echo "<p class='alert alert-success text-center'>Description Updated Successifully</p>";
          }
      }
   }

   public function updateTaskDateRange(Request $request)  {
    if ($_POST) {
      $taskID = $request->input('taskID');
      $start =str_replace('/', '-', $request->input('start'));
      $end = str_replace('/', '-', $request->input('end'));

      $dateStart = date('Y-m-d', strtotime($start));
      $dateEnd = date('Y-m-d', strtotime($end));
      $date_today=date('Y-m-d');
      //exit($dateEnd."AND".$dateStart);

      if ($dateEnd < $dateStart||$taskID=='') {
        echo "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
      }else{
        $updates = array(
          'start' =>$dateStart,
          'end' =>$dateEnd
        );
        $result = $this->performance_model->updateTask($updates, $taskID);
        if($result==true){
          $this->performance_model->audit_log("Updated the Date Range for a Task With ID = ".$taskID."");
          echo "<p class='alert alert-success text-center'>Task Start Date and End Date Updated Successifully</p>";
        }else{
          echo "<p class='alert alert-danger text-center'>Failed To Update Task's Start Date and End Date, Please Contact Your System Admin</p>";
        }
      }
    }
  } 
      
      public function updateTaskAdvanced()  
      { 
      if ($_POST) {
        $updates =  $request->input('outputID');
        $taskID =  $request->input('taskID');
        
        $values = explode('|', $updates);
            $output_ref = $values[0];
            $outcome_ref = $values[1];
        
        // echo $outputID."<><>".$outcomeref; exit();
        if($output_ref!=''||$taskID!=''||$outcome_ref!=''){
            $data = array( 
                 'output_ref' =>$output_ref,
                 'outcome_ref' =>$outcome_ref
            );   
          $this->performance_model->updateTask($data, $taskID);
           echo "<p class='alert alert-success text-center'>Task Updated Successifully</p>";
        }
      }
   } 
   
   public function updateTaskAdvanced2()  
      { 
      if ($_POST) {
        $employee =  $request->input('employeeID');
        $taskID =  $request->input('taskID');
        
        // echo $outputID."<><>".$outcomeref; exit();
        if($employee!=''||$taskID!=''){
            $data = array( 
                 'assigned_to' => $employee,
                 'isAssigned' => 1
            );   
          $this->performance_model->updateTask($data, $taskID);
           echo "<p class='alert alert-success text-center'>Task Updated Successifully</p>";
        }
      }
   }
   
      
  function task_notification(Request $request)  {
        if(session('line')!= 0 ){
             $counts1 = $this->performance_model->task_notification_line_manager(session('emp_id'));
             $counts2 = $this->performance_model->task_notification_employee(session('emp_id'));
             if(($counts1+$counts2)>0){
                 echo '<span class="badge bg-red">'.($counts1+$counts2).'</span>'; } else echo "";
        } else {
              $counts = $this->performance_model->task_notification_employee(session('emp_id'));
              if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
        }
       
   }
      
  function expire_contracts_notification(Request $request)  {
    $count = $this->performance_model->contract_to_expire();          
    if($count>0) echo '<span class="badge bg-red">'.$count.'</span>'; else echo "";
   } 

  function retire_notification(Request $request)  {
    $count = $this->performance_model->employee_to_retire();          
    if($count>0) echo '<span class="badge bg-red">'.$count.'</span>'; else echo "";
   }
    
      
  function activation_notification(Request $request)  {
      if(session('init_emp_state')!= 0 ||session('appr_emp_state')!= 0 ){
        if(session('init_emp_state')!=0 &&session('appr_emp_state')!= 0){
           $count = $this->performance_model->appr_emp_state()+$this->performance_model->init_emp_state();
        } elseif(session('appr_emp_state')!= 0 ) {
            $count = $this->performance_model->appr_emp_state();          
        }elseif(session('init_emp_state')!=0 ) {
            $count = $this->performance_model->init_emp_state();          
        }

      if($count>0) echo '<span class="badge bg-red">'.$count.'</span>'; else echo "";
      }
   }
   
   
   
   function loan_notification(Request $request)  {
       
      if(session('recom_loan')!= 0 ||session('appr_loan')!=0 ){
          if(session('recom_loan')!=0 &&session('appr_loan')!= 0){
              $counts1 = $this->performance_model->loan_notification_employee(session('emp_id'));
              $counts2 = $this->performance_model->loan_notification_hr();
              $counts3 = $this->performance_model->loan_notification_finance();
              $counts = $counts1+$counts2+$counts3;
               if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
          } elseif(session('recom_loan')!=0) {
              $counts1 = $this->performance_model->loan_notification_hr();
              $counts2 = $this->performance_model->loan_notification_employee(session('emp_id'));
              $counts = $counts1+$counts2;
              if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
          } elseif(session('appr_loan')!=0){
               
              $counts1 = $this->performance_model->loan_notification_employee(session('emp_id'));
              $counts2 = $this->performance_model->loan_notification_finance();
              $counts = $counts1+$counts2;
              if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
          } 
        }else {
              $counts = $this->performance_model->loan_notification_employee(session('emp_id'));
              if($counts>0){
                  echo '<span class="badge bg-red">'.$counts.'</span>'; } else echo "";
        }
       
   }
   
   function allnotifications(Request $request)  {
       
    $counts1 = 0; $counts2 = 0; $counts3 = 0; $countt1 = 0; $countt2 = 0;
        //   FOR TASK NOTIFICATION
    if(session('line')!= 0 ){
           if(session('dotask')== 0){
               $countt1 = $this->performance_model->task_notification_line_manager(session('emp_id'));
               $countt2 = $this->performance_model->task_notification_employee(session('emp_id'));
           } else{
                $countt1 = $this->performance_model->task_notification_line_manager(session('emp_id'));
           }
       } else if(session('line')== 0){
      $countt1 = $this->performance_model->task_notification_employee(session('emp_id'));
      
      }
      $sum2 = $countt1+$countt2;
      
    //   FOR LEAVE NOTIFICATION
     if(session('recomleave')!= 0 ){
          if(session('confleave')!=0){
              $counts1 = $this->attendance_model->leave_notification_employee(session('emp_id'));
              $counts2 = $this->attendance_model->leave_notification_line_manager(session('emp_id'));
              $counts3 = $this->attendance_model->leave_notification_hr();
          } else{
              $counts1 = $this->attendance_model->leave_notification_line_manager(session('emp_id'));
              $counts2 = $this->attendance_model->leave_notification_employee(session('emp_id'));
            } 
      } elseif(session('confleave')!=0){
               
              $counts1 = $this->attendance_model->leave_notification_employee(session('emp_id'));
              $counts2 = $this->attendance_model->leave_notification_hr();
     } else {
              $counts1 = $this->attendance_model->leave_notification_employee(session('emp_id'));
            }
    $sum1 = $counts1+$counts2+$counts3;
    $sum = $sum1+$sum2;
      echo '<span class="badge bg-red">'.$sum.'</span>';
       
   }
 
  public function current_task_progress(Request $request)  {

    if(session('line') != 0 ){
      $data['mytask'] = $this->performance_model->task_staff_current(session('emp_id'));
      $data['othertask'] = $this->performance_model->task_line_manager_current(session('emp_id'));
      $this->performance_model-> update_notification_task_line_manager(session('emp_id'));
      $data['active'] = 1; //Whether The Task is Active or Paused 
      $data['title'] = 'Task';
      $data['tag'] = "Current Task";
       return view('app.task', $data);
    } else {
      $data['mytask'] = $this->performance_model->task_staff_current(session('emp_id'));
      $this->performance_model-> update_notification_task_staff(session('emp_id'));
      $data['active'] = 1; //Whether The Task is Active or Paused 
      $data['title'] = 'Task';
      $data['tag'] = "Current Task";
       return view('app.task', $data);
    }
  }

  public function strategy_dashboard(Request $request)  {
    $strategyStatistics = $this->performance_model->strategy_info(session('current_strategy'));
    foreach ($strategyStatistics as $key) {
      $strategyID = $key->id;
      $strategyTitle = $key->title;
    }
    
    // $this->load->model('reports_model');
    
    $data['appreciated'] =  $this->flexperformance_model->appreciated_employee();
    $data['summary'] =  $this->performance_model->highlights();

    $data['taskline']= $this->performance_model->total_taskline(session('emp_id'));
    $data['taskstaff']= $this->performance_model->total_taskstaff(session('emp_id'));


    // Redirect To HOME
    $data['strategyTitle'] = $strategyTitle;
    $toDate = date('Y-m-d'); 
    $percentToAlert = $this->performance_model-> percentSetting();
    $data["strategyProgress"] = $this->performance_model->strategyProgress($strategyID);
    
    //OUTCOMES
    $data['progressOutcome'] = $this->performance_model-> outcomesProgress($strategyID);
    $data['notStartedOutcome'] = $this->performance_model-> outcomesNotStarted($strategyID, $toDate);
    $data['completedOutcome'] = $this->performance_model-> outcomesCompleted($strategyID);
    $data['overdueOutcome'] = $this->performance_model-> outcomesOverdue($strategyID, $toDate);
    $data['outcomeOffTrack'] = $this->performance_model->outcomeOffTrack($strategyID, $toDate, $percentToAlert);
    $data['outcomeOnTrack'] = $this->performance_model->outcomeOnTrack($strategyID, $toDate, $percentToAlert);
    
    //OUTPUT
    $data['progressOutput'] = $this->performance_model-> outputsProgress($strategyID);
    $data['notStartedOutput'] = $this->performance_model-> outputsNotStarted($strategyID,$toDate );   
    $data['completedOutput'] = $this->performance_model-> outputsCompleted($strategyID);
    $data['overdueOutput'] = $this->performance_model-> outputsOverdue($strategyID, $toDate);
    $data['outputOffTrack'] = $this->performance_model->outputOffTrack($strategyID, $toDate, $percentToAlert);
    $data['outputOnTrack'] = $this->performance_model->outputOnTrack($strategyID, $toDate, $percentToAlert);

    //TASK
    $data['notStartedTask'] = $this->performance_model-> tasksNotStarted($strategyID);
    $data['progressTask'] = $this->performance_model-> tasksProgress($strategyID);
    $data['completedTask'] = $this->performance_model-> tasksCompleted($strategyID);
    $data['overdueTask'] = $this->performance_model-> tasksOverdue($strategyID, $toDate);
    $data['taskOffTrack'] = $this->performance_model->taskOffTrack($strategyID, $toDate, $percentToAlert);
    $data['taskOnTrack'] = $this->performance_model->taskOnTrack($strategyID, $toDate, $percentToAlert);
    
    $data['outcomesGraph'] = $this->performance_model->outcomesGraph($strategyID); 
    $data['outputsGraph'] = $this->performance_model->outputsGraph($strategyID);
    
    $data['title'] = "Strategy_dashboard"; 
     return view('app.strategy_dashboard', $data); 
    
   } 
   
   

  public function outcomeGraph(Request $request)
      {
            $outcomeID = $this->uri->segment(3);
            $response_array['outputsGraph'] = $this->performance_model->outputsGraph($outcomeID);
            $response_array['status'] = "OK";
            header('Content-type: application/json');            
            echo json_encode($response_array);
        
         
      }

  //STRATEGY REPORTS
   
 function printDashboard(Request $request)  {
  //session('current_strateg') 
     $strategyStatistics = $this->performance_model->strategy_info(session('current_strategy'));
        foreach ($strategyStatistics as $key) {
          $strategyID = $key->id;
          $strategyTitle = $key->title;
        }
        
    $percentToAlert = $this->performance_model-> percentSetting();
        
    $toDate = date('Y-m-d'); 
    $data['notStartedOutcome'] = $this->performance_model-> outcomesNotStarted($strategyID, $toDate);
    $data['completedOutcome'] = $this->performance_model-> outcomesCompleted($strategyID);
    $data['progressOutcome'] = $this->performance_model-> outcomesProgress($strategyID);
    
    $data['notStartedOutput'] = $this->performance_model-> outputsNotStarted($strategyID,$toDate );
    $data['progressOutput'] = $this->performance_model-> outputsProgress($strategyID);
    $data['completedOutput'] = $this->performance_model-> outputsCompleted($strategyID);
    
    $data['notStartedTask'] = $this->performance_model-> tasksNotStarted($strategyID);
    $data['progressTask'] = $this->performance_model-> tasksProgress($strategyID);
    $data['completedTask'] = $this->performance_model-> tasksCompleted($strategyID);
    
    $data['title'] = $strategyTitle;
    
    
    //TIME BASED
    
    $data['overdueTask'] = $this->performance_model-> tasksOverdue($strategyID, $toDate);
    $data['taskOffTrack'] = $this->performance_model->taskOffTrack($strategyID, $toDate, $percentToAlert);
    $data['taskOnTrack'] = $this->performance_model->taskOnTrack($strategyID, $toDate, $percentToAlert);
    
    $data['overdueOutcome'] = $this->performance_model-> outcomesOverdue($strategyID, $toDate);
    $data['outcomeOffTrack'] = $this->performance_model->outcomeOffTrack($strategyID, $toDate, $percentToAlert);
    $data['outcomeOnTrack'] = $this->performance_model->outcomeOnTrack($strategyID, $toDate, $percentToAlert);
    
    $data['overdueOutput'] = $this->performance_model-> outputsOverdue($strategyID, $toDate);
    $data['outputOffTrack'] = $this->performance_model->outputOffTrack($strategyID, $toDate, $percentToAlert);
    $data['outputOnTrack'] = $this->performance_model->outputOnTrack($strategyID, $toDate, $percentToAlert);
    
    $data["strategyProgress"] = $this->performance_model->strategyProgress($strategyID);
    
    //TIME BASED
    
    $data['totalOutcome'] = ($this->performance_model-> outcomesNotStarted($strategyID, $toDate)+$this->performance_model-> outcomesCompleted($strategyID)+$this->performance_model-> outcomesProgress($strategyID));
    $data['totalOutput'] = ($this->performance_model-> outputsNotStarted($strategyID,$toDate )+$this->performance_model-> outputsProgress($strategyID)+$this->performance_model-> outputsCompleted($strategyID));
    $data['totalTask'] = ($this->performance_model-> tasksNotStarted($strategyID)+$this->performance_model-> tasksProgress($strategyID)+$this->performance_model-> tasksCompleted($strategyID));
     return view('app.reports/strategy_statistics', $data); 
         
     
 }
   
 function outcome_report(Request $request)  {
     $strategyStatistics = $this->performance_model->strategy_info(session('current_strategy'));
        foreach ($strategyStatistics as $key) {
          $strategyID = $key->id;
          $strategyTitle = $key->title;
        }
        
    $toDate = date('Y-m-d'); 
    $data['outcomeList'] = $this->performance_model-> outcomes($strategyID);
    $data["strategyProgress"] = $this->performance_model->strategyProgress($strategyID);
    $data['title'] = $strategyTitle;
     return view('app.reports/outcome_report', $data); 
     
 }
   
 function output_report(Request $request)  {
     $strategyStatistics = $this->performance_model->strategy_info(session('current_strategy'));
        foreach ($strategyStatistics as $key) {
          $strategyID = $key->id;
          $strategyTitle = $key->title;
        }
        
    $toDate = date('Y-m-d'); 
    $data['outputList'] = $this->performance_model-> output_report($strategyID);
    $data["strategyProgress"] = $this->performance_model->strategyProgress($strategyID);
    $data['title'] = $strategyTitle;
     return view('app.reports/output_report', $data); 
     
 }
   
 function task_report(Request $request)  {
     $strategyStatistics = $this->performance_model->strategy_info(session('current_strategy'));
        foreach ($strategyStatistics as $key) {
          $strategyID = $key->id;
          $strategyTitle = $key->title;
        }
        
    $toDate = date('Y-m-d'); 
    $data['taskList'] = $this->performance_model-> task_report($strategyID);
    $data["strategyProgress"] = $this->performance_model->strategyProgress($strategyID);
    $data['title'] = $strategyTitle;
     return view('app.reports/task_report', $data); 
     
 }

    public function funderInfo(Request $request) {
        $funderId = base64_decode($this->input->get('id'));

        $data['action'] = 1; // O For Addition, 1 For Info and Update
        $data['funder_info'] = $this->performance_model->funderInfo($funderId);
        $data['country_list'] = $this->flexperformance_model->nationality();
        $data['title']="Create New Funder";
         return view('app.funder_info', $data);
    }

    public function updateFunderName(Request $request)  {
        if ($_POST) {
            $funderID = $request->input('funderID');
            $data = array(
                'name' =>trim($request->input('name'))
            );
            $result = $this->performance_model->updateFunder($data, $funderID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>Funder Updated Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>FAILED, Funder Not Registered. Please Try Again</p>";
            }
        }
    }

    public function updateFunderEmail(Request $request)  {
        if ($_POST) {
            $funderID = $request->input('funderID');
            $data = array(
                'email' =>trim($request->input('email'))
            );
            $result = $this->performance_model->updateFunder($data, $funderID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>Funder Updated Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>FAILED, Funder Not Registered. Please Try Again</p>";
            }
        }
    }

    public function updateFunderPhone(Request $request)  {
        if ($_POST) {
            $funderID = $request->input('funderID');
            $data = array(
                'phone' =>trim($request->input('phone'))
            );
            $result = $this->performance_model->updateFunder($data, $funderID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>Funder Updated Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>FAILED, Funder Not Registered. Please Try Again</p>";
            }
        }
    }

    public function updateFunderDescription(Request $request)  {
        if ($_POST) {
            $funderID = $request->input('funderID');
            $data = array(
                'description' =>trim($request->input('description'))
            );
            $result = $this->performance_model->updateFunder($data, $funderID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>Funder Updated Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>FAILED, Funder Not Registered. Please Try Again</p>";
            }
        }
    }

    public function deactivateFunder(Request $request)  {
        header('Content-type: application/json');
        if ($this->uri->segment(3) > 0) {
            $funderID = $this->uri->segment(3);
            $data = array(
                'status' => 2
            );
            $result = $this->performance_model->updateFunder($data, $funderID);
            if($result==true) {
                $response_array['status'] = "OK";
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                echo json_encode($response_array);
            }
        }
    }

    public function deleteSegment(Request $request)  {
        header('Content-type: application/json');
        if ($this->uri->segment(3) > 0) {
            $segmentID = $this->uri->segment(3);

            $result = $this->performance_model->deleteSegment($segmentID);
            if($result==true) {
                $response_array['status'] = "OK";
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                echo json_encode($response_array);
            }
        }
    }

    public function deleteCategory(Request $request)  {
        header('Content-type: application/json');
        if ($this->uri->segment(3) > 0) {
            $categoryID = $this->uri->segment(3);

            $result = $this->performance_model->deleteCategory($categoryID);
            if($result==true) {
                $response_array['status'] = "OK";
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                echo json_encode($response_array);
            }
        }
    }

    public function deleteException(Request $request)  {
        header('Content-type: application/json');
        if ($this->uri->segment(3) > 0) {
            $exceptionID = $this->uri->segment(3);

            $result = $this->performance_model->deleteException($exceptionID);
            if($result==true) {
                $response_array['status'] = "OK";
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                echo json_encode($response_array);
            }
        }
    }








}
