<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Payroll\ReportModel;
use App\Models\AttendanceModel;
use App\models\Payroll\ImprestModel;
use App\models\ProjectModel;
use App\models\PerformanceModel;
use App\Helpers\SysHelper;

class BaseController extends Controller
{

  // function __construct(Request $request) {
  //   parent::__construct();

  //   $this->load->model('flexperformance_model');
  //   $this->load->model('performance_model');
  //   $this->load->library('session');
  //   $this->load->model('imprest_model');
  //   $this->load->model('payroll_model');
  //   $this->load->model('reports_model');
  //   $this->load->model('attendance_model');
  //   $this->load->model('project_model');

  //   $this->load->helper('url');
  //     $this->load->library('user_agent');  
  //     $this->load->library('form_validation');
  //     $this->load->model('flexperformance_model');

  //     if ($this->agent->is_browser())
  //     {
  //       $agent = $this->agent->browser().' '.$this->agent->version();
  //     }
  //     elseif ($this->agent->is_robot())
  //     {
  //       $agent = $this->agent->robot();
  //     }
  //     elseif ($this->agent->is_mobile())
  //     {
  //       $agent = $this->agent->mobile();
  //     }
  //     else
  //     {
  //       $agent = 'Unidentified User Agent';
  //     }
  //     $this->session->set_userdata('agent', $agent);
  //     $this->session->set_userdata('platform', $this->agent->platform()); 
  //     $this->session->set_userdata('ip_address', $this->input->ip_address()); 


  //     $username = $request->input('username');
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


