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
use App\Helpers\SysHelpers;
use App\Models\PerformanceModel;

class GeneralController extends Controller
{

    public function __construct($payroll_model=null,$flexperformance_model = null,$reports_model=null,$imprest_model = null, PerformanceModel $performanceModel)
    {
        $this->payroll_model = new Payroll();
        $this->imprest_model = new ImprestModel;
        $this->reports_model = new ReportModel;
        $this->flexperformance_model = new FlexPerformanceModel;
        $this->performanceModel = $performanceModel;

    }

   public function index()
      {
      $list = $this->flexperformance_model->contract_expire_list();
      foreach($list as $key){

      $this->flexperformance_model->terminate_contract($key->IDs);
      }
    $data['title']="Login";
    $this->load->view('login', $data);
   }



  public function password_check($str)
  {
     if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
       return TRUE;
     }
     $this->form_validation->set_message('password_check', 'The Password Should Contain 8 Characters Length with Mix of Letters and Numbers');
     return FALSE;
  }


  public function login_info() {

    $empID = $this->session->userdata('emp_id');
    $data['info'] = $this->flexperformance_model->login_info($empID);
    $data['title'] = "Login Credentials";
    $this->load->view('update_login_info', $data);
  }


  function checkPassword($password){
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    $res = false;
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
      $res = false;
      }else{
        $res = true;
    }
    return $res;
}


 public function update_login_info() {

    if($_POST) {
      $empID = $this->session->userdata('emp_id');

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password_conf = $this->input->post('conf_password');

      if($username!='' && $password!=''&& $password== $password_conf){
        if($this->checkPassword($password)){
        $password_hash = password_hash(trim($password), PASSWORD_BCRYPT);
        $data = array(
              'username' => $username,
              'password' => $password_hash,
              'password_set' => "0",
              'last_updated' =>date('Y-m-d')

          );
        $result = $this->flexperformance_model->updateEmployee($data,$empID);

        if($result){
          $data = array(
            'empID' => $this->session->userdata('emp_id'),
            'password' => $password_hash,
            'time' =>date('Y-m-d')
          );

          $this->flexperformance_model->insert_user_password($data);
            $response_array['status'] = 'OK';
            echo json_encode($response_array);
            $this->logout();

        } else {
            $response_array['status'] = 'ERR';
            echo json_encode($response_array);
        }

      } else{
        $response_array['status'] = 'ERR_P';
        echo json_encode($response_array);
      }
    }else{
      $response_array['status'] = 'ERR';
      echo json_encode($response_array);
    }




    } else {
      $response_array['status'] = 'ERR';
      echo json_encode($response_array);
    }


  }



  public function logout(){
    $this->session->sess_destroy();
    redirect('/Base_controller/', 'refresh');
  }


  public function userprofile() {
    $id = $this->input->get('id');
    $extra = $this->input->get('extra');
    $data['employee'] = $this->flexperformance_model->userprofile($id);
    $data['kin'] = $this->flexperformance_model->getkin($id);
    $data['property'] = $this->flexperformance_model->getproperty($id);
    $data['propertyexit'] = $this->flexperformance_model->getpropertyexit($id);
    $data['active_properties'] = $this->flexperformance_model->getactive_properties($id);
    $data['allrole'] = $this->flexperformance_model->role($id);
    $data['role'] = $this->flexperformance_model->getuserrole($id);
    $data['rolecount'] = $this->flexperformance_model->rolecount($id);
    $data['task_duration'] = $this->performanceModel->total_task_duration($id);
    $data['task_actual_duration'] = $this->performanceModel->total_task_actual_duration($id);
    $data['task_monetary_value'] = $this->performanceModel->all_task_monetary_value($id);
    $data['allTaskcompleted'] = $this->performanceModel->allTaskcompleted($id);

    $data['skills_missing'] = $this->flexperformance_model->skills_missing($id);

    $data['requested_skills'] = $this->flexperformance_model->requested_skills($id);
    $data['skills_have'] = $this->flexperformance_model->skills_have($id);
    $data['month_list'] = $this->flexperformance_model->payroll_month_list();
    $data['title']="Profile";
    $this->load->view('userprofile', $data);
  }


  public function contract_expire()
      {

      $data['contract_expire'] = $this->flexperformance_model->contract_expiration_list();
      $data['title']="Contract";
      $this->load->view('contract_expire', $data);
  }


 public function retire()
      {

      $data['retire'] = $this->flexperformance_model->retire_list();
      $data['title']="Contract";
      $this->load->view('retire', $data);
   }


 public function contract() {

      $data['contract'] = $this->flexperformance_model->contract();
      $data['title']="Contract";
      $this->load->view('contract', $data);
  }

  public function addContract() {
    if($_POST) {
      $data = array(
           'name' => $this->input->post('name'),
           'duration' => $this->input->post('duration'),
           'reminder' =>$this->input->post('alert')
      );

      $result = $this->flexperformance_model->contractAdd($data);
        if($result==true){
            $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-success text-center'>Contract Registered Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else{
            $response_array['status'] = "ERR";
            $response_array['title'] = "FAILED";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Contract Not Registered, Please try again</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
      } else {
          $response_array['status'] = "ERR";
            $response_array['title'] = "FAILED";
          $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Incorrect Values</p>";
          header('Content-type: application/json');
          echo json_encode($response_array);

    }
  }


    public function updatecontract()
      {
        $id = $this->input->get('id');

      $data['contract'] =  $this->flexperformance_model->getcontractbyid($id);
      $data['title']="Contract";
      $this->load->view('update_contract', $data);

      if (isset($_POST['update']) && $id!='') {
        $updates = array(
            'name' =>$this->input->post('name'),
            'duration' =>$this->input->post('duration'),
            'reminder' =>$this->input->post('alert')
            );
        $result = $this->flexperformance_model->updatecontract($updates, $id);
        if($result ==true){
            $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>Contract Deleted Successifully</p>");
            redirect('/cipay/contract/');
        }
      }
   }

   public function deletecontract()
          {
            $id = $this->uri->segment(3);
            $updates = array(
                    'state' =>0
                );
            $result = $this->flexperformance_model->updatecontract($updates, $id);
            if($result ==true){
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-danger text-center'>Department Deleted!</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }

          }


  public function bank() {
    if( $this->session->userdata('mng_bank_info')){
      $id = $this->session->userdata('emp_id');
      $data['banks'] =  $this->flexperformance_model->bank();
      $data['branch'] =  $this->flexperformance_model->bank_branch();
      $data['title']="Bank";
      $this->load->view('bank', $data);
    } else{
      echo "Unauthorized Access";
    }
  }

  public function department()
      {
       $id = $this->session->userdata('emp_id');
       $data['employee'] =  $this->flexperformance_model->customemployee();
       $data['cost_center'] =  $this->flexperformance_model->costCenter();
       $data['parent_department'] =  $this->flexperformance_model->departmentdropdown();
       $data['department'] = $this->flexperformance_model->alldepartment();
       $data['inactive_department'] = $this->flexperformance_model->inactive_department();
      $data['title']="Department";
      $this->load->view('department', $data);
   }


  public function organization_level()
      {
       $data['level'] = $this->flexperformance_model->getAllOrganizationLevel();
      $data['title']="Department";
      $this->load->view('organization_level', $data);
   }

   public function organization_level_info()  {
      $id = base64_decode($this->input->get('id'));
      $data['title'] =  'Organization Level';
      $data['category'] =  $this->flexperformance_model->organization_level_info($id);
      $this->load->view('organization_level_info', $data);
    }


   public function alldepartment(){
      $id = $this->session->userdata('emp_id');
      $data['department'] = $this->flexperformance_model->alldepartment();
      $data['title']="Department";
      $this->load->view('department', $data);

   }

  public function updateOrganizationLevelName() {
    $ID = $this->input->post('levelID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'name' =>$this->input->post('name')
                  );
              $result = $this->flexperformance_model->updateOrganizationLevel($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }
  public function updateMinSalary() {
    $ID = $this->input->post('levelID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'minSalary' =>$this->input->post('minSalary')
                  );
              $result = $this->flexperformance_model->updateOrganizationLevel($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }
  public function updateMaxSalary() {
    $ID = $this->input->post('levelID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'maxSalary' =>$this->input->post('maxSalary')
                  );
              $result = $this->flexperformance_model->updateOrganizationLevel($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }

    public function departmentAdd() {

      if($_POST) {
        $values = explode('|', $this->input->post('parent'));
        $parent_id = $values[0];
        $parent_code = $values[1];
        $parent_level = $values[2];
        $departmentData = array(
             'name' => $this->input->post('name'),
             'hod' => $this->input->post('hod'),
             'cost_center_id' => $this->input->post('cost_center_id'),
             'department_pattern' =>$this->code_generator(6),
             'parent_pattern' =>$parent_code,
             'reports_to' => $parent_id,
             'level' => $parent_level+1,
             'created_by' =>$this->session->userdata('emp_id')
        );

        $identifiers = $this->flexperformance_model->departmentAdd($departmentData);
        if(!empty($identifiers)) {
          foreach ($identifiers as $key ) {
            $departmentID = $key->depID;
            // $positionID = $key->posID;
          }
          $code = sprintf("%03d", $departmentID);

          $result = $this->flexperformance_model->updateDepartmentPosition($code, $departmentID);
          if($result==true) {
            echo "<p class='alert alert-success text-center'>Department Registered Successifully</p>";
          } else {
            echo "<p class='alert alert-danger text-center'>Department Registration has FAILED, Contact Your Admin</p>";
          }
        }else{
          echo  "<p class='alert alert-danger text-center'>FAILED! Department Registration was Unsuccessifull, Please Try Again</p>";
        }
      }
    }


  public function branch()
      {
       $id = $this->session->userdata('emp_id');
       $data['branch'] =  $this->flexperformance_model->branch();
       $data['department'] = $this->flexperformance_model->alldepartment();
       $data['countrydrop'] = $this->flexperformance_model->countrydropdown();
      $data['title']="Company Branch";
      $this->load->view('branch', $data);
   }

   public function costCenter()
   {
    $id = $this->session->userdata('emp_id');
    $data['cost_center'] =  $this->flexperformance_model->costCenter();
    $data['countrydrop'] = $this->flexperformance_model->countrydropdown();
   $data['title']="Cost Center";
   $this->load->view('cost_center', $data);
}

  public function nationality()
      {
       $id = $this->session->userdata('emp_id');
       $data['nationality'] =  $this->flexperformance_model->nationality();
      $data['title']="Employee Nationality";
      $this->load->view('nationality', $data);
   }


  public function addEmployeeNationality() {
    if ($_POST) {

      $data = array(
        'name' =>$this->input->post('name'),
        'code' =>$this->input->post('code')
      );
        $result = $this->flexperformance_model->addEmployeeNationality($data);
        if($result==true) {
          echo "<p class='alert alert-success text-center'>Country Added Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED, Country Not Added. Please Try Again</p>";
        }
    }
  }


  public function deleteCountry() {
    if($this->uri->segment(3)!=''){
      $code = $this->uri->segment(3);
      $checkEmployee = $this->flexperformance_model->checkEmployeeNationality($code);
      if($checkEmployee>0) {
        echo "<p class='alert alert-warning text-center'>WARNING, Country Can Not Be Deleted, Some Employee Have Nationality From This Country.</p>";
      }else{
        $result = $this->flexperformance_model->deleteCountry($code);
        if($result==true) {
          echo "<p class='alert alert-success text-center'>Country Deleted Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED, Country Not Deleted. Please Try Again</p>";
        }
      }
    }

  }

  public function addCompanyBranch() {
    if ($_POST) {

      $data = array(
        'name' =>$this->input->post('name'),
        'department_id' =>$this->input->post('department_id'),
        'street' =>$this->input->post('street'),
        'region' =>$this->input->post('region'),
        'code' =>"0",
        'country' =>$this->input->post('country')
      );
      $branchID = $this->flexperformance_model->addCompanyBranch($data);
      if($branchID>0) {
        $code = sprintf("%03d", $branchID);
        $updates = array(
          'code' =>$code
        );
        $result = $this->flexperformance_model->updateCompanyBranch($updates, $branchID);
        if($result==true) {
          echo "<p class='alert alert-success text-center'>Branch Added Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED, Branch Not Added. Please Try Again</p>";
        }
      }else{ echo "<p class='alert alert-danger text-center'>Branch Code: FAILED, Branch Not Added. Please Try Again</p>";
      }
    }
  }

  public function addCostCenter() {
    if ($_POST) {

      $data = array(
        'name' =>$this->input->post('name'),
        'street' =>$this->input->post('street'),
        'region' =>$this->input->post('region'),
        'code' =>"0",
        'country' =>$this->input->post('country')
      );
      $branchID = $this->flexperformance_model->addCostCenter($data);
      if($branchID>0) {
        $code = sprintf("%03d", $branchID);
        $updates = array(
          'code' =>$code
        );
        $result = $this->flexperformance_model->updateCompanyBranch($updates, $branchID);
        if($result==true) {
          echo "<p class='alert alert-success text-center'>Cost Center Added Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED, Branch Not Added. Please Try Again</p>";
        }
      }else{ echo "<p class='alert alert-danger text-center'>Branch Code: FAILED, Branch Not Added. Please Try Again</p>";
      }
    }
  }

  public function updateCompanyBranch() {

   if(isset($_POST['update']) && $this->input->post('branchID')!='') {
    $branchID = $this->input->post('branchID');
      $updates = array(
           'name' => $this->input->post('name'),
           'department_id' => $this->input->post('department_id'),
           'region' => $this->input->post('region'),
           'street' => $this->input->post('street')
      );

      $result =  $this->flexperformance_model->updateCompanyBranch($updates, $branchID);
      if($result){
          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Updated Successifully</p>");
          redirect('/cipay/branch/', 'refresh');
      } else {
        $this->session->set_flashdata('note', "<p class='alert alert-success text-danger'>FAILED to Update</p>");
        redirect('/cipay/branch/', 'refresh');
      }
    }
  }

  public function updateCostCenter() {

    if(isset($_POST['update']) && $this->input->post('costCenterID')!='') {
     $branchID = $this->input->post('costCenterID');
       $updates = array(
            'name' => $this->input->post('name'),
            'region' => $this->input->post('region'),
            'street' => $this->input->post('street')
       );

       $result =  $this->flexperformance_model->updateCostCenter($updates, $branchID);
       if($result){
           $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Updated Successifully</p>");
           redirect('/cipay/costCenter/', 'refresh');
       } else {
         $this->session->set_flashdata('note', "<p class='alert alert-success text-danger'>FAILED to Update</p>");
         redirect('/cipay/branch/', 'refresh');
       }
     }
   }

  public function addBank() {
     if(isset($_POST['add'])) {
        $data = array(
             'name' => $this->input->post('name'),
             'abbr' => $this->input->post('abbrv'),
             'bank_code' => $this->input->post('bank_code')
        );
        if( $this->session->userdata('mng_bank_info')){
          $result = $this->flexperformance_model->addBank($data);
          if($result){
              $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Bank Successifully</p>");
              redirect('/cipay/bank', 'refresh');
          } else {  redirect('/cipay/bank', 'refresh'); }
        }else{
          echo "Unauthorized Access";
        }
    }
  }



      public function addBankBranch() {
        if($_POST) {
          $data = array(
                  'name' => $this->input->post('name'),
                  'bank' => $this->input->post('bank'),
                  'street' => $this->input->post('street'),
                  'region' => $this->input->post('region'),
                  'branch_code' => $this->input->post('code'),
                  'country' => $this->input->post('country'),
                  'swiftcode' => $this->input->post('swiftcode')
              );
          $result = $this->flexperformance_model->addBankBranch($data);
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Branch Added Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Branch not Added, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }


    public function updateBank() {
      $id =base64_decode($this->input->get("id"));
      $category =$this->input->get("category");

      if($category == 1){ //Update Bank
        $data['bank_info'] =  $this->flexperformance_model->getbank($id);
        $data['category']=1;
        $data['title']="Bank Info";
        $this->load->view('update_bank', $data);
      }else{//Update Branch
        $data['branch_info'] =  $this->flexperformance_model->getbankbranch($id);
        $data['category']=2;
        $data['title']="Bank Info";
        $this->load->view('update_bank', $data);

      }
    }

      public function updateBankBranchName() {
        if($_POST) {
          $data = array(
                  'name' => $this->input->post('name'),
                  'bank' => $this->input->post('bank'),
                  'street' => $this->input->post('street'),
                  'region' => $this->input->post('region'),
                  'branch_code' => $this->input->post('code'),
                  'country' => $this->input->post('country'),
                  'swiftcode' => $this->input->post('swiftcode')
              );
          $result = $this->flexperformance_model->addBankBranch($data);
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Branch Added Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Branch not Added, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }

      public function updateBankName() {
        if($_POST && $this->input->post('bankID')!='') {
          $bankID = $this->input->post('bankID');
          $data = array(
                  'name' => $this->input->post('name')
              );
          $result = $this->flexperformance_model->updateBank($data,$bankID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Bank Name Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Bank name notUpdated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }

      public function updateAbbrev() {
        if($_POST && $this->input->post('bankID')!='') {
          $bankID = $this->input->post('bankID');
          $data = array(
                  'abbr' => $this->input->post('abbrev')
              );
          $result = $this->flexperformance_model->updateBank($data,$bankID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'> Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Not Updated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }

      public function updateBankCode() {
        if($_POST && $this->input->post('bankID')!='') {
          $bankID = $this->input->post('bankID');
          $data = array(
                  'bank_code' => $this->input->post('bank_code')
              );
          $result = $this->flexperformance_model->updateBank($data,$bankID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }

      public function updateBranchName() {
        if($_POST && $this->input->post('branchID')!='') {
          $branchID = $this->input->post('branchID');
          $data = array(
                  'name' => $this->input->post('name')
              );
          $result = $this->flexperformance_model->updateBankBranch($data,$branchID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }

      public function updateBranchCode() {
        if($_POST && $this->input->post('branchID')!='') {
          $branchID = $this->input->post('branchID');
          $data = array(
                  'branch_code' => $this->input->post('branch_code')
              );
          $result = $this->flexperformance_model->updateBankBranch($data,$branchID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }

      public function updateBranchSwiftcode() {
        if($_POST && $this->input->post('branchID')!='') {
          $branchID = $this->input->post('branchID');
          $data = array(
                  'swiftcode' => $this->input->post('swiftcode')
              );
          $result = $this->flexperformance_model->updateBankBranch($data,$branchID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }
      public function updateBranchStreet() {
        if($_POST && $this->input->post('branchID')!='') {
          $branchID = $this->input->post('branchID');
          $data = array(
                  'street' => $this->input->post('street')
              );
          $result = $this->flexperformance_model->updateBankBranch($data,$branchID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }

      public function updateBranchRegion() {
        if($_POST && $this->input->post('branchID')!='') {
          $branchID = $this->input->post('branchID');
          $data = array(
                  'region' => $this->input->post('region')
              );
          $result = $this->flexperformance_model->updateBankBranch($data,$branchID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }
      }

      public function updateBranchCountry() {
        if($_POST && $this->input->post('branchID')!='') {
          $branchID = $this->input->post('branchID');
          $data = array(
                  'country' => $this->input->post('country')
              );
          $result = $this->flexperformance_model->updateBankBranch($data,$branchID );
          if($result){
              $response_array['status'] = "OK";
              $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          } else{
              $response_array['status'] = "ERR";
              $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
              header('Content-type: application/json');
              echo json_encode($response_array);
          }
        }

      }


public function deleteDepartment()
      {

        $id = $this->uri->segment(3);
        $data = array(
        'state' => 0
        );
        $result = $this->flexperformance_model->updatedepartment($data, $id);
        if($result ==true){
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Department Deleted!</p>";
        }else{
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Department NOT Deleted!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);

      }

public function activateDepartment()
      {

        $id = $this->uri->segment(3);
        $data = array(
        'state' => 1
        );
        $result = $this->flexperformance_model->updatedepartment($data, $id);
        if($result ==true){
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Department Activated Successifully!</p>";
        }else{
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>Department Activation FAILED, Please Try again!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);

      }



   public function position_info()
      {
      $id =$this->input->get("id");
      $data['all_position'] =  $this->flexperformance_model->allposition();
      $data['organization_levels'] =  $this->flexperformance_model->getAllOrganizationLevel();
      $data['skills'] =  $this->flexperformance_model->getskills($id);
      $data['accountability'] =  $this->flexperformance_model->getaccountability($id);
      $data['position'] =  $this->flexperformance_model->getpositionbyid($id);
      $data['title']="Positions";
      $this->load->view('position_info', $data);
   }


   public function department_info()
      {

      $id = base64_decode($this->input->get("id"));

      $data['employee'] =  $this->flexperformance_model->customemployee();
      $data['cost_center'] =  $this->flexperformance_model->costCenter();
       $data['parent_department'] =  $this->flexperformance_model->departmentdropdown();
      $data['data'] =  $this->flexperformance_model->getdepartmentbyid($id);
      $data['title']="Department";
      $this->load->view('department_info', $data);
   }

  ############################## LEARNING AND DEVELOPMENT(TRAINING)#############################


  public function addBudget() {
    if (isset($_POST['request'])){

      $start = $this->input->post('start');
      $end = $this->input->post('end');

      $start_calendar = str_replace('/', '-', $start);
      $finish_calendar = str_replace('/', '-', $end);

      $start_final = date('Y-m-d', strtotime($start_calendar));
      $end_final = date('Y-m-d ', strtotime($finish_calendar));
      if($end_final <= $start_final) {
        $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>INVALID DATE Selection, Budget Not Added, Try Again</p>");
        redirect('/cipay/training_application', 'refresh');
      } else {

        $data = array(
             'description' => $this->input->post('name'),
             'start' => $start_final,
             'end' => $end_final,
             'amount' => $this->input->post('amount'),
             'recommended_by' => $this->session->userdata('emp_id'),
             'date_recommended' => date('Y-m-d'),
             'date_approved' => date('Y-m-d')
        );
        $result = $this->flexperformance_model->addBudget($data);

        if($result==true){
          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Budget Added Successifully</p>");
          redirect('/cipay/training_application', 'refresh');
        } else {
          $this->session->set_flashdata('note', "<p class='alert alert-danger text-center'>Budget Request Has FAILED, Please Try again</p>");
          redirect('/cipay/training_application', 'refresh');

        }
      }
    }
  }

  public function updateBudgetDescription() {
    if($_POST && $this->input->post('budgetID')!=''){
      $budgetID = $this->input->post('budgetID');
      $data = array(
               'description' =>$this->input->post('description')
          );
        $result = $this->flexperformance_model->updateBudget($data, $budgetID);
        if($result == true){
          echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
      }
    }
  }

  public function updateBudgetAmount() {
    if($_POST && $this->input->post('budgetID')!=''){
      $budgetID = $this->input->post('budgetID');
      $data = array(
               'amount' =>$this->input->post('amount')
          );
        $result = $this->flexperformance_model->updateBudget($data, $budgetID);
        if($result == true){
          echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
      }
    }
  }

  public function updateBudgetDateRange() {
    if($_POST && $this->input->post('budgetID')!=''){
      $budgetID = $this->input->post('budgetID');
      $start = $this->input->post('start');
      $end = $this->input->post('end');

      $start_calendar = str_replace('/', '-', $start);
      $finish_calendar = str_replace('/', '-', $end);

      $start_final = date('Y-m-d', strtotime($start_calendar));
      $end_final = date('Y-m-d ', strtotime($finish_calendar));
      if($end_final <= $start_final) {
        echo "<p class='alert alert-warning text-center'>INVALID DATE Selection, Budget Not Added, Try Again</p>";
      } else {

        $data = array(
                 'start' =>$start_final,
                 'end' =>$end_final
            );
          $result = $this->flexperformance_model->updateBudget($data, $budgetID);
          if($result == true){
            echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
          } else { echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
        }
      }
    }
  }

  public function approveBudget() {
    if($this->uri->segment(3)!=''){
      $budgetID = $this->uri->segment(3);
      $data = array(
               'status' =>1,
               'approved_by' =>$this->session->userdata('emp_id'),
               'date_approved' => date('Y-m-d')
          );
        $result = $this->flexperformance_model->updateBudget($data, $budgetID);
        if($result == true){
          echo "<p class='alert alert-success text-center'>Budget Approved Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Approve, Please Try Again!</p>";
      }
    }
  }

  public function disapproveBudget() {
    if($this->uri->segment(3)!=''){
      $budgetID = $this->uri->segment(3);
      $data = array(
               'status' =>2,
               'approved_by' =>$this->session->userdata('emp_id'),
               'date_approved' => date('Y-m-d')
          );
        $result = $this->flexperformance_model->updateBudget($data, $budgetID);
        if($result == true){
          echo "<p class='alert alert-success text-center'>Budget Disapproved Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Disapprove, Please Try Again!</p>";
      }
    }
  }

  public function deleteBudget() {
    if($this->uri->segment(3)!=''){
      $budgetID = $this->uri->segment(3);
        $result = $this->flexperformance_model->deleteBudget($budgetID);
        if($result == true){
          echo "<p class='alert alert-success text-center'>Budget Deleted Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Delete, Please Try Again!</p>";
      }
    }
  }



  public function training_application(){
      $empID= $this->session->userdata('emp_id');

      $data['budget'] = $this->flexperformance_model->budget();
      $data['my_applications'] = $this->flexperformance_model->my_training_applications($empID);
      $data['skill_gap'] = $this->flexperformance_model->skill_gap();
      $data['trainees_accepted'] = $this->flexperformance_model->accepted_applications();
      $totalCost = $this->flexperformance_model->total_training_cost();


      if($this->session->userdata('appr_training')!=0 && $this->session->userdata('conf_training')!=0 && $this->session->userdata('line')!=0) {
        $data['other_applications'] = $this->flexperformance_model->all_training_applications($empID);

      }elseif ($this->session->userdata('appr_training')!=0 && $this->session->userdata('conf_training')!=0) {
        $data['other_applications'] = $this->flexperformance_model->appr_conf_training_applications();

      }elseif ($this->session->userdata('appr_training')!=0 && $this->session->userdata('line')!=0) {
        $data['other_applications'] = $this->flexperformance_model->appr_line_training_applications($empID);
      }elseif ($this->session->userdata('conf_training')!=0 && $this->session->userdata('line')!=0) {
        $data['other_applications'] = $this->flexperformance_model->conf_line_training_applications($empID);
      }elseif ($this->session->userdata('line')!=0) {
        $data['other_applications'] = $this->flexperformance_model->line_training_applications($empID);
      }elseif ($this->session->userdata('appr_training')!=0) {
        $data['other_applications'] = $this->flexperformance_model->appr_training_applications();
      }elseif ($this->session->userdata('conf_training')!=0) {
        $data['other_applications'] = $this->flexperformance_model->conf_training_applications();
      }

      // $data['isBudgetPresent'] =  $this->flexperformance_model->checkCurrentYearBudget(date('Y'));
      $data['course'] = $this->flexperformance_model->all_skills($empID);
      $data['title']="Training Application";
      $data['total_training_cost'] = $totalCost;
      $this->load->view('training', $data);
  }

  function budget_info(){
    $budgetID =  base64_decode($this->input->get('id'));
    $data['info'] = $this->flexperformance_model->getBudget($budgetID);
    $data['title']="Training Budget";
    $this->load->view('budget_info', $data);
  }


  public function requestTraining() {
    $pattern = $this->input->get('pattern');

    $value = explode('|', $pattern);
    $empID = $value[0];
    $course = $value[1];
    $data = array(
            'empID' => $empID,
            'skills_ID' => $course,
            'nominated_by' => $this->session->userdata('emp_id')
        );
    $result = $this->flexperformance_model->requesttraining($data);
    if($result){
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Request Sent</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
    } else{
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-danger text-center'>Request sending Failed, Please try again</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

  }

  public function requestTraining2() {
    if($_POST){
      $empID = $this->session->userdata('emp_id');
      $course = $this->input->post('course');
      $data = array(
              'empID' => $empID,
              'skillsID' => $course,
              'date_recommended' => date('Y-m-d'),
              'date_approved' => date('Y-m-d'),
              'application_date' => date('Y-m-d'),
              'date_confirmed' => date('Y-m-d')
          );
      $result = $this->flexperformance_model->requestTraining($data);
      if($result){
          $response_array['status'] = "OK";
          $response_array['message'] = "<p class='alert alert-success text-center'>Training Request Sent</p>";
          header('Content-type: application/json');
          echo json_encode($response_array);
      } else{
          $response_array['status'] = "ERR";
          $response_array['message'] = "<p class='alert alert-danger text-center'>Request sending Failed, Please try again</p>";
          header('Content-type: application/json');
          echo json_encode($response_array);
      }
    }
  }

  public function recommendTrainingRequest() {
    if($this->uri->segment(3)!=''){
      $requestID = $this->uri->segment(3);
      $data = array(
               'status' =>1,
               'recommended_by' =>$this->session->userdata('emp_id'),
               'date_recommended' => date('Y-m-d')
          );
        $result = $this->flexperformance_model->updateTrainingRequest($data, $requestID);
        if($result == true){
          echo "<p class='alert alert-success text-center'>Request Recommended Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Recommend, Please Try Again!</p>";
      }
    }
  }

  public function suspendTrainingRequest() {
    if($this->uri->segment(3)!=''){
      $requestID = $this->uri->segment(3);
      $data = array(
               'status' =>4, //Held or Suspended
               'recommended_by' =>$this->session->userdata('emp_id'),
               'date_recommended' => date('Y-m-d')
          );
        $result = $this->flexperformance_model->updateTrainingRequest($data, $requestID);
        if($result == true){
          echo "<p class='alert alert-warning text-center'>Request Suspended Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Suspend, Please Try Again!</p>";
      }
    }
  }

  public function approveTrainingRequest() {
    if($this->uri->segment(3)!=''){
      $requestID = $this->uri->segment(3);
      $data = array(
               'status' =>3, //Held or Suspended
               'approved_by' =>$this->session->userdata('emp_id'),
               'date_approved' => date('Y-m-d')
          );
        $result = $this->flexperformance_model->updateTrainingRequest($data, $requestID);
        if($result == true){
          echo "<p class='alert alert-warning text-center'>Request Suspended Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Suspend, Please Try Again!</p>";
      }
    }
  }

  public function disapproveTrainingRequest() {
    if($this->uri->segment(3)!=''){
      $requestID = $this->uri->segment(3);
      $data = array(
               'status' =>5, //DisApproved
               'approved_by' =>$this->session->userdata('emp_id'),
               'date_approved' => date('Y-m-d')
          );
        $result = $this->flexperformance_model->updateTrainingRequest($data, $requestID);
        if($result == true){
          echo "<p class='alert alert-warning text-center'>Request Suspended Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Disapproved, Please Try Again!</p>";
      }
    }
  }

  public function confirmTrainingRequest() {
    if($this->uri->segment(3)!=''){
      $requestID = $this->uri->segment(3);
      $data = array(
               'status' =>3, //Confirmed
               'confirmed_by' =>$this->session->userdata('emp_id'),
               'date_confirmed' => date('Y-m-d')
          );
        $result = $this->flexperformance_model->confirmTrainingRequest($data, $requestID);
        if($result == true){
          echo "<p class='alert alert-success text-center'>Request Confirmed Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
      }
    }
  }

  public function unconfirmTrainingRequest() {
    if($this->uri->segment(3)!=''){
      $requestID = $this->uri->segment(3);
      $data = array(
               'status' =>6, //DisApproved
               'confirmed_by' =>$this->session->userdata('emp_id'),
               'date_confirmed' => date('Y-m-d')
          );
        $result = $this->flexperformance_model->unconfirmTrainingRequest($data, $requestID);
        if($result == true){
          echo "<p class='alert alert-warning text-center'>Request Unfonfirmed Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED, Please Try Again!</p>";
      }
    }
  }

  public function deleteTrainingRequest() {
    if($this->uri->segment(3)!=''){
      $requestID = $this->uri->segment(3);
        $result = $this->flexperformance_model->deleteTrainingRequest($requestID);
        if($result == true){
          echo "<p class='alert alert-success text-center'>Request Deleted Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'>FAILED, Please Try Again!</p>";
      }
    }
  }

   public function response_training_linemanager(){

     if(isset($_POST['recommend']) && !empty($this->input->post('option')))  {
           $arr = $this->input->post('option');

           foreach($arr as $check) {
               $applicationID = $check;

                $dataUpdates = array(
                     'isAccepted' => 2
                );

             $this->flexperformance_model->updateTrainingApplications($dataUpdates,  $applicationID);

                $check = '';

           }
           $this->session->set_flashdata('note_approved', "<p class='alert alert-success text-center'>Training Applications Recommended Successifully</p>");
           $this->training_application();

        } else{
            $this->session->set_flashdata('note_approved', "<p class='alert alert-warning text-center'>Sorry No item Selected</p>");
            $this->training_application();

        }

     if(isset($_POST['reject'])  && !empty($this->input->post('option')))  {
       $arr = $this->input->post('option');

           foreach($arr as $check) {
               $applicationID = $check;

                $dataUpdates = array(
                     'isAccepted' => 3
                );

             $this->flexperformance_model->updateTrainingApplications($dataUpdates,  $applicationID);

                $check = '';

           }
           $this->session->set_flashdata('note_approved', "<p class='alert alert-warning text-center'>Training Applications Rejected</p>");
           $this->training_application();

        } else{
            $this->session->set_flashdata('note_approved', "<p class='alert alert-warning text-center'>Sorry No item Selected</p>");
            $this->training_application();

        }
   }


   public function confirm_graduation(){

       $key = $this->input->get('key');

        $values = explode('|', $key);
        $empID = $values[0];
        $skillsID = $values[1];
        $graduationID = $values[2];

       $data['mode'] = 2; // 1 For Initial Skills, and  2 for Graduation after Training
       $data['traineeID'] = $empID;
       $data['trainingID'] = $graduationID;
       $data['skillsID'] = $skillsID;
       $data['title']="Training";
       $data['courseTitle']=$this->flexperformance_model->getSkillsName($skillsID);
       $this->load->view('confirm_graduation', $data);
   }


   public function employeeCertification(){

       $key = $this->input->get('val');

        $values = explode('|', $key);
        $empID = $values[0];
        $skillsID = $values[1];
        // $graduationID = $values[2];

       $data['mode'] = 1; // 1 For Initial Skills, and  2 for Graduation after Training
       $data['traineeID'] = $empID;
       // $data['trainingID'] = $graduationID;
       $data['skillsID'] = $skillsID;
       $data['title']="Qualification";
       $data['courseTitle']=$this->flexperformance_model->getSkillsName($skillsID);
       $this->load->view('confirm_graduation', $data);
   }


  public function confirmGraduation() {
    $ID = $this->input->post('trainingID');
    $traineeID = $this->input->post('traineeID');
    $skillsID = $this->input->post('skillsID');
    $remarks = trim($this->input->post('remarks'));
    if ($_POST && $ID!='') {
      $namefile = "certificate_".$traineeID."_".$skillsID;

      $config['upload_path']='./uploads/graduation/';
      $config['file_name'] = $namefile;
      $config['allowed_types']='pdf|jpeg|jpg|gif|jpg|png';
      $config['overwrite'] = true;

      $this->load->library('upload',$config);
      if($this->upload->do_upload("userfile")){
        $data =  $this->upload->data();
        $database = array(
            'certificate' =>$data["file_name"],
            'status' =>1,
            'remarks' =>$remarks,
            'accepted_by' =>$this->session->userdata('emp_id'),
            'date_accepted' =>date('Y-m-d')
        );
        $data_skills = array(
            'empID' => $traineeID,
            'remarks' =>$remarks,
            'certificate' =>$data["file_name"],
            'skill_ID' => $skillsID

        );
        $result = $this->flexperformance_model->confirm_graduation($database, $ID);
        $this->flexperformance_model->assignskills($data_skills);
        if($result==true) {
            echo "<p class='alert alert-success text-center'>Graduation Confirmed Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Confirmation Failed</p>"; }
      } else {
        echo  "<p class='alert alert-danger text-center'>Failed! Attachment Not Uploaded!</p>";
      }
    }  else {
      echo "<p class='alert alert-info text-center'>Nothing to Uploaded, Invalid Training/Course Reference!</p>";
    }
  }

  public function confirmEmployeeCertification() {
    $traineeID = $this->input->post('traineeID');
    $skillsID = $this->input->post('skillsID');
    $remarks = trim($this->input->post('remarks'));
    if ($_POST && $ID!='') {

      $namefile = "certificate_".$traineeID."_".$skillsID;

      $config['upload_path']='./uploads/graduation/';
      $config['file_name'] = $namefile;
      $config['allowed_types']='pdf|jpeg|jpg|gif|png';
      $config['overwrite'] = true;

      $this->load->library('upload',$config);
      if($this->upload->do_upload("userfile")){
        $data =  $this->upload->data();
        $data_skills = array(
            'empID' => $traineeID,
            'remarks' =>$remarks,
            'certificate' =>$data["file_name"],
            'skill_ID' => $skillsID

        );
        $result =  $this->flexperformance_model->assignskills($data_skills);
        if($result==true) {
            echo "<p class='alert alert-success text-center'>Certification Confirmed Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Confirmation Failed</p>"; }
      } else {
        echo  "<p class='alert alert-danger text-center'>Failed! Attachment Not Uploaded!</p>";
      }
    }  else {
      echo "<p class='alert alert-info text-center'>Nothing to Uploaded, Invalid Skills Reference!</p>";
    }
  }

  ############################## END LEARNING AND DEVELOPMENT(TRAINING)#############################



public function addAccountability()
      {
        $positionID =  $this->input->post('positionID');
        $data = array(
             'name' => $this->input->post('title'),
             'position_ref' => $positionID,
             'weighting' => $this->input->post('weighting')
        );
        $this->flexperformance_model->addAccountability($data);

        $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Accountability Added Successifully</p>");
        $reload = '/cipay/position_info/?id='.$positionID;
        redirect($reload, 'refresh');

      }

  public function addskills()  {

     if(isset($_POST['add']))
      {
        $id = $this->input->post('positionID');
        if($this->input->post('mandatory')=='1'){

        $data = array(
             'name' => $this->input->post('name'),
             'position_ref' => $id,
             'amount' => $this->input->post('amount'),
             'type' => $this->input->post('type'),
             'description' => $this->input->post('description'),
             'created_by' =>$this->session->userdata('emp_id')
        );

        } else {
          $data = array(
                 'name' => $this->input->post('name'),
                 'position_ref' => $id,
                 'amount' => $this->input->post('amount'),
                 'type' => $this->input->post('type'),
                 'description' => $this->input->post('description'),
                 'mandatory' => 0,
                 'created_by' =>$this->session->userdata('emp_id')
            );
        }

        $this->flexperformance_model->addskills($data);
        //echo "Record Added";
        $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Skills Added Successifully</p>");
        $reload = '/cipay/position_info/?id='.$id;
        redirect($reload, 'refresh');

      }
    }

    public function updatePositionName() {
        if($_POST){

          if($this->input->post('positionID')!=''){
            $positionID = $this->input->post('positionID');
            $data = array(
                   'name' => $this->input->post('name')
              );
            $result = $this->flexperformance_model->updateposition($data, $positionID);
            if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Position Updated Successifully!</p>";
            }else{
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
            }
          }else{

            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
          }
        header('Content-type: application/json');
        echo json_encode($response_array);
        }
      }

    public function updatePositionReportsTo() {
        if($_POST){

          if($this->input->post('positionID')!=''){
            $positionID = $this->input->post('positionID');
            $values = explode('|', $this->input->post('parent'));
            $parent_code = $values[0];
            $level = $values[1];
            $data = array(
                   'parent_code' => $parent_code,
                   'level' => $level+1
              );
            $result = $this->flexperformance_model->updateposition($data, $positionID);
            if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Position Updated Successifully!</p>";
            }else{
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
            }
          }else{

            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
          }
        header('Content-type: application/json');
        echo json_encode($response_array);
        }
      }

    public function updatePositionCode() {
        if($_POST){

          if($this->input->post('positionID')!=''){
            $positionID = $this->input->post('positionID');
            $data = array(
                   'code' =>strtoupper($this->input->post('code'))
              );
            $result = $this->flexperformance_model->updateposition($data, $positionID);
            if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Position Updated Successifully!</p>";
            }else{
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
            }
          }else{

            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
          }
        header('Content-type: application/json');
        echo json_encode($response_array);
        }
      }


    public function updatePositionOrganizationLevel() {
        if($_POST){

          if($this->input->post('positionID')!=''){
            $positionID = $this->input->post('positionID');
            $data = array(
                   'organization_level' =>strtoupper($this->input->post('organization_level'))
              );
            $result = $this->flexperformance_model->updateposition($data, $positionID);
            if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Position Updated Successifully!</p>";
            }else{
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
            }
          }else{

            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
          }
        header('Content-type: application/json');
        echo json_encode($response_array);
        }
      }

    public function position() {
      $data['ddrop'] = $this->flexperformance_model->departmentdropdown();
      $data['all_position'] =  $this->flexperformance_model->allposition();
      $data['levels'] =  $this->flexperformance_model->getAllOrganizationLevel();
      $data['position'] = $this->flexperformance_model->position();
      $data['inactive_position'] = $this->flexperformance_model->inactive_position();
      $data['title']="Position";
      $this->load->view('position', $data);

    }
    public function addPosition() {
        if($_POST){

            if($this->input->post('driving_licence')==""){
            $licence = 0;
            }  else   $licence = 1;


            $values = explode('|', $this->input->post('parent'));
            $parent_code = $values[0];
            $level = $values[1];

            $data = array(
                 'name' => $this->input->post('name'),
                 'purpose' => $this->input->post('purpose'),
                 'dept_id' => $this->input->post('department'),
                 'organization_level' => $this->input->post('organization_level'),
                 'code' => strtoupper($this->input->post('code')),
                 'driving_licence' => $licence,
                 'minimum_qualification' => $this->input->post('qualification'),
                 'created_by' =>$this->session->userdata('emp_id'),
                 'position_code' =>$this->code_generator(6),
                 'parent_code' => $parent_code,
                 'level' => $level+1

            );
            $result = $this->flexperformance_model->addposition($data);
            if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Position Added Successifully!</p>";
            }else{
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Deleted!</p>";
            }
        header('Content-type: application/json');
        echo json_encode($response_array);
        }

      }

    public function addOrganizationLevel() {
        if($_POST){

            $data = array(
                 'name' => $this->input->post('name'),
                 'minSalary' => $this->input->post('minSalary'),
                 'maxSalary' => $this->input->post('maxSalary')

            );
            $result = $this->flexperformance_model->addOrganizationLevel($data);
            if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Organization Level Added Successifully!</p>";
            }else{
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Organization Level NOT Deleted!</p>";
            }
        header('Content-type: application/json');
        echo json_encode($response_array);
        }

      }


    public function deletePosition()
      {

        $id = $this->uri->segment(3);
        $data = array(
        'state' => 0
        );
        $result = $this->flexperformance_model->updateposition($data, $id);
        if($result ==true){
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Position Deleted!</p>";
        }else{
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Deleted!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);

      }

public function activatePosition()
      {

        $id = $this->uri->segment(3);
        $data = array(
        'state' => 1
        );
        $result = $this->flexperformance_model->updateposition($data, $id);
        if($result ==true){
        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-success text-center'>Position Activated Successifully!</p>";
        }else{
        $response_array['status'] = "ERR";
        $response_array['message'] = "<p class='alert alert-danger text-center'>Position Activation FAILED, Please Try again!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);

      }

  public function updateskills()  {

     if(isset($_POST['update']))
      {
        $positionref = $this->input->post('positionref');
        $skillsref = $this->input->post('skillsID');
        if($this->input->post('mandatory')=='1'){

        $data = array(
             'name' => $this->input->post('name'),
             'position_ref' => $positionref,
             'amount' => $this->input->post('amount'),
             'type' => $this->input->post('type'),
             'description' => $this->input->post('description')
        );

        } else {

        $data = array(
           'name' => $this->input->post('name'),
           'position_ref' => $positionref,
           'amount' => $this->input->post('amount'),
           'type' => $this->input->post('type'),
           'description' => $this->input->post('description'),
           'mandatory' => 0
        );
      }

      $this->flexperformance_model->updateskills($data,  $skillsref);
      //echo "Record Added";
      $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Skills Added Successifully</p>");
      $reload = '/cipay/position_info/?id='.$positionref;
      redirect($reload, 'refresh');
    }
  }


  function applyOvertime(){

    if($_POST){

      $start = $this->input->post('time_start');
      $finish = $this->input->post('time_finish');
      $reason = $this->input->post('reason');
      $category = $this->input->post('category');
      $empID = $this->session->userdata('emp_id');

      $split_start = explode("  at  ", $start);
      $split_finish = explode("  at  ", $finish);

      $start_date = $split_start[0];
      $start_time = $split_start[1];

      $finish_date = $split_finish[0];
      $finish_time = $split_finish[1];

      $start_calendar = str_replace('/', '-', $start_date);
      $finish_calendar = str_replace('/', '-', $finish_date);

      $start_final = date('Y-m-d', strtotime($start_calendar));
      $finish_final = date('Y-m-d ', strtotime($finish_calendar));

      $maxRange = ((strtotime($finish_final)-strtotime($start_final))/3600);
      $line= $this->flexperformance_model->get_linemanagerID($empID);
      foreach($line as $row){
        $linemanager = $row->line_manager;
      }
      //Overtime Should range between 24 Hrs;
      if($maxRange>24){
        echo "<p class='alert alert-warning text-center'>Overtime Should Range between 0 to 24 Hours</p>";
      } else {

        $end_night_shift = "6:00";
        $start_night_shift = "20:00";
        if($start_date == $finish_date){
          if(strtotime($start_time)>=strtotime($finish_time)){
            echo "<p class='alert alert-danger text-center'>Invalid Time Selection, Please Choose the correct time and Try Again!</p>";
          } else {
            if(strtotime($start_time)>=strtotime($start_night_shift) || $start_time<=5 && strtotime($finish_time)<=strtotime($end_night_shift)) {
              $type = 1; // echo " CORRECT:  NIGHT OVERTIME";
              $data = array(
                   'time_start' =>$start_final." ".$start_time,
                   'time_end' => $finish_final." ".$finish_time,
                   'overtime_type' => $type,
                   'overtime_category' => $category,
                   'reason' => $reason,
                   'empID' => $empID,
                   'linemanager'=>$linemanager,
                   'time_recommended_line' => date('Y-m-d h:i:s'),
                   'time_approved_hr' => date('Y-m-d'),
                   'time_confirmed_line' => date('Y-m-d h:i:s')
              );
              $result = $this->flexperformance_model->apply_overtime($data);
              if($result == true){
                echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
              } else { echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>"; }
            } elseif(strtotime($start_time)>=strtotime($end_night_shift) && strtotime($start_time)<strtotime($start_night_shift) && strtotime($finish_time)<=strtotime($start_night_shift)) {
              $type = 0; // echo "DAY OVERTIME";
              $data = array(
                   'time_start' =>$start_final." ".$start_time,
                   'time_end' => $finish_final." ".$finish_time,
                   'overtime_type' => $type,
                   'overtime_category' => $category,
                   'reason' => $reason,
                   'empID' => $empID,
                   'linemanager'=>$linemanager,
                   'time_recommended_line' => date('Y-m-d h:i:s'),
                   'time_approved_hr' => date('Y-m-d'),
                   'time_confirmed_line' => date('Y-m-d h:i:s')
              );
              $result = $this->flexperformance_model->apply_overtime($data);
              if($result == true){
                echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
              } else { echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>"; }
            } else {
              echo "<p class='alert alert-warning text-center'>Sorry Cross-Shift Overtime is NOT ALLOWED, Please Choose the correct time and Try Again!</p>";
            }

          }
        } else if($start_date > $finish_date){
          echo "<p class='alert alert-warning text-center'>Invalid Date, Please Choose the correct Date and Try Again!</p>";
        } else {
          // echo "CORRECT DATE - <BR>";
          if(strtotime($start_time)>=strtotime($start_night_shift) && strtotime($finish_time)<=strtotime($end_night_shift)){
            $type = 1; // echo "NIGHT OVERTIME CROSS DATE ";
            $data = array(
                 'time_start' =>$start_final." ".$start_time,
                 'time_end' => $finish_final." ".$finish_time,
                 'overtime_type' => $type,
                  'overtime_category' => $category,
                 'reason' => $reason,
                 'empID' => $empID,
                 'linemanager'=>$linemanager,
                 'time_recommended_line' => date('Y-m-d h:i:s'),
                 'time_approved_hr' => date('Y-m-d'),
                 'time_confirmed_line' => date('Y-m-d h:i:s')
            );
              $result = $this->flexperformance_model->apply_overtime($data);
            if($result == true){
              echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
            } else { echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>"; }
          } else {
            $type = 0; // echo "DAY OVERTIME";
            $data = array(
                 'time_start' =>$start_final." ".$start_time,
                 'time_end' => $finish_final." ".$finish_time,
                 'overtime_type' => $type,
                   'overtime_category' => $category,
                 'reason' => $reason,
                 'empID' => $empID,
                 'linemanager'=>$linemanager,
                 'time_recommended_line' => date('Y-m-d h:i:s'),
                 'time_approved_hr' => date('Y-m-d'),
                 'time_confirmed_line' => date('Y-m-d h:i:s')
            );
            $result = $this->flexperformance_model->apply_overtime($data);
            if($result == true){
              echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
            } else { echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>"; }
          }

        }
      }

    }
  }

/*IMPREST FUNCTIONS MOVED TO IMPREST CONTROLLER*/


  function overtime(){

    $data['title']="Overtime";
    $data['my_overtimes'] = $this->flexperformance_model->my_overtimes($this->session->userdata('emp_id'));
    $data['overtimeCategory'] = $this->flexperformance_model->overtimeCategory();
    $data['line_overtime'] = $this->flexperformance_model->lineOvertimes($this->session->userdata('emp_id'));

    // elseif ($this->session->userdata('line')!=0) {
    //   $data['adv_overtime'] = $this->flexperformance_model->overtimesLinemanager($this->session->userdata('emp_id'));
    // }
    // elseif ($this->session->userdata('conf_overtime')!=0) {
    //   $data['adv_overtime'] = $this->flexperformance_model->overtimesHR();
    // }
    $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();

    $this->load->view('overtime', $data);

  }


    function overtime_info(){

        $initialOvertimeID = $this->uri->segment(3);

        if(isset($_POST['update_overtime'])){

            $timeframe = $this->input->post('time_range');
            $overtimeID = $this->input->post('overtimeID');

            // Separate between Start Time-Date and End Time-Date
            $datetime = explode(" - ", $timeframe);
            $stime = $datetime[0];
            $etime = $datetime[1];

            // Separate Time and Date
            $starttime = explode(" ",$stime);
            $endtime = explode(" ",$etime);


            $startDate = explode("/",$starttime[0]);
            $endDate = explode("/",$endtime[0]);

            $finalStartDate = $startDate[2]."-".$startDate[1]."-".$startDate[0];
            $finalEndDate = $endDate[2]."-".$endDate[1]."-".$endDate[0];


            $start = $finalStartDate." ".$starttime[1];
            $end = $finalEndDate." ".$endtime[1];

            // $this->flexperformance_model->apply_overtime($data);

            $data = array(
                 'time_start' =>$start,
                 'time_end' => $end,
                 'reason' => $this->input->post('reason'),
                 'empID' => $this->session->userdata('emp_id')
            );

            $this->flexperformance_model->update_overtime($data, $overtimeID);


           $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Your Overtime was Updated Successifully</p>");
           redirect('/cipay/overtime', 'refresh');

        }

        $data['title']="Overtime";
        $data['mode'] = 2; // Mode 1 for Comment Purpose and Mode 2 for Update Purpose
        $data['overtime'] = $this->flexperformance_model->fetch_my_overtime($initialOvertimeID);
        $this->load->view('overtime_info', $data);

    }

    public function confirmOvertime()  {

          if($this->uri->segment(3)!=''){

        $overtimeID = $this->uri->segment(3);
        $data = array(
                 'status' =>5,
                 'time_confirmed_line' => date('Y-m-d h:i:s'),
                 'linemanager' =>$this->session->userdata('emp_id')
            );
          $this->flexperformance_model->update_overtime($data, $overtimeID);
          echo "<p class='alert alert-success text-center'>Overtime Confirmed Successifully</p>";
          }
   }

    public function recommendOvertime()  {

          if($this->uri->segment(3)!=''){

        $overtimeID = $this->uri->segment(3);
        $data = array(
                 'status' =>1,
                 'time_recommended_line' => date('Y-m-d h:i:s')
            );
          $this->flexperformance_model->update_overtime($data, $overtimeID);
          echo "<p class='alert alert-success text-center'>Overtime Recommended Successifully</p>";
          }
   }

    public function approved_financial_payments()  {
       // if($this->session->userdata('mng_paym')|| $this->session->userdata('recom_paym')||$this->session->userdata('appr_paym')){
            $data['overtime'] = $this->flexperformance_model->approvedOvertimes();
            $data['imprests'] = $this->imprest_model->confirmedImprests();
            //$data['arrears'] = $this->payroll_model->all_arrears();
            $data['pending_arrears'] = $this->payroll_model->pending_arrears_payment();
            $data['monthly_arrears'] = $this->payroll_model->all_arrears_payroll_month();
            $data['month_list'] = $this->flexperformance_model->payroll_month_list();

            $data['bonus'] = $this->payroll_model->selectBonus();
            $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
            $data['incentives'] = $this->payroll_model->employee_bonuses();
            $data['employee'] =  $this->payroll_model->customemployee();


            $data['otherloan'] = $this->flexperformance_model->salary_advance();

            $data['pendingPayroll_month'] = $this->payroll_model->pendingPayroll_month();
            $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
            $data['payroll'] = $this->payroll_model->pendingPayroll();
            $data['payrollList'] =  $this->payroll_model->payrollMonthList();


            $data['other_imprests'] = $this->imprest_model->othersImprests(auth()->user()->emp_id);

            $data['adv_overtime'] = $this->flexperformance_model->allOvertimes(auth()->user()->emp_id);

            $title = "Pending Payments";$parent = 'Payroll';$child = "pending-payments";

            return view('payroll.financial_payment',compact('title','parent','child','data'));


        // }else{
        //     echo 'Unauthorised Access';
        // }

   }

 function arrears_info(){
    $payrollMonth = base64_decode($this->input->get('pdate'));
    if($payrollMonth ==''){
        exit("Payroll Month Not Found");
    } else {
        $data['payroll_month']= $payrollMonth;
        $data['arrears'] = $this->payroll_model->monthly_arrears($payrollMonth);
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['title'] = "Arrears";
        $this->load->view('arrears_info', $data);
    }
 }

 function individual_arrears_info(){
    $array_input = explode('@',base64_decode($this->input->get('id')));
     $empID = $array_input[0];
     $payroll_date = $array_input[1];

    if($empID=='' || ($this->reports_model->employeeInfo($empID))==false){
        exit("Employee ID Not Found");
    } else {
        $data['info']= $this->reports_model->company_info();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['arrears'] = $this->payroll_model->employee_arrears1($empID,$payroll_date);
        $data['employee'] = $this->reports_model->employeeInfo($empID);
        $data['title'] = "Arrears";
        $this->load->view('individual_arrears_info', $data);
    }
 }


  public function holdOvertime() {

    if($this->uri->segment(3)!=''){

      $overtimeID = $this->uri->segment(3);
      $data = array(
               'status' =>3
          );
      $this->flexperformance_model->update_overtime($data, $overtimeID);
      echo "<p class='alert alert-warning text-center'>Overtime Held</p>";
    }
  }

    public function approveOvertime() {
      if($this->uri->segment(3)!=''){

        $overtimeID = $this->uri->segment(3);

        // $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==4){
          $signatory = $this->session->userdata('emp_id');
          $time_approved = date('Y-m-d');
          $amount =0;
          $result = $this->flexperformance_model->approveOvertime($overtimeID, $signatory, $time_approved);
          if($result == true){
                echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
          } else { echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>"; }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is not yet Approved</p>";
        // }
      }
    }

    public function lineapproveOvertime() {
      if($this->uri->segment(3)!=''){

        $overtimeID = $this->uri->segment(3);

        $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // $rate = $this->flexperformance_model->get_overtime_rate();

        if($status==0){
          $signatory = $this->session->userdata('emp_id');
          $time_approved = date('Y-m-d');
          $result = $this->flexperformance_model->lineapproveOvertime($overtimeID, $time_approved);
          if($result == true){
                echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
          } else { echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>"; }
        }else{
          echo "<p class='alert alert-danger text-center'>Overtime is Already Approved</p>";
        }
      }
    }


    public function hrapproveOvertime() {
      if($this->uri->segment(3)!=''){

        $overtimeID = $this->uri->segment(3);

        $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==0){
          $signatory = $this->session->userdata('emp_id');
          $time_approved = date('Y-m-d');
          $result = $this->flexperformance_model->hrapproveOvertime($overtimeID,$signatory, $time_approved);
          if($result == true){
                echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
          } else { echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>"; }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is Already Approved</p>";
        // }
      }
    }


    public function fin_approveOvertime() {
      if($this->uri->segment(3)!=''){

        $overtimeID = $this->uri->segment(3);

        // $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==0){
          $signatory = $this->session->userdata('emp_id');
          $time_approved = date('Y-m-d');
          $result = $this->flexperformance_model->fin_approveOvertime($overtimeID,$signatory, $time_approved);
          if($result == true){
                echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
          } else { echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>"; }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is Already Approved</p>";
        // }
      }
    }

    public function denyOvertime()  {  //or disapprove

          if($this->uri->segment(3)!=''){

        $overtimeID = $this->uri->segment(3);
          $result = $this->flexperformance_model->deny_overtime($overtimeID);
          if($result == true){
          echo "<p class='alert alert-warning text-center'>Overtime DISSAPPROVED Successifully</p>";
         } else { echo "<p class='alert alert-danger text-center'>FAILED to Disapprove, Some Errors Occured Please Try Again!</p>"; }
          }
   }

    public function cancelOvertime() {

        if($this->uri->segment(3)!=''){

          $overtimeID = $this->uri->segment(3);
          $result = $this->flexperformance_model->deleteOvertime($overtimeID);
          if($result == true){
            echo "<p class='alert alert-warning text-center'>Overtime DELETED Successifully</p>";
          } else { echo "<p class='alert alert-danger text-center'>FAILED to DELETE, Please Try Again!</p>"; }
        }
    }



    public function confirmOvertimePayment() {

        if($this->uri->segment(3)!=''){

          $overtimeID = $this->uri->segment(3);
          $result = $this->flexperformance_model->confirmOvertimePayment($overtimeID, 1);
          if($result == true){
            echo "<p class='alert alert-warning text-center'>Overtime Payment Confirmed Successifully</p>";
          } else { echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>"; }
        }
    }

    public function unconfirmOvertimePayment() {

        if($this->uri->segment(3)!=''){

          $overtimeID = $this->uri->segment(3);
          $result = $this->flexperformance_model->confirmOvertimePayment($overtimeID, 0);
          if($result == true){
            echo "<p class='alert alert-warning text-center'>Overtime Payment Unconfirmed Successifully</p>";
          } else { echo "<p class='alert alert-danger text-center'>FAILED to Unconfirm, Please Try Again!</p>"; }
        }
    }

    public function fetchOvertimeComment()
      {

        $overtimeID = $this->uri->segment(3);
        $data['comment'] = $this->flexperformance_model->fetchOvertimeComment($overtimeID);
        $data['mode'] = 1; // Mode 1 fo Comment Purpose and Mode 2 for Update Purpose

      $this->load->view('overtime_info', $data);
   }

    public function commentOvertime()
      {

      if (isset($_POST['apply'])) {
          $overtimeID = $this->input->post('overtimeID');
        $data = array(
            'final_line_manager_comment' =>$this->input->post('comment'),
            'commit' =>1
            );

          $this->flexperformance_model->update_overtime($data, $overtimeID);

        $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Commented Successifully</p>");
        redirect('/cipay/overtime', 'refresh');

      }

   }




  /* public function deleteposition()
      {

        $id = $this->uri->segment(3);
        $data = array(
             'state' => 0
            );
        $this->flexperformance_model->updateposition($data, $id);

        $response_array['status'] = "OK";
        $response_array['message'] = "<p class='alert alert-danger text-center'>Department Deleted!</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);

      }*/
          /*{
            $id = $this->input->get("id");
            $data = array(
             'state' => 0
            );
            $this->flexperformance_model->updateposition($data, $id);
            $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>Position Removed Successifully</p>");
            redirect('/cipay/position', 'refresh');

          }*/


   public function editdepartment()
      {
        $id = $this->input->get('id');

      if (isset($_POST['updatename'])) {

      $data = array(
            'name' =>$this->input->post("name")
            );

        $this->flexperformance_model->updatedepartment($data, $id);
        $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Department Updated Successifully</p>");
            redirect('/cipay/department', 'refresh');
    }
    elseif(isset($_POST['updatecenter'])){
      $data = array(
        'cost_center_id' =>$this->input->post("cost_center_id")
        );

    $this->flexperformance_model->updatedepartment($data, $id);
    $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Cost Center Updated Successifully</p>");
        redirect('/cipay/department', 'refresh');
    }
    elseif (isset($_POST['updatehod'])) {

      $data = array(
            'hod' =>$this->input->post("hod")
            );

        $this->flexperformance_model->updatedepartment($data, $id);
        $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Department Updated Successifully</p>");
            redirect('/cipay/department', 'refresh');
    }
    elseif (isset($_POST['updateparent'])) {

      $data = array(
            'reports_to' =>$this->input->post("parent")
            );

        $this->flexperformance_model->updatedepartment($data, $id);
        $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Department Updated Successifully</p>");
        redirect('/cipay/department');
    }

   }





  public function employee(){

    // if($this->session->userdata('mng_emp')){
    //     $data['employee'] = $this->flexperformance_model->employee();
    //   } elseif($this->session->userdata('mng_emp') ){
        $data['employee'] = $this->flexperformance_model->employee();
      /*}elseif($this->session->userdata('mng_emp')){
        $data['employee'] = $this->flexperformance_model->employeelinemanager($this->session->userdata('emp_id'));
      }*/

    $data['title']="Employee";
    $this->load->view('employee', $data);

  }



   public function payroll()
      {
      $data['title']="Payrolls And Associated";
      $this->load->view('payroll', $data);

   }

   ################## UPDATE EMPLOYEE INFO #############################

   public function updateEmployee()
      {
        $pattern = $this->input->get('id');
        $values = explode('|', $pattern);
        $empID = $values[0];
        $departmentID = $values[1];

        $data['employee'] = $this->flexperformance_model->userprofile($empID);
        $data['title']="Employee";
        $data['pdrop'] = $this->flexperformance_model->positiondropdown2($departmentID );
        $data['contract'] = $this->flexperformance_model->contractdrop();
        $data['ldrop'] = $this->flexperformance_model->linemanagerdropdown();
        $data['ddrop'] = $this->flexperformance_model->departmentdropdown();
        $data['countrydrop'] = $this->flexperformance_model->nationality();
        $data['branchdrop'] = $this->flexperformance_model->branchdropdown();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['pension'] = $this->flexperformance_model->pension_fund();
        $data['salaryTransfer'] = $this->flexperformance_model->pendingSalaryTranferCheck($empID);
        $data['positionTransfer'] = $this->flexperformance_model->pendingPositionTranferCheck($empID);
        $data['departmentTransfer'] = $this->flexperformance_model->pendingDepartmentTranferCheck($empID);
        $data['branchTransfer'] = $this->flexperformance_model->pendingBranchTranferCheck($empID);
        $data['bankdrop'] = $this->flexperformance_model->bank();
        $this->load->view('updateEmployee',$data);

   }

   public function updateFirstName() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'fname' =>$this->input->post('fname'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>First Name Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateCode() {
    $empID = $this->input->post('empID');
      if ($_POST && $empID!='') {
          $updates = array(
                      'emp_code' =>$this->input->post('emp_code'),
                      'last_updated' => date('Y-m-d')
                  );
              $result = $this->flexperformance_model->updateEmployee($updates, $empID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Code Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
}

public function updateLevel() {
  $empID = $this->input->post('empID');
    if ($_POST && $empID!='') {
        $updates = array(
                    'emp_level' =>$this->input->post('emp_level'),
                    'last_updated' => date('Y-m-d')
                );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>Level Updated Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

    }
}

   public function updateMiddleName() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'mname' =>$this->input->post('mname'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Middle Name Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateLastName() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'lname' =>$this->input->post('lname'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Last Name Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateGender() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'gender' =>$this->input->post('gender'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Gender Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateDob() {
    $empID = $this->input->post('empID');
      if ($_POST && $empID!='') {
          $updates = array(
                      'birthdate' =>$this->input->post('dob'),
                      'last_updated' => date('Y-m-d')
                  );
              $result = $this->flexperformance_model->updateEmployee($updates, $empID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Birth date Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
}

   public function updateExpatriate() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'is_expatriate' =>$this->input->post('expatriate'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'> Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateEmployeePensionFund() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'pension_fund' =>$this->input->post('pension_fund'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Pension Fund Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

  public function updateEmployeePosition() {
    $empID = $this->input->post('empID');
    if ($_POST && $empID!='') {

      $data = array(
        'empID' =>$empID,
        'parameter' =>'Position',
        'parameterID' =>2,
        'recommended_by' =>$this->session->userdata('emp_id'),
        'date_recommended' =>date('Y-m-d'),
        'date_approved' =>date('Y-m-d'),
        'old' =>$this->input->post('old'),
        'new' =>$this->input->post('position')
      );
      $result = $this->flexperformance_model->employeeTransfer($data);
      $old = $this->flexperformance_model->getAttributeName("name","position", "id", $this->input->post('old') );
      $new = $this->flexperformance_model->getAttributeName("name","position", "id", $this->input->post('position') );
      if($result==true) {
          $this->flexperformance_model->audit_log("Requested Position Change For Employee with ID = ".$empID." From ".$old." To ".$new."");
          echo "<p class='alert alert-success text-center'>Request For Position Transfer Has Been Sent Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>FAILED, Request For Position Transfe Has Failed. Please Try Again</p>";
      }

    }
  }

 /* public function updateEmployeeBranch() {
    $empID = $this->input->post('empID');
    if ($_POST && $empID!='') {
      $data = array(
        'empID' =>$empID,
        'parameter' =>'Branch',
        'parameterID' =>4,
        'recommended_by' =>$this->session->userdata('emp_id'),
        'date_recommended' =>date('Y-m-d'),
        'date_approved' =>date('Y-m-d'),
        'old' =>$this->input->post('old'),
        'new' =>$this->input->post('branch')
      );
      $result = $this->flexperformance_model->employeeTransfer($data);
      if($result==true) {
          echo "<p class='alert alert-success text-center'>Request For Branch Transfer Has Been Sent Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>FAILED, Request For Branch Transfe Has Failed. Please Try Again</p>";
      }

    }
  }*/


   public function updateEmployeeBranch() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'branch' =>$this->input->post('branch'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Branch Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }


   public function updateEmployeeNationality() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'nationality' =>$this->input->post('nationality'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Nationality Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

  public function updateDeptPos() {
    $empID = $this->input->post('empID');
    if ($_POST && $empID!='') {

      $data = array(
        'empID' =>$empID,
        'parameter' =>'Department',
        'parameterID' =>3,
        'recommended_by' =>$this->session->userdata('emp_id'),
        'date_recommended' =>date('Y-m-d'),
        'date_approved' =>date('Y-m-d'),
        'old' =>$this->input->post('oldDepartment'),
        'new' =>$this->input->post('department'),
        'old_position' =>$this->input->post('oldPosition'),
        'new_position' =>$this->input->post('position')
      );
      $result = $this->flexperformance_model->employeeTransfer($data);
      $oldp = $this->flexperformance_model->getAttributeName("name","position", "id", $this->input->post('oldPosition') );
      $newp = $this->flexperformance_model->getAttributeName("name","position", "id", $this->input->post('position') );
      $oldd = $this->flexperformance_model->getAttributeName("name","department", "id", $this->input->post('oldDepartment') );
      $newd = $this->flexperformance_model->getAttributeName("name","department", "id", $this->input->post('department') );
      if($result==true) {
        $this->flexperformance_model->audit_log("Requested Department Change For Employee with ID = ".$empID." From ".$oldd." To ".$newd." and Position From ".$oldp." To ".$newp."");
          echo "<p class='alert alert-success text-center'>Request For Department and Position Transfer Has Been Sent Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>FAILED, Request For Department and Position Transfe Has Failed. Please Try Again</p>";
      }

    }
  }

  public function approveDeptPosTransfer() {
    if ($this->uri->segment(3)!='') {
      $transferID = $this->uri->segment(3);
      $transfer =  $this->flexperformance_model->getTransferInfo($transferID);
      foreach ($transfer as $key ) {
        $empID = $key->empID;
        $department = $key->new;
        $position = $key->new_position;
      }
      $empUpdates = array(
        'department' =>$department,
        'position' =>$position,
        'last_updated' =>date('Y-m-d')
      );
      $transferUpdates = array(
        'approved_by' =>$this->session->userdata('emp_id'),
        'status' =>1,
        'date_approved' =>date('Y-m-d')
      );
      $result = $this->flexperformance_model->confirmTransfer($empUpdates, $transferUpdates, $empID, $transferID);
      if($result==true) {
          echo "<p class='alert alert-success text-center'>Transfer Completed Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>"; }
    } else {
      echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
    }
  }

  public function approveSalaryTransfer() {
    if ($this->uri->segment(3)!='') {
      $transferID = $this->uri->segment(3);
      $transfer =  $this->flexperformance_model->getTransferInfo($transferID);
      foreach ($transfer as $key ) {
        $empID = $key->empID;
        $salary = $key->new;
      }
      $empUpdates = array(
        'salary' =>$salary,
        'last_updated' =>date('Y-m-d')
      );
      $transferUpdates = array(
        'approved_by' =>$this->session->userdata('emp_id'),
        'status' =>1,
        'date_approved' =>date('Y-m-d')
      );
      $result = $this->flexperformance_model->confirmTransfer($empUpdates, $transferUpdates, $empID, $transferID);
      if($result==true) {
          echo "<p class='alert alert-success text-center'>Transfer Completed Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>"; }
    } else {
      echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
    }
  }

  public function approvePositionTransfer() {
    if ($this->uri->segment(3)!='') {
      $transferID = $this->uri->segment(3);
      $transfer =  $this->flexperformance_model->getTransferInfo($transferID);
      foreach ($transfer as $key ) {
        $empID = $key->empID;
        $position = $key->new;
      }
      $empUpdates = array(
        'position' =>$position,
        'last_updated' =>date('Y-m-d')
      );
      $transferUpdates = array(
        'approved_by' =>$this->session->userdata('emp_id'),
        'status' =>1,
        'date_approved' =>date('Y-m-d')
      );
      $result = $this->flexperformance_model->confirmTransfer($empUpdates, $transferUpdates, $empID, $transferID);
      if($result==true) {
          echo "<p class='alert alert-success text-center'>Transfer Completed Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>"; }
    } else {
      echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
    }
  }

  public function cancelTransfer() {
    if ($this->uri->segment(3)!='') {
      $transferID = $this->uri->segment(3);

      $result = $this->flexperformance_model->cancelTransfer($transferID);
      if($result==true) {
          echo "<p class='alert alert-success text-center'>Transfer Cancelled Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>FAILED: Failed To Cancel The Transfer, Please Try Again</p>"; }
    } else {
      echo "<p class='alert alert-danger text-center'>FAILED: Transfer Operation has Failed, Please Try Again</p>";
    }
  }

  public function updateSalary() {
    $empID = $this->input->post('empID');
    if ($_POST && $empID!='') {
      $updates = array(
        'salary' =>$this->input->post('salary')
      );
      $data = array(
        'empID' =>$empID,
        'parameter' =>'Salary',
        'parameterID' =>1,
        'recommended_by' =>$this->session->userdata('emp_id'),
        'date_recommended' =>date('Y-m-d'),
        'date_approved' =>date('Y-m-d'),
        'old' =>$this->input->post('old'),
        'new' =>$this->input->post('salary')
      );
      // $result = $this->flexperformance_model->updateEmployee($updates, $empID);
      $result = $this->flexperformance_model->employeeTransfer($data);
      if($result==true) {
          echo "<p class='alert alert-success text-center'>Request For Salary Updation Has Been Sent Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>FAILED, Request For Salary Updation Has Failed. Please Try Again</p>";
      }

    }
  }

   public function updateEmail() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'email' =>$this->input->post('email'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Email Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updatePostAddress() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
              $address_no = $this->input->post('address');
              $full_address = "P.O Box ".$address_no;
                $updates = array(
                            'postal_address' =>$full_address,
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Posta Address Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updatePostCity() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'postal_city' =>$this->input->post('city'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Postal City Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updatePhysicalAddress() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'physical_address' =>$this->input->post('phys_address'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Physical Address Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateMobile() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'mobile' =>$this->input->post('mobile'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Mobile Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateHomeAddress() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'home' =>$this->input->post('home_address')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Physical Address Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updateNationalID() {
        $empID = $this->input->post('empID');
        if ($_POST && $empID!='') {
            $updates = array(
                'national_id' =>$this->input->post('nationalid')
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>National ID Updated Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

        }
    }

    public function updateTin() {
        $empID = $this->input->post('empID');
        if ($_POST && $empID!='') {
            $updates = array(
                'tin' =>$this->input->post('tin')
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>Tin Updated Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

        }
    }

   public function updateBankAccountNo() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'account_no' =>$this->input->post('acc_no'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Physical Address Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }


   public function updateBank_Bankbranch(){
    $empID = $this->input->post('empID');
    $bank = $this->input->post('bank');
    $bank_branch = $this->input->post('bank_branch');
    if ($_POST && $empID!='') {
                $updates = array(
                          'bank' =>$bank,
                          'bank_branch' =>$bank_branch,
                          'last_updated' => date('Y-m-d')
                        );
                        $result = $this->flexperformance_model->updateEmployee($updates, $empID);

                        if($result==true) {
                            echo "<p class='alert alert-success text-center'>Bank and Bank Branch Updated Successifully!</p>";
                        } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }


                      }


   }





   public function updateLineManager() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'line_manager' =>$this->input->post('line_manager'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Line Manager Status Address Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateEmployeeContract() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'contract_type' =>$this->input->post('contract'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Contract Status Address Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateMeritalStatus() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'merital_status' =>$this->input->post('merital_status'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Merital Status Address Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updatePensionFundNo() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'pf_membership_no' =>$this->input->post('pension_no'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Physical Address Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateOldID() {
          $empID = $this->input->post('empID');
            if ($_POST && $empID!='') {
                $updates = array(
                            'old_emp_id' =>$this->input->post('old_id'),
                            'last_updated' => date('Y-m-d')
                        );
                    $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   public function updateEmployeePhoto() {
          $empID = $this->input->post('empID');
          // $old_photo = $this->flexperformance_model->getOldPhoto($empID);
          // $photo_path = './uploads/userprofile/'.$old_photo;
          // if($old_photo!='user.png'){
          //   unlink($photo_path);
          // }

            if ($_POST && $empID!='') {
              $namefile = "user_".$empID;
              $config['upload_path']='./uploads/userprofile/';
              $config['file_name'] = $namefile;
              $config['allowed_types']='jpeg|img|jpg|png';
              $config['overwrite'] = true;

              $this->load->library('upload',$config);
              if($this->upload->do_upload("userfile")){
                  $data =  $this->upload->data();
                  chmod($data["full_path"], 0777);
                  $updates = array(
                          'photo' =>$data["file_name"],
                          'last_updated' =>date('Y-m-d')
                      );

                  $result = $this->flexperformance_model->updateEmployee($updates, $empID);
                  if($result==true) {

                      echo "<p class='alert alert-success text-center'>Employee Picture Updated Successifully!</p>";
                  } else { echo "<p class='alert alert-danger text-center'>Failed to Update, Try again</p>"; }
              } else {
                  echo  "<p class='alert alert-danger text-center'>".$this->upload->display_errors()."<br>FAILED! User Picture Not Uploaded!</p>";
              }

            }
   }


  public function transfers() {
    // $data['leave'] =  $this->attendance_model->leavereport();
      if($this->session->userdata('mng_emp') || $this->session->userdata('vw_emp') || $this->session->userdata('appr_emp') || $this->session->userdata('mng_roles_grp')){
          $data['transfers'] =  $this->flexperformance_model->employeeTransfers();
          $data['title']="Transfers";
          $this->load->view('transfer', $data);
      }else{
          echo 'Unauthorized Access';
      }


  }


// ###################LEAVE######################################


   public function salary_advance()   {

      // if( $this->session->userdata('mng_paym') || $this->session->userdata('recom_paym') || $this->session->userdata('appr_paym')){
           $data['myloan'] = $this->flexperformance_model->mysalary_advance($this->session->userdata('emp_id'));

           // if($this->session->userdata('recom_loan')!='' && $this->session->userdata('appr_loan')){

           $data['otherloan'] = $this->flexperformance_model->salary_advance();

           // } elseif ($this->session->userdata('recom_loan')!=''){
           //     $data['otherloan'] = $this->flexperformance_model->hr_fin_salary_advance();
           // }
           // elseif ($this->session->userdata('appr_loan')!=''){
           //     $data['otherloan'] = $this->flexperformance_model->fin_salary_advance();
           // }

           $data['employee'] =  $this->flexperformance_model->customemployee();
           $data['max_amount'] =  $this->flexperformance_model->get_max_salary_advance($this->session->userdata('emp_id'));
           $data['title']="Loans and Salaries";
           $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
           $this->load->view('salary_advance', $data);
      // }else{
       //    echo 'Unauthorized Access';
       //}

   }


  public function current_loan_progress()  {
    $data['max_amount'] =  $this->flexperformance_model->get_max_salary_advance($this->session->userdata('emp_id'));
      $data['myloan'] = $this->flexperformance_model->mysalary_advance_current($this->session->userdata('emp_id'));

      $this->flexperformance_model-> update_salary_advance_notification_staff($this->session->userdata('emp_id'));


      if($this->session->userdata('recom_loan')!='' && $this->session->userdata('appr_loan')!='' ){
          $data['otherloan'] = $this->flexperformance_model->hr_fin_salary_advance_current();
          $this->flexperformance_model-> update_salary_advance_notification_hr_fin($this->session->userdata('emp_id'));

      } elseif ($this->session->userdata('recom_loan')!=''){
          $data['otherloan'] = $this->flexperformance_model->hr_salary_advance_current();
          $this->flexperformance_model-> update_salary_advance_notification_hr();

      }  elseif ($this->session->userdata('appr_loan')!=''){
          $data['otherloan'] = $this->flexperformance_model->fin_salary_advance_current();
          $this->flexperformance_model-> update_salary_advance_notification_fin();

      }

      $data['employee'] =  $this->flexperformance_model->customemployee();
      $data['title']="Loans and Salaries";
      $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
      $this->load->view('salary_advance', $data);

   }


   public function apply_salary_advance()   {

      if ($_POST) {
        $amount_normal =$this->input->post("amount");
        $amount_mid =$this->input->post("amount_mid");
        $advance_type =$this->input->post("advance_type");
        $deduction =$this->input->post("deduction");

        if($advance_type==1){
          $amount = $amount_normal;
          $deduction_amount = $amount_normal;
        } else {
          $amount = $amount_normal;
          $deduction_amount = $deduction;
        }

         $data = array(
              'empID' =>$this->session->userdata('emp_id'),
              'amount' =>$amount,
              'deduction_amount' =>$deduction_amount,
              'type' =>1,
              'notification' =>2,
              'status' =>0,
              'reason' =>$this->input->post("reason"),
              'application_date' =>date('Y-m-d')
          );

          $result = $this->flexperformance_model->applyloan($data);
          if($result==true){
              echo "<p class='alert alert-success text-center'>Request Submitted Successifully</p>";
          } else {
               echo "<p class='alert alert-warning text-center'>Request FAILED, Please Try Again</p>";
          }
       }
//      else echo "string";

   }

   public function insert_directLoan()   {

      if ($_POST) {
          $category = $this->input->post("type");

          if($category == 2){
              $type = 3;
              $form_four_index_no = $this->input->post("index_no");
              $deduction =0;
          } elseif($category == 1) {
            $form_four_index_no = "0";
            $type = 2;
            $deduction =$this->input->post("deduction");
          }

           $data = array(
                'empID' =>$this->input->post("employee"),
                'amount' =>$this->input->post("amount"),
                'deduction_amount' =>$deduction,
                'approved_hr' =>$this->session->userdata('emp_id'),
                'status' =>0,
                'notification' =>3,
                'approved_date_hr' => date('Y-m-d'),
                'type' =>$type,
                'form_four_index_no' => $form_four_index_no,
                'reason' =>$this->input->post("reason"),
                'application_date' => date('Y-m-d')
            );


          $result = $this->flexperformance_model->applyloan($data);
          if($result==true){
              echo "<p class='alert alert-success text-center'>Request Submitted Successifully</p>";
          } else {
               echo "<p class='alert alert-warning text-center'>Request FAILED, Please Try Again</p>";
          }
      }

   }

    public function confirmed_loans()  {
      $empID = $this->session->userdata('emp_id');

      $data['my_loans'] = $this->flexperformance_model->my_confirmedloan($empID);
      if($this->session->userdata('appr_loan')!=''){
        $data['other_loans'] = $this->flexperformance_model->all_confirmedloan();
      }
      $data['title']="Loan";
      $this->load->view('loan', $data);

   }

    public function loan_advanced_payments()  {
      $loanID = base64_decode($this->input->get('key'));

      $data['loan_info'] = $this->flexperformance_model->getloan($loanID);
      $data['title']="Advanced Loan Payments";
      $this->load->view('loan_adv_payment', $data);

   }

    public function adv_loan_pay() {
    if($_POST) {
      $state = 1;
      $loanID = $this->input->post('loanID');
      $accrued = $this->input->post('accrued');
      $paid = $this->input->post('paid');
      $amount = $this->input->post('amount');
      $remained = $this->input->post('remained');
      if($amount === $remained){
        $state = 0;
      }
        $data = array(
              'amount_last_paid' => $paid,
              'paid' => $paid+$accrued,
              'state' => $state,
              'last_paid_date' =>date('Y-m-d')

          );
        $result = $this->flexperformance_model->updateLoan($data,$loanID);
        if($result){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Updated Updated Successifully</p>";
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Loan Not Updated, Please try again</p>";
        }

      header('Content-type: application/json');
      echo json_encode($response_array);
    }

  }




   ################## START LOAN OPERATIONS ###########################
  public function cancelLoan() {

    if($this->uri->segment(3)!=''){
      $loanID = $this->uri->segment(3);
      $result = $this->flexperformance_model->deleteLoan($loanID);
      if($result==true){
          echo "<p class='alert alert-warning text-center'>Loan DELETED Successifully</p>";
      } else {
       echo "<p class='alert alert-danger text-center'>DELETION FAILED, Please Try Again</p>";
      }
    }
  }

    public function recommendLoan()
      {

          if($this->uri->segment(3)!=''){

        $loanID = $this->uri->segment(3);
        $data = array(

                 'approved_date_finance' =>date('Y-m-d'),
                 'approved_finance' =>$this->session->userdata('emp_id'),
                 'status' =>1,
                'notification' =>3,
            );
          $this->flexperformance_model->update_loan($data, $loanID);
          echo "<p class='alert alert-info text-center'>Loan Recommended Successifully</p>";
          }
   }

   public function hrrecommendLoan()
   {

       if($this->uri->segment(3)!=''){

     $loanID = $this->uri->segment(3);
     $data = array(

              'approved_date_hr' =>date('Y-m-d'),
              'approved_hr' =>$this->session->userdata('emp_id'),
              'status' =>6,
             'notification' =>3,
         );
       $this->flexperformance_model->update_loan($data, $loanID);
       echo "<p class='alert alert-info text-center'>Loan Recommended Successifully</p>";
       }
}

    public function holdLoan()
      {

          if($this->uri->segment(3)!=''){

        $loanID = $this->uri->segment(3);
        $data = array(
                 'status' =>3,
                'notification' =>1,
            );
          $this->flexperformance_model->update_loan($data, $loanID);
          echo "<p class='alert alert-warning text-center'>Loan Held Successifully</p>";
          }
   }

    public function approveLoan()
      {

          if($this->uri->segment(3)!=''){

        $loanID = $this->uri->segment(3);
        $todate = date('Y-m-d');

          $result = $this->flexperformance_model->approve_loan($loanID, $this->session->userdata('emp_id'), $todate);
          if($result==true){
              echo "<p class='alert alert-success text-center'>Loan Approved Successifully</p>";
          } else {
              echo "<p class='alert alert-warning text-center'>Loan NOT Approved, Please Try Again</p>";
          }

          }
   }

  public function pauseLoan() {
    if($this->uri->segment(3)!=''){
      $loanID = $this->uri->segment(3);
      $data = array(
          'state' =>2
        );

      $result = $this->flexperformance_model->updateLoan($data, $loanID);
      if($result==true){
          echo "<p class='alert alert-success text-center'>Loan PAUSED Successifully</p>";
      } else {
          echo "<p class='alert alert-warning text-center'>Loan NOT PAUSED, Please Try Again</p>";
      }
    }
  }

  public function resumeLoan() {
    if($this->uri->segment(3)!=''){
      $loanID = $this->uri->segment(3);
      $data = array(
          'state' =>1
        );

      $result = $this->flexperformance_model->updateLoan($data, $loanID);
      if($result==true){
          echo "<p class='alert alert-success text-center'>Loan RESUMED Successifully</p>";
      } else {
          echo "<p class='alert alert-warning text-center'>Loan NOT RESUMED, Please Try Again</p>";
      }
    }
  }

    public function rejectLoan()
      {

          if($this->uri->segment(3)!=''){

        $loanID = $this->uri->segment(3);
        $data = array(
                 'status' =>5,
                 'notification'=>1
            );
          $this->flexperformance_model->update_loan($data, $loanID);
          echo "<p class='alert alert-danger text-center'>Loan Disapproved!</p>";
          }
   }

   ######################## END LOAN OPERATIONS##############################




   public function loan_application_info()  {
        $id = $this->input->get('id');

      $data['data'] =  $this->flexperformance_model->getloanbyid($id);
      $data['title']="Loans and Salary Advance";
      $this->load->view('loan_application_remarks', $data);

      if (isset($_POST['add'])) {
        if ($this->session->userdata('recomloan')!=0) {
              $data2 = array(
            'reason_hr' =>$this->input->post("remarks")
            );
            }
            elseif ($this->session->userdata('appr_loan')!=0) {
              $data2 = array(
            'reason_finance' =>$this->input->post("remarks")
            );
            }

        $this->flexperformance_model->confirmloan($data2, $id);
        $reload = '/cipay/loan_application';
        redirect($reload, 'refresh');
      }

   }


   public function updateloan(){

      $loanID = $this->input->get('id');

      $data['loan'] =  $this->flexperformance_model->getloanbyid($loanID);
      $data['title']="Loan";
      $this->load->view('updateloan', $data);

   }

   public function updateloan_info()   {
       if ($_POST && $this->input->post('loanID')) {
          $loanID = $this->input->post('loanID');
          $updates = array(
            'amount' => $this->input->post('amount'),
            'deduction_amount' =>$this->input->post('deduction'),
            'reason' =>$this->input->post('reason'),
            'notification'=>1
            );

        $result = $this->flexperformance_model->update_loan($updates, $loanID);
        if($result==true){
              echo "<p class='alert alert-success text-center'>Application Updated Successifully</p>";
          } else {
               echo "<p class='alert alert-warning text-center'>Application Update FAILED, Please Try Again</p>";
          }
      }
   }


    public function financial_reports()
      {
    //
         // if($this->session->userdata('mng_paym')|| $this->session->userdata('recom_paym')||$this->session->userdata('appr_paym')){
              $data['month_list'] = $this->flexperformance_model->payroll_month_list();
              $data['year_list'] = $this->flexperformance_model->payroll_year_list();
              $title="Financial Reports";
              $parent="Payroll";
              $child="Financial Reports";


              return view('payroll.financial_reports',compact('title','parent','child','data'));
        //   }else{
        //       echo 'Unauthorised Access';
        //   }


   }

    public function organisation_reports()
    {
        if($this->session->userdata('mng_paym')|| $this->session->userdata('recom_paym')||$this->session->userdata('appr_paym')){
            $data['month_list'] = $this->flexperformance_model->payroll_month_list();
            $data['year_list'] = $this->flexperformance_model->payroll_year_list();
            $data['projects'] = $this->project_model->allProjects();
            $data['title']="Organisation Reports";
            $this->load->view('organisation_reports', $data);
        }else{
            echo 'Unauthorized Access';
        }


    }




   function not_logged_in()
   {
    $this->session->set_flashdata('error', 'Sorry! You Have to Login Before any Attempt');
    redirect('/cipay/', 'refresh');
   }

   public function viewrecords()
      {

      $data['viewrecords'] = $this->flexperformance_model->viewrecords();
      $this->load->view('viewrecords', $data);

   }

  public function home() {
    $strategyStatistics = $this->performanceModel->strategy_info($this->session->userdata('current_strategy'));
    $payrollMonth = $this->payroll_model->recent_payroll_month(date('Y-m-d'));

  $previous_payroll_month_raw = date('Y-m',strtotime( date('Y-m-d',strtotime($payrollMonth."-1 month"))));
  $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

    foreach ($strategyStatistics as $key) {
      $strategyID = $key->id;
      $strategyTitle = $key->title;
      $start = date_create($key->start);
    }
    $strategyProgress = $this->performanceModel->strategyProgress($strategyID);

    $current = date_create(date('Y-m-d'));
    $diff=date_diff($start, $current);
    $required = $diff->format("%a");
    $months = number_format(($required/30.5), 4);
    $rate_per_month = number_format(($strategyProgress/ $months), 1);

    $data['appreciated'] =  $this->flexperformance_model->appreciated_employee();

    // $data['employee_count'] =  $this->flexperformance_model->count_employees();
    $data['overview'] =  $this->flexperformance_model->employees_info();
    $data["strategyProgress"] = $strategyProgress;
    $data["monthly"] = $rate_per_month;

    $data['taskline']= $this->performanceModel->total_taskline($this->session->userdata('emp_id'));
    $data['taskstaff']= $this->performanceModel->total_taskstaff($this->session->userdata('emp_id'));


    $data['payroll_totals'] =  $this->payroll_model->payrollTotals("payroll_logs",$payrollMonth);
    $data['total_allowances'] =  $this->payroll_model->total_allowances("allowance_logs",$payrollMonth);
    $data['total_bonuses'] =  $this->payroll_model->total_bonuses($payrollMonth);
    $data['total_loans'] =  $this->payroll_model->total_loans("loan_logs",$payrollMonth);
    $data['total_heslb'] =  $this->payroll_model->total_heslb("loan_logs",$payrollMonth);
    $data['take_home'] = $this->reports_model-> sum_take_home($payrollMonth);
    $data['total_deductions'] =  $this->payroll_model->total_deductions("deduction_logs",$payrollMonth);
    $data['total_overtimes'] =  $this->payroll_model->total_overtimes($payrollMonth);
    $data['payroll_date']= $payrollMonth;
    $data['arrears'] = $this->payroll_model->arrearsMonth($payrollMonth);
    $data['s_gross_c'] = $this->reports_model->s_grossMonthly($payrollMonth);
    $data['v_gross_c'] = $this->reports_model->v_grossMonthly($payrollMonth);
    $data['s_gross_p'] = $this->reports_model->s_grossMonthly($previous_payroll_month);
    $data['v_gross_p'] = $this->reports_model->v_grossMonthly($previous_payroll_month);
    $data['s_net_c'] = $this->reports_model->staff_sum_take_home($payrollMonth);
    $data['v_net_c'] = $this->reports_model->volunteer_sum_take_home($payrollMonth);
    $data['s_net_p'] = $this->reports_model->staff_sum_take_home($previous_payroll_month);
    $data['v_net_p'] = $this->reports_model->volunteer_sum_take_home($previous_payroll_month);
    $data['v_staff'] = $this->reports_model->v_payrollEmployee($payrollMonth,'');
    $data['s_staff'] = $this->reports_model->s_payrollEmployee($payrollMonth,'');
    $data['v_staff_p'] = $this->reports_model->v_payrollEmployee($previous_payroll_month,'');
    $data['s_staff_p'] = $this->reports_model->s_payrollEmployee($previous_payroll_month,'');
    $data['net_total'] = $this->netTotalSummation($payrollMonth);

    if($this->session->userdata('password_set') =="1"){
      $this->login_info();
    }else{

    // Redirect To HOME
    $data['title'] = "Home";
    $this->load->view('home', $data);

    }


  }




function subdropFetcher(){

    if(!empty($this->uri_segment(3))){
    $querypos = $this->flexperformance_model->positionfetcher($this->uri_segment(3));

     foreach ($querysub as $row){
      echo "<option value='".$row->id."'>".$row->name."</option>";

        }
      }else{
        echo '<option value="">Position not available</option>';
    }

   }

   function positionFetcher(){

    if(!empty($this->input->post("dept_id"))){
    $query = $this->flexperformance_model->positionfetcher($this->input->post("dept_id"));
    $querypos = $query[0];
    $querylinemanager = $query[1];
    $querydirector = $query[2];
    $data = [];
    $data['position'] = $querypos;
    $data['linemanager'] = $querylinemanager;
    $data['director'] = $querydirector;

        echo json_encode($data);
      }
//    else{
//        echo '<option value="">Position not available</option>';
//    }

   }

   function bankBranchFetcher(){

    if(!empty($this->input->post("bank"))){
    $queryBranch = $this->flexperformance_model->bankBranchFetcher($this->input->post("bank"));

     foreach ($queryBranch as $rows){
      echo "<option value='".$rows->id."'>".$rows->name."</option>";

        }
      }else{
        echo '<option value="">Branch Not Available</option>';
    }

   }

   public function addkin()
      {
        date_default_timezone_set('Africa/Dar_es_Salaam');

     if(isset($_POST['add']))
      {
        $id = $this->input->get('id');

                $data = array(
                      'fname' =>$this->input->post("fname"),
                      'mname' =>$this->input->post("mname"),
                      'lname' =>$this->input->post("lname"),
                      'mobile' =>$this->input->post("mobile"),
                      'relationship' =>$this->input->post("relationship"),
                      'employee_fk' =>$id,
                      'postal_address' =>$this->input->post("postal_address"),
                      'physical_address' =>$this->input->post("physical_address"),
                      'office_no' =>$this->input->post("office_no"),
                     'added_on' => date('Y-m-d')
                );

                $this->flexperformance_model->addkin($data);
                //echo "Record Added";
                  $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Record Added Successifully</p>");

                  $reload = '/cipay/userprofile/?id='.$id;
                    redirect($reload, 'refresh');


              }
              // die();
      }

      public function deletekin()
          {
            $id = $this->input->get("id");
            $this->db->where('id',$id);
            $this->db->delete('next_of_kin');
            $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>Position Removed Successifully</p>");

                  $reload = '/cipay/employee_info/';
                    redirect($reload, 'refresh');

          }



   public function addproperty()
      {

     if(isset($_POST['add']))
      {
        if($this->input->post("type") != 'Others'){
        // $id = $this->input->get('id');
          $type = $this->input->post("type");}
        else { $type = $this->input->post("type2"); }

                $data = array(
                      'prop_type' =>$type,
                      'prop_name' =>$this->input->post("name"),
                      'serial_no' =>$this->input->post("serial"),
                      'given_by' =>$this->session->userdata('emp_id'),
                      'given_to' =>$this->input->post("employee")
                );

                $this->flexperformance_model->addproperty($data);
                  $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Property Assigned Successifully</p>");

                  $reload = '/cipay/userprofile/?id='.$this->input->post("employee");
                    redirect($reload, 'refresh');

              }
      }


   public function employee_exit()
      {

          $empID = $this->uri->segment(3);
              $datalog = array(
                  'state' =>0,
                  'empID' =>$empID,
                  'author' =>$this->session->userdata('emp_id')
              );

                $this->flexperformance_model->employeestatelog($datalog);
//                if($result ==true){
//                    $this->flexperformance_model->audit_log("Requested Deactivation of an Employee with ID =".$empID."");
                    $response_array['status'] = "OK";
                    $response_array['title'] = "SUCCESS";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Deactivation Request For This Employee Has Been Sent Successifully</p>";
                    header('Content-type: application/json');
                    echo json_encode($response_array);
//                } else {
//                    $response_array['status'] = "ERR";
//                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Deactivation Request Not Sent</p>";
//                    header('Content-type: application/json');
//                    echo json_encode($response_array);
//                }
      }


      public function deleteproperty($id)
          {
            $employee = $this->input->get("employee");

            $data = array(
                      'isActive' =>0
                );
                $this->flexperformance_model-> updateproperty($data, $id);

            $response_array['status'] = "OK";
            header('Content-type: application/json');
            echo json_encode($response_array);

          }

  public function employeeDeactivationRequest() {
      if(isset($_POST['exit']))
      {
          $exit_date = str_replace('/', '-', $this->input->post('exit_date'));

          $data = array(
              'empID' =>$this->input->post("empID"),
              'initiator' =>$this->input->post("initiator"),
              'confirmed_by' =>$this->session->userdata('emp_id'),
              'date_confirmed' =>date('Y-m-d'),
              'reason' =>$this->input->post("reason"),
              'exit_date' => date('Y-m-d',strtotime($exit_date))
          );

          $datalog = array(
              'state' =>3,
              'empID' =>$this->input->post("empID"),
              'author' =>$this->session->userdata('emp_id')
          );
//          echo json_encode($data);

          $this->flexperformance_model->employee_exit($data);
          $this->flexperformance_model->employeestatelog($datalog);
          $this->flexperformance_model->audit_log("Requested Deactivation of an Employee with ID =".$this->input->post("empID")."");
          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Employee Done Successifully</p>");

          $reload = '/cipay/userprofile/?id='.$this->input->post("empID");
          redirect($reload, 'refresh');

      }

    }

  public function employeeActivationRequest() {
        $empID = $this->uri->segment(3);
        $datalog = array(
          'state' =>1,
          'empID' =>$empID,
          'author' =>$this->session->userdata('emp_id')
        );
        $result = $this->flexperformance_model->updateemployeestatelog($datalog,$empID);
        if($result ==true){
            $this->flexperformance_model->audit_log("Activation of Employee with ID =".$empID."");
            $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-success text-center'>Activation Request For This Employee Has Been Sent Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Activation Request Not Sent</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

  public function cancelRequest() {
      $logID = $this->uri->segment(3);
      $empID = $this->uri->segment(4);
        $updates = array(
            'state' => 0,
          'current_state' =>0,
            'empID' => $empID
        );

        $result = $this->flexperformance_model->updateemployeestatelog($updates, $logID);
      $this->flexperformance_model->audit_log("Exit Cancelled of an Employee with ID =".$empID."");
      $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-success text-center'>Activation Request For This Employee Has Been CANCELLED Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);

//      if($result ==true){
//            $response_array['status'] = "OK";
//            $response_array['title'] = "SUCCESS";
//            $response_array['message'] = "<p class='alert alert-success text-center'>Activation Request For This Employee Has Been CANCELLED Successifully</p>";
//            header('Content-type: application/json');
//            echo json_encode($response_array);
//        } else {
//            $response_array['status'] = "ERR";
//            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED:Failed to Cancel this Request</p>";
//            header('Content-type: application/json');
//            echo json_encode($response_array);
//        }
    }

  public function activateEmployee() {
        $logID = $this->uri->segment(3);
        $empID = $this->uri->segment(4);
        $todate = date('Y-m-d');

        $property = array(
              'prop_type' =>"Employee Package",
              'prop_name' =>"Employee ID, Health Insuarance Card Email and System Access",
              'serial_no' =>$empID,
              'given_by' =>$this->session->userdata('emp_id'),
              'given_to' =>$empID
        );
        $datagroup = array(
               'empID' =>$empID,
               'group_name'=>1
        );

        $datalog = array(
          'state' =>1,
          'current_state' =>1,
          'empID' =>$empID,
          'author' =>$this->session->userdata('emp_id')
          );


        $result = $this->flexperformance_model->activateEmployee($property, $datagroup, $datalog, $empID, $logID, $todate);
        if($result ==true){
          $this->flexperformance_model->audit_log("Activated an Employee of ID =".$empID."");
            $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-success text-center'>Employee Has Activated Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED:Failed to Activate Employee</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

  public function deactivateEmployee() {
        //confirm exit status is 4
        $logID = $this->uri->segment(3);
        $empID = $this->uri->segment(4);
        $todate = date('Y-m-d');

        $final_state = array(
            'current_state' =>1);

        $datalog = array(
          'state' =>4,
          'current_state' =>4,
          'empID' =>$empID,
          'author' =>$this->session->userdata('emp_id')
          );
//        echo json_encode($datalog);

        $this->flexperformance_model->deactivateEmployee($empID, $datalog, $logID, $todate);
      $this->flexperformance_model->employeestatelog($datalog);
      $this->flexperformance_model->audit_log("Exit Confirm Employee of ID =".$empID."");
        $response_array['status'] = "OK";
        $response_array['title'] = "SUCCESS";
        $response_array['message'] = "<p class='alert alert-success text-center'>Employee Has Deactivated Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
//        $result = $this->flexperformance_model->deactivateEmployee($empID, $datalog, $logID, $todate);
//        if($result ==true){
//            $this->flexperformance_model->audit_log("Deactivated Employee of ID =".$empID."");
//            $response_array['status'] = "OK";
//            $response_array['title'] = "SUCCESS";
//            $response_array['message'] = "<p class='alert alert-success text-center'>Employee Has Deactivated Successifully</p>";
//            header('Content-type: application/json');
//            echo json_encode($response_array);
//        } else {
//            $response_array['status'] = "ERR";
//            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED:Failed to Deactivate Employee</p>";
//            header('Content-type: application/json');
//            echo json_encode($response_array);
//        }
    }

   public function inactive_employee() {
       if($this->session->userdata('mng_emp') || $this->session->userdata('vw_emp') || $this->session->userdata('appr_emp') || $this->session->userdata('mng_roles_grp')){
           $data['employee1'] = $this->flexperformance_model->inactive_employee1();
           $data['employee2'] = $this->flexperformance_model->inactive_employee2();

           $data['title']="Employee";
           $this->load->view('inactive_employee', $data);
       }else{
           echo 'Unauthorized Access';
       }


   }

#####################DEDUCTIONS############################################



   public function delete_deduction()
      {
         $id = $this->input->get('id');
         // $is_active = 0;

      $data = array(
            'is_active' =>0,
            'rate_employer' =>0,
            'rate_employee' =>0
            );

       if($this->flexperformance_model->updatededuction($data, $id))
       {
          redirect('/cipay/deduction', 'refresh');
      }

   }

    public function deduction_info()  {

        $pattern = $this->input->get('pattern');
        $values = explode('|', $pattern);
        $deductionID = $values[0];
        $deductionType = $values[1];

        /*
        PARAMETERS:
        1 For Pension,
        2 For Deductions,
        3 For Meals deduction
        */

        if($deductionType==1){
            $data['pension'] =  $this->flexperformance_model->getPensionById($deductionID);
            $data['deduction_type'] = 1;
        }

        if($deductionType==2){
            $data['deduction'] =  $this->flexperformance_model->getDeductionById($deductionID);
            $data['deduction_type'] = 2;
            $data['group'] =  $this->flexperformance_model->deduction_customgroup($deductionID);
            $data['employeein'] =  $this->flexperformance_model->deduction_individual_employee($deductionID);
            $data['membersCount'] =  $this->flexperformance_model->deduction_membersCount($deductionID);
            $data['groupin'] =  $this->flexperformance_model->get_deduction_group_in($deductionID);
            $data['employee'] =  $this->flexperformance_model->employee_deduction($deductionID);
        }

        if($deductionType==3){
            $data['meals'] =  $this->flexperformance_model->getMeaslById($deductionID);
            $data['deduction_type'] = 3;
        }

      $data['parameter']=$deductionType;
      $data['title']="Deductions";
      $this->load->view('deduction_info', $data);

   }

public function assign_deduction_individual(){

  if ($_POST) {

      $data = array(
          'empID' =>$this->input->post('empID'),
          'deduction' =>$this->input->post('deduction')
          );

      $result = $this->flexperformance_model->assign_deduction($data);
      if($result==true) {
        $this->flexperformance_model->audit_log("Assigned a Deduction to an Employee of ID =".$this->input->post('empID')."");
            echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>"; }

  }
}


public function assign_deduction_group(){

  if ($_POST) {

      $members = $this->flexperformance_model->get_deduction_members($this->input->post('deduction'), $this->input->post('group'));
      foreach ($members as $row) {
         $data = array(
          'empID' =>$row->empID,
          'deduction' =>$this->input->post('deduction'),
          'group_name' => $this->input->post('group')
          );
      $result = $this->flexperformance_model->assign_deduction($data);

        }
      if($result==true) {
        $this->flexperformance_model->audit_log("Assigned a Deduction to a Group of ID =".$this->input->post('group')."");
        echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>"; }


  }
}



public function remove_individual_deduction(){

  if ($_POST && !empty($this->input->post('option'))) {

      $arr = $this->input->post('option');
      $arrayString = implode(",", $arr);
      $deductionID = $this->input->post('deductionID');
      if(sizeof($arr)<1){
          echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select Atlest One Employee</p>";
      } else {

        foreach ($arr as $employee) {
            $empID = $employee;;
            $result = $this->flexperformance_model->remove_individual_deduction($empID, $deductionID );
        }
        if($result==true) {
          $this->flexperformance_model->audit_log("Removed From Deduction an Employees of IDs =".$arrayString."");
        echo "<p class='alert alert-success text-center'>Removed Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Not Removed, Try Again</p>"; }
      }
    } else {
      echo "<p class='alert alert-warning text-center'>No Item Selected</p>";
    }
}


public function remove_group_deduction(){

  if ($_POST) {

      $arr = $this->input->post('option');
      $arrayString = implode(",", $arr);
      $deductionID = $this->input->post('deductionID');
      if(sizeof($arr)<1){
          echo "<p class='alert alert-warning text-center'>No Group Selected! Please Select Atlest One Employee</p>";
      } else {

        foreach ($arr as $group) {
            $groupID = $group;
            $result = $this->flexperformance_model->remove_group_deduction($groupID, $deductionID );
        }
        if($result==true) {
          $this->flexperformance_model->audit_log("Removed From Deduction Groups of IDs =".$arrayString."");
        echo "<p class='alert alert-warning text-center'>Group Removed Successifully</p>";
        } else { echo "<p class='alert alert-danger text-center'Group NOT Removed, Try Again</p>"; }
      }
    }
}



#####################DEDUCTIONS############################################

#####################PAYE############################################





  public function addpaye() {
    if($_POST) {
      $minimum = $this->input->post('minimum');
      $maximum = $this->input->post('maximum');
      $excess = $this->input->post('excess');
      if($maximum>$minimum && $excess<$minimum){
        $data = array(
             'minimum' => $this->input->post('minimum'),
             'maximum' => $this->input->post("maximum"),
             'excess_added' => $this->input->post("excess"),
             'rate' => 0.01*($this->input->post("rate"))
            );
        $result = $this->flexperformance_model->addpaye($data);
        if($result){
            $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-success text-center'>Branch Added Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else{
            $response_array['status'] = "ERR";
            $response_array['title'] = "FAILED";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Branch not Added, Please try again</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
      }else{
          $response_array['status'] = "ERR";
            $response_array['title'] = "FAILED";
          $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Incorrect Values</p>";
          header('Content-type: application/json');
          echo json_encode($response_array);

      }
    }

  }



public function deletepaye()
          {
            $id = $this->input->get('id');
            $this->db->where('id',$id);
            $this->db->delete('PAYE');
            // die;
            $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>Record Deleted Successifully</p>");
                   redirect('/cipay/paye', 'refresh');

          }





public function paye_info()
      {
        $id = $this->input->get('id');

      $data['paye'] =  $this->flexperformance_model->getpayebyid($id);
      $data['title']="PAYE";
      $this->load->view('updatepaye', $data);
   }


  public function updatepaye() {
    if($_POST) {
      $payeID = $this->input->post('payeID');
      $minimum = $this->input->post('minimum');
      $maximum = $this->input->post('maximum');
      $excess = $this->input->post('excess');
      if($maximum>$minimum && $excess<$minimum && $payeID!=''){
        $updates = array(
             'minimum' => $this->input->post('minimum'),
             'maximum' => $this->input->post("maximum"),
             'excess_added' => $this->input->post("excess"),
             'rate' => 0.01*($this->input->post("rate"))
            );
        $result = $this->flexperformance_model->updatepaye($updates, $payeID);
        if($result){
            $this->flexperformance_model->audit_log("Updated PAYE Brackets");
            $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else{
            $response_array['status'] = "ERR";
            $response_array['title'] = "FAILED";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Not Updated Please try again</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
      }else{
          $response_array['status'] = "ERR";
            $response_array['title'] = "FAILED";
          $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Incorrect Values</p>";
          header('Content-type: application/json');
          echo json_encode($response_array);

      }
    }

  }
  public function updateOvertimeAllowance(){
      if ($_POST && $this->input->post('allowanceID')!='') {
        $allowanceID = $this->input->post('allowanceID');
        $updates = array(
            'name' =>$this->input->post('name'),
            'rate_employee' =>$this->input->post('rate_employee')/100,
            'rate_employer' =>$this->input->post('rate_employer')/100
        );
          $result = $this->flexperformance_model->updateCommonDeductions($updates, $allowanceID);
          if($result ==true) {
            echo "<p class='alert alert-success text-center'>Updated Successifully</p>";

          } else { echo "<p class='alert alert-danger text-center'>Updation Failed, Please Try Again</p>"; }
      }

   }



  public function updateCommonDeductions(){
      if ($_POST && $this->input->post('deductionID')!='') {
        $deductionID = $this->input->post('deductionID');
        $updates = array(
            'name' =>$this->input->post('name'),
            'rate_employee' =>$this->input->post('rate_employee')/100,
            'rate_employer' =>$this->input->post('rate_employer')/100
        );
          $result = $this->flexperformance_model->updateCommonDeductions($updates, $deductionID);
          if($result ==true) {
            $this->flexperformance_model->audit_log("Updated Deductions with ID = ".$deductionID."");
            echo "<p class='alert alert-success text-center'>Updated Successifully</p>";

          } else { echo "<p class='alert alert-danger text-center'>Updation Failed, Please Try Again</p>"; }
      }

   }



public function common_deductions_info() {

      $id = $this->input->get('id');
      $data['deductions'] =  $this->flexperformance_model->getcommon_deduction($id);
      $data['title']="Deductions";
      $this->load->view('updatededuction', $data);

   }


    public function updatePensionName() {
          $fundID = $this->input->post('fundID');
            if ($_POST && $fundID!='') {
                $updates = array(
                            'name' =>$this->input->post('name')
                        );
                    $result = $this->flexperformance_model->updatePension($updates, $fundID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updatePercentEmployee() {
          $fundID = $this->input->post('fundID');
            if ($_POST && $fundID!='') {
                $updates = array(
                            'amount_employee' =>$this->input->post('employee_amount')/100
                        );
                    $result = $this->flexperformance_model->updatePension($updates, $fundID);
                    if($result==true) {
                      $this->flexperformance_model->audit_log("Updated Pension with ID =".$fundID." To Employee Value of ".$this->input->post('employee_amount')." ");
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updatePercentEmployer() {
          $fundID = $this->input->post('fundID');
            if ($_POST && $fundID!='') {
                $updates = array(
                            'amount_employer' =>$this->input->post('employer_amount')/100
                        );
                    $result = $this->flexperformance_model->updatePension($updates, $fundID);
                    if($result==true) {
                      $this->flexperformance_model->audit_log("Updated Pension with ID =".$fundID." To Employer Value of ".$this->input->post('employee_amount')." ");
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updatePensionPolicy() {
          $fundID = $this->input->post('fundID');
            if ($_POST && $fundID!='') {
                $updates = array(
                            'deduction_from' =>$this->input->post('policy')
                        );
                    $result = $this->flexperformance_model->updatePension($updates, $fundID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updateDeductionName() {
          $deductionID = $this->input->post('deductionID');
            if ($_POST && $deductionID!='') {
                $updates = array(
                            'name' =>$this->input->post('name')
                        );
                    $result = $this->flexperformance_model->updateDeductions($updates, $deductionID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updateDeductionAmount() {
          $deductionID = $this->input->post('deductionID');
            if ($_POST && $deductionID!='') {
                $updates = array(
                            'amount' =>$this->input->post('amount')
                        );
                    $result = $this->flexperformance_model->updateDeductions($updates, $deductionID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updateDeductionPercent() {
          $deductionID = $this->input->post('deductionID');
            if ($_POST && $deductionID!='') {
                $updates = array(
                            'percent' =>$this->input->post('percent')/100
                        );
                    $result = $this->flexperformance_model->updateDeductions($updates, $deductionID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updateDeductionPolicy() {
          $deductionID = $this->input->post('deductionID');
            if ($_POST && $deductionID!='') {
                $updates = array(
                            'mode' =>$this->input->post('policy')
                        );
                    $result = $this->flexperformance_model->updateDeductions($updates, $deductionID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

   //UPDATE MEALS DEDUCTION

    public function updateMealsName() {
          $deductionID = $this->input->post('deductionID');
            if ($_POST && $deductionID!='') {
                $updates = array(
                            'name' =>$this->input->post('name')
                        );
                    $result = $this->flexperformance_model->updateMeals($updates, $deductionID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updateMealsMargin() {
          $deductionID = $this->input->post('deductionID');
            if ($_POST && $deductionID!='') {
                $updates = array(
                            'minimum_gross' =>$this->input->post('margin')
                        );
                    $result = $this->flexperformance_model->updateMeals($updates, $deductionID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updateMealsLowerAmount() {
          $deductionID = $this->input->post('deductionID');
            if ($_POST && $deductionID!='') {
                $updates = array(
                            'minimum_payment' =>$this->input->post('amount_lower')
                        );
                    $result = $this->flexperformance_model->updateMeals($updates, $deductionID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

    public function updateMealsUpperAmount() {
          $deductionID = $this->input->post('deductionID');
            if ($_POST && $deductionID!='') {
                $updates = array(
                            'maximum_payment' =>$this->input->post('amount_upper')
                        );
                    $result = $this->flexperformance_model->updateMeals($updates, $deductionID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

            }
   }

#####################PAYE############################################


   ##################################ALLOWANCE##########################

   public function allowance() {

        if( $this->session->userdata('mng_paym') || $this->session->userdata('recom_paym') || $this->session->userdata('appr_paym')){
            $data['allowance'] = $this->flexperformance_model->allowance();
            $data['meals'] = $this->flexperformance_model->meals_deduction();
            $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
            $data['title']="Allowances";
            $this->load->view('allowance', $data);
        }else{
            echo "Unauthorized Access";
        }

  }

  public function allowance_overtime() {

    if( $this->session->userdata('mng_paym') || $this->session->userdata('recom_paym') || $this->session->userdata('appr_paym')){
      $data['overtimes'] = $this->flexperformance_model->overtime_allowances();
      $data['overtimess'] = $this->flexperformance_model->overtime_allowances();
      $data['meals'] = $this->flexperformance_model->meals_deduction();
      $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
      $data['title']="Overtime";
      $this->load->view('allowance_overtime', $data);

    }else{
      echo "Unauthorized Access";
    }

  }

  public function statutory_deductions(){

    if( $this->session->userdata('mng_paym') || $this->session->userdata('recom_paym') || $this->session->userdata('appr_paym')){
      $data['allowance'] = $this->flexperformance_model->allowance();
      $data['overtimes'] = $this->flexperformance_model->overtime_allowances();
      $data['deduction'] = $this->flexperformance_model->deductions();
      $data['pension'] = $this->flexperformance_model->pension_fund();
      $data['meals'] = $this->flexperformance_model->meals_deduction();
      $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
      $data['deduction'] = $this->flexperformance_model->deduction();

      $data['paye'] = $this->flexperformance_model->paye();
      $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();

      $data['title']="Statutory Deductions";
      $this->load->view('statutory_deduction', $data);

    }else{
      echo "Unauthorized Access";
    }

  }


 public function non_statutory_deductions() {
  if( $this->session->userdata('mng_paym') || $this->session->userdata('recom_paym') || $this->session->userdata('appr_paym')){
    $data['allowance'] = $this->flexperformance_model->allowance();
    $data['overtimes'] = $this->flexperformance_model->overtime_allowances();
    $data['deduction'] = $this->flexperformance_model->deductions();
    $data['pension'] = $this->flexperformance_model->pension_fund();
    $data['meals'] = $this->flexperformance_model->meals_deduction();
    $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
    $data['title']="Non-Statutory Deductions";
    $this->load->view('non_statutory_deductions', $data);

  }else{
    echo "Unauthorized Access";
  }

}


    public function addAllowance()   {

      if ($_POST) {
        $policy = $this->input->post('policy');
        if($policy==1){
          $amount = $this->input->post('amount');
          $percent = 0;
        } else{
          $amount = 0;
          $percent = 0.01*($this->input->post('rate'));
        }
        $data = array(
            'name' =>$this->input->post('name'),
            'amount' =>$amount,
            'mode' =>$this->input->post('policy'),
            'state' =>1,
            'percent' =>$percent
            );

          $result = $this->flexperformance_model->addAllowance($data);
          if($result==true){
            $this->flexperformance_model->audit_log("Created New Allowance ");
              echo "<p class='alert alert-success text-center'>Allowance Registered Successifully</p>";
          } else {
               echo "<p class='alert alert-warning text-center'>Allowance Registration FAILED, Please Try Again</p>";
          }
      }

   }


    public function addOvertimeCategory()   {

      if ($_POST) {
        $data = array(
            'name' =>$this->input->post('name'),
            'day_percent' =>($this->input->post('day_percent')/100),
            'night_percent' =>($this->input->post('night_percent')/100)
          );
          $result = $this->flexperformance_model->addOvertimeCategory($data);
          if($result==true){
            $this->flexperformance_model->audit_log("Created New Overtime ");
              echo "<p class='alert alert-success text-center'>Overtime Registered Successifully</p>";
          } else {
              echo "<p class='alert alert-warning text-center'>Overtime Registration FAILED, Please Try Again</p>";
          }
      }
    }

    public function addDeduction()   {

      if ($_POST) {
        $policy = $this->input->post('policy');
        if($policy==1){
          $amount = $this->input->post('amount');
          $percent = 0;
        } else{
          $amount = 0;
          $percent = 0.01*($this->input->post('rate'));
        }
        $data = array(
            'name' =>trim($this->input->post('name')),
            'amount' =>$amount,
            'mode' =>$this->input->post('policy'),
            'state' =>1,
            'apply_to' =>2,
            'percent' =>$percent
            );

          $result = $this->flexperformance_model->addDeduction($data);
          if($result==true){
             $this->flexperformance_model->audit_log("Created New Deduction ");
              echo "<p class='alert alert-success text-center'>Deduction Registered Successifully</p>";
          } else {
               echo "<p class='alert alert-warning text-center'>Deduction Registration FAILED, Please Try Again</p>";
          }
      }

   }

public function assign_allowance_individual(){

  if ($_POST) {

      $data = array(
          'empID' =>$this->input->post('empID'),
          'allowance' =>$this->input->post('allowance')
          );

      $result = $this->flexperformance_model->assign_allowance($data);
      if($result==true) {
        $this->flexperformance_model->audit_log("Assigned an allowance to Employee with Id = ".$this->input->post('empID')." ");
            echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>"; }

  }
}



public function assign_allowance_group(){

  if ($_POST) {

      $members = $this->flexperformance_model->get_allowance_members($this->input->post('allowance'), $this->input->post('group'));
      foreach ($members as $row) {
         $data = array(
          'empID' =>$row->empID,
          'allowance' =>$this->input->post('allowance'),
          'group_name' => $this->input->post('group')
          );
      $result = $this->flexperformance_model->assign_allowance($data);

        }
      if($result==true) {
        $this->flexperformance_model->audit_log("Assigned an allowance to Group with Id = ".$this->input->post('group')." ");
        echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
      } else { echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>"; }


  }
}

public function remove_individual_from_allowance(){

  if ($_POST) {

      $arr = $this->input->post('option');
      $allowanceID = $this->input->post('allowanceID');
      if(sizeof($arr)<1){
          echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select Atlest One Employee</p>";
      } else {

        foreach ($arr as $employee) {
            $empID = $employee;;
            $result = $this->flexperformance_model->remove_individual_from_allowance($empID, $allowanceID );
        }
        if($result==true) {
          $this->flexperformance_model->audit_log("Removed Employees of IDs = ".implode(',', $arr)." From an allowance  with Id = ".$allowanceID." ");
        echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>"; }
      }
    }
}

public function remove_group_from_allowance(){

  if ($_POST) {

      $arr = $this->input->post('option');
      $allowanceID = $this->input->post('allowanceID');
      if(sizeof($arr)<1){
          echo "<p class='alert alert-warning text-center'>No Group Selected! Please Select Atlest One Employee</p>";
      } else {

        foreach ($arr as $group) {
            $groupID = $group;;
            $result = $this->flexperformance_model->remove_group_from_allowance($groupID, $allowanceID );
        }
        if($result==true) {
          $this->flexperformance_model->audit_log("Removed Group of ID = ".implode(',', $arr)." From Alowance with Id = ".$allowanceID." ");
        echo "<p class='alert alert-warning text-center'>Group Removed </p>";
        } else { echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>"; }
      }
    }
}

  public function allowance_info()  {
      $id = base64_decode($this->input->get('id'));
      $data['title'] =  'Package';
      $data['allowance'] =  $this->flexperformance_model->getallowancebyid($id);
      $data['group'] =  $this->flexperformance_model->customgroup($id);
      $data['employeein'] =  $this->flexperformance_model->get_individual_employee($id);
      $data['membersCount'] =  $this->flexperformance_model->allowance_membersCount($id);
      $data['groupin'] =  $this->flexperformance_model->get_allowance_group_in($id);
      $data['employee'] =  $this->flexperformance_model->employee_allowance($id);
      $data['allowanceID'] =  $id;
      $data['title'] =  "Allowances";
      $this->load->view('allowance_info', $data);
    }


  public function overtime_category_info()  {
      $id = base64_decode($this->input->get('id'));
      $data['title'] =  'Overtime Category';
      $data['category'] =  $this->flexperformance_model->OvertimeCategoryInfo($id);
      $this->load->view('overtime_category_info', $data);
    }


 public function deleteAllowance() {
          $ID = $this->uri->segment(3);
            if ( $ID!='') {
                $updates = array(
                            'state' =>0
                        );
                    $result = $this->flexperformance_model->updateAllowance($updates, $ID);
                    if($result==true) {
                      $json_array['status'] = "OK";
                      $json_array['message'] = "<p class='alert alert-success text-center'>Allowance Deleted!</p>";

                        echo "";
                    } else {

                      $json_array['status'] = "ERR";
                      $json_array['message'] = "<p class='alert alert-danger text-center'>Deletion Failed</p>"; }
                    header("Content-type: application/json");
                    echo json_encode($json_array);

            }
   }

  public function activateAllowance() {
    $ID = $this->uri->segment(3);
      if ( $ID!='') {
          $updates = array(
                      'state' =>1
                  );
              $result = $this->flexperformance_model->updateAllowance($updates, $ID);
              if($result==true) {
                $json_array['status'] = "OK";
                $json_array['message'] = "<p class='alert alert-success text-center'>Allowance Activated</p>";

                  echo "";
              } else {

                $json_array['status'] = "ERR";
                $json_array['message'] = "<p class='alert alert-danger text-center'>Activation Failed</p>"; }
              header("Content-type: application/json");
              echo json_encode($json_array);

      }
   }


  public function updateAllowanceName() {
    $ID = $this->input->post('allowanceID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'name' =>$this->input->post('name')
                  );
              $result = $this->flexperformance_model->updateAllowance($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }

   public function updateAllowanceTaxable() {
    $ID = $this->input->post('allowanceID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'taxable' =>$this->input->post('taxable')
                  );
              $result = $this->flexperformance_model->updateAllowance($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }

   public function updateAllowancePentionable() {
    $ID = $this->input->post('allowanceID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'pentionable' =>$this->input->post('pentionable')
                  );
              $result = $this->flexperformance_model->updateAllowance($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }

  public function updateOvertimeName() {
    $ID = $this->input->post('categoryID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'name' =>$this->input->post('name')
                  );
              $result = $this->flexperformance_model->updateOvertimeCategory($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }
  public function updateOvertimeRateDay() {
    $ID = $this->input->post('categoryID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'day_percent' =>($this->input->post('day_percent')/100)
                  );
              $result = $this->flexperformance_model->updateOvertimeCategory($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }
  public function updateOvertimeRateNight() {
    $ID = $this->input->post('categoryID');
      if ($_POST && $ID!='') {
          $updates = array(
                      'night_percent' =>($this->input->post('night_percent')/100)
                  );
              $result = $this->flexperformance_model->updateOvertimeCategory($updates, $ID);
              if($result==true) {
                  echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
              } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

      }
   }


    public function updateAllowanceAmount() {
          $ID = $this->input->post('allowanceID');
            if ($_POST && $ID!='') {
                $updates = array(
                            'amount' =>$this->input->post('amount')
                        );
                    $result = $this->flexperformance_model->updateAllowance($updates, $ID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Updation Failed</p>"; }

            }
   }

    public function updateAllowancePercent() {
          $ID = $this->input->post('allowanceID');
            if ($_POST && $ID!='') {
                $updates = array(
                            'percent' =>$this->input->post('percent')/100
                        );
                    $result = $this->flexperformance_model->updateAllowance($updates, $ID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Updation Failed</p>"; }

            }
   }


    public function updateAllowanceApplyTo() {
          $ID = $this->input->post('allowanceID');
            if ($_POST && $ID!='') {
                $updates = array(
                            'apply_to' =>$this->input->post('apply_to')
                        );
                    $result = $this->flexperformance_model->updateAllowance($updates, $ID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Updation Failed</p>"; }

            }
   }

    public function updateAllowancePolicy() {
          $ID = $this->input->post('allowanceID');
            if ($_POST && $ID!='') {
                $updates = array(
                            'mode' =>$this->input->post('policy')
                        );
                    $result = $this->flexperformance_model->updateAllowance($updates, $ID);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Updation Failed</p>"; }

            }
   }


   //###########BONUS################# updateAllowanceName


    public function addToBonus() {
          $empID = $this->input->post('employee');
          $init_author = $this->session->userdata('emp_id');
          $amount = $this->input->post('amount');
          $days = $this->input->post('days');
          $percent = $this->input->post('percent');
            if ($_POST && $empID!='' && $amount!='' && $days =='' && $percent != '') {
                $data = array(
                            'empID' =>$this->input->post('employee'),
                            'amount' =>$amount*$percent/100,
                            'name' =>$this->input->post('bonus'),
                            'init_author' =>$init_author,
                            'appr_author' =>"",
                            'state' =>0
                        );
                    $result = $this->flexperformance_model->addToBonus($data);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Added To Bonus Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Not Added, Some Erors Occured, Retry</p>"; }

            }
            if ($_POST && $empID!='' && $amount!='' && $days !='' && $percent == '') {
              $data = array(
                          'empID' =>$this->input->post('employee'),
                          'amount' =>$amount*$days/30,
                          'name' =>$this->input->post('bonus'),
                          'init_author' =>$init_author,
                          'appr_author' =>"",
                          'state' =>0
                      );
                  $result = $this->flexperformance_model->addToBonus($data);
                  if($result==true) {

                      echo "<p class='alert alert-success text-center'>Added To Bonus Successifully!</p>";
                  } else { echo "<p class='alert alert-danger text-center'>Not Added, Some Erors Occured, Retry</p>"; }

          }
          if ($_POST && $empID!='' && $amount!='' && $days =='' && $percent == '') {
            $data = array(
                        'empID' =>$this->input->post('employee'),
                        'amount' =>$amount,
                        'name' =>$this->input->post('bonus'),
                        'init_author' =>$init_author,
                        'appr_author' =>"",
                        'state' =>0
                    );
                $result = $this->flexperformance_model->addToBonus($data);
                if($result==true) {
                    echo "<p class='alert alert-success text-center'>Added To Bonus Successifully!</p>";
                } else { echo "<p class='alert alert-danger text-center'>Not Added, Some Erors Occured, Retry</p>"; }

        }
   }
    public function addBonusTag() {
          $name = $this->input->post('name');
            if ($_POST && $name!='') {
                $data = array(
                            'name' =>$this->input->post('name')
                        );
                    $result = $this->flexperformance_model->addBonusTag($data);
                    if($result==true) {
                        echo "<p class='alert alert-success text-center'>Added To Bonus Successifully!</p>";
                    } else { echo "<p class='alert alert-danger text-center'>Not Added, Some Erors Occured, Retry</p>"; }

            }
   }

public function cancelBonus()
      {
        $bonusID = $this->uri->segment(3);
        $data = array(
                            'state' =>0,
                            'appr_author' =>null
                        );
        $result = $this->flexperformance_model->updateBonus($data, $bonusID);
        if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-warning text-center'>Bonus Cancelled!</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed: Bonus Not Cancelled</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }



    }

public function confirmBonus()
      {
        $bonusID = $this->uri->segment(3);
        $appr_author = $this->session->userdata('emp_id');
        $data = array(
                            'state' =>1,
                            'appr_author' =>$appr_author
                        );
        $result = $this->flexperformance_model->updateBonus($data, $bonusID);
        if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Bonus Confirmed Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed: Bonus Not Confirmed</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }



    }

    public function recommendBonus()
      {
        $bonusID = $this->uri->segment(3);
        $appr_author = $this->session->userdata('emp_id');
        $data = array(
                            'state' =>2,
                            'recom_author' =>$appr_author
                        );
        $result = $this->flexperformance_model->updateBonus($data, $bonusID);
        if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Bonus Confirmed Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed: Bonus Not Confirmed</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }



    }


public function deleteBonus()
      {
        $bonusID = $this->uri->segment(3);
        $result = $this->flexperformance_model->deleteBonus( $bonusID);

        if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Bonus Deleted Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed: Bonus Not Deleted</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }



    }
   ###################################END ALLOWANCE#######################


#####################PRIVELEGES######################################



  public function role() {
    if( $this->session->userdata('mng_roles_grp')){
      if(isset($_POST['addrole'])){
        $data = array(
             'name' => $this->input->post('name'),
             'created_by' =>$this->session->userdata('emp_id')
        );

        $result = $this->flexperformance_model->addrole($data);
        if($result==true) {
          $this->flexperformance_model->audit_log("Created New Role with empty permission set");
          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Role Added Successifully</p>");
        redirect('/cipay/role', 'refresh');
        } else {
          echo "<p class='alert alert-danger text-center'>Department Registration has FAILED, Contact Your Admin</p>";
        }


      } elseif(isset($_POST['addgroup'])) {

        $data = array(
             'name' => $this->input->post('name'),
             'type' => $this->input->post('type'),
             'created_by' =>$this->session->userdata('emp_id')
        );

        $this->flexperformance_model->addgroup($data);

        $this->session->set_flashdata('notegroup', "<p class='alert alert-success text-center'>Group Added Successifully</p>");
        $this->department();
        redirect('/cipay/role', 'refresh');
      } else {
        // $id = $this->session->userdata('emp_id');
        $data['role'] = $this->flexperformance_model->allrole();
        $data['financialgroups'] = $this->flexperformance_model->finencialgroups();
        $data['rolesgroups'] = $this->flexperformance_model->rolesgroups();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['title']="Roles and Groups";
        $this->load->view('role', $data);
      }
    }else{
        echo "Unauthorized Access";
    }
  }
   public function groups(){
      if( $this->session->userdata('mng_roles_grp')){
        $id = base64_decode($this->input->get('id'));
        $data['members'] = $this->flexperformance_model->members_byid($id);
        $data['nonmembers'] = $this->flexperformance_model->nonmembers_byid($id);
        $data['headcounts'] = $this->flexperformance_model->memberscount($id);
        $data['groupInfo'] = $this->flexperformance_model->group_byid($id);
        $data['title']="Groups";
        $this->load->view('groups', $data);
      } else {
        echo "Unauthorized Access";
      }
   }


public function removeEmployeeFromGroup(){

  if ($_POST) {

      $arr = $this->input->post('option');
      $groupID = $this->input->post('groupID');
      if(sizeof($arr)<1){
          echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select At Least One Employee</p>";
      } else {

         foreach ($arr as $composite) {
            $values = explode('|', $composite);
            $refID = $values[0];
            $empID = $values[1];

          $result = $this->flexperformance_model->removeEmployeeFromGroup($refID, $empID, $groupID);
        }
        if($result==true) {
        echo "<p class='alert alert-success text-center'>Removed Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Not Removed, Try Again</p>"; }
      }
    }
}


public function removeEmployeeFromRole(){

  if ($_POST) {

      $arr = $this->input->post('option');
      if($arr == "" || $arr == "[]"){
          echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select At Least One Employee</p>";
      } else {

         foreach ($arr as $composite) {
            $values = explode('|', $composite);
            $refID = $values[0];
            $empID = $values[1];

            //get the group if exists
             $group_id = $this->flexperformance_model->employeeFromGroup($refID);
             if ($group_id){
                 $this->flexperformance_model->deleteEmployeeFromGroup($group_id, $empID);
             }

          $result = $this->flexperformance_model->removeEmployeeFromRole($refID, $empID);
        }
        if($result==true) {
        echo "<p class='alert alert-success text-center'>Removed Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Not Removed, Try Again</p>"; }
      }
    }
}


public function addEmployeeToGroup(){

  if ($_POST) {

      $arr = $this->input->post('option');
      $groupID = $this->input->post('groupID');
      $group_roles = $this->flexperformance_model->get_group_roles($groupID);
      $group_allowances = $this->flexperformance_model->get_group_allowances($groupID);
      $group_deductions = $this->flexperformance_model->get_group_deductions($groupID);
      if(sizeof($arr)<1){
          echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select At Least One Employee</p>";
      } else {

        foreach ($arr as $value) {
            $empID = $value;
            if(!empty($group_allowances)){
              foreach ($group_allowances as $key) {
                $allowance = $key->allowance;
                $data = array(
                       'empID' =>$empID,
                       'allowance' =>$allowance,
                       'group_name'=>$groupID
                  );

                $this->flexperformance_model->assign_allowance($data);
              }
            }
            if(!empty($group_roles)){
              foreach ($group_roles as $key) {
                $role = $key->role;
                $data = array(
                       'userID' =>$empID,
                       'role' =>$role,
                       'group_name'=>$groupID
                  );

                $this->flexperformance_model->assignrole($data);
              }
            }
            if(!empty($group_deductions)){
              foreach ($group_deductions as $key) {
                $deduction = $key->deduction;
                $data = array(
                       'empID' =>$empID,
                       'deduction' =>$deduction,
                       'group_name'=>$groupID
                  );

                $this->flexperformance_model->assign_deduction($data);
              }
            }

          $result = $this->flexperformance_model->addEmployeeToGroup($empID, $groupID);
        }
        if($result==true) {
        echo "<p class='alert alert-success text-center'>Employee Added Successifully!</p>";
        } else { echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>"; }
      }
    }
}




    public function updategroup(){
      if (isset($_POST['addselected'])) {

      $arr = $this->input->post('option');
        $groupID = $this->input->get('id');
        if(sizeof($arr)<1){
          $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>No Employee Selected! Please Select Atlest One Employee</p>");
          redirect('/cipay/groups/?id='.base64_encode($groupID), 'refresh');
      }
        foreach ($arr as $value) {
          $datagroup = array(
                     'empID' =>$value,
                     'group_name'=>$groupID
                );

            $rolesingroup = $this->flexperformance_model->roleswithingroup($groupID);
            $allowanceswithingroup = $this->flexperformance_model->allowanceswithingroup($groupID);

            foreach ($allowanceswithingroup as $allowances) {
                $allowanceswithin = $allowances->allowanceswithin;
                $data = array(
                        'empID' =>$value,
                        'allowance' =>$allowanceswithin,
                        'group_name'=>$groupID
                    );

                $this->flexperformance_model->assign_allowance($data);


            }

            foreach ($rolesingroup as $roles) {

                $roleswithin = $roles->roleswithin;
                $data = array(
                        'userID' =>$value,
                         'role' =>$roleswithin,
                         'group_name'=>$groupID
                   );

                $this->flexperformance_model->assignrole($data);


            }
          $this->flexperformance_model->add_to_group($datagroup);

    }
      $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Employee(s) Added Successifully!</p>");
      redirect('/cipay/groups/?id='.base64_encode($groupID), 'refresh');

      }

      elseif (isset($_POST['removeselected'])) {

      $arr = $this->input->post('option');
      $groupID = $this->input->get('id');
      if(sizeof($arr)<1){
          $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>No Employee Selected! Please Select Atlest One Employee</p>");
          redirect('/cipay/groups/?id='.base64_encode($groupID), 'refresh');
      }

        foreach ($arr as $composite) {
            $values = explode('|', $composite);
            $db_id = $values[0];
            $EMPID = $values[1];

          $this->flexperformance_model->remove_from_group($db_id);
          $this->flexperformance_model->remove_from_grouprole($EMPID, $groupID);
          $this->flexperformance_model->remove_from_grouppackage($EMPID, $groupID);

    }
          $this->session->set_flashdata('note', "<p class='alert alert-danger text-center'>Employees Removed Successifully!</p>");
      redirect('/cipay/groups/?id='.base64_encode($groupID), 'refresh');

    }

  }



public function deleteRole()
      {
        $roleID = $this->uri->segment(3);
        $result = $this->flexperformance_model->deleteRole($roleID);
        if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Role Deleted Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Role Not Deleted</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

public function deleteGroup()
      {
        $groupID = $this->uri->segment(3);
        $result = $this->flexperformance_model->deleteGroup($groupID);
        if($result ==true){
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Group Deleted Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Group Not Deleted</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }


   public function permission()
      {

      $data['permission'] = $this->flexperformance_model->permission();
      $data['title']="Roles and Activities";
      $this->load->view('permission', $data);


   }

    public function assignrole2() {

        if(isset($_POST['assign'])){
            $roleref = base64_encode($this->input->post('roleID'));

          $data = array(
                     'userID' =>$this->input->post('empID'),
                     'role' => $this->input->post('roleID')
                );

          $this->flexperformance_model->assignrole($data);


          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Role Assigned Successifully</p>");
          $reload = '/cipay/role_info/?id='. $roleref;
          redirect($reload, 'refresh');



        }
        if(isset($_POST['addgroup'])){
      $groupID = $this->input->post("groupID");
      $roleID = $this->input->post("roleID");

      $members = $this->flexperformance_model->get_rolegroupmembers($groupID);
      foreach ($members as $row) {
         $data = array(
          'userID' =>$row->empID,
          'role' =>$roleID,
          'group_name' =>$groupID
          );
      $this->flexperformance_model->assignrole($data);

        }

          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Role Assigned Successifully</p>");
          $reload = '/cipay/role_info/?id='. base64_encode($roleID);
          redirect($reload, 'refresh');
        }


    }

    public function role_info()  {
      if( $this->session->userdata('mng_roles_grp')){
        $id = base64_decode($this->input->get('id'));

          $data['employeesnot'] =  $this->flexperformance_model->employeesrole($id);
          $data['role'] = $this->flexperformance_model->getrolebyid($id);
          $data['roleID'] = $id;
          $data['groupsnot'] = $this->flexperformance_model->rolesgroupsnot();
          $data['groupsin'] = $this->flexperformance_model->rolesgroupsin();
          $data['members'] = $this->flexperformance_model->role_members_byid($id);
          $data['permissions'] = $this->flexperformance_model->permission();
          $data['hr_permissions'] = $this->flexperformance_model->hr_permissions();
          $data['general_permissions'] = $this->flexperformance_model->general_permissions();
          $data['cdir_permissions'] = $this->flexperformance_model->cdir_permissions();
          $data['fin_permissions'] = $this->flexperformance_model->fin_permissions();
          $data['line_permissions'] = $this->flexperformance_model->line_permissions();
          $data['perf_permissions'] = $this->flexperformance_model->perf_permissions();
          $data['title']="Roles and Activities";
          //get members with their group
            $all_member_in_role = $this->flexperformance_model->role_members_byid($id);
            foreach ($all_member_in_role as $item){
                $data['group'][$item->userID] = $this->flexperformance_model->memberWithGroup($id,$item->userID);
            }
          $this->load->view('updaterole', $data);
      }
    }



  function code_generator($size){
    $char = 'abcdefghijklmnopqrstuvwxyz';
    $init = strlen($char);
    $init--;

    $result=NULL;
        for($x=1;$x<=$size; $x++){
            $index = rand(0,$init);
            $result .= substr($char,$index,1);
        }
    return $result;
  }


  function updaterole(){
    if (isset($_POST['assign'])) {
      $arr = $this->input->post('option');
      $idpost = $this->input->post('roleID');
      $data = array(
           'permissions' =>implode("" , $arr)
      );

      $result = $this->flexperformance_model->updaterole($data, $idpost);
      if($result==true){
        $this->flexperformance_model->audit_log("Added Permissions to a Role  permission tag as ".implode("" , $arr)." ");
        $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Permissions Assigned Successifully!</p>");
        redirect('/cipay/role/', 'refresh');
      }else{
        $this->session->set_flashdata('note', "<p class='alert alert-danger text-center'>FAILED: Permissions NOT Assigned, Please try Again!</p>");
        redirect('/cipay/role/', 'refresh');
      }

    }
    if (isset($_POST['updatename'])) {
      $idpost = $this->input->get('id');

      $data = array(
           'name' =>$this->input->post('name')
      );

      $result = $this->flexperformance_model->updaterole($data, $idpost);
      if($result==true){
        $this->flexperformance_model->audit_log("Updated Role Name to   ".$this->input->post('name')." ");
        $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Role Updated Successifully!</p>");
        redirect('/cipay/role', 'refresh');
      } else{
        $this->session->set_flashdata('note', "<p class='alert alert-danger text-center'>FAILED: Role Name NOT Updated, Please Try Again!</p>");
        redirect('/cipay/role', 'refresh');
      }
    }
  }




    function assignrole(){

      if (isset($_POST['assign'])) {
        $arr = $this->input->post('option');

        $userID = $this->input->post('empID');
        if (sizeof($arr)<=0) {
          $this->session->set_flashdata('note', "<p class='alert alert-danger text-center'>Sorry, No Role Selected!</p>");
            redirect('/cipay/userprofile/?id='.$userID, 'refresh');

        }else{
        for ($i=0; $i < sizeof($arr); $i++) {
          $rolevalue = $arr[$i];
          $data = array(
                     'userID' =>$userID,
                     'role' => $rolevalue
                );

          $result = $this->flexperformance_model->assignrole($data);
        }
        if($result==true){
          $this->flexperformance_model->audit_log("Assigned a Role with IDs  ".implode(",", $arr)."  to User with ID ".$userID." ");

          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Role(s) Granted Successifully!</p>");
            redirect('/cipay/userprofile/?id='.$userID.'#tab_role', 'refresh');
        }else{
          $this->session->set_flashdata('note', "<p class='alert alert-danger text-center'>FAILED: Role(s) NOT Granted, Please Try Again!</p>");
            redirect('/cipay/userprofile/?id='.$userID.'#tab_role', 'refresh');

        }
        }
      }

    }

  function revokerole(){

      if (isset($_POST['revoke'])) {

      $arr = $this->input->post('option');
        $userID = $this->input->post('empID');
        $roleid = $this->input->post('roleid');

        if (sizeof($arr)<=0) {

          $this->session->set_flashdata('note', "<p class='alert alert-danger text-center'>Sorry, No Role Selected!</p>");
          redirect('/cipay/userprofile/?id='.$userID, 'refresh');

        } else{
        for ($i=0; $i < sizeof($arr); $i++) {
          $rolename =  $arr[$i];
          // echo $rolename;

          $result = $this->flexperformance_model->revokerole($userID, $rolename, 0);
        }
        if($result==true){
           $this->flexperformance_model->audit_log("Revoked a Role with IDs  ".implode(",", $arr)."  to User with ID ".$userID." ");
           $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>Role Revoked Successifully!</p>");
          redirect('/cipay/userprofile/?id='.$userID, 'refresh');
        }else{
          $this->session->set_flashdata('note', "<p class='alert alert-danger text-center'>FAILED: Role NOT Revoked, Please Try Again!</p>");
          redirect('/cipay/userprofile/?id='.$userID, 'refresh');
        }

      }
    }
  }
######################PRIVELEGES######################################



public function appreciation(){

      $data['title'] =  'Appreciation';
      $data['appreciated'] =  $this->flexperformance_model->appreciated_employee();
      $data['employee'] =  $this->flexperformance_model->customemployee();
      $this->load->view('appreciation', $data);
}

public function add_apprec()
      {
        date_default_timezone_set('Africa/Dar_es_Salaam');

      if (isset($_POST['update'])) {




          $data = array(
            'empID' =>$this->input->post("empID"),
            'description' =>$this->input->post("description"),
            'date_apprd' =>date('Y-m-d')
            );

          $this->flexperformance_model->add_apprec($data);
          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Employee of the month Updated Successifully</p>");
       redirect('/cipay/appreciation', 'refresh');

       }
      }


public function employee_payslip(){

    $data['title'] = 'Employee Payslip';
    $data['payrollList'] = $this->payroll_model->payrollMonthList();
    $data['title'] = "Employee Payslip";
    $data['month_list'] = $this->payroll_model->payroll_month_list();
    $data['employee'] = $this->payroll_model->customemployee();
    $this->load->view('employee_payslip', $data);
}




######################LEAVE NOTIFICATION######################################

######################NOTIFICATION BADGES ######################################


 function contract_expiration(){

       $contract =$this->flexperformance_model->contract_expiration();
       foreach ($contract as $key) {
      $retire = $key->RETIRE;
      $tempo = $key->TEMPO;
      $permanent = $key->PERMANENT;
      $intern = $key->INTERN;
    }

 }

 ################### ADD EMPLOYEE    ################################


public function updateCompanyName() {
      $id = 1;
        if ($_POST && $id!='') {
            $data = array(
                        'cname' =>$this->input->post('name')
                    );
                $result = $this->flexperformance_model->updateemployer($data, $id);
                if($result==true) {
                    echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
        </button>Company Name Updated Successifully
      </div>';
                } else { echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
        </buttonUpdation Failed
      </div>'; }

        }
   }

 function addEmployee(){
     if($this->session->userdata('mng_emp') || $this->session->userdata('vw_emp') || $this->session->userdata('appr_emp') || $this->session->userdata('mng_roles_grp')){
         $data['pdrop'] = $this->flexperformance_model->positiondropdown();
         $data['contract'] = $this->flexperformance_model->contractdrop();
         $data['ldrop'] = $this->flexperformance_model->linemanagerdropdown();
         $data['ddrop'] = $this->flexperformance_model->departmentdropdown();

         $data['pensiondrop'] = $this->flexperformance_model->pensiondropdown();
         $data['branch'] = $this->flexperformance_model->branchdropdown();
         $data['bankdrop'] = $this->flexperformance_model->bank();
         $data['countrydrop'] = $this->flexperformance_model->countrydropdown();

         $data['title'] = "Add Employee";
         $this->load->view('employeeAdd', $data);
     }else{
         echo 'Unauthorized Access';
     }

   }

public function getPositionSalaryRange()
  {

    $positionID = $this->input->post("positionID");
    $data = array(
    'state' => 0
    );

    $minSalary = $maxSalary = 0;;
    $result = $this->flexperformance_model->getPositionSalaryRange($positionID);
    foreach ($result as $value) {
      $minSalary = $value->minSalary;
      $maxSalary = $value->maxSalary;
    }
    if($result){
    //$response_array['status'] = "OK";
    $response_array['salary'] = "<input required='required'  class='form-control col-md-7 col-xs-12' type='number' min='".$minSalary."' step='0.01' max='".$maxSalary."'  name='salary'>";
    }else{
    $response_array['salary'] = "<input required='required'  class='form-control col-md-7 col-xs-12' type='text' readonly value = 'Salary was Set to 10000'><input hidden required='required' type='number' readonly value = '10000' name='salary'>";
    }
    header('Content-type: application/json');
    echo json_encode($response_array);

  }



//upload Employee

function import()
{
  if(isset($_FILES["file"]["name"]))
  {

  $path = $_FILES["file"]["tmp_name"];
  $object = PHPExcel_IOFactory::load($path);
  foreach($object->getWorksheetIterator() as $worksheet)
  {
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();
    for($row=2; $row<=$highestRow; $row++)
    {
    $data[] = array(
      'emp_id' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
      'fname' =>$worksheet->getCellByColumnAndRow(1, $row)->getValue(),
      'mname' =>$worksheet->getCellByColumnAndRow(2, $row)->getValue(),
      'lname' =>$worksheet->getCellByColumnAndRow(3, $row)->getValue(),
      'gender' =>$worksheet->getCellByColumnAndRow(4, $row)->getValue(),
      'mobile' =>$worksheet->getCellByColumnAndRow(5, $row)->getValue(),
      'email' =>$worksheet->getCellByColumnAndRow(6, $row)->getValue(),
      'salary' =>$worksheet->getCellByColumnAndRow(7, $row)->getValue(),
      'account_no' =>$worksheet->getCellByColumnAndRow(8, $row)->getValue(),
      'bank' =>1,
      'bank_branch' =>1,
      'pension_fund' =>2
    );
    }
  }
  $this->flexperformance_model->uploadEmployees($data);

  }
}


function password_generator($size){
  $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
  $init = strlen($char);
  $init--;

  $result=NULL;
      for($x=1;$x<=$size; $x++){
          $index = rand(0, $init);
          $result .= substr($char,$index,1);
      }
  return $result;
}


  public function registerEmployee() {

    if($_POST) {

      // DATE MANIPULATION
        $calendar = str_replace('/', '-', $this->input->post('birthdate'));
        $contract_end = str_replace('/', '-', $this->input->post('contract_end'));
        $contract_start = str_replace('/', '-', $this->input->post('contract_start'));

      $birthdate = date('Y-m-d', strtotime($calendar));

      $date1=date_create($birthdate);
      $date2=date_create(date('Y-m-d'));

      $diff=date_diff($date1, $date2);
      $required = $diff->format("%R%a");

      if (($required/365) > 16) {

        $countryCode = $this->input->post("nationality");
        $randomPassword = $this->password_generator(8);
        $employee = array(
          'fname' =>$this->input->post("fname"),
          'mname' =>$this->input->post("mname"),

          'emp_code' =>$this->input->post("emp_code"),
          'emp_level' =>$this->input->post("emp_level"),
          //'lname' =>$this->input->post("lname"),
          'lname' =>$randomPassword,
          'salary' =>$this->input->post("salary"),
          'gender' =>$this->input->post("gender"),
          'email' =>$this->input->post("email"),
          'nationality' =>$this->input->post("nationality"),
          'merital_status' =>$this->input->post("status"),
          'birthdate' =>$birthdate,
          'position' =>$this->input->post("position"),
          'contract_type' =>$this->input->post("ctype"),
          'postal_address' =>$this->input->post("postaddress"),
          'physical_address' =>$this->input->post('haddress'),
          'mobile' =>$this->input->post('mobile'),
          'account_no' =>$this->input->post("accno"),
          'bank' =>$this->input->post("bank"),
          'bank_branch' =>$this->input->post("bank_branch"),
          'pension_fund' =>$this->input->post("pension_fund"),
          'pf_membership_no' =>$this->input->post("pf_membership_no"),
          'home' =>$this->input->post("haddress"),
          'postal_city' =>$this->input->post("postalcity"),
          'photo' =>"user.png",
          'password_set' =>"1",
          'line_manager' =>$this->input->post("linemanager"),
          'department' =>$this->input->post("department"),
          'branch' => $this->input->post("branch"),
          'hire_date' => date('Y-m-d',strtotime($contract_start)),
          'contract_renewal_date' => date('Y-m-d'),
            'emp_id' => $this->input->post("emp_id"),
            'username' => $this->input->post("emp_id"),
            'password' => password_hash( $randomPassword, PASSWORD_BCRYPT),
            'contract_end' => date('Y-m-d',strtotime($contract_end)),
            'state' => 5,
            'national_id' =>$this->input->post("nationalid"),
            'tin' =>$this->input->post("tin"),

      );
      $empName = $this->input->post("fname") .' '.$this->input->post("mname").' '.$this->input->post("lname");


      $recordID = $this->flexperformance_model->employeeAdd($employee);

        if($recordID > 0){

        /*give 100 allocation*/
            $data = array(
                'empID' =>$this->input->post("emp_id"),
                'activity_code' =>'AC0018',
                'grant_code' =>'VSO',
                'percent' => 100.00
            );
          $this->project_model->allocateActivity($data);

          // $empID = sprintf("%03d", $countryCode).sprintf("%04d", $recordID);
          $empID = $this->input->post("emp_id");

          $property = array(
                'prop_type' =>"Employee Package",
                'prop_name' =>"Employee ID, Health Insuarance Card, Email Address and System Access",
                'serial_no' =>$empID,
                'given_by' =>$this->session->userdata('emp_id'),
                'given_to' =>$empID
          );
          $datagroup = array(
                 'empID' =>$empID,
                 'group_name'=>1
          );

          $result = $this->flexperformance_model->updateEmployeeID($recordID, $empID, $property, $datagroup);
          if($result == true){

        $senderInfo = $this->payroll_model->senderInfo();
    //         /* EMAIL*/
    //     foreach ($senderInfo as $keyInfo) {
    //       $host = $keyInfo->host;
    //       $username = $keyInfo->username;
    //       $password = $keyInfo->password;
    //       $smtpsecure = $keyInfo->secure;
    //       $port = $keyInfo->port;
    //       $senderEmail = $keyInfo->email;
    //       $senderName = $keyInfo->name;
    //     }
    //   // PHPMailer object
    //     $mail = $this->phpmailer_lib->load();// PHPMailer object
    //     // SMTP configuration
    //     $mail->isSMTP();
    //     $mail->Host     = $host;
    //     $mail->SMTPAuth = true;
    //     $mail->Username = $username;
    //     $mail->Password = $password;


    //     $mail->SMTPSecure = $smtpsecure;
    //     $mail->Port     = $port;


    //     $mail->setFrom($senderEmail, $senderName);

    //     // Add a recipient
    //     $mail->addAddress($this->input->post("email"));


    //     // Email subject
    //     $mail->Subject = "VSO User Credentials";

    //     // Set email format to HTML
    //     $mail->isHTML(true);

    //     // Email body content
    //     $mailContent = "<p>Dear <b>".$empName."</b>,</p>
    //                 <p>Your Flex Performance Account login credential are  password: <b>".$randomPassword."</b>.
    //                 Please use your employee ID as your username.</p>
    //                 <p>You are advised not to share your password with anyone. If you dont know this activity or you received this email by accident, please report
    //                     this incident to the system administrator.<br><br>
    //                     Thank you,<br>
    //                     Flex Performance Software Self Service.</p>";
    //     $mail->Body = $mailContent;

    //     if(!$mail->send()){

    //         $this->session->set_flashdata("note", "<p><font color='green'>Email was not sent</font></p>");
    //         }else{
    //         $this->session->set_flashdata("note","<p><font color='green'>Email sent!</font></p>");
    //       }

              /*add in transfer with status = 5 (registered, waiting for approval)*/
              $data_transfer = array(
                  'empID' => $this->input->post("emp_id"),
                  'parameter' => 'New Employee',
                  'parameterID' => 5,
                  'old' => 0,
                  'new' => $this->input->post("salary"),
                  'old_department' => 0,
                  'new_department' => $this->input->post("department"),
                  'old_position' => 0,
                  'new_position' => $this->input->post("position"),
                  'status' => 5,//new employee
                  'recommended_by' => $this->session->userdata('emp_id'),
                  'approved_by' => '',
                  'date_recommended' => date('Y-m-d'),
                  'date_approved' => ''
              );
              $this->flexperformance_model->employeeTransfer($data_transfer);
              /*end add employee in transfer*/

              $this->flexperformance_model->audit_log("Registered New Employee ");
            $response_array['empID'] = $empID;
            $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<div class='alert alert-success alert-dismissible fade in' role='alert'>
                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span> </button>Employee Added Successifully
                    </div>";
            header('Content-type: application/json');
            $response_array['credentials'] = "username ni ".$this->input->post("emp_id")."password:".$randomPassword;
            echo json_encode($response_array);
          }else{
            $response_array['status'] = "ERR";
            $response_array['title'] = "FAILED";
            $response_array['message'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span> </button>FAILED: Employee Not Added Please try again
                    </div>';
            header('Content-type: application/json');
            echo json_encode($response_array);
          }
        } else {
          $response_array['status'] = "ERR";
          $response_array['title'] = "FAILED";
          $response_array['message'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span> </button>Registration Failed, Employee`s Age is Less Than 16
                  </div>';
          header('Content-type: application/json');
          echo json_encode($response_array);


        }

      }
    }
  }


 ##################  END ADD EMPLOYEE  ############################





    public function organization_structure()
      {
        $id = 1;
       $this->load->model("flexperformance_model");
       $data['details'] = $this->flexperformance_model->employerdetails($id);

       $data['allpositioncodes'] = $this->flexperformance_model->allpositioncodes();
       $data['topposition'] = $this->flexperformance_model->topposition();
       $data['otherpositions'] = $this->flexperformance_model->otherpositions();

       $data['allDepartments'] = $this->flexperformance_model->alldepartmentcodes();
       $data['topDepartment'] = $this->flexperformance_model->topDepartment();
       $data['childDepartments'] = $this->flexperformance_model->childDepartments();

       $data['title'] = "Employer Info";
       $this->load->view('company_info', $data);
      }

    public function accounting_coding()
    {

        $this->load->model("flexperformance_model");
        $data['accounting_coding'] = $this->flexperformance_model->accounting_coding();
        $this->load->view('accounting_coding', $data);
    }

    public function department_structure()
      {
        $id = 1;
       $this->load->model("flexperformance_model");
       $data['details'] = $this->flexperformance_model->employerdetails($id);

       $data['allpositioncodes'] = $this->flexperformance_model->allpositioncodes();
       $data['topposition'] = $this->flexperformance_model->topposition();
       $data['otherpositions'] = $this->flexperformance_model->otherpositions();

       $data['allDepartments'] = $this->flexperformance_model->alldepartmentcodes();
       $data['topDepartment'] = $this->flexperformance_model->topDepartment();
       $data['childDepartments'] = $this->flexperformance_model->childDepartments();

       $data['title'] = "Employer Info";
       $this->load->view('company_info', $data);
      }


    public function Oldorganization_structure()
      {
        $id = 1;
       $this->load->model("flexperformance_model");
       $data['details'] = $this->flexperformance_model->employerdetails($id);

       $data['allpositioncodes'] = $this->flexperformance_model->allpositioncodes();
       $data['topposition'] = $this->flexperformance_model->topposition();
       $data['otherpositions'] = $this->flexperformance_model->otherpositions();

       $data['title'] = "Employer Info";
       $this->load->view('company_info', $data);


         if(isset($_POST['update']))
      {

        $config = array(
            'upload_path' => "./uploads/logo/",
            'file_name' => "organization_logo",
            'allowed_types' => "img|jpg|jpeg|png",
            'overwrite' => TRUE
            );
        $path = "/uploads/logo/";

        $this->load->library('upload', $config);
        if($this->upload->do_upload())
        {
        $data =  $this->upload->data();
        // $completepath =  $path.$data["file_name"];

         $data = array(
            // 'tin' => $this->input->post('tin'),
            // 'cname' => $this->input->post('cname'),
            // 'postal_address' => $this->input->post('postal_address'),
            'postal_city' => $this->input->post('postal_city'),
            'phone_no1' => $this->input->post('phone_no1'),
            'phone_no2' => $this->input->post('phone_no2'),
            'phone_no3' => $this->input->post('phone_no3'),
            'fax_no' => $this->input->post('fax_no'),
            'email' => $this->input->post('email' ),
            'plot_no' => $this->input->post('plot_no'),
            'block_no' => $this->input->post('block_no'),
            'street' => $this->input->post('street'),
            'branch' => $this->input->post('branch'),
            'wcf_reg_no' => $this->input->post('wcf_reg_no'),
            'heslb_code_no' => $this->input->post('heslb_code_no'),
            'business_nature' => $this->input->post('business_nature'),
            'logo' => $path.$data["file_name"],
            'company_type' => $this->input->post('company_type')

               );

          $this->flexperformance_model->updateemployer($data, $id);// ) {
          $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Company Information Updated Successifully</p>");

          redirect('/cipay/employer', 'refresh');
          }


        else
        {
        // $error = $this->upload->display_errors();
        $this->session->set_flashdata('note', "<p class='alert alert-warning text-center'>The filetype you are attempting to upload is not allowed!.</p>");
          redirect('/cipay/employer', 'refresh');
        }

      }

    }


    ################## GRIEVANCES AND DISCPLINARY#############################

    public function grievances(){
      $empID = $this->session->userdata('emp_id');
      $data['title'] =  'Grievances and Disciplinary';
      $data['my_grievances'] =  $this->flexperformance_model->my_grievances($empID);
      //if($this->session->userdata('griev_hr')!=''){
        $data['other_grievances'] =  $this->flexperformance_model->all_grievances();
      //}
      $this->load->view('grievances', $data);



   if (isset($_POST["submit"]) ){

      $config = array(
            'upload_path' => "./uploads/grievances/",
            'file_name' => "FILE".date("Ymd-His"),
            'allowed_types' => "img|jpg|jpeg|png|pdf|xlsx|xls|doc|ppt|docx",
            'overwrite' => TRUE
            );
        $path = "/uploads/grievances/";

        $this->load->library('upload', $config);
        if($this->upload->do_upload()){

        $data =  $this->upload->data();
         if($this->input->post('anonymous') == '1'){

          $data = array(
            'title' =>$this->input->post("title"),
            'description' =>$this->input->post("description"),
            'empID' =>$this->session->userdata('emp_id'),
            'anonymous' => 1,
            'attachment' =>$path.$data["file_name"],
            'forwarded' => 1
            ); }
            else {

          $data = array(
            'title' =>$this->input->post("title"),
            'description' =>$this->input->post("description"),
            'empID' =>$this->session->userdata('emp_id'),
            'attachment' =>$path.$data["file_name"]
            );


            }

      $this->flexperformance_model->add_grievance($data);
      $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Your Grievance has been Submitted Successifully</p>");
      redirect('/cipay/grievances', 'refresh');
        }

        else{


         if($this->input->post('anonymous') == '1'){

          $data = array(
            'title' =>$this->input->post("title"),
            'description' =>$this->input->post("description"),
            'empID' =>$this->session->userdata('emp_id'),
            'attachment' =>"N/A",
            'anonymous' => 1,
            'forwarded' => 1
            );

         }
            else {


          $data = array(
            'title' =>$this->input->post("title"),
            'description' =>$this->input->post("description"),
            'empID' =>$this->session->userdata('emp_id'),
            'attachment' =>"N/A",
            );


            }

      $this->flexperformance_model->add_grievance($data);
      $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Your Grievance has been Submitted Successifully</p>");
      redirect('/cipay/grievances', 'refresh');

        }


   }


}

public function grievance_details()
      {
         $id = $this->input->get('id');

          $data['title'] =  'Grievances and Disciplinary';
          $data['details'] =  $this->flexperformance_model->grievance_details($id);

    $this->load->view('grievance_details', $data);

    if (isset($_POST["submit"]) ){

      $id = $this->input->get('id');

      $config = array(
            'upload_path' => "./uploads/grievances/",
            'file_name' => "FILE".date("Ymd-His"),
            'allowed_types' => "img|jpg|jpeg|png|pdf|xlsx|xls|doc|ppt|docx",
            'overwrite' => TRUE
            );
        $path = "/uploads/grievances/";

        $this->load->library('upload', $config);
        if($this->upload->do_upload()){
            // echo "skip"; exit();

        $uploadData =  $this->upload->data();

          $updates = array(
            'remarks' =>$this->input->post("remarks"),
            'support_document' => $path.$uploadData["file_name"],
            'forwarded_by' => $this->session->userdata('emp_id'),
            'forwarded' => 1
            );

      $this->flexperformance_model->forward_grievance($updates, $id);
      $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Your Grievance has been Submitted Successifully</p>");
      redirect('/cipay/grievances', 'refresh');
        }

        else{


          $data = array(
            'remarks' =>$this->input->post("remarks"),
            'forwarded_by' => $this->session->userdata('emp_id'),
            'forwarded' => 1
            );

         }

      $this->flexperformance_model->forward_grievance($data, $id);
      $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Your Grievance has been Submitted Successifully</p>");
      redirect('/cipay/grievances', 'refresh');




      }

    //   SOLVE

    if (isset($_POST["solve"]) ){

      $id = $this->input->get('id');

      $config = array(
            'upload_path' => "./uploads/grievances/",
            'file_name' => "FILE".date("Ymd-His"),
            'allowed_types' => "img|jpg|jpeg|png|pdf|xlsx|xls|doc|ppt|docx",
            'overwrite' => TRUE
            );
        $path = "/uploads/grievances/";

        $this->load->library('upload', $config);
        if($this->upload->do_upload()){
            // echo "skip"; exit();

        $uploadData =  $this->upload->data();

          $updates = array(
            'remarks' =>$this->input->post("remarks"),
            'support_document' => $path.$uploadData["file_name"],
            'forwarded_by' => $this->session->userdata('emp_id'),
            'forwarded' => 1,
            'status' => 1
            );

      $this->flexperformance_model->forward_grievance($updates, $id);
      $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Grievance has Solved Successifully</p>");
      redirect('/cipay/grievances', 'refresh');

        } else{


          $data = array(
            'remarks' =>$this->input->post("remarks"),
            'forwarded_by' => $this->session->userdata('emp_id'),
            'forwarded' => 1,
            'status' => 1
            );

         }

      $this->flexperformance_model->forward_grievance($data, $id);
      $this->session->set_flashdata('note', "<p class='alert alert-success text-center'>Grievance has Solved Successifully</p>");
      redirect('/cipay/grievances', 'refresh');




      }

   }
  public function resolve_grievance() {

    if($this->uri->segment(3)!=''){
      $refID = $this->uri->segment(3);
      $datalog = array(
            'status' =>1
            );

      $result = $this->flexperformance_model->updategrievances($datalog, $refID);

      if($result==true){
          echo "<p class='alert alert-warning text-center'>Marked As Resolved</p>";
      } else {
       echo "<p class='alert alert-danger text-center'>FAILED: Try again</p>";
      }
    }
  }
  public function unresolve_grievance() {

    if($this->uri->segment(3)!=''){
      $refID = $this->uri->segment(3);
      $datalog = array(
            'status' =>0
            );

      $result = $this->flexperformance_model->updategrievances($datalog, $refID);

      if($result==true){
          echo "<p class='alert alert-warning text-center'>Marked As Unresolved</p>";
      } else {
       echo "<p class='alert alert-danger text-center'>FAILED Try again</p>";
      }
    }
  }



  public function audit_logs() {
    if( $this->session->userdata('mng_audit')){
      $data['logs'] =  $this->flexperformance_model->audit_logs();
      $data['purge_logs'] =  $this->flexperformance_model->audit_purge_logs();
      $data['title']="Audit Trail";
      $this->load->view('audit_logs', $data);
    } else {
      echo "Unauthorized Access";
    }
  }


   public function export_audit_logs() {
    $this->load->library("excel");
    $object = new Spreadsheet();
    $filename = "audit_logs_".date('Y_m_d_H_i_s').".xls";

    $object->setActiveSheetIndex(0);

    $table_columns = array("S/N","ID","Name", "Department", "Position", "Description", "Platform", "Agent", "IP Address", "Time");

    $column = 0;

    foreach($table_columns as $field)
    {
     $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
     $column++;
    }

    $records = $this->flexperformance_model->audit_logs();

    $data_row = 2;

    $SNO = 1;
    foreach($records as $row)
    {
     $object->getActiveSheet()->setCellValueByColumnAndRow(0, $data_row, $SNO);
     $object->getActiveSheet()->setCellValueByColumnAndRow(1, $data_row, $row->empID);
     $object->getActiveSheet()->setCellValueByColumnAndRow(2, $data_row, $row->empName);
     $object->getActiveSheet()->setCellValueByColumnAndRow(3, $data_row, $row->department);
     $object->getActiveSheet()->setCellValueByColumnAndRow(4, $data_row, $row->position);
     $object->getActiveSheet()->setCellValueByColumnAndRow(5, $data_row, $row->description);
     $object->getActiveSheet()->setCellValueByColumnAndRow(6, $data_row, $row->platform);
     $object->getActiveSheet()->setCellValueByColumnAndRow(7, $data_row, $row->agent);
     $object->getActiveSheet()->setCellValueByColumnAndRow(8, $data_row, $row->ip_address);
     $object->getActiveSheet()->setCellValueByColumnAndRow(9, $data_row, $row->dated." at ".$row->timed);
     $data_row++;
     $SNO++;
    }

       $writer = new Xls($object); // instantiate Xlsx
       header('Content-Type: application/vnd.ms-excel'); // generate excel file
       header('Content-Disposition: attachment;filename="'. $filename .'.xls"');
       header('Cache-Control: max-age=0');
       ob_end_clean();
       ob_start();
       $writer->save('php://output');	// download file

    $result =$this->flexperformance_model->clear_audit_logs();

    if($result==true) {
        $logData = array(
            'empID' => $this->session->userdata('emp_id'),
            'description' => "Cleared Audit logs",
            'agent' => $this->session->userdata('agent'),
//        'platform' =>$this->agent->platform(),
            'ip_address' => $this->input->ip_address(),
            'due_date' => date('Y_m_d_H_i_s')
        );
    }

     $this->flexperformance_model->insertAuditPurgeLog($logData);


 }
############################ END GRIEVANCES AND DISCPLINARY#############################





#################################### TEST FUNCTIONS #######################################


  public function userArray() {
    $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
    $recipients = $this->flexperformance_model->employeeMails();



      // SEND EMAIL
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mirajissa1@gmail.com';
        $mail->Password = 'Mirajissa1@1994';

         //For server uses
        /*$mail->SMTPSecure = 'tls';
        $mail->Port     = 587;*/

        //For localhost uses
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;


        $mail->setFrom('mirajissa1@gmail.com', 'Miraj Issa');
        // $mail->addReplyTo('mirajissa1@gmail.com', 'CodexWorld');

        // Add a recipient
        // $mail->addAddress($email);

        foreach($recipients as $row)
      {
        $mail->addAddress($row->email, $row->name);
      }
        // Add cc or bcc
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Email subject
        $mail->Subject ='Test Multiple Mail';

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Hello! &nbsp; YOUR NAME HERE</h1>
            <p>Please Find The Attached Payslip For the <b>THIS MONTH</b> Payroll Month</p>";
        $mail->Body = $mailContent;
        // $mail->AddStringAttachment($payslip, 'payslip.pdf');

        $mail->send(); // Send email

        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Emails  has been sent SUCCESSIFULLY';
        }
        // SEND EMAIL

  }
  public function userAgent() {
    if ($this->agent->is_browser())
    {
      $agent = $this->agent->browser().' '.$this->agent->version();
    }
    elseif ($this->agent->is_robot())
    {
      $agent = $this->agent->robot();
    }
    elseif ($this->agent->is_mobile())
    {
      $agent = $this->agent->mobile();
    }
    else
    {
      $agent = 'Unidentified User Agent';
    }

    echo $agent."<br>";

    echo $this->agent->platform()."<br>"; // Platform info (Windows, Linux, Mac, etc.)
    echo $this->input->ip_address();

  }




   function sendMailuser()
{
  /*$settings = $this->flexperformance_model->get_email_conf();
  foreach ($settings as $data) {
    $host = $data->host;
    $port = $data->port;
  }*/
  //exit($host.$port);
  $d =
    $config = array(
  'protocol' => 'TLS',
  'smtp_host' => 'smtp.gmail.com',
  'smtp_port' => 587,
  'smtp_user' => 'mirajissa1@gmail.com', // change it to yours
  'smtp_pass' => 'Mirajissa1@1994', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);

        $message = "This is my email";
        $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('mirajissa1@gmail.com'); // change it to yours
      $this->email->to('mirajissa1@gmail.com');// change it to yours
      $this->email->subject('Boardroom invitation');
      $this->email->message($message);
     if ($this->email->send())
     {
       echo 'User Registered Successfuly';
        // redirect('../setting/user/');
       echo $this->email->print_debugger();
     }
     else
    {
     show_error($this->email->print_debugger());
    }

}

public function patterntest(){
    $string = "6|0|2|0.165*3|300000|1|0.000";
    $split = explode("*", $string);
    foreach($split as $values){
        $allowances = explode("|",$values);

        echo $this->flexperformance_model->get_allowance_name($allowances[0])." The Rate is ".$allowances[3]."<br>";
    }


}


   function sendMailuserFinal()
{
  /*$settings = $this->flexperformance_model->get_email_conf();
  foreach ($settings as $data) {
    $host = $data->host;
    $port = $data->port;
  }*/
  //exit($host.$port);
  $d =
    $config = array(
  'protocol' => 'TLS',
  'smtp_host' => 'smtp.gmail.com',
  'smtp_port' => 587,
  'smtp_user' => 'mirajissa1@gmail.com', // change it to yours
  'smtp_pass' => 'Mirajissa1@1994', // change it to yours
  'mailtype' => 'text',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);

        $message = "This is my email";
        $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('mirajissa1@gmail.com'); // change it to yours
      $this->email->to('mirajissa1@gmail.com');// change it to yours
      $this->email->subject('Fl&#233;x Boardroom invitation');
      $this->email->message($message);
     if ($this->email->send())
     {
       echo 'User Registered Successfuly';
        // redirect('../setting/user/');
       echo $this->email->print_debugger();
     }
     else
    {
     show_error($this->email->print_debugger());
    }

}

public function send_email() {
    $config = Array(
        'protocol' => 'TLS',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 587, //465,
        'smtp_user' => 'mirajissa1@gmail.com',
        'smtp_pass' => 'Mirajissa1@1994',
        'smtp_crypto' => 'tls',
        'smtp_timeout' => '20',
        'mailtype'  => 'html',
        'charset'   => 'iso-8859-1'
    );
    $config['newline'] = "\r\n";
    $config['crlf'] = "\r\n";
    $this->load->library('email', $config);
    $this->email->from('mirajissa1@gmail.com', 'Admin');
    $this->email->to('mirajissa1@gmail.com');
    $this->email->subject('Grretings');
    $this->email->message('Hello Miraji How Are You Doing with Coding?');

    /*$this->email->attach('C:\Users\xyz\Desktop\images\abc.png');
    $pdfString = $pdf->Output('dummy.pdf', 'S');
    $mailer->AddStringAttachment($pdfString, 'some_filename.pdf');*/

    //$this->email->send();
    if ( ! $this->email->send()) {
        echo "FAILED TO SEND EMAIL";
    }
    echo "EMAIL SENT SUCCESSIFULLY";
}


//using PHPMiler

function send(){
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mirajissa1@gmail.com';
        $mail->Password = 'Mirajissa1@1994';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('mirajissa1@gmail.com', 'CodexWorld');
        $mail->addReplyTo('mirajissa1@gmail.com', 'CodexWorld');

        // Add a recipient
        $mail->addAddress('mirajissa1@gmail.com');

        // Add cc or bcc
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Email subject
        $mail->Subject = 'SUCCESS:Send Email via SMTP using PHPMailer in CodeIgniter';

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }
    }

    public function retired(){
        $empID = $this->input->get('id');
        $this->flexperformance_model->employeeRetired($empID);
        $this->session->set_flashdata('retired', "<p class='alert alert-warning text-center'>Contract Deleted Successifully</p>");
        $reload = '/cipay/userprofile/?id='.$empID;
        redirect($reload, 'refresh');
    }

    public function loginuser(){
        $empID = $this->input->get('id');
        $this->flexperformance_model->employeeLogin($empID);
        $this->session->set_flashdata('loginuser', "<p class='alert alert-warning text-center'>Contract Deleted Successifully</p>");
        $reload = '/cipay/userprofile/?id='.$empID;
        redirect($reload, 'refresh');
    }

    public function employeeReport() {
        // $data['leave'] =  $this->attendance_model->leavereport();
        $data['employees'] =  $this->flexperformance_model->employeeReport();
        $data['month_list'] = $this->payroll_model->payroll_month_list();
        $data['title']="Employee Report";
        $this->load->view('employee_report', $data);

    }

    public function partial(){
        if($_POST) {
            if ($this->input->post('to') == '' || $this->input->post('from') == ''){
                $response_array['status'] = "no_date";
                echo json_encode($response_array);
            }else{

                $fx = explode('/',$this->input->post('from'));
                $tx = explode('/',$this->input->post('to'));
                $from = $fx[2].'-'.$fx[1].'-'.$fx[0];
                $to = $tx[2].'-'.$tx[1].'-'.$tx[0];
                $start = strtotime($from);
                $end = strtotime($to);
                $days = ceil(abs($end - $start) / 86400) + 1;

                if ($start > $end){
                    // Start date is in front of end date!
                    $response_array['status'] = "date_mismatch";
                    echo json_encode($response_array);
                }else{
                    $data = array(
                        'empID' => $this->input->post('employee'),
                        'start_date' => $from,
                        'end_date' => $to,
                        'days' =>$days,
                        'date' => date('Y-m-d'),
                        'init' => $this->session->userdata('emp_id')
                    );

                    $this->flexperformance_model->addPartialPayment($data);
                    $response_array['status'] = "OK";
                    echo json_encode($response_array);
                }
            }
        }
    }

    public function deletePayment()
    {
        $payment_id = $this->uri->segment(3);
        $result = $this->flexperformance_model->deletePayment( $payment_id);
        if($result ==true){
            $response_array['status'] = "OK";
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            echo json_encode($response_array);
        }

    }

    public function updateGroupEdit(){
        if($_POST) {

            $group_id = $this->input->post('group_id');
            $group_name = $this->input->post('group_name');
            $result = $this->flexperformance_model->updateGroupEdit($group_id,$group_name);
            if($result ==true){
                $response_array['status'] = "OK";
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                echo json_encode($response_array);
            }

        }
    }

    public function netTotalSummation($payroll_date){
        //FROM DATABASE
        $volunteer_mwp_total = $this->reports_model->volunteerAllowanceMWPExport($payroll_date);
        $staff_bank_totals = $this->reports_model->staffPayrollBankExport($payroll_date);
        $volunteer_bank_totals = $this->reports_model->volunteerPayrollBankExport($payroll_date);

        /*amount bank staff*/
        $amount_staff_bank = 0;
        foreach($staff_bank_totals as $row) {
            $amount_staff_bank += $row->salary + $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;
        }

        /*amount bank volunteer*/
        $amount_volunteer_bank = 0;
        foreach($volunteer_bank_totals as $row) {
            $amount_volunteer_bank += $row->salary + $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;
        }

        /*mwp total*/
        $amount_mwp = 0;
        foreach($volunteer_mwp_total as $row)
        {
            $amount_mwp += $row->salary + $row->allowances-$row->pension-$row->loans-$row->deductions-$row->meals-$row->taxdue;
        }

        $total = $amount_mwp + $amount_staff_bank + $amount_volunteer_bank;

        return $total;

    }

    public function updateContractStart() {
        $empID = $this->input->post('empID');
        if ($_POST && $empID!='') {
            $contract_start = str_replace('/', '-', $this->input->post('contract_start'));
            $updates = array(
                'hire_date' =>date('Y-m-d',strtotime($contract_start)),
                'last_updated' => date('Y-m-d')
            );
            $result = $this->flexperformance_model->updateContractStart($updates, $empID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>Contract Start Date Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

        }
    }

    public function updateContractEnd() {
        $empID = $this->input->post('empID');
        if ($_POST && $empID!='') {
            $contract_end = str_replace('/', '-', $this->input->post('contract_end'));
            $updates = array(
                'contract_end' =>date('Y-m-d',strtotime($contract_end)),
                'last_updated' => date('Y-m-d')
            );
            $result = $this->flexperformance_model->updateContractEnd($updates, $empID);
            if($result==true) {
                echo "<p class='alert alert-success text-center'>Contract End Date Successifully!</p>";
            } else { echo "<p class='alert alert-danger text-center'>Update Failed</p>"; }

        }
    }

    public function approveRegistration() {
        /*
         * status 7 = cancelled
         * status 6 = accepted
        */
        if ($this->uri->segment(3)!='') {
            $transferID = $this->uri->segment(3);
            $transfers = $this->flexperformance_model->transfers($transferID);
            if ($transfers){
                $emp_id = $transfers->empID;
                $approver = $this->session->userdata('emp_id');
                $date = date('Y-m-d');
                $result = $this->flexperformance_model->approveRegistration($emp_id,$transferID, $approver, $date);
                if($result==true) {
                    echo "<p class='alert alert-success text-center'>Registration Successfully!</p>";
                } else { echo "<p class='alert alert-danger text-center'>FAILED: Failed To Approve Registration, Please Try Again</p>"; }
            }
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED: Failed To Approve Registration, Please Try Again</p>";
        }
    }

    public function disapproveRegistration() {
       /*
        * status 7 = cancelled
        * status 6 = accepted
       */
        if ($this->uri->segment(3)!='') {
            $transferID = $this->uri->segment(3);
            $transfers = $this->flexperformance_model->transfers($transferID);
            if ($transfers){
                $emp_id = $transfers->empID;
                $result = $this->flexperformance_model->disapproveRegistration($emp_id,$transferID);
                if($result==true) {
                    echo "<p class='alert alert-success text-center'>Registration Cancelled Successfully!</p>";
                } else { echo "<p class='alert alert-danger text-center'>FAILED: Failed To Cancel Registration, Please Try Again</p>"; }
            }
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED: Failed To Cancel Registration, Please Try Again</p>";
        }
    }

}
?>
