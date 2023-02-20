<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;

use App\Models\EMPL;
use App\Models\Role;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\Position;
use App\Models\UserRole;
use App\Models\Approvals;
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

        $data['employee_pension'] = $this->reports_model->employee_pension($id);

        // return view('my-services/pensions',$data);

        
        return response(
            [
                'data'=>$data
            ],200 );
    }
     // end of pension history

    //  start of employee overtimes function
    public function myOvetimes(Type $var = null)
    {
       
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(session('emp_id'));
        $data['overtimeCategory'] = $this->flexperformance_model->overtimeCategory();
        $data['employees'] = $this->flexperformance_model->Employee();

        $data['line_overtime'] = $this->flexperformance_model->lineOvertimes(session('emp_id'));

        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = 'My Services';
        $data['child'] = 'Overtimes';

             
        return response( [ 'data'=>$data ],200 );
    }
    //  end of employee overtimes function

    //  start of apply overtimes function
    public function apply_overtime(Request $request)
    {

        $start = $request->input('time_start');
        $finish = $request->input('time_finish');
        $reason = $request->input('reason');
        $category = $request->input('category');
        $linemanager = $request->input('linemanager');

        $empID = session('emp_id');


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

        $maxRange = ((strtotime($finish_final) - strtotime($start_final)) / 3600);

        //fetch Line manager data from employee table and send email
        $linemanager_data = SysHelpers::employeeData($linemanager);
        $fullname = $linemanager_data['full_name'];
        $email_data = array(
            'subject'=> 'Employee Overtime Approval',
            'view' => 'emails.linemanager.overtime-approval',
            'email' => $linemanager_data['email'],
            'full_name' => $fullname,
        );
        Notification::route('mail', $email_data['email'])->notify(new EmailRequests($email_data));
        // dd('Email Sent Successfully');
        //$linemanager = $this->flexperformance_model->get_linemanagerID($empID);

        // foreach ($line as $row) {
        //     $linemanager = $row->line_manager;
        // }
        //Overtime Should range between 24 Hrs;

        if ($maxRange > 24) {

            echo "<p class='alert alert-warning text-center'>Overtime Should Range between 0 to 24 Hours</p>";
        } else {

            $end_night_shift = "6:00";
            $start_night_shift = "20:00";

            if ($start_date == $finish_date) {

                if (strtotime($start_time) >= strtotime($finish_time)) {

                    echo "<p class='alert alert-danger text-center'>Invalid Time Selection, Please Choose the correct time and Try Again!</p>";
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
                            echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                        } else {
                            echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
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
                            echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                        } else {
                            echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
                        }
                    } else {
                        echo "<p class='alert alert-warning text-center'>Sorry Cross-Shift Overtime is NOT ALLOWED, Please Choose the correct time and Try Again!</p>";
                    }
                }
            } else if ($start_date > $finish_date) {
                echo "<p class='alert alert-warning text-center'>Invalid Date, Please Choose the correct Date and Try Again!</p>";
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
                        echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                    } else {
                        echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
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
                        echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                    } else {
                        echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
                    }
                }
            }
        }
    }

    //  end of apply overtimes function



}