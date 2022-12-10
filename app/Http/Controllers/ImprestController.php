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

class ImprestController extends Controller
{

  // public function __construct(Request $request) {
  //   parent::__construct();

  //   $this->load->model('imprest_model');    
  //   $this->load->helper('url');
  //   $this->load->library('form_validation');
  //   $this->load->library('encryption');
  //    $this->load->library('Pdf');
  //   $this->load->library('user_agent');

  //   date_default_timezone_set('Africa/Dar_es_Salaam');    



  // }

  public function __construct($payroll_model = null, $flexperformance_model = null, $reports_model = null)
  {
    $this->payroll_model = new Payroll;
    $this->reports_model = new ReportModel;
    $this->flexperformance_model = new FlexPerformanceModel;


    // $this->flexperformance_model = new flexperformance_model();

    $this->flexperformance_model = new FlexPerformanceModel();
    $this->imprest_model = new ImprestModel();
    $this->reports_model = new ReportModel();
    $this->attendance_model = new AttendanceModel();
    $this->project_model = new ProjectModel();
    $this->performance_model = new PerformanceModel();
    // $this->load->library('form_validation');

    session('agent', '');
    session('platform', '');
    session('ip_address', '');
  }
  function confirmed_imprest(Request $request)
  {
    $data['imprests'] = $this->imprest_model->confirmedImprests();
    $data['title'] = "Imprest";
    return view('app.confirmed_imprest', $data);
  }

  function imprest(Request $request)
  {

    $data['title'] = "Imprest";
    // $this->load->model('payroll_model');
    $data['my_imprests'] = $this->imprest_model->my_imprests(session('emp_id'));
    // if(session('appr_paym') ||session('mng_paym') ){
    //   if(session('appr_paym')){
    //     $data['other_imprests'] = $this->imprest_model->other_imprests_line_hr(session('emp_id'));
    //   } elseif(session('appr_paym')){
    //   $data['other_imprests'] = $this->imprest_model->other_imprests_line_fin(session('emp_id')); 
    //   } elseif(session('appr_paym')){
    //   $data['other_imprests'] = $this->imprest_model->other_imprests_hr(); 
    //   } elseif(session('appr_paym') ||session('mng_paym')){
    //   $data['other_imprests'] = $this->imprest_model->other_imprests_line(session('emp_id')); 
    //   } elseif(session('appr_paym')){
    //     $data['other_imprests'] = $this->imprest_model->other_imprests_hr(); 
    //   } elseif (session('appr_paym')) {
    //     $data['other_imprests'] = $this->imprest_model->other_imprests_fin();
    //   }     
    // }


    $data['other_imprests'] = $this->imprest_model->othersImprests(session('emp_id'));
    $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();

    return view('app.imprest', $data);
  }

  public function imprest_info(Request $request)
  {
    $imprestID =  base64_decode($this->input->get('id'));

    $data['imprest_details'] =  $this->imprest_model->getImprest($imprestID);
    $data['requirements'] =  $this->imprest_model->getImprestRequirements($imprestID);
    $data['title'] = "Imprest";
    return view('app.imprest_info', $data);
  }