  function index(Request $request)
  {


    if (strlen('') > 0) {

      $strategyStatistics = $this->performance_model->strategy_info(session('current_strategy'));
      $payrollMonth = $this->payroll_model->recent_payroll_month(date('Y-m-d'));

      $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($payrollMonth . "-1 month"))));
      $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

      foreach ($strategyStatistics as $key) {
        $strategyID = $key->id;
        $strategyTitle = $key->title;
        $start = date_create($key->start);
      }
      $strategyProgress = $this->performance_model->strategyProgress($strategyID);

      $current = date_create(date('Y-m-d'));
      $diff = date_diff($start, $current);
      $required = $diff->format("%a");
      $months = number_format(($required / 30.5), 4);
      $rate_per_month = number_format(($strategyProgress / $months), 1);

      $data['appreciated'] =  $this->flexperformance_model->appreciated_employee();

      // $data['employee_count'] =  $this->flexperformance_model->count_employees();
      $data['overview'] =  $this->flexperformance_model->employees_info();
      $data["strategyProgress"] = $strategyProgress;
      $data["monthly"] = $rate_per_month;

      $data['taskline'] = $this->performance_model->total_taskline(session('emp_id'));
      $data['taskstaff'] = $this->performance_model->total_taskstaff(session('emp_id'));


      $data['payroll_totals'] =  $this->payroll_model->payrollTotals("payroll_logs", $payrollMonth);
      $data['total_allowances'] =  $this->payroll_model->total_allowances("allowance_logs", $payrollMonth);
      $data['total_bonuses'] =  $this->payroll_model->total_bonuses($payrollMonth);
      $data['total_loans'] =  $this->payroll_model->total_loans("loan_logs", $payrollMonth);
      $data['total_heslb'] =  $this->payroll_model->total_heslb("loan_logs", $payrollMonth);
      $data['take_home'] = $this->reports_model->sum_take_home($payrollMonth);
      $data['total_deductions'] =  $this->payroll_model->total_deductions("deduction_logs", $payrollMonth);
      $data['total_overtimes'] =  $this->payroll_model->total_overtimes($payrollMonth);
      $data['payroll_date'] = $payrollMonth;
      $data['arrears'] = $this->payroll_model->arrearsMonth($payrollMonth);
      $data['s_gross_c'] = $this->reports_model->s_grossMonthly($payrollMonth);
      $data['v_gross_c'] = $this->reports_model->v_grossMonthly($payrollMonth);
      $data['s_gross_p'] = $this->reports_model->s_grossMonthly($previous_payroll_month);
      $data['v_gross_p'] = $this->reports_model->v_grossMonthly($previous_payroll_month);
      $data['s_net_c'] = $this->reports_model->staff_sum_take_home($payrollMonth);
      $data['v_net_c'] = $this->reports_model->temporary_sum_take_home($payrollMonth);
      $data['s_net_p'] = $this->reports_model->staff_sum_take_home($previous_payroll_month);
      $data['v_net_p'] = $this->reports_model->temporary_sum_take_home($previous_payroll_month);
      $data['v_staff'] = $this->reports_model->v_payrollEmployee($payrollMonth, '');
      $data['s_staff'] = $this->reports_model->s_payrollEmployee($payrollMonth, '');
      $data['v_staff_p'] = $this->reports_model->v_payrollEmployee($previous_payroll_month, '');
      $data['s_staff_p'] = $this->reports_model->s_payrollEmployee($previous_payroll_month, '');
      $data['net_total'] = $this->netTotalSummation($payrollMonth);

      if (session('password_set') == "1") {
        $this->login_info();
      } else {

        // Redirect To HOME
        $data['title'] = "Home";
        return view('app.home', $data);
      }
    } else {
      $data['title'] = "login";
      return view('auth.login', $data);
    }
  }


  public function netTotalSummation($payroll_date)
  {
    //FROM DATABASE
    $temporary_mwp_total = $this->reports_model->temporaryAllowanceMWPExport($payroll_date);
    $staff_bank_totals = $this->reports_model->staffPayrollBankExport($payroll_date);
    $temporary_bank_totals = $this->reports_model->temporaryPayrollBankExport($payroll_date);

    /*amount bank staff*/
    $amount_staff_bank = 0;
    foreach ($staff_bank_totals as $row) {
      $amount_staff_bank += $row->salary + $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;
    }

    /*amount bank temporary*/
    $amount_temporary_bank = 0;
    foreach ($temporary_bank_totals as $row) {
      $amount_temporary_bank += $row->salary + $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;
    }

    /*mwp total*/
    $amount_mwp = 0;
    foreach ($temporary_mwp_total as $row) {
      $amount_mwp += $row->salary + $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;
    }

    $total = $amount_mwp + $amount_staff_bank + $amount_temporary_bank;

    return $total;
  }


  function checkPassword($password)
  {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    $res = false;
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
      $res = false;
    } else {
      $res = true;
    }
    return $res;
  }



  function login(Request $request)
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules("username", "Userame", 'required');
    $this->form_validation->set_rules("password", "Password", 'required');



    if (isset($_POST['login']) && $this->form_validation->run()) {

      // $password = base64_encode($request->input('password'));
      $username = trim($request->input('username'));
      $password = trim($request->input('password'));

      $data = $this->flexperformance_model->login_user($username, $password);
      $from = "";
      $last_pass_date = $this->flexperformance_model->password_age($username);
      foreach ($last_pass_date as $row) {
        $from = $row->time;
      }

      $from = date_create($from);
      $today = date_create(date('Y-m-d'));
      $diff = date_diff($from, $today);
      $accrued = $diff->format("%a%") + 1;


      if ($data) {
        $this->session->set_userdata('pass_age', $accrued);
        $this->session->set_userdata('logo', $this->flexperformance_model->logo());
        $this->session->set_userdata('id', $data['id']);
        $this->session->set_userdata('emp_id', $data['emp_id']);

        $this->session->set_userdata('password_set', $data['password_set']);
        $this->session->set_userdata('username', $data['username']);
        $this->session->set_userdata('password', $data['password']);
        $this->session->set_userdata('email', $data['email']);
        $this->session->set_userdata('fname', $data['fname']);
        $this->session->set_userdata('mname', $data['mname']);
        $this->session->set_userdata('lname', $data['lname']);
        $this->session->set_userdata('position', $data['pName']);
        $this->session->set_userdata('departmentID', $data['departmentID']);
        $this->session->set_userdata('positionID', $data['positionID']);
        $this->session->set_userdata('photo', $data['photo']);
        $this->session->set_userdata('birthdate', $data['birthdate']);
        $this->session->set_userdata('nationality', $data['nationality']);
        $this->session->set_userdata('gender', $data['gender']);
        $this->session->set_userdata('merital_status', $data['merital_status']);
        $this->session->set_userdata('department', $data['dname']);
        $this->session->set_userdata('postal_city', $data['postal_city']);
        $this->session->set_userdata('mobile', $data['mobile']);
        $this->session->set_userdata('linemanager', $data['lineManager']);
        $this->session->set_userdata('ctype', $data['CONTRACT']);
        $this->session->set_userdata('postal_address', $data['postal_address']);
        $this->session->set_userdata('physical_address', $data['physical_address']);
        $this->session->set_userdata('salary', $data['salary']);
        $this->session->set_userdata('account_no', $data['account_no']);
        $this->session->set_userdata('last_updated', $data['last_updated']);
        $this->session->set_userdata('pf_membership_no', $data['pf_membership_no']);
        $this->session->set_userdata('hire_date', $data['hire_date']);

        $updates = array(
          'last_login' => date('Y-m-d')
        );
        $this->flexperformance_model->updateEmployee($updates, $data['emp_id']);
        $this->getPermissions();
      } else {
        session('note', 'Invalid username or Password');

        $data['title'] = "Login";
        $this->load->view("login", $data);
      }
    } else {
      $data['title'] = "Login";
      return view('app.login', $data);
    }
  }

  function register()
  {
    $data['title'] = "Register";
    return view('app.register', $data);
  }


  public function register_submit(Request $request)
  {
    $this->form_validation->set_rules("username", "Userame", 'required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[30]');
    $this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required|matches[password]');
    $this->form_validation->set_rules("userID", "User ID", 'required');

    if (isset($_POST['register']) && $this->form_validation->run()) {

      $id = $request->input('userID');
      $password = password_hash(trim($request->input('password')), PASSWORD_BCRYPT);

      $data = array(
        'username' => $request->input('username'),
        'password' => $password
      );

      if ($this->flexperformance_model->updateEmployee($data, $id)) {
        session('note', "<p><font color = 'green'>Employee Credentials Updated Successifully</font></p>");
        $data['title'] = "Register";
        return view('app.register', $data);
      } else {
        session('note', "<p><font color = 'red'>Employee Credentials Not Updated Successifully</font></p>");
        $data['title'] = "Register";
        return view('app.register', $data);
      }
    } else {
      $data['title'] = "Register";
      return view('app.register', $data);
    }
  }

  public function getPermissions(Request $request)
  {
    $id = session('emp_id');
    $empID = session('emp_id');

    // NEW ROLES AND PERMISSION;
    $this->session->set_userdata('vw_emp_sum', $this->flexperformance_model->getpermission($empID, '0'));
    $this->session->set_userdata('vw_payr_sum', $this->flexperformance_model->getpermission($empID, '1'));
    $this->session->set_userdata('vw_dept_proj_sum', $this->flexperformance_model->getpermission($empID, '2'));
    $this->session->set_userdata('vw_org_proj_sum', $this->flexperformance_model->getpermission($empID, '3'));
    $this->session->set_userdata('vw_emp', $this->flexperformance_model->getpermission($empID, '4'));
    $this->session->set_userdata('mng_emp', $this->flexperformance_model->getpermission($empID, '5'));
    $this->session->set_userdata('appr_emp', $this->flexperformance_model->getpermission($empID, '6'));
    $this->session->set_userdata('vw_proj', $this->flexperformance_model->getpermission($empID, '7'));
    $this->session->set_userdata('mng_proj', $this->flexperformance_model->getpermission($empID, '8'));
    $this->session->set_userdata('vw_leave', $this->flexperformance_model->getpermission($empID, '9'));
    $this->session->set_userdata('mng_leave', $this->flexperformance_model->getpermission($empID, 'a'));
    $this->session->set_userdata('appr_leave', $this->flexperformance_model->getpermission($empID, 'b'));
    $this->session->set_userdata('mng_attend', $this->flexperformance_model->getpermission($empID, 'c'));
    $this->session->set_userdata('mng_leave_rpt', $this->flexperformance_model->getpermission($empID, 'd'));
    $this->session->set_userdata('vw_org', $this->flexperformance_model->getpermission($empID, 'e'));
    $this->session->set_userdata('mng_org', $this->flexperformance_model->getpermission($empID, 'f'));
    $this->session->set_userdata('recom_paym', $this->flexperformance_model->getpermission($empID, 'g'));
    $this->session->set_userdata('mng_stat_rpt', $this->flexperformance_model->getpermission($empID, 'h'));
    $this->session->set_userdata('mng_paym', $this->flexperformance_model->getpermission($empID, 'i'));
    $this->session->set_userdata('gen_payslip', $this->flexperformance_model->getpermission($empID, 'j'));
    $this->session->set_userdata('use_salary_calc', $this->flexperformance_model->getpermission($empID, 'k'));
    $this->session->set_userdata('appr_paym', $this->flexperformance_model->getpermission($empID, 'l'));
    $this->session->set_userdata('mng_roles_grp', $this->flexperformance_model->getpermission($empID, 'm'));
    $this->session->set_userdata('mng_audit', $this->flexperformance_model->getpermission($empID, 'n'));
    $this->session->set_userdata('mng_bank_info', $this->flexperformance_model->getpermission($empID, 'o'));
    $this->session->set_userdata('recom_deduction', $this->flexperformance_model->getpermission($empID, 'p'));
    $this->session->set_userdata('appr_deduction', $this->flexperformance_model->getpermission($empID, 'q'));
    $this->session->set_userdata('mgn_deduction', $this->flexperformance_model->getpermission($empID, 'r'));
    $this->session->set_userdata('vw_dept_allocation', $this->flexperformance_model->getpermission($empID, 's'));
    $this->session->set_userdata('vw_settings', $this->flexperformance_model->getpermission($empID, 't'));
    $this->session->set_userdata('vw_proj', $this->flexperformance_model->getpermission($empID, 'u'));
    $this->session->set_userdata('vw_trans', $this->flexperformance_model->getpermission($empID, 'v'));
    $this->session->set_userdata('vw_org', $this->flexperformance_model->getpermission($empID, 'w'));


    //set default strategy as current strategy
    $defaultStrategy = $this->flexperformance_model->getCurrentStrategy();
    $this->session->set_userdata('current_strategy', $defaultStrategy);

    $logData = array(
      'empID' => session('emp_id'),
      'description' => "Logged In",
      'agent' => session('agent'),
      'platform' => $this->agent->platform(),
      'ip_address' => $this->input->ip_address()
    );

    $result = $this->flexperformance_model->insertAuditLog($logData);
    if ($result == true) {
      return redirect('/flex/cipay/home');
    } else {
      echo "<p class='alert alert-danger text-center'>Department Registration has FAILED, Contact Your Admin</p>";
    }
  }

  function forgot_password()
  {
    $data['title'] = "Reset Password";
    return view('app.reset_password', $data);
  }

  public function resetPassword(Request $request)
  {

    if (Request::isMethod('post') && $request->input('email') != '') {
      $this->load->model('payroll_model');
      $this->load->library('phpmailer_lib');
      $mail = $this->phpmailer_lib->load();
      $email = $request->input('email');
      $senderInfo = $this->payroll_model->senderInfo();
      $randomPassword = $this->password_generator(6);
      $password_hash = password_hash($randomPassword, PASSWORD_BCRYPT);
      $employee_details = $this->flexperformance_model->getEmployeeNameByemail($email);
      if ($employee_details) {

        foreach ($employee_details as $info) {
          $new_username = $info->emp_id;
          $empName = $info->name;
          $empID = $info->emp_id;
        }

        $updates = array(
          'username' => $new_username,
          'password' => $password_hash,
          'password_set' => "1",
          'last_updated' => date('Y-m-d')
        );

        /* EMAIL*/
        foreach ($senderInfo as $keyInfo) {
          $host = $keyInfo->host;
          $username = $keyInfo->username;
          $password = $keyInfo->password;
          $smtpsecure = $keyInfo->secure;
          $port = $keyInfo->port;
          $senderEmail = $keyInfo->email;
          $senderName = $keyInfo->name;
        }
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;


        $mail->SMTPSecure = $smtpsecure;
        $mail->Port     = $port;


        $mail->setFrom($senderEmail, $senderName);


        // Add a recipient
        $mail->addAddress($email);


        // Email subject
        $mail->Subject = "VSO Password Reset";

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<p>Dear <b>" . $empName . "</b>,</p>
                    <p>Your Flex Performance password has been reset following your request. Your new password is <b>" . $randomPassword . "</b>.
                    Please use your employee ID as your username.</p>
                    <p>You are advised not to share your password with anyone. If you did not request password reset, please report
                        this incident to the system administrator.<br><br>
                        Thank you,<br>
                        Flex Performance Software Self Service.</p>";
        $mail->Body = $mailContent;

        if (!$mail->send()) {

          session("note", "<p><font color='red'>Password Reset Has Failed, Please contact Your System Admin</font></p>");
        } else {
          $result = $this->flexperformance_model->updateEmployee($updates, $empID);
          if ($result == true) {
            $logData = array(
              'empID' => $empID,
              'description' => "Requested password reset",
              'agent' => session('agent'),
              'platform' => $this->agent->platform(),
              'ip_address' => $this->input->ip_address()
            );

            $result = $this->flexperformance_model->insertAuditLog($logData);
            session("note", "<p><font color='green'>Password Has been Reset  Successfully, Check Your Email to view the new Login Credentials</font></p>");
          } else {

            session("note", "<p><font color='red'>Password Reset Has Failed, Please contact Your System Admin</font></p>");
          }
        }
      } else {
        session("note", "<p><font color='red'>Sorry No Employee With This Email, Please Contact Your System Admin</font></p>");
      }


      $data['title'] = "Reset Password";
      return view('app.reset_password', $data);
    }
  }


  function password_generator($size)
  {
    $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
    $init = strlen($char);
    $init--;

    $result = NULL;
    for ($x = 1; $x <= $size; $x++) {
      $index = rand(0, $init);
      $result .= substr($char, $index, 1);
    }
    return $result;
  }

  public function logout(Request $request)
  {

    $logData = array(
      'empID' => session('emp_id'),
      'description' => "Logged out",
      'agent' => session('agent'),
      'platform' => $this->agent->platform(),
      'ip_address' => $this->input->ip_address()
    );
    if (!session('emp_id') == null) {
      $result = $this->flexperformance_model->insertAuditLog($logData);
    }
    $this->session->sess_destroy();
    return redirect('/flex/Base_controller/');
  }
}
