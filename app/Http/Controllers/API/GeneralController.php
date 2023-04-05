<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;

use DateTime;
use App\Models\EMPL;
use App\Models\Role;
use App\Models\User;
use App\Models\Leaves;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\Position;
use App\Models\UserRole;
use App\Models\Approvals;
use App\Models\LeaveType;
use App\Models\Promotion;
use Illuminate\Http\File;
use App\Models\AuditTrail;
use App\Models\BankBranch;
use App\Helpers\SysHelpers;
use App\Models\Termination;
use App\Models\Disciplinary;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use App\Models\ApprovalLevel;
use App\Models\FinancialLogs;
use App\Models\LeaveApproval;
use App\Models\EmployeeDetail;
use App\Models\EmployeeParent;
use App\Models\EmployeeSpouse;
use App\Models\AttendanceModel;
use App\Models\Payroll\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Elibyy\TCPDF\Facades\TCPDF;

use App\Models\EmergencyContact;
use App\Models\EmployeeComplain;
use App\Models\PerformanceModel;
use App\Models\EmailNotification;
use App\Models\EmployeeDependant;
use App\Models\EmploymentHistory;
use Illuminate\Support\Facades\DB;
use App\Models\Payroll\ReportModel;
use App\Http\Controllers\Controller;
use App\Models\Payroll\ImprestModel;
use App\Notifications\EmailRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\RegisteredUser;
use App\Models\EducationQualification;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use App\Models\ProfessionalCertification;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\AccessControll\Departments;
use App\Models\Helsb;
use App\Models\Payroll\FlexPerformanceModel;
use Illuminate\Support\Facades\Notification;
// use Barryvdh\DomPDF\Facade\Pdf;