  public function add_imprest_requirement(Request $request)
  {
    $imprestID = $request->input('imprestID');
    $description = trim($request->input('description'));
    $initial_amount = $request->input('initial_amount');
    if (Request::isMethod('post') && $imprestID != '') {
      $database = array(
        'evidence' => '0',
        'status' => 0,
        'imprestID' => $imprestID,
        'description' => $description,
        'initial_amount' => $initial_amount,
        'final_amount' => 0,
        'due_date' => date('Y-m-d')
      );

      $result = $this->imprest_model->add_imprest_requirement($database);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Requirement Added Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Requirement Not Adde Try Again</p>";
      }
    } else {
      echo "<p class='alert alert-info text-center'>Nothing Recorded, Invalid Imprest Reference!</p>";
    }
  }

  public function uploadRequirementEvidence(Request $request)
  {
    if (isset($_POST['confirm']) && $request->input('requirementID') != '') {

      $requirementID = $request->input('requirementID');
      $final_amount = $request->input('final_amount');
      $imprestID = $request->input('imprestID');
      if (empty($_FILES['userfile']['name'])) {
        $updates = array(
          'final_amount' => $final_amount,
          'evidence' => '0',
          'status' => 3
        );
        $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
        if ($result == true) {
          session('note', "<p class='alert alert-success text-center'>Retirement Done Successifully, No Evidence Uploaded</p>");
        } else {
          session('note', "<p class='alert alert-danger text-center'>Retirement Failed, Please try Again</p>");
        }
        $finalID = base64_encode($imprestID);
        return redirect('/flex/imprest/imprest_info/?id=' . $finalID);
      } else {
        $namefile = "evidence_" . $imprestID . "_" . date('YmdHis');
        $config['upload_path'] = './uploads/imprests/';
        $config['file_name'] = $namefile;
        $config['allowed_types'] = 'pdf|jpeg|img|jpg|png';
        $config['overwrite'] = true;

        $this->load->library('upload', $config);
        if ($this->upload->do_upload("userfile")) {
          $data =  $this->upload->data();
          chmod($data["full_path"], 0777);
          $updates = array(
            'evidence' => $data["file_name"],
            'final_amount' => $final_amount,
            'status' => 3
          );
          $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
          if ($result == true) {
            session('note', "<p class='alert alert-success text-center'>Evidence Uploaded Successifully</p>");
          } else {
            session('note', "<p class='alert alert-danger text-center'>Evidence Not Uploaded, Please try Again</p>");
          }
        } else {
          session('note', "<p class='alert alert-danger text-center'>Evidence Not Uploaded, Please try Again</p>");
        }

        $finalID = base64_encode($imprestID);
        return redirect('/flex/imprest/imprest_info/?id=' . $finalID);
      }
    } else {
      echo "INVALID ACCESS</p>";
    }
  }

  public function deleteImprest(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $imprestID = $this->uri->segment(3);

      $result = $this->imprest_model->deleteImprest($imprestID);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Imprest Deleted Successifully</p>";
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED to Delete, Please Try Again!</p>";
      }
      header('Content-type: application/json');
      echo json_encode($response_array);
    }
  }

  public function deleteRequirement(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $requirementID = $this->uri->segment(3);
      $file = $this->imprest_model->getRequirementFile($requirementID);

      $result = $this->imprest_model->removeRequirement($requirementID);
      if ($result == true) {
        if ($file != '0') {
          $path_to_file = './uploads/imprests/' . $file;
          unlink($path_to_file);
        }

        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Requirement Deleted Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED to Delete, Please Try Again!</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      }
    }
  }

  public function approveRequirement(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $requirementID = $this->uri->segment(3);
      $updates = array(
        'status' => 2
      );
      $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Requirement Approved Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED Approve, Please Try Again!</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      }
    }
  }

  public function confirmRequirementRetirement(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $requirementID = $this->uri->segment(3);
      $updates = array(
        'status' => 4
      );
      $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Retirement Confirmed Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED , Please Try Again!</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      }
    }
  }


  public function unconfirmRequirementRetirement(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $requirementID = $this->uri->segment(3);
      $updates = array(
        'status' => 8
      );
      $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Retirement unconfirmed Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED , Please Try Again!</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      }
    }
  }


  public function disapproveRequirement(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $requirementID = $this->uri->segment(3);
      $updates = array(
        'status' => 5
      );
      $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Requirement Disapproved Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED to Disapprove, Please Try Again!</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      }
    }
  }


  public function confirmRequirement(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $requirementID = $this->uri->segment(3);
      $updates = array(
        'status' => 2
      );
      $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Requirement Confirmed Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED to Confirmed, Please Try Again!</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      }
    }
  }

  public function unconfirmRequirement(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $requirementID = $this->uri->segment(3);
      $updates = array(
        'status' => 6
      );
      $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Requirement Unconfirmed Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED to Unconfirmed, Please Try Again!</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
      }
    }
  }

  public function deleteEvidence(Request $request)
  {

    if ($this->uri->segment(3) != '') {
      $requirementID = $this->uri->segment(3);
      $updates = array(
        'status' => 7,
        'final_amount' => 0,
        'evidence' => '0'
      );
      $file = $this->imprest_model->getRequirementFile($requirementID);
      if ($file != "0") {

        $path_to_file = './uploads/imprests/' . $file;
        if (is_writable($path_to_file)) {
          unlink($path_to_file);
          $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
        } else {
          $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
          $message = "<p class='alert alert-danger text-center'>Retirement Cancelled Successifully, Attachment was NOT DELETED</p>";
        }
      } else {
        $result = $this->imprest_model->update_imprest_requirement($updates, $requirementID);
        $message = "<p class='alert alert-danger text-center'>Retirement Cancelled Successifully</p>";
      }

      if ($result == true) {
        echo $message;
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Please Try Again!</p>";
      }
    } else {
      echo "<p class='alert alert-danger text-center'>FAILED, Reference Errors</p>";
    }
  }

  public function updateImprestTitle(Request $request)
  {
    if ($_POST) {

      if ($request->input('imprestID') != '') {

        $imprestID = $request->input('imprestID');
        $updates = array(
          'title' => $request->input('title')
        );
        $result = $this->imprest_model->update_imprest($updates, $imprestID);
        if ($result == true) {
          echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
        } else {
          echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
        }
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Update, Reference Errors</p>";
      }
    }
  }
  public function updateImprestDescription(Request $request)
  {
    if ($_POST) {
      if ($request->input('imprestID') != '') {

        $imprestID = $request->input('imprestID');
        $updates = array(
          'description' => $request->input('description')
        );
        $result = $this->imprest_model->update_imprest($updates, $imprestID);
        if ($result == true) {
          echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
        } else {
          echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
        }
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Update, Reference Errors</p>";
      }
    }
  }
  public function updateImprestDateRange(Request $request)
  {
    if ($_POST) {
      if ($request->input('imprestID') != '') {
        $imprestID = $request->input('imprestID');
        $start = str_replace('/', '-', $request->input('start'));
        $end = str_replace('/', '-', $request->input('end'));

        $dateStart = date('Y-m-d', strtotime($start));
        $dateEnd = date('Y-m-d', strtotime($end));
        $date_today = date('Y-m-d');

        if ($dateEnd < $dateStart) {
          echo "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
        } else {
          $updates = array(
            'start' => $dateStart,
            'end' => $dateEnd
          );
          $result = $this->imprest_model->update_imprest($updates, $imprestID);
          if ($result == true) {
            echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
          } else {
            echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
          }
        }
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Update, Reference Errors</p>";
      }
    }
  }

  public function update_imprestRequirement(Request $request)
  {

    if (isset($_POST['update']) && $request->input('imprestID') != '') {
      $imprestID = $request->input('imprestID');
      $requirementID = $request->input('requirementID');
      $updates = array(
        'description' => $request->input('description'),
        'initial_amount' => $request->input('initial_amount')
      );

      $result =  $this->imprest_model->update_imprest_requirement($updates, $requirementID);
      if ($result) {
        session('note', "<p class='alert alert-success text-center'>Updated Successifully</p>");
        $finalID = base64_encode($imprestID);
        return redirect('/flex/imprest/imprest_info/?id=' . $finalID);
      } else {

        session('note', "<p class='alert alert-success text-danger'>FAILED to Update</p>");
        $finalID = base64_encode($imprestID);
        return redirect('/flex/imprest/imprest_info/?id=' . $finalID);
      }
    }
  }


  public function confirmImprest(Request $request)
  {

    if ($this->uri->segment(3) != '') {
      $imprestID  = $this->uri->segment(3);
      $initial = $this->imprest_model->getInitialRequirementCost($imprestID);
      $empID = $this->imprest_model->getEmployee($imprestID);
      // $final = $this->imprest_model->getFinalRequirementCost($imprestID);
      if ($initial > 0) {
        $initial_amount = $this->imprest_model->getInitialRequirementCost($imprestID);
      } else $initial_amount = 0;
      // if($final>0){
      //   $final_amount = $this->imprest_model->getFinalRequirementCost($imprestID); 
      // } else $final_amount = 0;

      $data = array(
        'imprestID' => $imprestID,
        'initial' => $initial_amount,
        'empID' => $empID,
        'status' => 0,
        'date_confirmed' => date('Y-m-d'),
        'date_resolved' => date('Y-m-d'),
        'final' => 0
      );
      $updates = array(
        'date_confirmed' => date('Y-m-d'),
        'confirmed_by' => session('emp_id'),
        'status' => 3
      );
      $result = $this->imprest_model->confirmImprest($updates, $data, $imprestID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Confirmed Successifully</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Confirmed, Please Try Again!</p>";
      }
    }
  }


  public function unconfirmImprest(Request $request)
  {

    if ($this->uri->segment(3) != '') {
      $imprestID  = $this->uri->segment(3);
      $result = $this->imprest_model->unconfirmImprest($imprestID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Imprest Unconfirmed Successifully</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Unconfirmed, Please Try Again!</p>";
      }
    }
  }

  public function confirmImprestRetirement(Request $request)
  {

    if ($this->uri->segment(3) != '') {
      $imprestID  = $this->uri->segment(3);
      $final = $this->imprest_model->getFinalRequirementCost($imprestID);

      if ($final > 0) {
        $final_amount = $this->imprest_model->getFinalRequirementCost($imprestID);
      } else $final_amount = 0;

      $dateConfirmed =   date('Y-m-d');
      $result = $this->imprest_model->updateConfirmedImprest2($final_amount, $dateConfirmed, $imprestID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>RETIREMENT Confirmed Successifully</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
      }
    }
  }


  public function resolveImprest(Request $request)
  {
    if ($this->uri->segment(3) != '') {
      // $this->load->model('flexperformance_model');
      $imprestID = $this->uri->segment(3);
      $initial = $this->imprest_model->getInitialConfirmedCost($imprestID);
      $empID = $this->imprest_model->getConfirmedEmployee($imprestID);
      $final = $this->imprest_model->getFinalConfirmedCost($imprestID);
      $updates = array(
        'status' => 1
      );

      if ($initial < $final) {
        $refund = $final - $initial;
        $data = array(
          'empID' => $empID,
          'amount' => $refund,
          'name' => 12,
          'init_author' => session('emp_id'),
          'appr_author' => session('emp_id'),
          'state' => 1
        );
        $result = $this->flexperformance_model->addToBonus($data);
        if ($result == true) {
          $this->imprest_model->updateConfirmedImprest($updates, $imprestID);
          echo "<p class='alert alert-success text-center'>Imprest Resolved Successifully</p>";
        } else {
          echo "<p class='alert alert-danger text-center'>FAILED to Resolved, Please Try Again!</p>";
        }
      } elseif ($initial > $final) {
        $refund = $initial - $final;
        $data = array(
          'empID' => $empID,
          'description' => "Imprest Refund",
          'policy' => "Fixed Amount",
          'paid' => $refund,
          'payment_date' => date('Y-m-d')
        );
        $result = $this->imprest_model->addImprestDeduction($data);
        if ($result == true) {
          $this->imprest_model->updateConfirmedImprest($updates, $imprestID);
          echo "<p class='alert alert-success text-center'>Request Submitted Successifully</p>";
        } else {
          echo "<p class='alert alert-warning text-center'>Request FAILED, Please Try Again</p>";
        }
      } else {
        $this->imprest_model->updateConfirmedImprest($updates, $imprestID);
        echo "<p class='alert alert-success text-center'>Imprest Resolved Successifully</p>";
      }
    }
  }

  public function recommendImprest(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $imprestID = $this->uri->segment(3);
      $data = array(
        'status' => 1,
        'recommended_by' => session('emp_id'),
        'date_recommended' => date('Y-m-d')
      );
      $result = $this->imprest_model->update_imprest($data, $imprestID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Imprest Recommended Successifully</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Recommend Please Try Again!</p>";
      }
    }
  }




  public function hr_recommendImprest(Request $request)
  {

    if ($this->uri->segment(3) != '') {

      $imprestID = $this->uri->segment(3);
      $data = array(
        'status' => 9,
        'hr_recommend' => session('emp_id'),
        'date_hr_recommend' => date('Y-m-d')
      );
      $result = $this->imprest_model->update_imprest($data, $imprestID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Imprest Recommended Successifully</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Recommend Please Try Again!</p>";
      }
    }
  }


  public function holdImprest()
  {

    if ($this->uri->segment(3) != '') {

      $imprestID = $this->uri->segment(3);
      $data = array(
        'status' => 3,
        'recommended_by' => session('emp_id'),
        'date_recommended' => date('Y-m-d')
      );
      $result = $this->imprest_model->update_imprest($data, $imprestID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Imprest Held Successifully</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Please Try Again!</p>";
      }
    }
  }

  public function approveImprest(Request $request)
  {
    if ($this->uri->segment(3) != '') {


      $imprestID = $this->uri->segment(3);
      $data = array(
        'status' => 2,
        'approved_by' => session('emp_id'),
        'date_approved' => date('Y-m-d')
      );
      $result = $this->imprest_model->update_imprest($data, $imprestID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Imprest Approved Successifully</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Approve, Please Try Again!</p>";
      }
    }
  }

  public function disapproveImprest(Request $request)
  {
    if ($this->uri->segment(3) != '') {


      $imprestID = $this->uri->segment(3);
      $data = array(
        'status' => 5,
        'approved_by' => session('emp_id'),
        'date_approved' => date('Y-m-d')
      );
      $result = $this->imprest_model->update_imprest($data, $imprestID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Imprest Disapproved Successifully</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED to Disapprove, Please Try Again!</p>";
      }
    }
  }

  public function requestImprest(Request $request)
  {
    if ($_POST) {

      $start = str_replace('/', '-', $request->input('start'));
      $end = str_replace('/', '-', $request->input('end'));

      $dateStart = date('Y-m-d', strtotime($start));
      $dateEnd = date('Y-m-d', strtotime($end));
      $date_today = date('Y-m-d');

      if ($dateStart < $date_today || $dateEnd <= $dateStart) {
        echo "<p class='alert alert-danger text-center'>Please Choose The Appropriate Date</p>";
      } else {

        $data = array(
          'title' => $request->input('title'),
          'description' => $request->input('description'),
          'empID' => session('emp_id'),
          'start' => $dateStart,
          'end' => $dateEnd,
          'date_recommended' => $date_today,
          'date_approved' => $date_today,
          'application_date' => $date_today,
          'date_confirmed' => date('Y-m-d'),
          'status' => 0

        );
        $result = $this->imprest_model->requestImprest($data);
        if ($result == true) {
          $id = $this->imprest_model->getRecentImprest(session('emp_id'));
          $response_array['status'] = "OK";
          $response_array['id'] = base64_encode($id);
          header('Content-type: application/json');
          echo json_encode($response_array);
        } else {
          $response_array['status'] = "ERR";
          $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED to Send the Request, Please Try Again!</p>";
          header('Content-type: application/json');
          echo json_encode($response_array);
        }
      }
    }
  }
}
