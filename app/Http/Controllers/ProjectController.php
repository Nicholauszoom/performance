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
use App\Helpers\SysHelpers;
use App\Models\PerformanceModel;

class ProjectController extends Controller
{

  // public function __construct(Request $request)
  // {
  //   parent::__construct();

  //   $this->load->model('flexperformance_model');
  //   $this->load->model('performance_model');
  //   $this->load->model('imprest_model');
  //   $this->load->model('payroll_model');
  //   $this->load->model('reports_model');
  //   $this->load->model('attendance_model');
  //   $this->load->model('project_model');
  //   $this->load->helper('url');
  //   $this->load->library('form_validation');
  //   $this->load->library('Pdf');
  //   date_default_timezone_set('Africa/Dar_es_Salaam');

  //   if (session('emp_id') == '') {
  //     session('error', 'Sorry! You Have to Login Before any Attempt');
  //     redirect(base_url() . "index.php/base_controller/", 'refresh');
  //   }
  // }


  public function __construct($payroll_model = null, $flexperformance_model = null, $reports_model = null)
  {
    $this->payroll_model = new Payroll;
    $this->reports_model = new ReportModel;
    $this->flexperformance_model = new FlexPerformanceModel;


    // $this->flexperformance_model = new flexperformance_model();
    $this->performance_model = new FlexPerformanceModel();
    $this->imprest_model = new ImprestModel();
    $this->reports_model = new ReportModel();
    $this->attendance_model = new AttendanceModel();
    $this->project_model = new ProjectModel();
    // $this->load->library('form_validation');

    session('agent', '');
    session('platform', '');
    session('ip_address', '');
  }

  public function index(Request $request)
  {
    if (session('vw_proj') || session('mng_proj')) {


      $data['projects'] = $this->project_model->allProjects();
      //$projects = $this->project_model->allProjects();
      //       $result = null;
      //       foreach($projects as $key=>$value){

      //         $result[$key][$value->name]= $this->project_model->getAllDeliverable($value->id);
      //         foreach($result[$key][$value->name] as $key2=>$value2){

      //           $result[$key][$value->name][$value2->name] = $this->project_model->getAllActivity($value2->id);
      //         }
      //       }

      // echo json_encode($result);

      //     }


      $data['allocations'] = $this->project_model->getProjectAllocations();
      //       $data['allocations'] = $this->project_model->getProjectAllocationsByLineManager(session('username'));
      $data['grants'] = $this->project_model->allGrants();
      $data['activities'] = $this->project_model->allActivities();
      $data['employee'] =  $this->payroll_model->customemployee();
      $data['assignments'] = $this->project_model->myAssignmentsAll(session('emp_id'));
      $data['categories'] = $this->performance_model->getExpenseCategory();
    } else {
      $data['projects'] = $this->project_model->myProjects(session('emp_id'));
      $data['allocations'] = $this->project_model->myProjectAllocations(session('emp_id'));
      $data['activities'] = $this->project_model->myActivities(session('emp_id'));
      $data['assignments'] = $this->project_model->myAssignmentsAll(session('emp_id'));
      $data['categories'] = $this->performance_model->getExpenseCategory();
    }
    $data['title'] = "Project";
    return view('app.project', $data);
  }

  public function employeeTotalPercentAllocation(Request $request)
  {
    $data = $this->project_model->employeeAllocationPercentage($request->input("projectCode"));
    echo json_encode($data);
  }

  public function employeeRellocation(Request $request)
  {
    if ($_POST) {
      header('Content-type: application/json');
      if (strtoupper(trim($request->input('percent'))) == 0) {
        $data = array(
          'empID' => $request->input('emp_id'),
          'row_id' => strtoupper(trim($request->input('row_id'))),
          'percent' => 0,
          'activity' => $request->input('activity_code'),
          'remaining' => strtoupper(trim($request->input('remaining_percent'))),
          'active' => 0
        );
      } else {
        $data = array(
          'empID' => $request->input('emp_id'),
          'row_id' => strtoupper(trim($request->input('row_id'))),
          'percent' => strtoupper(trim($request->input('percent'))),
          'activity' => $request->input('activity_code'),
          'remaining' => strtoupper(trim($request->input('remaining_percent'))),
          'active' => 1
        );
      }


      $remaining_percent = trim($request->input('remaining_percent')) - trim($request->input('percent'));

      /*if > 0 put to default*/
      if ($remaining_percent > 0) {
        //check default allocation
        $data_update = array(
          'empID' => $request->input('emp_id'),
          'percent' => $remaining_percent,
          'remaining' => $remaining_percent,
          'active' => 1
        );
      } else {
        $data_update = array(
          'empID' => $request->input('emp_id'),
          'percent' => $remaining_percent,
          'remaining' => $remaining_percent,
          'active' => 0
        );
      }

      $has_default_allocation = $this->project_model->checkDefaultAllocation($request->input('emp_id'));

      if ($has_default_allocation) {
        $this->project_model->updateDefaultAllocationPercentage($data_update);
      } else {
        $data_default = array(
          'empID' => $request->input('emp_id'),
          'activity_code' => 'AC0018',
          'grant_code' => 'VSO',
          'percent' => $remaining_percent,
          'isActive' => 1
        );
        $this->project_model->insertDefault($data_default);
      }

      $this->project_model->updateAllocationActivity($data);

      echo json_encode('success');
    }
  }

  public function fetchActivity(Request $request)
  {
    if (!empty($request->input("projectCode"))) {
      $activities = $this->project_model->fetchActivities($request->input("projectCode"));

      foreach ($activities as $rows) {
        echo "<option value=''>Select Activity</option><option value='" . $rows->code . "'>" . $rows->code . "</option>";
      }
    } else {
      echo '<option value="">Activity not available</option>';
    }
  }

