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
use Symfony\Component\Mailer\Exception\TransportException;
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

        $data['overtime_total'] = $this->flexperformance_model->Overtime_total($emp_id);

        $data['line_overtime'] = $this->flexperformance_model->lineOvertimes($emp_id);

        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = 'My Services';
        $data['child'] = 'Overtimes';


        return response( [ 'data'=>$data ],200 );
    }
    public function myOvertimeApprovals()
    {

        $emp_id=auth()->user()->emp_id;

      
        $data['line_overtime'] = $this->flexperformance_model->lineOvertime($emp_id);



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
        $employee_data =  EMPL::where('emp_id',$empID)->first();




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
                            $linemanager_data = SysHelpers::employeeData($linemanager);
                            $fullname = $linemanager_data['full_name'];
                            $email_data = array(
                                'subject' => 'Employee Overtime Approval',
                                'view' => 'emails.linemanager.overtime-approval',
                                'email' => $linemanager_data['email'],
                                'full_name' => $fullname,
                            );
                            try {
                                PushNotificationController::bulksend([
                                    'title' => '4',
                                    'body' =>''.$employee_data['full_name'].' has an overtime request',
                                    'img' => '',
                                    'id' => $linemanager,
                                    'leave_id' => '',
                                    'overtime_id' => '',
                                   
                                    ]);
    
                                Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));
                            } catch (TransportException $exception) {
                                // echo "<p class='alert alert-danger text-center'>Overtime Request  Sent, But Email not sent due to connectivity problem!</p>";
                                $msg='Overtime Request  Sent, But Email not sent due to connectivity problem!';
                                return response( [ 'msg'=>$msg ],200);
                            }
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
                            $linemanager_data = SysHelpers::employeeData($linemanager);
                            $fullname = $linemanager_data['full_name'];
                            $email_data = array(
                                'subject' => 'Employee Overtime Approval',
                                'view' => 'emails.linemanager.overtime-approval',
                                'email' => $linemanager_data['email'],
                                'full_name' => $fullname,
                            );
                            try {
                                PushNotificationController::bulksend([
                                    'title' => '4',
                                    'body' =>''.$employee_data['full_name'].' has an overtime request',
                                    'img' => '',
                                    'id' => $linemanager,
                                    'leave_id' => '',
                                    'overtime_id' => '',
                                   
                                    ]);
    
                                Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));
                            } catch (TransportException $exception) {
                                // echo "<p class='alert alert-danger text-center'>Overtime Request  Sent, But Email not sent due to connectivity problem!</p>";
                                $msg='Overtime Request  Sent, But Email not sent due to connectivity problem!';
                                return response( [ 'msg'=>$msg ],200);
                            }
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
                        $linemanager_data = SysHelpers::employeeData($linemanager);
                        $fullname = $linemanager_data['full_name'];
                        $email_data = array(
                            'subject' => 'Employee Overtime Approval',
                            'view' => 'emails.linemanager.overtime-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                        );
                        try {
                            PushNotificationController::bulksend([
                                'title' => '4',
                                'body' =>''.$employee_data['full_name'].' has an overtime request',
                                'img' => '',
                                'id' => $linemanager,
                                'leave_id' => '',
                                'overtime_id' => '',
                               
                                ]);

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));
                        } catch (TransportException $exception) {
                            // echo "<p class='alert alert-danger text-center'>Overtime Request  Sent, But Email not sent due to connectivity problem!</p>";
                           $msg='Overtime Request  Sent, But Email not sent due to connectivity problem!';
                            return response( [ 'msg'=>$msg ],200);
                        }
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

                        $linemanager_data = SysHelpers::employeeData($linemanager);
                        $fullname = $linemanager_data['full_name'];
                        $email_data = array(
                            'subject' => 'Employee Overtime Approval',
                            'view' => 'emails.linemanager.overtime-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                        );
                        try {
                            PushNotificationController::bulksend([
                                'title' => '4',
                                'body' =>''.$employee_data['full_name'].' has an overtime request',
                                'img' => '',
                                'id' => $linemanager,
                                'leave_id' => '',
                                'overtime_id' => '',
                               
                                ]);

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));
                        } catch (TransportException $exception) {
                            // echo "<p class='alert alert-danger text-center'>Overtime Request  Sent, But Email not sent due to connectivity problem!</p>";
                         $msg='Overtime Request  Sent, But Email not sent due to connectivity problem!';
                            return response( [ 'msg'=>$msg ],200);
                        }
                        // echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";

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
    public function myLeave1s(Request $request)
    {
     //  $data['leaves'] =Leaves::orderBy('id','desc')->get();
      
        // $data['myleave'] = array_reverse($data['myleave']); // Reverse the order of leaves

        $emp_id=auth()->user()->emp_id;
        $data['leaves'] = $this->attendance_model->myLeaves($emp_id);
        // $data['leaves'] = $this->attendance_model->other_leaves($emp_id);
        // $data['leaves'] = $this->attendance_model->leave_line($emp_id);
        // $data['leave_types'] =LeaveType::all();
        // $data['employees'] =EMPL::where('line_manager',Auth::user()->emp_id)->get();
        // $data['leaves'] =Leaves::get();


        // Start of Escallation
       


    return response( [ 'data'=>$data  ],200 );
    }
    public function myLeaves(Request $request)
    {
     
        $data['leaves'] = Leaves::whereNot('reason', 'Automatic applied!')->whereNot('state',4)->orderBy('id', 'desc')->get();
        $data['revoked_leaves'] = Leaves::where('revoke_status', 0)->whereNot('reason', 'Automatic applied!')
        ->orWhere('revoke_status', 1)
        ->orderBy('id', 'DESC')->get();
        $line_manager = auth()->user()->emp_id;
        if ($data['leaves']->isNotEmpty()||$data['revoked_leaves']->isNotEmpty()) {
            foreach ($data['leaves'] as $key => $leave) {
                $uniqueLeaveID = $leave['id'];

                // Fetch 'appliedBy' value from 'sick_leave_forfeit_days' based on the unique 'leaveID'
                $appliedByValue = DB::table('sick_leave_forfeit_days')
                    ->where('leaveID', $uniqueLeaveID)
                    ->value('appliedBy');

                // Fetch 'forfeit_days' value from 'sick_leave_forfeit_days' based on the unique 'leaveID'
                $forfeitDaysValue = DB::table('sick_leave_forfeit_days')
                    ->where('leaveID', $uniqueLeaveID)
                    ->value('forfeit_days');

                if ($appliedByValue !== null) {
                    // Fetch 'full_name' from 'EMPL' model based on 'emp_id'
                    $full_name = EMPL::where('emp_id', $appliedByValue)->value('full_name');

                    // Add the 'appliedBy' attribute to the leave item
                    $data['leaves'][$key]['appliedBy'] = $full_name;

                    // Add the 'forfeit_days' attribute to the leave item
                    $data['leaves'][$key]['forfeit_days'] = $forfeitDaysValue;
                }
            }
            foreach ($data['revoked_leaves'] as $key => $leave) {
                $uniqueLeaveID = $leave['id'];

                // Fetch 'appliedBy' value from 'sick_leave_forfeit_days' based on the unique 'leaveID'
                $appliedByValue = DB::table('sick_leave_forfeit_days')
                    ->where('leaveID', $uniqueLeaveID)
                    ->value('appliedBy');

                // Fetch 'forfeit_days' value from 'sick_leave_forfeit_days' based on the unique 'leaveID'
                $forfeitDaysValue = DB::table('sick_leave_forfeit_days')
                    ->where('leaveID', $uniqueLeaveID)
                    ->value('forfeit_days');

                if ($appliedByValue !== null) {
                    // Fetch 'full_name' from 'EMPL' model based on 'emp_id'
                    $full_name = EMPL::where('emp_id', $appliedByValue)->value('full_name');

                    // Add the 'appliedBy' attribute to the leave item
                    $data['revoked_leaves'][$key]['appliedBy'] = $full_name;

                    // Add the 'forfeit_days' attribute to the leave item
                    $data['revoked_leaves'][$key]['forfeit_days'] = $forfeitDaysValue;
                }
            }
        }

        $filteredLeaves = [];
        $filteredLeaves1 = [];
        
        foreach ($data['leaves'] as $leave) {
            $level1 = LeaveApproval::where('empID', $leave->empID)
                ->where('level1', $line_manager)
                ->first();
           
            $level2 = LeaveApproval::where('empID', $leave->empID)
                ->where('level2', $line_manager)
                ->first();
        
            $level3 = LeaveApproval::where('empID', $leave->empID)
                ->where('level3', $line_manager)
                ->first();
        
            $approval = LeaveApproval::where('empID', $leave->empID)->first();
        
            if (
                auth()->user()->emp_id == $approval->level1 ||
                (auth()->user()->emp_id == $approval->level2 && $leave->status == 2) ||
                (auth()->user()->emp_id == $approval->level3 && $leave->status == 3) ||
                (auth()->user()->emp_id == $leave->deligated && $leave->status == 3)
            ) {
                $filteredLeaves[] = $leave;
            }
        }
        foreach ($data['revoked_leaves'] as $leave) {
            $level1 = LeaveApproval::where('empID', $leave->empID)
                ->where('level1', $line_manager)
                ->first();
           
            $level2 = LeaveApproval::where('empID', $leave->empID)
                ->where('level2', $line_manager)
                ->first();
        
            $level3 = LeaveApproval::where('empID', $leave->empID)
                ->where('level3', $line_manager)
                ->first();
        
            $approval = LeaveApproval::where('empID', $leave->empID)->first();
        
            if (
                auth()->user()->emp_id == $approval->level1 ||
                (auth()->user()->emp_id == $approval->level2 && $leave->status == 2) ||
                (auth()->user()->emp_id == $approval->level3 && $leave->status == 3) ||
                (auth()->user()->emp_id == $leave->deligated && $leave->status == 3)
            ) {
                $filteredLeaves1[] = $leave;
            }
        }
       
        
       


        $numberOfLeaves = count($filteredLeaves);
        $numberOfLeaves2 = count($filteredLeaves1);
        $data['leaves']=$filteredLeaves;
        $data['revoked_leaves']=$filteredLeaves1;

        

        foreach ($data['leaves'] as &$slip) {
            $slipArray = json_decode(json_encode($slip), true);
            $employee= EMPL::where("emp_id",$slipArray["empID"])->get()->first();

      
            $slipArray['empName'] = $employee['fname'].' '.$employee['lname'];
            
        
      
           
            $slip = (array) $slipArray;

            
        }
        foreach ($data['revoked_leaves'] as &$slip) {
            $slipArray = json_decode(json_encode($slip), true);
            $employee= EMPL::where("emp_id",$slipArray["empID"])->get()->first();

      
            $slipArray['empName'] = $employee['fname'].' '.$employee['lname'];
            
        
      
           
            $slip = (array) $slipArray;

            
        }
        

        return response( [ 'data'=>$data ],200);

    }
    
    
    //  end of employee leaves function


        //  start of employee leaves function
        public function myLoans(Request $request)
        {
            $empID = auth()->user()->emp_id;
            $data['loans'] = $this->reports_model->getALlLoanHistory($empID);
            // For pending loans
             $data['heslb'] =Helsb::where('empID',$empID)->get();


        return response( [ 'data'=>$data  ],200 );
        }
        //  end of employee leaves function


        //  start of employee Slips function
        public function mySlips(Request $request)
        {
            $empID = auth()->user()->emp_id;
            $data['month_list'] = $this->flexperformance_model->payroll_month_list2($empID);


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

                    //
                         $data['loans'] = $this->reports_model->loans($empID, $payroll_month);
                      
                         
                    foreach ($data['slipinfo'] as &$slip) {
                        $slipArray = json_decode(json_encode($slip), true);
                      
                    
                     
                        $slipArray['allowances'] = $data['allowances'] ;
                        
                    
                  
                        $slipArray['total_allowances'] =  $data['total_allowances'];
                        
                        foreach($data['loans'] as $loans){
                            array_push( $data['deductions'],$loans);
                        }
                       
                     
                        $slipArray['deductions'] = $data['deductions'] ;
                    
                        $slipArray['total_deductions'] =  $data['total_deductions'];

                        $slip = (array) $slipArray;

                        
                    }
                    
                    
                    $slipinfo =$data['slipinfo'];
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
                        $data['loans'] = $this->reports_model->loans($empID, $payroll_month);
                     
                        foreach ($data['slipinfo'] as &$slip) {
                            $slipArray = json_decode(json_encode($slip), true);
                      
                    
                     
                            $slipArray['allowances'] = $data['allowances'] ;
                            
                        
                      
                            $slipArray['total_allowances'] =  $data['total_allowances'];
                    
                        
                            $slipArray['deductions'] = $data['deductions'] ;
                            foreach($data['loans'] as $loans){
                                array_push( $data['deductions'],$loans);
                            }
                           
                        
                            $slipArray['total_deductions'] =  $data['total_deductions'];
    
                            $slip = (array) $slipArray;

    
                           
                        }
                        $slipinfo =$data['slipInfo'];
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
    public function employeeEmergency(Request $request)
    {
        $id = auth()->user()->emp_id;

        $emergency = EmergencyContact::where('employeeID', $id)->first();

        if ($emergency) {

            $emergency->employeeID = $id;
            $emergency->em_fname = $request->em_fname;
            $emergency->em_mname = $request->em_mname;
            $emergency->em_sname = $request->em_lname;
            $emergency->em_relationship = $request->em_relationship;
            $emergency->em_occupation = $request->em_occupation;
            $emergency->em_phone = $request->em_phone;
            $emergency->update();
        } else {
            $emergency = new EmergencyContact();
            
            $emergency->employeeID = $id;
            $emergency->em_fname = $request->em_fname;
            $emergency->em_mname = $request->em_mname;
            $emergency->em_sname = $request->em_lname;
            $emergency->em_relationship = $request->em_relationship;
            $emergency->em_occupation = $request->em_occupation;
            $emergency->em_phone = $request->em_phone;
            $emergency->save();
        }

        $msg = "Employee Details Have Been Updated successfully";
        return response(['msg'=>$msg],200);
    }
    public function updateUserInfo(Request $request)
    {


        $user = auth()->user()->emp_id;
        // request()->validate([
        //     'image' => 'required'
        // ]);

        $employee = EMPL::where('emp_id', $user)->first();

            $employee->physical_address =$request->physical_address;
            $employee->mobile=$request->mobile;
            $employee->update();

            $msg='Your Profile is updated Successfully !';
            return response( [ 'msg'=>$msg  ],200 );

        
        



    }
     

    //Viewing leave attachment
    // public function leaveAttachment(Request $request)
    // {


    //     $user = auth()->user()->emp_id;
    //     $image=$request->image;
    //     // request()->validate([
    //     //     'image' => 'required'
    //     // ]);

    //     $employee = EMPL::where('emp_id', $user)->first();
    //     if ($request->image !==null) {

    //         $newImageName = $image->hashName();
    //        $image->move(public_path('storage/profile'), $newImageName);
       

    //         $msg='';
    //         return response( [ 'msg'=>$msg  ],200 );

    //     }
    //     else
    //     {
    //         $msg='No attachments found';
    //         return response( [ 'msg'=>$msg  ],400 );
    //     }



    // }
    public function leaveAttachment(Request $request)
    {
        $user = auth()->user()->emp_id;
        $fileContent = $request->input('image');
        $storageDirectory = 'storage/leaves/';
    
        $employee = EMPL::where('emp_id', $user)->first();
    
        if ($fileContent !== "") {
            $fileName = hash('sha256', $fileContent);
            $filePath = $storageDirectory . $fileName;
            $bytesWritten = file_put_contents(public_path($filePath), $fileContent);
    
            if ($bytesWritten !== false) {
                $msg = 'File saved successfully.';
                return response(['msg' => $msg], 200);
            } else {
                $msg = 'Error occurred while saving the file.';
                return response(['msg' => $msg], 500);
            }
        } else {
            $msg = 'No file content provided.';
            return response(['msg' => $msg], 400);
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

    public function approveOvertime(Request $request)
    {

        $overtimeID =$request->id;

        // $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==4){
            dd($overtimeID);
        $signatory = session('emp_id');
        $time_approved = date('Y-m-d');
        $amount = 0;

        $overtime = $this->flexperformance_model->get_employee_overtime($overtimeID);
        //dd($overtime);

        $emp_id = $this->flexperformance_model->get_employee_overtimeID($overtimeID);

        $result = $this->flexperformance_model->approveOvertime($overtimeID, $signatory, $time_approved);
        if ($result == true) {


            SysHelpers::FinancialLogs($emp_id, 'Assigned Overtime', '0', number_format($overtime, 2), 'Payroll Input');

            echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>";
        }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is not yet Approved</p>";
        // }

    }

    public function lineApproveOvertime(Request $request)
    {

        $overtimeID = $request->id;

        $status = $this->flexperformance_model->checkOvertimeStatus($overtimeID);
   //     dd($status);
        $empID = $this->flexperformance_model->get_employee_overtimeID($overtimeID);
        $approver=EMPL::where('emp_id',auth()->user()->emp_id)->first();
        $employee_data =  EMPL::where('emp_id',$empID)->first();
        // $rate = $this->flexperformance_model->get_overtime_rate();
   
        if ($status == 0) {
            $signatory = session('emp_id');
          //  dd($signatory)
            $time_approved = date('Y-m-d');
            $result = $this->flexperformance_model->lineapproveOvertime($overtimeID, $time_approved);

            if ($result == true) {
                       PushNotificationController::bulksend([
                                    'title' => '5',
                                    'body' =>'Dear '.$employee_data['full_name'].',  Your overtime request has been recommended by '.$approver['full_name'].'',
                                    'img' => '',
                                    'id' =>$empID,
                                    'leave_id' => '',
                                    'overtime_id' => '',
                                   
                                    ]);
                return response()->json([
                
                    'msg' => 'Overtime Recommended Successifully'],200);
            } else {
                 return response()->json([
                    'msg' => 'Overtime recommendation failed'],400);
            }
        }else if($status == 4){
            return response()->json([
                'msg' => 'Overtime cannot be recommended '],400);
        }
     
        else {
            return response()->json([
                'msg' => "Overtime already recommended "],400);
        }
    }

    public function hrapproveOvertime($id)
    {

        $overtimeID = $id;

        $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==0){
        $signatory = session('emp_id');
        $time_approved = date('Y-m-d');
        $result = $this->flexperformance_model->hrapproveOvertime($overtimeID, $signatory, $time_approved);
        if ($result == true) {
            echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>";
        }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is Already Approved</p>";
        // }

    }

   public function dashboardData(){
        $id=auth()->user()->emp_id;
        $active_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->whereNot('reason', 'Automatic applied!')->get();
        $data=$active_leaves;
    //   foreach ($active_leaves as &object){
    //         if($active_leaves->state==0){

    //         }
    //   }
    $pending_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->where('state','1')->whereNot('reason', 'Automatic applied!')->get();
    $approved_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->where('state','0')->whereNot('reason', 'Automatic applied!')->get();
    $denied_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->where('state','5')->whereNot('reason', 'Automatic applied!')->get();
    $cancelled_leaves=Leaves::where('empID',auth()->user()->emp_id)->with('type:id,type,max_days')->where('state','4')->whereNot('reason', 'Automatic applied!')->get();
    // $data['total leaves applied']=$data;

    $overtimes= $this->flexperformance_model->my_overtimes($id);
  
    
    $count = 0;
    $count2 =0;
    $count3 =0;
    $count4=0;
    
    foreach ($overtimes as $overtime) {
        if ($overtime->status == '0') {
            $count++;
        }
        else if($overtime->status =='1'){
   $count2++;
        }else if($overtime->status =='2'){
            $count3++;
        }
        else if($overtime->status =='4'){
            $count4++;
        }
    }
    
    $pending = $count;
    $recommended= $count2;
    $approved= $count3;
    $denied= $count4;

    $loans =Helsb::where('empID',$id)->get();
    //dd($loans->count());
    if($loans->count()>0){
     $total =$loans->first()->amount;
     $paid =$loans->first()->paid;

     $remaining = $total-$paid;
     $percentage= $paid/$total *100;
     
     $pensions = $this->reports_model->employee_pension($id);
     $pension_employee =0;
     $pension_employer=0;
     foreach ($pensions
      as $pension) {
        $pension_employee = $pension_employee + $pension->pension_employee;
        # code...
        $pension_employer = $pension_employer + $pension->pension_employer;
     }
     $pension_employee=$pension_employee;
     $pension_employer=$pension_employer;
     $total_pension=$pension_employee+$pension_employee;


    
   
        return response([
           'total leaves applied'=>$data->count(),
           'pending leaves'=> $pending_leaves->count(),
           'approved leaves'=>$approved_leaves->count(),
           'denied leaves'=>$denied_leaves->count(),
           'cancelled leaves'=>$cancelled_leaves->count(),
           'total overtimes'=>count($overtimes),
           'pending overtimes'=>$pending,
           'recommended overtimes'=>$recommended,
           'approved overtimes'=>$approved,
            'denied overtimes'=>$denied,
           'total loan amount'=>$total,
           'remaining amount'=>$remaining,
           'paid amount'=>$paid,
           'percentage paid' => $percentage,
           'total employee pension contribution'=>$pension_employee,
           'total employer pension contribution'=>$pension_employer,
           'total pension'=>$total_pension

          // 'approved overtimes'=>count($overtimes->where('status','0'))
        ],200);
    }
    else{
        $pensions = $this->reports_model->employee_pension($id);
        $pension_employee =0;
        $pension_employer=0;
        foreach ($pensions
         as $pension) {
           $pension_employee = $pension_employee + $pension->pension_employee;
           # code...
           $pension_employer = $pension_employer + $pension->pension_employer;
        }
        $pension_employee=$pension_employee;
        $pension_employer=$pension_employer;
        $total_pension=$pension_employee+$pension_employee;
      //  $msg="No loan data found";
        return response([
            'total leaves applied'=>$data->count(),
            'pending leaves'=> $pending_leaves->count(),
            'denied leaves'=>$denied_leaves->count(),
           'cancelled leaves'=>$cancelled_leaves->count(),
            'approved leaves'=>$approved_leaves->count(),
            'total overtimes'=>count($overtimes),
            'pending overtimes'=>$pending,
            'denied overtimes'=>$denied,
            'approved overtimes'=>$approved,
            'recommended overtimes'=>$recommended,
            'remaining amount'=>'0.0',
            'paid amount'=>'0.0',
            'percentage paid' => '0.0',
            'total employee pension contribution'=>$pension_employee,
            'total employer pension contribution'=>$pension_employer,
            'total pension'=>$total_pension
           
 
           // 'approved overtimes'=>count($overtimes->where('status','0'))
         ],200);
    }
    
    }

    public function fin_approveOvertime($id)
    {

        $overtimeID = $id;

        // $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==0){
        $signatory = session('emp_id');
        $time_approved = date('Y-m-d');
        $result = $this->flexperformance_model->fin_approveOvertime($overtimeID, $signatory, $time_approved);
        if ($result == true) {
            echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>";
        }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is Already Approved</p>";
        // }

    }

    public function denyOvertime(Request $request)
    { //or disapprove

        $overtimeID = $request->id;
        $empID = $this->flexperformance_model->get_employee_overtimeID($overtimeID);
        $approver=EMPL::where('emp_id',auth()->user()->emp_id)->first();
        $employee_data =  EMPL::where('emp_id',$empID)->first();

        $status = $this->flexperformance_model->checkOvertimeStatus($overtimeID);
        if($status===0){
        $result = $this->flexperformance_model->deny_overtime($overtimeID);
        if ($result == true) {
            PushNotificationController::bulksend([
                'title' => '9',
                'body' =>'Dear '.$employee_data['full_name'].',  Your overtime request is denied by '.$approver['full_name'].'',
                'img' => '',
                'id' =>$empID,
                'leave_id' => '',
                'overtime_id' => '',
               
                ]);
            $msg="Overtime denied Successfully";
            return response([
                'msg'=>$msg
            ],200);
        } else {
            $msg="Overtime not denied, Some Errors Occured Please Try Again!";
            return response([
                'msg'=>$msg
            ],400);
        }
    }
        else {
            if($status==4){
            $msg="You cannot further reject this overtime";
            return response([
                'msg'=>$msg
            ],400);}
            else if($status==1)
            {
                $msg="You cannot  reject this overtime";
                return response([
                    'msg'=>$msg
                ],400);
            }
        }
      //  dd($status);
       
    }

    public function cancelOvertime(Request $request
    )
    {

        $id = $request->id;
       $overtimes= $this->flexperformance_model->checkOvertimeExistence($id);
        //dd($overtimes);
        $status = $this->flexperformance_model->checkOvertimeStatus($id);
        if($overtimes==true){

        if($status==0 || $status==4){ 
        $result = $this->flexperformance_model->deleteOvertime($id);

        if ($result == true) {
          return response([
              'msg'=>'Overtime cancelled Successfully'
          ],200);
        } else {
            return response([
                'msg'=>'Overtime not cancelled, Some Errors Occured Please Try Again!'
            ],400);
   
        }
    }else{
       // if($status==1){
            return response([
                'msg'=>'You cannot cancel this overtime'
            ],400);
        //}
    }}
    else{
        if($overtimes == false){
            return response([
                'msg'=>'Overtime not found'
            ],400);
        }
    }
    }

    public function confirmOvertimePayment(Request $request)
    {

        if ($this->uri->segment(3) != '') {

            $overtimeID = $this->uri->segment(3);
            $result = $this->flexperformance_model->confirmOvertimePayment($overtimeID, 1);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Overtime Payment Confirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
            }
        }
    }

    public function unconfirmOvertimePayment(Request $request)
    {

        if ($this->uri->segment(3) != '') {

            $overtimeID = $this->uri->segment(3);
            $result = $this->flexperformance_model->confirmOvertimePayment($overtimeID, 0);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Overtime Payment Unconfirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Unconfirm, Please Try Again!</p>";
            }
        }
    }

    public function fetchOvertimeComment(Request $request, $id)
    {

        $data['comment'] = $this->flexperformance_model->fetchOvertimeComment($id);
        $data['mode'] = 1; // Mode 1 fo Comment Purpose and Mode 2 for Update Purpose
        $data['parent'] = 'Overtime Remarks';

        return view('overtime.overtime_info', $data);
    }

    public function commentOvertime(Request $request)
    {
        $overtimeID = $request->input('overtimeID');

        $data = array(
            'final_line_manager_comment' => $request->input('comment'),
            'commit' => 1,
        );

        $this->flexperformance_model->update_overtime($data, $overtimeID);

        session('note', "<p class='alert alert-success text-center'>Commented Successifully</p>");

        return redirect(route('flex.overtime'));
    }

    /* public function deleteposition(Request $request)
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
    $id = $request->input("id");
    $data = array(
    'state' => 0
    );
    $this->flexperformance_model->updateposition($data, $id);
    session('note', "<p class='alert alert-warning text-center'>Position Removed Successifully</p>");
    return  redirect('/flex/position');

    }*/


}