class GeneralController extends Controller
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
        $this->flexperformance_model = $flexperformance_model;
        $this->imprest_model = new ImprestModel();
        $this->reports_model = new ReportModel();
        $this->attendance_model = new AttendanceModel();
        $this->project_model = new ProjectModel();
        $this->performanceModel = new PerformanceModel();
        $this->payroll_model = new Payroll;
    }


    public function update_login_info(Request $request)
    {

        if ($request->method() == "POST") {
            $empID = session('emp_id');

            $username = $request->input('username');
            $password = $request->input('password');
            $password_conf = $request->input('conf_password');

            if ($username != '' && $password != '' && $password == $password_conf) {
                if ($this->checkPassword($password)) {
                    $password_hash = password_hash(trim($password), PASSWORD_BCRYPT);
                    $data = array(
                        'username' => $username,
                        'password' => $password_hash,
                        'password_set' => "0",
                        'last_updated' => date('Y-m-d'),

                    );
                    $result = $this->flexperformance_model->updateEmployee($data, $empID);

                    if ($result) {
                        $data = array(
                            'empID' => session('emp_id'),
                            'password' => $password_hash,
                            'time' => date('Y-m-d'),
                        );

                        $this->flexperformance_model->insert_user_password($data);
                        $response_array['status'] = 'OK';
                        echo json_encode($response_array);
                        // $this->logout();

                    } else {
                        $response_array['status'] = 'ERR';
                        echo json_encode($response_array);
                    }
                } else {
                    $response_array['status'] = 'ERR_P';
                    echo json_encode($response_array);
                }
            } else {
                $response_array['status'] = 'ERR';
                echo json_encode($response_array);
            }
        } else {
            $response_array['status'] = 'ERR';
            echo json_encode($response_array);
        }
    }

    public function logout(Request $request)
    {
        // $this->session->sess_destroy();
        return redirect('/flex/Base_controller/');
    }

    // Start of employee details function
    public function userprofile(Request $request)
    {
        $id = auth()->user()->emp_id;

        $extra = $request->input('extra');
        $data['employee'] = $this->flexperformance_model->userprofile($id);

        // dd($data['employee'] );
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
        $data['title'] = "Profile";

        $data['employee_pension'] = $this->reports_model->employee_pension($id);

        //dd($data['employee_pension']);
        $data['qualifications'] = EducationQualification::where('employeeID', $id)->get();

        $data['photo'] = "";

        $data['parent'] = "Employee Profile";

        // return view('employee.userprofile', $data);


        return response(
            [
                'data'=>$data
            ],200 );

        // return view('employee.employee-biodata', $data);

    }
    // End of employee details function


    // start of pension history
    public function pension(Request $request)
    {
        $id = auth()->user()->emp_id;

        $data['pensions'] = $this->reports_model->employee_pension($id);

        // return view('my-services/pensions',$data);

        
        return response( ['data'=>$data ],200 );
    }
     // end of pension history

    //  start of employee overtimes function
    public function myOvetimes()
    {

        $emp_id=auth()->user()->emp_id;
       
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes($emp_id);
        $data['overtimeCategory'] = $this->flexperformance_model->overtimeCategory();
        $data['employees'] = $this->flexperformance_model->Employee();

        $data['line_overtime'] = $this->flexperformance_model->lineOvertimes(session($emp_id));

        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = 'My Services';
        $data['child'] = 'Overtimes';

             
        return response( [ 'data'=>$data ],200 );
    }
    //  end of employee overtimes function

    //  start of apply overtimes function
    public function applyOvertime(Request $request)
    {

        $start = $request->input('time_start');
        $finish = $request->input('time_finish');
        $reason = $request->input('reason');
        $category = $request->input('category');
        $linemanager = $request->input('linemanager');

        $empID = auth()->user()->emp_id;

       


        $split_start = explode(" ", $start);
        $split_finish = explode(" ", $finish);

        $start_date = $split_start[0];
        $start_time = $split_start[1];

        $finish_date = $split_finish[0];
        $finish_time = $split_finish[1];

        $start_calendar = str_replace('/', '-', $start_date);
        $finish_calendar = str_replace('/', '-', $finish_date);

        $start_final = date('Y-m-d', strtotime($start_calendar));
        $finish_final = date('Y-m-d ', strtotime($finish_calendar));

        $maxRange = ((strtotime($finish_final) - strtotime($start_final)) / 3600);


        if ($maxRange > 24) {

            $msg='Overtime Should Range between 0 to 24 Hours';
            return response( [ 'msg'=>$msg ],401);
        } else {

            $end_night_shift = "6:00";
            $start_night_shift = "20:00";

            if ($start_date == $finish_date) {

                if (strtotime($start_time) >= strtotime($finish_time)) {
                    $msg='Invalid Time Selection, Please Choose the correct time and Try Again!';
                    return response( [ 'msg'=>$msg ],401);
                } else {

                    if (strtotime($start_time) >= strtotime($start_night_shift) || $start_time <= 5 && strtotime($finish_time) <= strtotime($end_night_shift)) {

                        $type = 1; // echo " CORRECT:  NIGHT OVERTIME";

                        $data = array(
                            'time_start' => $start_final . " " . $start_time,
                            'time_end' => $finish_final . " " . $finish_time,
                            'overtime_type' => $type,
                            'overtime_category' => $category,
                            'reason' => $reason,
                            'empID' => $empID,
                            'linemanager' => $linemanager,
                            'time_recommended_line' => date('Y-m-d h:i:s'),
                            'time_approved_hr' => date('Y-m-d'),
                            'time_confirmed_line' => date('Y-m-d h:i:s'),
                        );

                        $result = $this->flexperformance_model->apply_overtime($data);

                        if ($result == true) {

                            $msg='Overtime Request Sent Successifully!';
                            return response( [ 'msg'=>$msg ],200);
                        } else {
                            $msg='Overtime Request Not Sent, Please Try Again!';
                            return response( [ 'msg'=>$msg ],401);
                        }
                    } elseif (strtotime($start_time) >= strtotime($end_night_shift) && strtotime($start_time) < strtotime($start_night_shift) && strtotime($finish_time) <= strtotime($start_night_shift)) {

                        $type = 0; // echo "DAY OVERTIME";

                        $data = array(
                            'time_start' => $start_final . " " . $start_time,
                            'time_end' => $finish_final . " " . $finish_time,
                            'overtime_type' => $type,
                            'overtime_category' => $category,
                            'reason' => $reason,
                            'empID' => $empID,
                            'linemanager' => $linemanager,
                            'time_recommended_line' => date('Y-m-d h:i:s'),
                            'time_approved_hr' => date('Y-m-d'),
                            'time_confirmed_line' => date('Y-m-d h:i:s'),
                        );

                        $result = $this->flexperformance_model->apply_overtime($data);

                        if ($result == true) {

                            $msg='Overtime Request Sent Successifully !';
                            return response( [ 'msg'=>$msg ],200);
                        } else {
                           
                            $msg='Overtime Request Not Sent, Please Try Again!';
                            return response( [ 'msg'=>$msg ],401);
                        }
                    } else {

                        $msg='Sorry Cross-Shift Overtime is NOT ALLOWED, Please Choose the correct time and Try Again!';
                        return response( [ 'msg'=>$msg ],401);
                    }
                }
            } else if ($start_date > $finish_date) {

                $msg='Invalid Date, Please Choose the correct Date and Try Again!';
                return response( [ 'msg'=>$msg ],401);
            } else {
                // echo "CORRECT DATE - <BR>";
                if (strtotime($start_time) >= strtotime($start_night_shift) && strtotime($finish_time) <= strtotime($end_night_shift)) {
                    $type = 1; // echo "NIGHT OVERTIME CROSS DATE ";
                    $data = array(
                        'time_start' => $start_final . " " . $start_time,
                        'time_end' => $finish_final . " " . $finish_time,
                        'overtime_type' => $type,
                        'overtime_category' => $category,
                        'reason' => $reason,
                        'empID' => $empID,
                        'linemanager' => $linemanager,
                        'time_recommended_line' => date('Y-m-d h:i:s'),
                        'time_approved_hr' => date('Y-m-d'),
                        'time_confirmed_line' => date('Y-m-d h:i:s'),
                    );
                    $result = $this->flexperformance_model->apply_overtime($data);
                    if ($result == true) {
                  
                        $msg='Overtime Request Sent Successifully!';
                        return response( [ 'msg'=>$msg ],200);
                    } else {
                 
                        $msg='Overtime Request Not Sent, Please Try Again!';
                        return response( [ 'msg'=>$msg ],401);
                    }
                } else {
                    $type = 0; // echo "DAY OVERTIME";
                    $data = array(
                        'time_start' => $start_final . " " . $start_time,
                        'time_end' => $finish_final . " " . $finish_time,
                        'overtime_type' => $type,
                        'overtime_category' => $category,
                        'reason' => $reason,
                        'empID' => $empID,
                        'linemanager' => $linemanager,
                        'time_recommended_line' => date('Y-m-d h:i:s'),
                        'time_approved_hr' => date('Y-m-d'),
                        'time_confirmed_line' => date('Y-m-d h:i:s'),
                    );
                    $result = $this->flexperformance_model->apply_overtime($data);
                    if ($result == true) {
                    
                        $msg='Overtime Request Sent Successifully!';
                        return response( [ 'msg'=>$msg ],200);
                    } else {

                        $msg='Overtime Request Not Sent, Please Try Again!';
                        return response( [ 'msg'=>$msg ],401);
                    }
                }
            }
        }
    }

    //  end of apply overtimes function


    //  start of employee leaves function
    public function myLeaves(Request $request)
    {
        $data['myleave'] =Leaves::where('empID',Auth::user()->emp_id)->orderBy('id','desc')->get();
        // $data['myleave'] = array_reverse($data['myleave']); // Reverse the order of leaves

        $emp_id=auth()->user()->emp_id;
        
        // $data['leave_types'] =LeaveType::all();
        // $data['employees'] =EMPL::where('line_manager',Auth::user()->emp_id)->get();
        // $data['leaves'] =Leaves::get();


        // Start of Escallation
        $leaves=Leaves::get();
        if ($leaves) {

          foreach($leaves as $item)
          {
              $today= new DateTime();
              $applied =$item->updated_at;
              $diff= $today->diff($applied);
              $range=$diff->days;
              $approval=LeaveApproval::where('empID',$item->empID)->first();

              if ($approval) {
                if ($range>$approval->escallation_time) {
                  $leave=Leaves::where('id' ,$item->id)->first();
                  $status=$leave->status;
                  
                  if ($status == 0) {
                    if ($approval->level2 != null) {
                      $leave->status=1;
                      $leave->updated_at=$today;
                      $leave->update();
                  
                    }
                 
                  }
                  elseif ($status == 1)
                  {
                    if ($approval->level3 != null) {
                      $leave->status=2;
                      $leave->updated_at=$today;
                      $leave->update();
                    }
                    else
                    {
                      $leave->status=0;
                      $leave->updated_at=$today;
                      $leave->update();
                    }
                  }
                  elseif ($status == 2)
                  {
                    if ($approval->level1 != null) {
                      $leave->status=0;
                      $leave->updated_at=$today;
                      $leave->update();
                    }
                  }
                }
              }
        
          }
        }
        // End of Escallation

        // For Working days
        // $d1 = new DateTime (Auth::user()->hire_date);
        // $d2 = new DateTime();
        // $interval = $d2->diff($d1);
        // $data['days']=$interval->days;
        // $data['leaveBalance'] = $this->attendance_model->getLeaveBalance($emp_id, auth()->user()->hire_date, date('Y-m-d'));
        // $data['leave_type'] = $this->attendance_model->leave_type();
      

  

    return response( [ 'data'=>$data  ],200 );
    }
    //  end of employee leaves function


        //  start of employee leaves function
        public function myLoans(Request $request)
        {
            $empID = auth()->user()->emp_id;
            // For pending loans
            $data['loans'] =Helsb::where('empID',$empID)->get();
         

        return response( [ 'data'=>$data  ],200 );
        }
        //  end of employee leaves function


        //  start of employee Slips function
        public function mySlips(Request $request)
        {
            // $empID = auth()->user()->emp_id;

            $data['month_list'] = $this->flexperformance_model->payroll_month_list();
        

        return response( [ 'data'=>$data  ],200 );
        }
        //  end of employee salary slips function


        // Start of single payslip

        public function SlipDetail($date)
        {
            //dd($request->all());
            $empID = auth()->user()->emp_id;
    
            if ($empID != "Select Employee") {
    
                // DATE MANIPULATION
                $empID = auth()->user()->emp_id;
                $start = $date;
                $profile = auth()->user()->emp_id; //For redirecting Purpose
                $date_separate = explode("-", $start);
    
                $mm = $date_separate[1];
                $yyyy = $date_separate[0];
                $dd = $date_separate[2];
                $one_year_back = $date_separate[0] - 1;
    
                $payroll_date = $yyyy . "-" . $mm . "-" . $dd;
                $payroll_month_end = $yyyy . "-" . $mm . "-31";
                $payroll_month = $yyyy . "-" . $mm;
    
                $check = $this->reports_model->payslipcheck($payroll_month, $empID);
    
                if ($check == 0) {
                    if ($profile == 0) {
                        session('note', "<p class='alert alert-warning text-center'>Sorry No Payroll Records Found For This Employee under the Selected Month</font></p>");
                        return redirect('/flex/payroll/employee_payslip/');
                    } else {
                        session('note', "<p class='alert alert-warning text-center'>Sorry No Payroll Records Found For This Employee under the Selected Month</font></p>");
                        return redirect('/flex/userprofile/?id=' . $empID);
                    }
                } else {
                    $data['slipinfo'] = $this->reports_model->payslip_info($empID, $payroll_month_end, $payroll_month);
                    $data['leaves'] = $this->reports_model->leaves($empID, $payroll_month_end);
                    $data['annualLeaveSpent'] = $this->reports_model->annualLeaveSpent($empID, $payroll_month_end);
                    $data['allowances'] = $this->reports_model->allowances($empID, $payroll_month);
                    $data['deductions'] = $this->reports_model->deductions($empID, $payroll_month);
                    $data['loans'] = $this->reports_model->loans($empID, $payroll_month);
                    $data['salary_advance_loan'] = $this->reports_model->loansPolicyAmount($empID, $payroll_month);
                    $data['total_allowances'] = $this->reports_model->total_allowances($empID, $payroll_month);
                    $data['total_pensions'] = $this->reports_model->total_pensions($empID, $payroll_date);
                    $data['total_deductions'] = $this->reports_model->total_deductions($empID, $payroll_month);
                    $data['companyinfo'] = $this->reports_model->company_info();
                    $data['arrears_paid'] = $this->reports_model->employeeArrearByMonth($empID, $payroll_date);
                    $data['arrears_paid_all'] = $this->reports_model->employeeArrearAllPaid($empID, $payroll_date);
                    $data['arrears_all'] = $this->reports_model->employeeArrearAll($empID, $payroll_date);
                    $data['arrears_paid'] = $this->reports_model->employeeArrearByMonth($empID, $payroll_date);
                    $data['paid_with_arrears'] = $this->reports_model->employeePaidWithArrear($empID, $payroll_date);
                    $data['paid_with_arrears_d'] = $this->reports_model->employeeArrearPaidAll($empID, $payroll_date);
                    $data['salary_advance_loan_remained'] = $this->reports_model->loansAmountRemained($empID, $payroll_date);
    
                    $slipinfo = $data['slipinfo'];
                    $leaves = $data['leaves'];
                    $annualLeaveSpent = $data['annualLeaveSpent'];
                    $allowances = $data['allowances'];
                    $deductions = $data['deductions'];
                    $loans = $data['loans'];
                    $salary_advance_loan = $data['salary_advance_loan'];
                    $total_allowances = $data['total_allowances'];
                    $total_pensions = $data['total_pensions'];
                    $total_deductions = $data['total_deductions'];
                    $companyinfo = $data['companyinfo'];
                    $arrears_paid = $data['arrears_paid'];
                    $arrears_paid_all = $data['arrears_paid_all'];
                    $arrears_all = $data['arrears_all'];
                    $arrears_paid = $data['arrears_paid'];
                    $paid_with_arrears = $data['paid_with_arrears'];
                    $paid_with_arrears_d = $data['paid_with_arrears_d'];
                    $salary_advance_loan_remained = $data['salary_advance_loan_remained'];
                    $data['payroll_date'] = $date;
    
                    $date = explode('-',$payroll_date);
                    $payroll_month = $date[0].'-'.$date[1];
    
                    $data['bank_loan'] = $this->reports_model->bank_loans($empID, $payroll_month);
                    $data['total_bank_loan'] = $this->reports_model->sum_bank_loans($empID, $payroll_month);
    
                    //include(app_path() . '/reports/customleave_report.php');
                    // include app_path() . '/reports/payslip.php';
    
                    //return view('payroll.payslip2', $data);
                    // $pdf = Pdf::loadView('payroll.payslip2',$data)->setPaper('a4', 'potrait');
    
                    // return $pdf->download('payslip_for_'.$empID.'.pdf');
                    
        return response( [ 'data'=>$data  ],200 );
                }
            } else {
                // DATE MANIPULATION
                $start = $date;
                $date_separate = explode("-", $start);
                $reportType = 1;  //Staff = 1, temporary = 2
                // $reportformat = $request->input('type'); //Staff = 1, temporary = 2
    
                $mm = $date_separate[1];
                $yyyy = $date_separate[0];
                $dd = $date_separate[2];
                $one_year_back = $date_separate[0] - 1;
    
                $payroll_date = $yyyy . "-" . $mm . "-" . $dd;
                $payroll_month_end = $yyyy . "-" . $mm . "-31";
                $payroll_month = $yyyy . "-" . $mm;
    
                $check = $this->reports_model->payslipcheckAll($payroll_month);
    
                if ($check == 0) {
                    // session('note', "<p class='alert alert-warning text-center'>Sorry No Payroll Records Found For This Employee under the Selected Month</font></p>");
                    // return redirect('/flex/cipay/employee_payslip/');

                        $msg='Sorry No Payroll Records Found For This Employee under the Selected Month';
                        return response( [ 'msg'=>$msg  ],401 );
                } else {
                    /*print all*/
                    if ($reportType == 1) {
                        $payroll_emp_ids = $this->reports_model->s_payrollLogEmpID($payroll_month);
                    } else {
                        $payroll_emp_ids = $this->reports_model->v_payrollLogEmpID($payroll_month);
                    }
                    $data_all = [];
                    foreach ($payroll_emp_ids as $payroll_emp_id) {
    
                        // if($payroll_emp_id->empID != 255001){
                        $data['slipinfo'] = $this->reports_model->payslip_info($payroll_emp_id->empID, $payroll_month_end, $payroll_month);
                        $data['leaves'] = $this->reports_model->leaves($payroll_emp_id->empID, $payroll_month_end);
                        $data['annualLeaveSpent'] = $this->reports_model->annualLeaveSpent($payroll_emp_id->empID, $payroll_month_end);
                        $data['allowances'] = $this->reports_model->allowances($payroll_emp_id->empID, $payroll_month);
                        $data['deductions'] = $this->reports_model->deductions($payroll_emp_id->empID, $payroll_month);
                        $data['loans'] = $this->reports_model->loans($payroll_emp_id->empID, $payroll_month);
                        $data['salary_advance_loan'] = $this->reports_model->loansPolicyAmount($payroll_emp_id->empID, $payroll_month);
                        $data['total_allowances'] = $this->reports_model->total_allowances($payroll_emp_id->empID, $payroll_month);
                        $data['total_pensions'] = $this->reports_model->total_pensions($payroll_emp_id->empID, $payroll_date);
                        $data['total_deductions'] = $this->reports_model->total_deductions($payroll_emp_id->empID, $payroll_month);
                        $data['companyinfo'] = $this->reports_model->company_info();
                        $data['arrears_paid'] = $this->reports_model->employeeArrearByMonth($payroll_emp_id->empID, $payroll_date);
                        $data['arrears_paid_all'] = $this->reports_model->employeeArrearAllPaid($payroll_emp_id->empID, $payroll_date);
                        $data['arrears_all'] = $this->reports_model->employeeArrearAll($payroll_emp_id->empID, $payroll_date);
                        $data['arrears_paid'] = $this->reports_model->employeeArrearByMonth($payroll_emp_id->empID, $payroll_date);
                        $data['paid_with_arrears'] = $this->reports_model->employeePaidWithArrear($payroll_emp_id->empID, $payroll_date);
                        $data['paid_with_arrears_d'] = $this->reports_model->employeeArrearPaidAll($payroll_emp_id->empID, $payroll_date);
                        $data['salary_advance_loan_remained'] = $this->reports_model->loansAmountRemained($payroll_emp_id->empID, $payroll_month);
                        $data_all['dat'][$payroll_emp_id->empID] = $data;
    
                        $slipinfo = $data['slipinfo'];
                        $leaves = $data['leaves'];
                        $annualLeaveSpent = $data['annualLeaveSpent'];
                        $allowances = $data['allowances'];
                        $deductions = $data['deductions'];
                        $loans = $data['loans'];
                        $salary_advance_loan = $data['salary_advance_loan'];
                        $total_allowances = $data['total_allowances'];
                        $total_pensions = $data['total_pensions'];
                        $total_deductions = $data['total_deductions'];
                        $companyinfo = $data['companyinfo'];
                        $arrears_paid = $data['arrears_paid'];
                        $arrears_paid_all = $data['arrears_paid_all'];
                        $arrears_all = $data['arrears_all'];
                        $arrears_paid = $data['arrears_paid'];
                        $paid_with_arrears = $data['paid_with_arrears'];
                        $paid_with_arrears_d = $data['paid_with_arrears_d'];
                        $salary_advance_loan_remained = $data['salary_advance_loan_remained'];
    
                        // include app_path() . '/reports/payslip.php';

                        return response( [ 'data'=>$data  ],200 );

                        // }
                    }
    
                    $data_all['emp_id'] = $payroll_emp_ids;
    
                    // return view('app.reports/payslip_all', $data_all);

                    return response( [ 'data_all'=>$data_all  ],401 );

                }
            }
        }
        // End of single payslip


            // For updating profile image
    public function updateImg(Request $request)
    {

      
        $user = auth()->user()->emp_id;
        request()->validate([
            'image' => 'required'
        ]);

        $employee = EMPL::where('emp_id', $user)->first();
        if ($request->hasfile('image')) {

            $newImageName = $request->image->hashName();
            $request->image->move(public_path('storage/profile'), $newImageName);
            $employee->photo = $newImageName;
            
            $employee->update();

            $msg='Your Profile Image is updated Successfully !';
            return response( [ 'msg'=>$msg  ],200 );
    
        }
        else
        {
            $msg='Fail To Update Image !';
            return response( [ 'msg'=>$msg  ],401 );
        }

    

    }



    // Termination test
        //For Viewing Termination
    public function viewTermination($id)
    {
        $termination = Termination::where('id', $id)->first();

        $employee_info = $this->flexperformance_model->userprofile($termination->employeeID);


        $pdf = Pdf::loadView('reports.terminalbenefit', compact('termination', 'employee_info'));
        $pdf->setPaper([0, 0, 885.98, 396.85], 'landscape');

        $newImageName= $pdf->download('terminal-benefit-slip.pdf');

        // return(  $newImageName);
       $test= $newImageName->move(public_path('storage/tests'), $newImageName);

      return response( [ 'test'=> $test ],200 );
        
    }


}