  public function fetchGrant(Request $request)
  {
    if (!empty($request->input("activityCode"))) {
      $grants = $this->project_model->fetchGrants($request->input("activityCode"));

      foreach ($grants as $rows) {
        echo "<option value=''>Select Grant</option><option value='" . $rows->grant_code . "'>" . $rows->grant_code . "</option>";
      }
    } else {
      echo '<option value="">Grants Not available</option>';
    }
  }

  public function fetchEmployee(Request $request)
  {
    if (!empty($request->input("activityCode"))) {
      $employees = $this->project_model->fetchActivityEmployee($request->input("activityCode"));
      echo json_encode($employees);
    }
  }

  public function newProject(Request $request)
  {
    $data['action'] = 0; // O For Addition, 1 For Info and Update
    $data['segments'] = $this->performance_model->getProjectSegment();
    $data['funders'] = $this->performance_model->getFunders();
    $data['employees'] = $this->performance_model->projectManager();
    $data['title'] = "Create New Project";
    return view('app.project_info', $data);
  }


  public function addProject(Request $request)
  {
    if ($_POST) {
      if ($request->input('start_date') != '') {
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('start_date'))));
      } else {
        $start_date = null;
      }
      if ($request->input('end_date') != '') {
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('end_date'))));
      } else {
        $end_date = null;
      }

      $data = array(
        'name' => trim($request->input('name')),
        'code' => trim($request->input('code')),
        'cost' => trim($request->input('cost')),
        'target' => trim($request->input('target')),
        'description' => trim($request->input('description')),
        'project_segment' => trim($request->input('segment')),
        'managed_by' => $request->input('managed_by'),
        'start_date' => $start_date,
        'end_date' => $end_date,
      );

      //upload file
      $config['upload_path'] = 'uploads/';
      $config['allowed_types'] = '*';
      $config['max_filename'] = '255';
      $config['encrypt_name'] = TRUE;
      $config['max_size'] = '30024'; //1 MB

      if (isset($_FILES['file']['name'])) {
        if (0 < $_FILES['file']['error']) {
          //no file
        } else {
          if (file_exists('uploads/' . $_FILES['file']['name'])) {
            //file exists
          } else {
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
              echo $this->upload->display_errors();
            } else {
              //file successfully
              $file_info = $this->upload->data();
              $data['document'] = $file_info['file_name'];
            }
          }
        }
      }

      $result = $this->project_model->addProject($data);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Project Registered Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Project Not Registered. Please Try Again</p>";
      }
    }
  }

  public function evaluateEmployee(Request $request)
  {
    $pattern = $request->input('id');
    $values = explode('|', $pattern);
    $empID = $values[0];
    $departmentID = $values[1];

    $deliverableId = base64_decode($this->input->get('deliverableId'));

    $data['action'] = 1; // O For Addition, 1 For Info and Update  
    $data['empID'] = $empID;
    $data['activities'] = $this->project_model->getAllActivityByEmployeeID($empID);
    $data['departmentID'] = $departmentID;
    $data['funders'] = $this->performance_model->getFunders();
    $data['segments'] = $this->performance_model->getProjectSegment();
    $data['employees'] = $this->performance_model->projectManager();
    $data['title'] = "Ecaluation";
    return view('app.employee_evaluation', $data);
  }
  public function addEvaluationResults(Request $request)
  {
    $pattern = $request->input('id');
    $values = explode('|', $pattern);
    $empID = $values[0];
    $departmentID = $values[1];
    $activity_id = $values[1];

    $deliverableId = base64_decode($this->input->get('deliverableId'));

    $data['action'] = 1; // O For Addition, 1 For Info and Update  
    $data['empID'] = $empID;
    $data['activity_id'] = $activity_id;
    $data['activities'] = $this->project_model->getAllActivityByEmployeeID($empID);
    $data['departmentID'] = $departmentID;
    $data['funders'] = $this->performance_model->getFunders();
    $data['segments'] = $this->performance_model->getProjectSegment();
    $data['employees'] = $this->performance_model->projectManager();
    $data['title'] = "Ecaluation";
    return view('app.employee_evaluation_result', $data);
  }

  public function printPerformance(Request $request)
  {
    $id = $request->input('id');

    $data['basic_info'] = $this->project_model->getEmpInfoById($id);
    $data['line_manager'] = $this->project_model->getEmpInfoById($data['basic_info']->line_manager);
    $data['department'] = $this->project_model->getDepInfoById($data['basic_info']->department);

    $data['activity_result'] = $this->project_model->getAllActivityResultByEmployeeID($id);

    $data['Project_name'] = $this->project_model->getProjectById(1);

    $data['employees'] = $this->performance_model->projectManager();
    $data['title'] = "Create New Project";
    return view('app.reports/performance_report', $data);
  }

  public function saveActivityResult(Request $request)
  {
    if ($_POST) {
      if ($request->input('start_date') != '') {
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('start_date'))));
      } else {
        $start_date = null;
      }
      if ($request->input('end_date') != '') {
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('end_date'))));
      } else {
        $end_date = null;
      }
      $department = trim($request->input('empID'));
      $empID = trim($request->input('empID'));




      $id = trim($request->input('empID'));

      $activity_id = trim($request->input('activity_id'));
      $activity = $this->project_model->getActivityByID($activity_id);

      $data = array(
        'state' => 0
      );
      $result = $this->project_model->updateActivity($data, $activity->id);


      $data = array(
        'name' => $activity->name,
        'deliverable_id' => $activity->deliverable_id,
        'cost' => $activity->cost,

        'exactly_cost' => $request->input('exactly_cost'),
        'activity_id' => $activity->id,
        'result' => $request->input('result'),
        'emp_id' => $activity->managed_by,

        'target' => $activity->target,
        'description' => $activity->description,
        'managed_by' => $activity->managed_by,
        'start_date' => $activity->start_date,
        'end_date' => $activity->end_date,
      );

      //upload file
      $config['upload_path'] = 'uploads/';
      $config['allowed_types'] = '*';
      $config['max_filename'] = '255';
      $config['encrypt_name'] = TRUE;
      $config['max_size'] = '30024'; //1 MB

      if (isset($_FILES['file']['name'])) {
        if (0 < $_FILES['file']['error']) {
          //no file
        } else {
          if (file_exists('uploads/' . $_FILES['file']['name'])) {
            //file exists
          } else {
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
              echo $this->upload->display_errors();
            } else {
              //file successfully
              $file_info = $this->upload->data();
              $data['document'] = $file_info['file_name'];
            }
          }
        }
      }

      $result = $this->project_model->addActivityResult($data);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Activity Registered Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Activity Not Registered. Please Try Again</p>";
      }
    }
  }

  public function saveActivity(Request $request)
  {
    if ($_POST) {
      if ($request->input('start_date') != '') {
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('start_date'))));
      } else {
        $start_date = null;
      }
      if ($request->input('end_date') != '') {
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('end_date'))));
      } else {
        $end_date = null;
      }
      //$id = trim($request->input('projectID'));
      $data = array(
        'name' => trim($request->input('name')),
        'deliverable_id' => trim($request->input('deliverableID')),
        'cost' => trim($request->input('cost')),
        'target' => trim($request->input('target')),
        'description' => trim($request->input('description')),
        'managed_by' => $request->input('managed_by'),
        'start_date' => $start_date,
        'end_date' => $end_date,
      );

      //upload file
      $config['upload_path'] = 'uploads/';
      $config['allowed_types'] = '*';
      $config['max_filename'] = '255';
      $config['encrypt_name'] = TRUE;
      $config['max_size'] = '30024'; //1 MB

      if (isset($_FILES['file']['name'])) {
        if (0 < $_FILES['file']['error']) {
          //no file
        } else {
          if (file_exists('uploads/' . $_FILES['file']['name'])) {
            //file exists
          } else {
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
              echo $this->upload->display_errors();
            } else {
              //file successfully
              $file_info = $this->upload->data();
              $data['document'] = $file_info['file_name'];
            }
          }
        }
      }

      $result = $this->project_model->addActivity($data);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Activity Registered Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Activity Not Registered. Please Try Again</p>";
      }
    }
  }

  public function saveDeliverable(Request $request)
  {
    if ($_POST) {
      if ($request->input('start_date') != '') {
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('start_date'))));
      } else {
        $start_date = null;
      }
      if ($request->input('end_date') != '') {
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('end_date'))));
      } else {
        $end_date = null;
      }
      //$id = trim($request->input('projectID'));
      $data = array(
        'name' => trim($request->input('name')),
        'project_id' => trim($request->input('projectID')),
        'cost' => trim($request->input('cost')),
        'target' => trim($request->input('target')),
        'description' => trim($request->input('description')),
        'managed_by' => $request->input('managed_by'),
        'start_date' => $start_date,
        'end_date' => $end_date,
      );

      //upload file
      $config['upload_path'] = 'uploads/';
      $config['allowed_types'] = '*';
      $config['max_filename'] = '255';
      $config['encrypt_name'] = TRUE;
      $config['max_size'] = '30024'; //1 MB

      if (isset($_FILES['file']['name'])) {
        if (0 < $_FILES['file']['error']) {
          //no file
        } else {
          if (file_exists('uploads/' . $_FILES['file']['name'])) {
            //file exists
          } else {
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
              echo $this->upload->display_errors();
            } else {
              //file successfully
              $file_info = $this->upload->data();
              $data['document'] = $file_info['file_name'];
            }
          }
        }
      }

      $result = $this->project_model->addDeliverable($data);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Deliverable Registered Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Deliverable Not Registered. Please Try Again</p>";
      }
    }
  }

  public function updateProject(Request $request)
  {
    if ($_POST) {
      if ($request->input('start_date') != '') {
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('start_date'))));
      } else {
        $start_date = null;
      }
      if ($request->input('end_date') != '') {
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('end_date'))));
      } else {
        $end_date = null;
      }

      $id = trim($request->input('projectID'));
      if ($request->input('code')) {
        $data = array(
          'name' => trim($request->input('name')),
          'code' => trim($request->input('code')),
          'cost' => trim($request->input('cost')),
          'target' => trim($request->input('target')),
          'description' => trim($request->input('description')),
          'project_segment' => trim($request->input('segment')),
          'managed_by' => $request->input('managed_by'),
          'start_date' => $start_date,
          'end_date' => $end_date,
        );
      } else {
        $data = array(
          'name' => trim($request->input('name')),
          'cost' => trim($request->input('cost')),
          'target' => trim($request->input('target')),
          'description' => trim($request->input('description')),
          'project_segment' => trim($request->input('segment')),
          'managed_by' => $request->input('managed_by'),
          'start_date' => $start_date,
          'end_date' => $end_date,
        );
      }

      //upload file
      $config['upload_path'] = 'uploads/';
      $config['allowed_types'] = '*';
      $config['max_filename'] = '255';
      $config['encrypt_name'] = TRUE;
      $config['max_size'] = '30024'; //1 MB

      if (isset($_FILES['file']['name'])) {
        if (0 < $_FILES['file']['error']) {
          //no file
        } else {
          if (file_exists('uploads/' . $_FILES['file']['name'])) {
            //file exists
          } else {
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
              echo $this->upload->display_errors();
            } else {
              //file successfully
              $file_info = $this->upload->data();
              $data['document'] = $file_info['file_name'];
            }
          }
        }
      }

      $result = $this->project_model->updateProject($data, $id);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Project Registered Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Project Not Registered. Please Try Again</p>";
      }
    }
  }
  public function editProject(Request $request)
  {
    $projectId = base64_decode($this->input->get('code'));

    $data['action'] = 1; // O For Addition, 1 For Info and Update  
    $data['project_info'] = $this->project_model->projectInfo($projectId);
    $data['employee'] = $this->project_model->projectInfoManager($projectId);
    $data['funders'] = $this->performance_model->getFunders();
    $data['segments'] = $this->performance_model->getProjectSegment();
    $data['employees'] = $this->performance_model->projectManager();
    $data['title'] = "Create New Project";
    return view('app.edit_project', $data);
  }


  public function projectInfo(Request $request)
  {
    $projectId = base64_decode($this->input->get('code'));

    $data['action'] = 1; // O For Addition, 1 For Info and Update  
    $data['project_info'] = $this->project_model->projectInfo($projectId);
    $data['deliverables'] = $this->project_model->getAllDeliverable($projectId);
    $data['employee'] = $this->project_model->projectInfoManager($projectId);
    $data['funders'] = $this->performance_model->getFunders();
    $data['segments'] = $this->performance_model->getProjectSegment();
    $data['employees'] = $this->performance_model->projectManager();
    $data['title'] = "Create New Project";
    return view('app.project_info', $data);
  }
  public function deliverableInfo(Request $request)
  {
    $deliverableId = base64_decode($this->input->get('deliverableId'));

    $data['action'] = 1; // O For Addition, 1 For Info and Update  
    $data['deliverable_info'] = $this->project_model->deliverableInfo($deliverableId);
    $data['activities'] = $this->project_model->getAllActivity($deliverableId);
    $data['employee'] = $this->project_model->projectInfoManager($deliverableId);
    $data['funders'] = $this->performance_model->getFunders();
    $data['segments'] = $this->performance_model->getProjectSegment();
    $data['employees'] = $this->performance_model->projectManager();
    $data['title'] = "Deliverable Info";
    return view('app.deliverable_info', $data);
  }

  public function updateProjectName(Request $request)
  {
    if ($_POST) {
      $projectID = $request->input('projectID');
      $data = array(
        'name' => trim($request->input('name'))
      );
      $result = $this->project_model->updateProject($data, $projectID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Project Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Project Not Registered. Please Try Again</p>";
      }
    }
  }

  public function updateProjectCode(Request $request)
  {
    if ($_POST) {
      $projectID = $request->input('projectID');
      $data = array(
        'code' => trim($request->input('code'))
      );
      $result = $this->project_model->updateProject($data, $projectID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Project Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Project Not Registered. Please Try Again</p>";
      }
    }
  }

  public function updateProjectDescription(Request $request)
  {
    if ($_POST) {
      $projectID = $request->input('projectID');
      $data = array(
        'description' => trim($request->input('description'))
      );
      $result = $this->project_model->updateProject($data, $projectID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Project Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Project Not Registered. Please Try Again</p>";
      }
    }
  }
  public function newGrant(Request $request)
  {
    $data['action'] = 0; // O For Addition, 1 For Info and Update
    $data['funders'] = $this->performance_model->getFunders();
    $data['title'] = "Create New Grant";
    return view('app.grant_info', $data);
  }

  public function addGrant(Request $request)
  {
    if ($_POST) {
      $data = array(
        'name' => trim($request->input('name')),
        'code' => strtoupper(trim($request->input('code'))),
        'description' => trim($request->input('description')),
        'funder' => $request->input('funder'),
        'amount' => $request->input('amount')
      );
      $result = $this->project_model->addGrant($data);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Grant Registered Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Grant Not Registered. Please Try Again</p>";
      }
    }
  }

  public function grantInfo(Request $request)
  {
    $grantId = base64_decode($this->input->get('grantCode'));

    $data['action'] = 1; // O For Addition, 1 For Info and Update  
    $data['grant_info'] = $this->project_model->grantInfo($grantId);
    $data['funders'] = $this->performance_model->getFunders();
    $data['title'] = "Grant Info";
    return view('app.grant_info', $data);
  }

  public function updateGrantName(Request $request)
  {
    if ($_POST) {
      $grantID = $request->input('grantID');
      $data = array(
        'name' => trim($request->input('name'))
      );
      $result = $this->project_model->updateGrant($data, $grantID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Grant Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Grant Not Registered. Please Try Again</p>";
      }
    }
  }

  public function updateGrantCode(Request $request)
  {
    if ($_POST) {
      $grantID = $request->input('grantID');
      $data = array(
        'code' => trim($request->input('code'))
      );
      $result = $this->project_model->updateGrant($data, $grantID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Grant Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Grant Not Registered. Please Try Again</p>";
      }
    }
  }

  public function updateGrantDescription(Request $request)
  {
    if ($_POST) {
      $grantID = $request->input('grantID');
      $data = array(
        'description' => trim($request->input('description'))
      );
      $result = $this->project_model->updateGrant($data, $grantID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Grant Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Grant Not Registered. Please Try Again</p>";
      }
    }
  }

  public function newActivity(Request $request)
  {
    $data['action'] = 0; // O For Addition, 1 For Info and Update  
    $data['title'] = "Create New Activity";
    $data['projects'] = $this->project_model->allProjects();
    $data['grants'] = $this->project_model->allGrants();
    return view('app.activity_info', $data);
  }

  public function addActivity(Request $request)
  {
    if ($_POST) {
      $activityCode = strtoupper(trim($request->input('code')));
      $checkExistance = $this->project_model->checkExistance($activityCode);
      if ($checkExistance > 0) {
        echo "<p class='alert alert-danger text-center'>Activity Not Registered. The Code Provided is Already Assigned to Another Project, Try Another Code</p>";
      } else {
        $activityData = array(
          'name' => trim($request->input('name')),
          'code' => $activityCode,
          'project_ref' => strtoupper(trim($request->input('project'))),
          'description' => trim($request->input('description'))
        );
        $grantData = array(
          'activity_code' => strtoupper(trim($request->input('code'))),
          'grant_code' => trim($request->input('grant'))
        );
        $result = $this->project_model->addActivity($activityData, $grantData);
        if ($result == true) {
          echo "<p class='alert alert-success text-center'>Activity Registered Successifully!</p>";
        } else {
          echo "<p class='alert alert-danger text-center'>FAILED, Activity Not Registered. Please Try Again</p>";
        }
      }
    }
  }

  public function activityInfo(Request $request)
  {
    $activityId = base64_decode($this->input->get('activityCode'));

    $data['action'] = 1; // O For Addition, 1 For Info and Update  
    $data['activity_info'] = $this->project_model->activityInfo($activityId);
    $data['grants'] = $this->project_model->activeGrants($activityId);
    $data['activity_grants'] = $this->project_model->activityGrants($activityId);
    $data['title'] = "Activity Info";
    return view('app.activity_info', $data);
  }

  public function updateActivityName(Request $request)
  {
    if ($_POST) {
      $activityID = $request->input('activityID');
      $data = array(
        'name' => trim($request->input('name'))
      );
      $result = $this->project_model->updateActivity($data, $activityID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Activity Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Activity Not Registered. Please Try Again</p>";
      }
    }
  }

  public function updateActivityCode(Request $request)
  {
    if ($_POST) {
      $activityID = $request->input('activityID');
      $data = array(
        'code' => strtoupper(trim($request->input('code')))
      );
      $result = $this->project_model->updateActivity($data, $activityID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Activity Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Activity Not Registered. Please Try Again</p>";
      }
    }
  }


  public function allocateGrantToActivity(Request $request)
  {
    if ($_POST) {
      $data = array(
        'activity_code' => strtoupper(trim($request->input('activityCode'))),
        'grant_code' => strtoupper(trim($request->input('grantCode')))
      );
      $result = $this->project_model->allocateGrantToActivity($data);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Grant Allocated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Grant NotAllocated. Please Try Again</p>";
      }
    }
  }

  public function updateActivityDescription(Request $request)
  {
    if ($_POST) {
      $activityID = $request->input('activityID');
      $data = array(
        'description' => trim($request->input('description'))
      );
      $result = $this->project_model->updateActivity($data, $activityID);
      if ($result == true) {
        echo "<p class='alert alert-success text-center'>Activity Updated Successifully!</p>";
      } else {
        echo "<p class='alert alert-danger text-center'>FAILED, Activity Not Registered. Please Try Again</p>";
      }
    }
  }
  public function allocateActivity(Request $request)
  {
    if ($_POST) {
      header('Content-type: application/json');
      $data = array(
        'empID' => $request->input('employee'),
        'activity_code' => strtoupper(trim($request->input('activity'))),
        'grant_code' => strtoupper(trim($request->input('grant'))),
        'percent' => trim($request->input('percent'))
      );
      $duplicates = $this->project_model->checkDuplicateAllocation($request->input('activity'), $request->input('employee'), strtoupper(trim($request->input('grant'))));
      $percentAlreadyAllocated = $this->project_model->checkEmployeeTotalPercentAllocation($request->input('employee'));

      if ($duplicates > 0) {

        $response_array['status'] = "ERR_DUP";
        //      $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED, The Employee is Already Assigned This Activity. Please Try Another Activity</p>";
        echo json_encode($response_array);
      } elseif ($percentAlreadyAllocated >= 100) {
        //        /*check the available default allocation*/
        $default_allocation = $this->project_model->employeeDefaultAvailablePercentage($request->input('employee'));
        //allocated exceed the default pool percent
        if (trim($request->input('percent')) > $default_allocation) {
          $response_array['status'] = "ERR_EXCEED";
          echo json_encode($response_array);
        } else {
          //                if less, minus, and the remaining one goes to default
          $remaining_default = $default_allocation - trim($request->input('percent'));
          //              before inserting check if that record is in active
          $present_allocation_record = $this->project_model->inactiveAllocation($request->input('activity'), $request->input('employee'), strtoupper(trim($request->input('grant'))));

          if ($present_allocation_record) {
            $update_allocation_data = array(
              'row_id' => $present_allocation_record,
              'percent' => trim($request->input('percent')),
              'remaining' => strtoupper(trim($request->input('remaining_percent'))),
              'active' => 1
            );

            $this->project_model->updateAllocationActivity($update_allocation_data);
          } else {
            $this->project_model->allocateActivity($data);
          }
          if ($remaining_default > 0) {
            $data_update = array(
              'empID' => $request->input('employee'),
              'percent' => $remaining_default,
              'active' => 1
            );
          } else {
            $data_update = array(
              'empID' => $request->input('employee'),
              'percent' => $remaining_default,
              'active' => 0
            );
          }

          $this->project_model->updateDefaultAllocationPercentage($data_update);
          $response_array['status'] = "OK";
          echo json_encode($response_array);
        }
        //        $response_array['message'] = "<p class='alert alert-danger text-center'>Error: The Selected Employee Has been Already Allocated Activities which contributes 100%, No more Allocation is Allowed For this Employee.<br>
        //        Solution: Deallocate Some activities Already assiged to this employee, and Try Again</p>";

      } elseif ($percentAlreadyAllocated + $request->input('percent') > 100) {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>Error: The Allocated Percent Is Not Allowed, Since an Employee can Not Have allocation more tan 100%.<br>
        Solution: Maximum percent That can be Assigned To this Employee is <b>" . (100 - $percentAlreadyAllocated) . "%</b></p>";
        echo json_encode($response_array);
      } else {
        $result = $this->project_model->allocateActivity($data);
        if ($result == true) {
          $response_array['status'] = "OK";
          //          $response_array['message'] = "<p class='alert alert-success text-center'>Allocation Done Successifully!</p>";
          echo json_encode($response_array);
        } else {
          $response_array['status'] = "ERR";
          $response_array['message'] = "<p class='alert alert-danger text-center'>Allocation Failed. Please Try Again</p>";
          echo json_encode($response_array);
        }
      }
    }
  }


  public function deleteActivity(Request $request)
  {
    if ($this->uri->segment(3) > 0) {
      $activityCode = $this->uri->segment(3);
      $result = $this->project_model->deleteActivity($activityCode);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-warning text-center'>Allocation Deleted Successifully!</p>";
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Allocation NOT Deleted!</p>";
      }
    } else {
      $response_array['status'] = "ERR";
      $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Allocation NOT Deleted!</p>";
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
  }

  public function deleteActivityGrant(Request $request)
  {
    if ($this->uri->segment(3) > 0) {
      $id = $this->uri->segment(3);
      $result = $this->project_model->deleteActivityGrant($id);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-warning text-center'>Allocation Removed Successifully!</p>";
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Allocation NOT Removed!</p>";
      }
    } else {
      $response_array['status'] = "ERR";
      $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Allocation NOT Removed!</p>";
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
  }

  public function deleteAllocation(Request $request)
  {
    if ($this->uri->segment(3) > 0) {
      $id = $this->uri->segment(3);
      $result = $this->project_model->deleteAllocation($id);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-warning text-center'>Activity Deleted Successifully!</p>";
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Activity NOT Deleted!</p>";
      }
    } else {
      $response_array['status'] = "ERR";
      $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Activity NOT Deleted!</p>";
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
  }


  public function deactivateAllocation(Request $request)
  {
    header('Content-type: application/json');
    if ($this->uri->segment(3) > 0) {
      $id = $this->uri->segment(3);
      $percent = $this->uri->segment(4);
      $data = array(
        'percent' => 0,
        'isActive' => 0
      );
      //      in deactivating release the allocation to default
      $empID = $this->project_model->allocatedPercentage($id);
      $default_percentage = $this->project_model->employeeDefaultAvailablePercentage($empID);
      if ($default_percentage == null) {
        $default_percentage = 0;
      }
      $total_available = $default_percentage + $percent;

      $data_update = array(
        'empID' => $empID,
        'percent' => $total_available,
        'active' => 1
      );
      $this->project_model->updateDefaultAllocationPercentage($data_update);
      $result = $this->project_model->deactivateAllocation($id, $data);
      if ($result == true) {
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-warning text-center'>Allocation Has Deactivated Successifully!</p>";
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED to Deactivate!, Please Try Again</p>";
        echo json_encode($response_array);
      }
    } else {
      $response_array['status'] = "ERR";
      $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED to Deactivate!, Please Try Again!</p>";
      echo json_encode($response_array);
    }
  }

  public function deactivateActivity(Request $request)
  {
    header('Content-type: application/json');
    if ($this->uri->segment(3) > 0) {
      $id = $this->uri->segment(3);

      /*get the activity*/
      $activity_code = $this->project_model->anActivity($id);
      if ($activity_code) {
        //get all employee in that activity
        $all_employees = $this->project_model->allEmployeeInActivity($activity_code->code);

        if ($all_employees) {
          foreach ($all_employees as $all_employee) {
            $total_default_percent = $this->project_model->employeeDefaultAvailablePercentage($all_employee->empID);
            $total_remaining = $total_default_percent + $all_employee->percent;
            $data_update = array(
              'empID' => $all_employee->empID,
              'percent' => $total_remaining,
              'remaining' => $total_remaining,
              'active' => 1
            );
            $data = array(
              'percent' => 0,
              'isActive' => 0
            );

            $this->project_model->updateDefaultAllocationPercentage($data_update);
            $this->project_model->deactivateAllocation($all_employee->id, $data);
          }
        }

        $data_activity = array(
          'isActive' => 0
        );

        $this->project_model->deactivateActivity($activity_code->id, $data_activity);
        $response_array['status'] = "OK";
        echo json_encode($response_array);
      }
    } else {
      $response_array['status'] = "ERR";
      echo json_encode($response_array);
    }
  }

  public function deactivateProject(Request $request)
  {
    header('Content-type: application/json');
    if ($this->uri->segment(3) > 0) {
      $id = $this->uri->segment(3);

      /*get the activity*/
      $project_code = $this->project_model->aProject($id);
      if ($project_code) {
        //get all activities in that project
        $all_activities = $this->project_model->allActivityInProject($project_code->code);
        if ($all_activities) {
          foreach ($all_activities as $all_activity) {
            //get all employees in that activity
            $all_employees = $this->project_model->allEmployeeInActivity($all_activity->code);
            if ($all_employees) {
              foreach ($all_employees as $all_employee) {
                $total_default_percent = $this->project_model->employeeDefaultAvailablePercentage($all_employee->empID);
                $total_remaining = $total_default_percent + $all_employee->percent;
                $data_update = array(
                  'empID' => $all_employee->empID,
                  'percent' => $total_remaining,
                  'remaining' => $total_remaining,
                  'active' => 1
                );
                $data = array(
                  'percent' => 0,
                  'isActive' => 0
                );

                $this->project_model->updateDefaultAllocationPercentage($data_update);
                $this->project_model->deactivateAllocation($all_employee->id, $data);
              }
            }

            $data_activity = array(
              'isActive' => 0
            );

            $this->project_model->deactivateActivity($all_activity->id, $data_activity);
          }
        }


        $data_project = array(
          'state' => 0
        );
        $this->project_model->deactivateProject($project_code->id, $data_project);
        $response_array['status'] = "OK";
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        echo json_encode($response_array);
      }
    } else {
      $response_array['status'] = "ERR";
      echo json_encode($response_array);
    }
  }

  public function assignActivity(Request $request)
  {
    if ($_POST) {
      $assignment_name = trim($request->input('assignment_name'));
      $project = trim($request->input('project_assign'));
      $activity = trim($request->input('activity'));
      if ($request->input('start_date')) {
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('start_date'))));
      } else {
        $start_date = null;
      }
      if ($request->input('end_date')) {
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('end_date'))));
      } else {
        $end_date = null;
      }
      $employees = $request->input('employee');
      $description = $request->input('description');

      $data = array(
        'name' => $assignment_name,
        'project' => $project,
        'activity' => $activity,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'description' => $description,
        'assigned_by' => session('emp_id')
      );

      $assignment_id = $this->project_model->addAssignment($data);

      $result = false;
      if ($assignment_id) {
        foreach ($employees as $employee) {
          $data1 = array(
            'assignment_id' => $assignment_id,
            'emp_id' => $employee
          );
          $result = $this->project_model->addAssignmentEmployee($data1);
        }
        $data2 = array(
          'assignment_id' => $assignment_id,
          'emp_id' => session('emp_id')
        );
        $this->project_model->addAssignmentEmployee($data2);
      }

      if ($result) {
        $response_array['status'] = "OK";
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        echo json_encode($response_array);
      }
    }
  }

  public function assignmentInfo(Request $request)
  {
    if (session('vw_proj') || session('mng_proj')) {
      $data['projects'] = $this->project_model->allProjects();
      $assignID = base64_decode($this->input->get('code'));

      $data['action'] = 1; // O For Addition, 1 For Info and Update
      $data['assignments'] = $this->project_model->allAssignments($assignID);
      $data['my_assignments'] = $this->project_model->myAssignments(session('emp_id'), $assignID);
      $data['assignment_costs'] = $this->project_model->allAssignmentCosts($assignID);
      $data['title'] = "Create New Project";
      return view('app.assignment_info', $data);
    }
  }

  public function timeTrackInfo(Request $request)
  {
    if (session('vw_proj') || session('mng_proj')) {
      $data['projects'] = $this->project_model->allProjects();
      $assignID = base64_decode($this->input->get('code'));
      $data['action'] = 1; // O For Addition, 1 For Info and Update
      $data['my_assignments'] = $this->project_model->myAssignments(session('emp_id'), $assignID);
      $data['time_track'] = $this->project_model->allTimeTrackAll(session('emp_id'), $assignID);
      $data['exceptions'] = $this->performance_model->getException();
      $data['all_exceptions'] = $this->project_model->allException(session('emp_id'));
      $data['title'] = "Create New Project";
    } else {
      $data['projects'] = $this->project_model->allProjects();
      $assignID = base64_decode($this->input->get('code'));
      $data['action'] = 1; // O For Addition, 1 For Info and Update
      $data['time_track'] = $this->project_model->myTimeTrack(session('emp_id'), $assignID);
      $data['my_assignments'] = $this->project_model->myAssignments(session('emp_id'), $assignID);
      $data['exceptions'] = $this->performance_model->getException();
      $data['all_exceptions'] = $this->project_model->myException(session('emp_id'));
      $data['title'] = "Create New Project";
    }
    return view('app.time_track', $data);
  }

  public function commentInfo(Request $request)
  {
    if (session('vw_proj') || session('mng_proj')) {
      $data['projects'] = $this->project_model->allProjects();
      $assignID = base64_decode($this->input->get('code'));
      $data['action'] = 1; // O For Addition, 1 For Info and Update
      $data['comments'] = $this->project_model->allComment($assignID);
      $data['assignID'] = $assignID;
      $data['my_assignments'] = $this->project_model->myAssignmentsAll(session('emp_id'));
      $data['title'] = "Create New Project";
    } else {
      $data['projects'] = $this->project_model->allProjects();
      $assignID = base64_decode($this->input->get('code'));
      $data['action'] = 1; // O For Addition, 1 For Info and Update
      $data['comments'] = $this->project_model->allComment($assignID);
      $data['assignID'] = $assignID;
      $data['my_assignments'] = $this->project_model->myAssignments(session('emp_id'), $assignID);
      $data['title'] = "Create New Project";
    }

    return view('app.comment', $data);
  }

  public function updateAssignment(Request $request)
  {
    if ($_POST) {
      $assignID = trim($request->input('assignID'));
      $assignment_name = trim($request->input('assignment_name'));
      $project = trim($request->input('project_assign'));
      $activity = trim($request->input('activity'));
      $progress_form = trim($request->input('progress_form'));
      if ($progress_form != 'pf') {
        //not progress form
        if ($request->input('start_date')) {
          $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('start_date'))));
        } else {
          $start_date = null;
        }
        if ($request->input('end_date')) {
          $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('end_date'))));
        } else {
          $end_date = null;
        }
        $employees = $request->input('employee');
        $description = $request->input('description');

        $data = array(
          'name' => $assignment_name,
          'project' => $project,
          'activity' => $activity,
          'start_date' => $start_date,
          'end_date' => $end_date,
          'description' => $description,
          'assigned_by' => session('emp_id')
        );

        $assignment = $this->project_model->updateAssignment($data, $assignID);

        $result = false;
        if ($assignment) {
          foreach ($employees as $employee) {
            $data1 = array(
              'assignment_id' => $assignID,
              'emp_id' => $employee
            );
            $result = $this->project_model->addAssignmentEmployee($data1);
          }
        }

        if ($result) {
          $response_array['status'] = "OK";
          echo json_encode($response_array);
        } else {
          $response_array['status'] = "ERR";
          echo json_encode($response_array);
        }
      } else {
        $assign_progress_id = trim($request->input('project_progress'));
        $assignment_progress = trim($request->input('assignment_progress'));

        $data = array(
          'progress' => $assignment_progress
        );

        $assignment = $this->project_model->updateAssignment($data, $assign_progress_id);

        if ($assignment) {
          $response_array['status'] = "OK";
          echo json_encode($response_array);
        } else {
          $response_array['status'] = "ERR";
          echo json_encode($response_array);
        }
      }
    }
  }

  public function deleteEmployeeAssignment(Request $request)
  {
    if ($this->uri->segment(3) > 0) {
      $assignID = $this->uri->segment(3);
      $emp_id = $this->uri->segment(4);

      $result = $this->project_model->deleteEmployeeAssignment($assignID, $emp_id);
      if ($result == true) {
        $response_array['status'] = "OK";
        //                $response_array['message'] = "<p class='alert alert-warning text-center'>Allocation Deleted Successifully!</p>";
      } else {
        $response_array['status'] = "ERR";
        //                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Allocation NOT Deleted!</p>";
      }
    } else {
      $response_array['status'] = "ERR";
      //            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Allocation NOT Deleted!</p>";
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
  }

  public function addTask(Request $request)
  {
    if ($_POST) {
      $assignment_employee_id = trim($request->input('assignment_employee_id'));
      $description = trim($request->input('descriptions'));
      $name = trim($request->input('names'));

      if ($request->input('start_date')) {
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', explode(',', $request->input('start_date'))[0])));
        $start_date_time  = date("H:i:s", strtotime(explode(',', $request->input('start_date'))[1]));
      } else {
        $start_date = null;
        $start_date_time = null;
      }
      if ($request->input('end_date')) {
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', explode(',', $request->input('end_date'))[0])));
        $end_date_time  = date("H:i:s", strtotime(explode(',', $request->input('end_date'))[1]));
      } else {
        $end_date = null;
        $end_date_time = null;
      }


      $data = array(
        'assignment_employee_id' => $assignment_employee_id,
        'task_name' => $name,
        'start_date' => $start_date . ' ' . $start_date_time,
        'end_date' => $end_date . ' ' . $end_date_time,
        'description' => $description
      );

      $result = $this->project_model->addTask($data);
      if ($result == true) {
        $response_array['status'] = "OK";
      } else {
        $response_array['status'] = "ERR";
      }

      header('Content-type: application/json');
      echo json_encode($response_array);
    }
  }

  public function addException(Request $request)
  {
    if ($_POST) {
      $assignment_id = trim($request->input('name_id'));
      $emp_id = session('emp_id');
      $exception_type = trim($request->input('exception_type'));

      if ($request->input('start_date')) {
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('start_date'))));
      } else {
        $start_date = null;
      }
      if ($request->input('end_date')) {
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->input('end_date'))));
      } else {
        $end_date = null;
      }


      $data = array(
        'assignment_id' => $assignment_id,
        'emp_id' => $emp_id,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'exception_type' => $exception_type
      );

      $result = $this->project_model->addException($data);
      if ($result == true) {
        $response_array['status'] = "OK";
      } else {
        $response_array['status'] = "ERR";
      }

      header('Content-type: application/json');
      echo json_encode($response_array);
    }
  }

  public function approveTask(Request $request)
  {
    if ($this->uri->segment(3) > 0) {
      $assignID = $this->uri->segment(3);
      $data = array(
        'status' => 1
      );
      $result = $this->project_model->updateTask($assignID, $data);
      if ($result == true) {
        $response_array['status'] = "OK";
      } else {
        $response_array['status'] = "ERR";
      }
    } else {
      $response_array['status'] = "ERR";
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
  }

  public function commentTask()
  {
    if ($_POST) {
      $assignID = $request->input('id');
      $comment = $request->input('comment');
      $data = array(
        'task_id' => $assignID,
        'remarks' => $comment,
        'remark_by' => session('emp_id'),
        'date' => date('Y-m-d H:i:s')
      );
      $result = $this->project_model->taskComment($data);
      if ($result == true) {
        $response_array['status'] = "OK";
      } else {
        $response_array['status'] = "ERR";
      }
    } else {
      $response_array['status'] = "ERR";
    }
    header('Content-type: application/json');
    echo json_encode($response_array);
  }

  public function deleteComment(Request $request)
  {
    if ($this->uri->segment(3) > 0) {
      $assignID = $this->uri->segment(3);

      $result = $this->project_model->deleteComment($assignID);
      if ($result == true) {
        $response_array['status'] = "OK";
      } else {
        $response_array['status'] = "ERR";
      }
    } else {
      $response_array['status'] = "ERR";
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
  }

  public function addCost(Request $request)
  {
    if ($_POST) {
      $data = array(
        'emp_id' => session('emp_id'),
        'project' => $request->input('project_name'),
        'activity' => $request->input('activity_name'),
        'assignment' => $request->input('id'),
        'cost_category' => $request->input('category'),
        'amount' => $request->input('cost_amount'),
        'description' => $request->input('cost_description'),
        'created_at' => date('Y-m-d'),
        'created_by' => session('emp_id')
      );

      //upload file
      if (!file_exists('uploads/costs')) {
        mkdir('uploads/costs', 0777, true);
      }
      $config['upload_path'] = 'uploads/costs/';
      $config['allowed_types'] = '*';
      $config['max_filename'] = '255';
      $config['encrypt_name'] = TRUE;
      $config['max_size'] = '30024'; //1 MB

      if (isset($_FILES['file']['name'])) {
        if (0 < $_FILES['file']['error']) {
          //no file
        } else {
          if (file_exists('uploads/costs/' . $_FILES['file']['name'])) {
            //file exists
          } else {

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
              echo $this->upload->display_errors();
            } else {
              //file successfully
              $file_info = $this->upload->data();
              $data['document'] = $file_info['file_name'];
            }
          }
        }
      }

      $result = $this->performance_model->addCost($data);
      if ($result == true) {
        //get activity, project
        $grant_code = $this->performance_model->getGrantCode($request->input('activity_name'), $request->input('project_name'));
        if ($grant_code) {
          foreach ($grant_code as $item) {
            $new_grant = $item->amount - $request->input('cost_amount');
            $data_ = array(
              'amount' => $new_grant
            );

            $data_1 = array(
              'funder' => $item->funder,
              'project' => $request->input('project_name'),
              'activity' => $request->input('activity_name'),
              'mode' => "OUT",
              'amount' => $request->input('cost_amount'),
              'created_at' => date('Y-m-d'),
              'created_by' => session('emp_id')
            );
            $this->performance_model->addRequest($data_1);
            $this->performance_model->updateGrant($item->grant_code, $data_);
          }
        }

        $response_array['status'] = "OK";
        header('Content-type: application/json');
        echo json_encode($response_array);
      } else {
        $response_array['status'] = "ERR";
        header('Content-type: application/json');
        echo json_encode($response_array);
      }
    }
  }
}
