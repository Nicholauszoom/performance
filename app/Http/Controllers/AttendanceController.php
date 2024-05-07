<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Helpers\SysHelpers;
use App\Http\Controllers\API\PushNotificationController;
use App\Http\Middleware\Leave;
use App\Imports\ClearLeavesImport;
use App\Models\AttendanceModel;
use App\Models\EMPL;
use App\Models\Employee;
use App\Models\LeaveApproval;
use App\Models\LeaveForfeiting;
use App\Models\Leaves;
use App\Models\LeaveSubType;
use App\Models\LeaveType;
use App\Models\Level1;
use App\Models\level2;
use App\Models\Level3;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Payroll\ImprestModel;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\ReportModel;
use App\Models\PerformanceModel;
use App\Models\Position;
use App\Models\ProjectModel;
use App\Notifications\EmailRequests;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth; // Create this import
use Illuminate\Support\Facades\DB;
// use App\Http\Middleware\Employee;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
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
        $this->flexperformance_model = new FlexPerformanceModel();
        $this->imprest_model = new ImprestModel();
        $this->reports_model = new ReportModel();
        $this->attendance_model = new AttendanceModel();
        $this->project_model = new ProjectModel();
        $this->performanceModel = new PerformanceModel();
        $this->payroll_model = new Payroll;

    }

    public function authenticateUser($permissions)
    {
        // Check if the user is not authenticated
        if (!auth()->check()) {
            // Redirect the user to the login page
            return redirect()->route('login');
        }

        // Check if the authenticated user does not have the specified permissions
        if (!Gate::allows($permissions)) {
            // If not, abort the request with a 401 Unauthorized status code
            abort(Response::HTTP_UNAUTHORIZED);
        }
    }
    public function attendance()
    {

        if (Auth::user()->emp_id != '' && $this->input->post('state') == 'due_in') {
            $data = array(
                'empID' => Auth::user()->emp_id,
                'due_in' => date('Y-m-d h:i:s'),
                'due_out' => date('Y-m-d h:i:s'),
                'state' => 1,
            );
            $this->attendance_model->attendance($data);

            echo '<form method ="post"  id = "attendance" >  <button class="btn btn-round btn-default">  <span id = "resultAttendance"></span>Attended <span class="badge bg-green"><i class="fa fa-check-square-o"></i></span> </span></button></form>';

        }

        if (Auth::user()->emp_id != '' && $this->input->post('state') == 'due_out') {
            $this->attendance_model->attend_out(Auth::user()->emp_id, date('Y-m-d'), date('Y-m-d h:i:s'));
            echo '<span><button class="btn btn-round btn-default">Attended Out <span class="badge bg-grey"><i class="fa fa-check"></i></span></button></span>';

        }
    }

    public function attendees()
    {
        //   $id = Auth::user()->emp_id;
        if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {
            $date = date('Y-m-d');
            $data['attendee'] = $this->attendance_model->attendees($date);
            $data['title'] = "Attendances";
            return view('app.attendees', $data);
        } else {
            echo 'Unauthorized Access';
        }

    }

    public function attendeesFetcher()
    {

        $date = $this->input->post('due_date');
        $day = str_replace('/', '-', $date);
        $customday = date('Y-m-d', strtotime($day));

        $attendees = $this->attendance_model->attendees($customday);

        // echo $customday;

        if ($attendees) {
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

            foreach ($attendees as $row) {

                echo '<tr>
            <td width="1px">' . $row->SNo . '</td>
            <td>' . $row->name . '</td>
            <td> <b>Department: </b>' . $row->DEPARTMENT . '<br><b>Position: </b>' . $row->POSITION . '</td>
            <td>' . $row->time_in . '</td>
            <td>' . $row->time_out . '</td>
          </tr>';
            }
            echo '</tbody>
                    </table>';
        } else {
            echo 'No Attendees In This Date';
        }

    }

    public function leaveforfeiting()
    {

        $empID = Auth::user()->emp_id;
        $leaveforfeitings = LeaveForfeiting::all();
        $data['leaveForfeiting'] = LeaveForfeiting::all();
        $data['employees'] = Employee::where('state', 1)->get();

        $today = date('Y-m-d');
        $arryear = explode('-', $today);
        $year = $arryear[0];

        $employeeDate = $year . ('-01-01');

        $data['leaves'] = Leaves::where('state', 0)->latest()->get();

        foreach ($leaveforfeitings as $key => $leaveforfeit) {
            $data['leaveForfeiting'][$key]['leaveBalance'] = $this->attendance_model->getLeaveBalance($leaveforfeit->empID, $employeeDate, date('Y-m-d'));
        }

        $data['title'] = "Leaves";
        $data['today'] = date('Y-m-d');
        return view('app.leave_forfeiting_report', $data);

    }

    public function leave()
    {

        //$this->authenticateUser('view-leave');
        $data['myleave'] = Leaves::where('empID', Auth::user()->emp_id)->get();

        if (session('appr_leave') || 1) {
            $data['otherleave'] = $this->attendance_model->leave_line(Auth::user()->emp_id);
        } else {
            $data['otherleave'] = $this->attendance_model->other_leaves(Auth::user()->emp_id);
        }

        // Now, you have the 'appliedBy' value for the specific leave

        $data['leave_types'] = LeaveType::all();

        $data['leaves'] = Leaves::where('state', 1)->orderBy('id', 'DESC')->get();

        $data['approved_leaves'] = Leaves::where('state', 0)
            ->orderBy('id', 'DESC')->get();
        $data['revoked_leaves'] = Leaves::where('revoke_status', 0)
            ->orWhere('revoke_status', 1)
            ->orderBy('id', 'DESC')->get();
        $full_names = []; // Initialize an array to store full names
        $appliedBy = [];
        //  dd($data['leaves']);

// Check if 'leaves' is not empty and has at least one item
// Process leaves
        if ($data['leaves']->isNotEmpty()) {
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
        }

// Process leaves
        if ($data['approved_leaves']->isNotEmpty()) {
            foreach ($data['approved_leaves'] as $key => $leave) {
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
                    $data['approved_leaves'][$key]['forfeit_days'] = $forfeitDaysValue;

                    // Add the 'appliedBy' attribute to the leave item
                    $data['approved_leaves'][$key]['appliedBy'] = $full_name;
                }
            }
        }

// Now, you have an array of 'full_name' values corresponding to each leave
//dd($full_names);

        $data['leave_types'] = LeaveType::all();

        $data['leaveBalance'] = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id, Auth::user()->hire_date, date('Y-m-d'));

        $employ = EMPL::whereNot('state', 4)->get();
        $data['employees'] = EMPL::get();

        foreach ($employ as $item) {
            $balance = $this->attendance_model->getLeaveBalance($item->emp_id, $item->hire_date, date('Y-m-d'));
            $total_leave = Leaves::where('empID', $item->emp_id)->where('nature', 1)->sum('days');

            $remaining = $balance - $total_leave - 6.99;

        }

        // For Working days
        $d1 = new DateTime(Auth::user()->hire_date);
        $d2 = new DateTime();
        $interval = $d2->diff($d1);
        $data['days'] = $interval->days;
        $data['title'] = 'Leave';
        $id = Auth::user()->emp_id;
        $level1 = DB::table('leave_approvals')->Where('level1', $id)->count();
        $level2 = DB::table('leave_approvals')->Where('level2', $id)->count();
        $level3 = DB::table('leave_approvals')->Where('level3', $id)->count();

        $data['deligate'] = $level1 + $level2 + $level3;

        $data['leave_type'] = $this->attendance_model->leave_type();
        return view('app.leave', $data);

    }

    // For My Leaves
    public function myLeaves()
    {


        $this->authenticateUser('view-leaves');

        $data['myleave'] = Leaves::where('empID', Auth::user()->emp_id)->orderBy('id', 'desc')->get();
        $id = Auth::user()->emp_id;
        $employeee = Employee::where('emp_id', $id)->first();


        $level1 = DB::table('leave_approvals')->Where('level1', $id)->count();
        $level2 = DB::table('leave_approvals')->Where('level2', $id)->count();
        $level3 = DB::table('leave_approvals')->Where('level3', $id)->count();

        $data['deligate'] = $level1 + $level2 + $level3;
        $data['leave_types'] = LeaveType::all();
        $data['employees'] = EMPL::where('emp_id', '!=', Auth::user()->emp_id)->whereNot('state', 4)->get();
        $data['leave_days_entitled'] = Employee::where('emp_id', '!=', Auth::user())->value('leave_days_entitled');
        $data['balance_brought_foward'] = LeaveForfeiting::where('empID', '!=', Auth::user())->value('opening_balance');
        // $data['leaves'] =Leaves::get();

        // For Working days
        $d1 = new DateTime(Auth::user()->hire_date);
        $d2 = new DateTime();
        $interval = $d2->diff($d1);
        $data['days'] = $interval->days;
        $data['title'] = 'Leave';
        //$max_leave_days = 10000;
        $today = date('Y-m-d');
        $arryear = explode('-', $today);
        $year = $arryear[0];

        $employeeHiredate = explode('-', Auth::user()->hire_date);
        $employeeHireYear = $employeeHiredate[0];
        $employeeDate = '';

        if ($employeeHireYear == $year) {
            $employeeDate = Auth::user()->hire_date;

        } else {
            $employeeDate = $year . ('-01-01');
        }

        // dd($emp loyeeDate);
        $data['leaveDates'] = $this->checkDate(Auth::user()->emp_id);

        $data['leaveBalance'] = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id, $employeeDate, date('Y-m-d'));
        $data['outstandingLeaveBalance'] = $this->attendance_model->getAnnualOutstandingBalance(Auth::user()->emp_id, $employeeDate, date('Y-m-d'));
        $data['annualLeaveBalance'] = $this->getspentDays(Auth::user()->emp_id, 1);
        $data['checking'] = $this->annuaLeaveSummary($year);
        $data['leave_type'] = $this->attendance_model->leave_type();

        $data['parent'] = 'My Services';
        $data['child'] = 'Leaves';

        return view('my-services/leaves', $data);
    }



    public function annuaLeaveSummary($year)
    {

        $data = [];
        $employee = Employee::where('emp_id', Auth::user()->emp_id)->first();
        if ($employee->leave_effective_date) {
            if (date('Y-m-d') <= $employee->leave_effective_date) {
                // If the current date is before or equal to the leave effective date
                $data['Days Entitled'] = Employee::where('emp_id', Auth::user()->emp_id)->value('old_leave_days_entitled');
            } else {
                // If the current date is after the leave effective date
                // You might want to handle this case differently
                $data['Days Entitled'] = Employee::where('emp_id', Auth::user()->emp_id)->value('leave_days_entitled');
            }
        } else {
            // If leave_effective_date is null
            $data['Days Entitled'] = Employee::where('emp_id', Auth::user()->emp_id)->value('leave_days_entitled');
        }

        $openingBalance = LeaveForfeiting::where('empID', Auth::user()->emp_id)->value('opening_balance');
        if ($year > date('Y')) {
            $forfeitDays = 0;
            $data['Opening Balance'] = 0;
        } elseif ($year < date('Y')) {
            $forfeitDays = LeaveForfeiting::where('empID', Auth::user()->emp_id)
                ->where('forfeiting_year', $year)
                ->value('days');
            $openingBalance = LeaveForfeiting::where('empID', Auth::user()->emp_id)->where('opening_balance_year', $year)->value('opening_balance');

            $data['Opening Balance'] = $openingBalance ?? 0;

        } else {
            $forfeitDays = LeaveForfeiting::where('empID', Auth::user()->emp_id)
            ->where('forfeiting_year', $year)
                ->value('days');
            $openingBalance = LeaveForfeiting::where('empID', Auth::user()->emp_id)->value('opening_balance');

            $data['Opening Balance'] = $openingBalance ?? 0;
        }

        // $data['Opening Balance'] = $openingBalance ?? 0;
        $data['Days Forfeited'] = $forfeitDays ?? 0;

        $employeeHiredate = explode('-', Auth::user()->hire_date);
        $employeeHireYear = $employeeHiredate[0];
        $employeeDate = '';

        if ($year > date('Y')) {
            $daysAccrued = 0;
            $outstandingLeaveBalance = 0;
        } elseif ($year < date('Y')) {
            if ($employeeHireYear == $year) {
                $employeeDate = Auth::user()->hire_date;
            } else {
                $employeeDate = $year . '-01-01';
            }
            $endDate = $year . '-12-31';
            $daysAccrued = $this->attendance_model->getAccruedBalance(Auth::user()->emp_id, $employeeDate, $endDate);
            $spent = $this->getspentDays(Auth::user()->emp_id, $year);
            $outstandingLeaveBalance =  $daysAccrued  - $spent + $openingBalance - $forfeitDays;
        } else {
            if ($employeeHireYear == $year) {
                $employeeDate = Auth::user()->hire_date;
            } else {
                $employeeDate = $year . '-01-01';
            }
            $daysAccrued = $this->attendance_model->getAccruedBalance(Auth::user()->emp_id, $employeeDate, date('Y-m-d'));
            $outstandingLeaveBalance = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id, $employeeDate, date('Y-m-d'));
        }
        $data['Days Taken	'] = $this->getspentDays(Auth::user()->emp_id, $year);



        $data['Accrued Days'] = number_format($daysAccrued ?? 0, 2);
        $data['Outstanding Leave Balance'] = number_format($outstandingLeaveBalance , 2) ;
        return response()->json($data);
    }

    public function getDetails($uid = 0)
    {

        $par = $uid;

        $raw = explode('|', $par);
        $id = $raw[0];
        $start = $raw[1];
        $end = $raw[2];

        if ($start == null || $end == null) {
            $total_days = 0;
        } else {
            $days = SysHelpers::countWorkingDays($start, $end);
            $holidays = SysHelpers::countHolidays($start, $end);
            $total_days = $days - $holidays;
        }

        //For Gender
        $gender = Auth::user()->gender;
        if ($gender == "Male") {$gender = 1;} else { $gender = 2;}
        // For Male Employees
        if ($gender == 1) {
            $data['data'] = LeaveSubType::where('category_id', $id)->Where('sex', 0)->get();
            // return response()->json($data);
            return json_encode($data);
        }
        // For Female Employees
        else {
            $data = LeaveSubType::where('category_id', $id)->get();
            // return json_encode($data);
            return response()->json(['data' => $data, 'days' => $total_days]);
        }

    }
    public function getDetailsSub($uid = 0)
    {

        $par = $uid;

        $raw = explode('|', $par);
        $id = $raw[0];
        $start = $raw[1];
        $end = $raw[2];
        $empID = $raw[3];

        if ($start == null || $end == null) {
            $total_days = 0;
        } else {
            $days = SysHelpers::countWorkingDays($start, $end);
            $holidays = SysHelpers::countHolidays($start, $end);
            $total_days = $days - $holidays;
        }

        //For Gender
        $gender = EMPL::where('id', $empID)->value('gender');
        if ($gender !== null) {
            // dd($gender);
        } else {
            // Handle the case where no employee with the specified empID was found.
        }
        if ($gender == "Male") {$gender = 1;} else { $gender = 2;}
        // For Male Employees
        if ($gender == 1) {
            $data['data'] = LeaveSubType::where('category_id', $id)->Where('sex', 0)->get();
            // return response()->json($data);
            return json_encode($data);
        }
        // For Female Employees
        else {
            $data = LeaveSubType::where('category_id', $id)->get();
            // return json_encode($data);
            return response()->json(['data' => $data, 'days' => $total_days]);
        }

    }

    public function getspentDays($employeeId, $year)
    {
        $natureId = 1;
        $currentYear = date('Y');

        if ($year != date('Y')) {
            $startDate = $year . '-01-01'; // Start of the current year
            $endDate = $year . '-12-31';

            $daysSpent = Leaves::where('empId', $employeeId)
                ->where('nature', $natureId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNot('reason', 'Automatic applied!')
                ->where('state', 0)
                ->sum('days');
        } else {
            $startDate = $year . '-01-01'; // Start of the current year
            $endDate = $currentYear . '-12-31'; // Current date

            $daysSpent = Leaves::where('empId', $employeeId)
                ->where('nature', $natureId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNot('reason', 'Automatic applied!')
                ->where('state', 0)
                ->sum('days');
        }

        return $daysSpent;
    }

    public function check_leave_balance(Request $request)
    {
        $today = date('Y-m-d');
        $arryear = explode('-', $today);
        $year = $arryear[0];
        $nature = $request->nature;
        $empID = $request->empID;

        if ($nature == 1) {

        } elseif ($nature == 2) {

        } elseif ($nature == 3) {

        } elseif ($nature == 4) {

        } elseif ($nature == 5) {
            $leave_balance = $this->attendance_model->get_sick_leave_balance($empID, $nature, $year);

        } elseif ($nature == 6) {
            $leave_balance = $this->attendance_model->get_sick_leave_balance($empID, $nature, $year);

        }
// elseif($nature == 7)
// {
//  $leave_balance =   $this->attendance_model-> ($empID,$nature,$year,$today);

// }

        return json_encode($year);
    }



    public function validateSickLeaveDate(Request $request,$date) {
        return json_encode([ 'status' => SysHelpers::isDateNextToWeekendOrHoliday($date)]);
    }

    public function checkDate($empID)
    {
        // Get the current year
        $currentYear = Carbon::now()->year;

        // Get the leaves for the specified employee within the current year
        $leaves = Leaves::where('empID', $empID)
            ->whereYear('start', $currentYear)
            ->get();

        // Initialize an array to store the start and end dates for each leave
        $userLeaves = [];

        foreach ($leaves as $leave) {
            $userLeaves[] = [
                'start' => $leave->start,
                'end' => $leave->end,
            ];
        }

        // Return the array of start and end dates for the employee's leaves within the current year
        return $userLeaves;
    }

    public function saveLeave(Request $request)
    {

        request()->validate(
            [

               // start of name information validation

                'mobile' => 'required|numeric',
                'leave_address' => 'nullable',
                'reason' => 'required',

            ]);
        $start = $request->start;
        $end = $request->end;

        // For Redirection Url
        $url = redirect('flex/attendance/my-leaves');

        $employeee = Employee::where('emp_id', Auth::user()->emp_id)->first();

        $linemanager = $employeee->line_manager;
        $leaveApproval = new LeaveApproval();
        $leaveApproval = $leaveApproval::where('empID', Auth::user()->emp_id)->first();

        if(!$leaveApproval){
           $leaveApproval =  new LeaveApproval();
           $leaveApproval->empID = Auth::user()->emp_id;
           $leaveApproval->level1 = $linemanager;
           $leaveApproval->save();
        }

        if ($start <= $end) {

            //For Gender
            $gender = Auth::user()->gender;
            if ($gender == "Male") {$gender = 1;} else { $gender = 2;}
            // for checking balance
            $today = date('Y-m-d');
            $arryear = explode('-', $today);
            $year = $arryear[0];
            $nature = $request->nature;
            $empID = Auth::user()->emp_id;

            // Check if there is a pending leave in the given number of days (start,end)
            // $pendingLeave = Leaves::where('empId', $empID)
            //     ->where('state', 1)
            //     ->whereDate('end', '>=', $start)
            //     ->first();
            $pendingLeave = Leaves::where('empId', $empID)
            ->where('state', 1)
            ->whereDate('start', '<=', $start)
            ->whereDate('end', '>=', $start)
            ->first();

            $approvedLeave = Leaves::where('empId', $empID)
            ->where('state', 0)
            ->whereDate('start', '<=', $start)
            ->whereDate('end', '>=', $start)
            ->first();


            if ($pendingLeave || $approvedLeave) {
                $message = 'You have a ';

                if ($pendingLeave) {
                    $message .= 'pending ' . $pendingLeave->type->type . ' application ';
                }

                if ($approvedLeave) {
                    $message .= ($pendingLeave ? 'and ' : '') . 'approved ' . $approvedLeave->type->type . ' application ';
                }

                $message .= 'within the requested leave time';

                return $url->with('error', $message);
            }

            // Checking used leave days based on leave type and sub type
            $leaves = Leaves::where('empID', $empID)->where('nature', $nature)->where('sub_category', $request->sub_cat)->whereNot('reason', 'Automatic applied!')->whereYear('created_at', date('Y'))->sum('days');

            $leave_balance = $leaves;
            // For Leave Nature days
            $type = LeaveType::where('id', $nature)->first();
            $max_leave_days = $type->max_days;

            //$max_leave_days = 10000;

            $employeeHiredate = explode('-', Auth::user()->hire_date);
            $employeeHireYear = $employeeHiredate[0];
            $employeeDate = '';

            if ($employeeHireYear == $year) {
                $employeeDate = Auth::user()->hire_date;

            } else {
                $employeeDate = $year . ('-01-01');
            }

            // Annual leave accurated days
            $annualleaveBalance = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id, $employeeDate, date('Y-m-d'));
            // For  Requested days
            if ($nature == 1 || $nature == 6 ) {
                $holidays = SysHelpers::countHolidays($start, $end);
                $different_days = SysHelpers::countWorkingDays($start, $end) - $holidays;

            } else {

                // $holidays=SysHelpers::countHolidays($start,$end);
                // $different_days = SysHelpers::countWorkingDays($start,$end)-$holidays;
                $different_days = SysHelpers::countWorkingDaysForOtherLeaves($start, $end);

                // $startDate = Carbon::parse($start);
                // $endDate = Carbon::parse($end);
                // $different_days = $endDate->diffInDays($startDate);
            }

            // For Total Leave days
            $total_remaining = $leaves + $different_days;

            // For Working days
            $d1 = new DateTime($employeeDate);
            $d2 = new DateTime();
            $interval = $d2->diff($d1);
            $day = SysHelpers::countWorkingDays($d1, $d2);

            // For Employees with less than 12 months of employement
            if ($day <= 365) {

                //  For Leaves with sub Category
                if ($request->sub_cat > 0) {

                    // For Sub Category details
                    $sub_cat = $request->sub_cat;
                    $sub = LeaveSubType::where('id', $sub_cat)->first();

                    // dd($sub);

                    $total_leave_days = $leaves + $different_days;
                    dd($total_leave_days);

                    $maximum = $sub->max_days;
                    // Case hasnt used all days
                    if ($total_leave_days < $maximum) {
                        $leaves = new Leaves();
                        $empID = Auth::user()->emp_id;
                        $leaves->empID = $empID;
                        $leaves->status = 1;
                        $leaves->start = $request->start;
                        $leaves->end = $request->end;
                        $leaves->leave_address = $request->address;
                        $leaves->mobile = $request->mobile;
                        $leaves->nature = $request->nature;

                        // For Study Leave
                        if ($request->nature == 6) {
                            $leaves->days = $different_days;
                        }
                        //For Compassionate and Maternity
                        else {
                            $leaves->days = $different_days;
                        }
                        $leaves->reason = $request->reason;
                        $leaves->sub_category = $request->sub_cat;
                        $leaves->remaining = $request->sub_cat;
                        $leaves->application_date = date('Y-m-d');
                        // For Leave Attachments
                        if ($request->hasfile('image')) {
                            $request->validate([
                                //  'image' => 'required|clamav',
                            ]);
                            $request->validate([
                                'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                            ]);
                            $newImageName = $request->image->hashName();
                            $request->image->move(public_path('storage/leaves'), $newImageName);
                            $leaves->attachment = $newImageName;

                        }
                        $leaves->save();
                        $autheniticateduser = auth()->user()->emp_id;
                        $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;

                        //fetch Line manager data from employee table and send email
                        $linemanager = LeaveApproval::where('empID', $empID)->first();
                        $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                        $employee_data = SysHelpers::employeeData($empID);
                        $fullname = $linemanager_data['full_name'];
                        $email_data = array(
                            'subject' => 'Employee Leave Approval',
                            'view' => 'emails.linemanager.leave-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                            'employee_name' => $employee_data['full_name'],
                            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                        );

                        try {
                            PushNotificationController::bulksend([
                                'title' => '2',
                                'body' => 'Dear '.$linemanager_data['full_name'].',You have a leave request to approve of ' . $employee_data['full_name'],
                                'img' => '',
                                'id' => $linemanager->level1,
                                'leave_id' => $leaves->id,
                                'overtime_id' => '',
                            ]);

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                        } catch (Exception $exception) {
                            $msg = $type_name . " Leave Request  Has been Requested But Email is not sent(SMTP Problem)!";
                            return $url->with('msg', $msg);

                        }
                        $msg = $type_name . " Leave Request  Has been Requested Successfully!";
                        return $url->with('msg', $msg);

                    }
                    //  Case has used up all days or has less remaining leave days balance
                    else {

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;
                        $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance";

                        return $url->with('msg', $msg);
                    }

                }
                // For Leaves with no sub Category
                else {

                    $total_leave_days = $leaves + $different_days;

                    if ($total_leave_days < $max_leave_days || $request->nature == 1) {
                        $remaining = $max_leave_days - ($leave_balance + $different_days);
                        $leaves = new Leaves();
                        $empID = Auth::user()->emp_id;
                        $leaves->empID = $empID;
                        $leaves->start = $request->start;
                        $leaves->end = $request->end;
                        $leaves->leave_address = $request->address;
                        $leaves->status = 1;
                        $leaves->mobile = $request->mobile;
                        $leaves->nature = $request->nature;
                        $leaves->deligated = $request->deligate;

                        // for annual leave
                        if ($request->nature == 1) {
                            $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id, $employeeDate, date('Y-m-d'));

                            // checking annual leave balance
                            if ($different_days < $annualleaveBalance) {
                                $leaves->days = $different_days;
                                $remaining = $annualleaveBalance - $different_days;
                            } else {
                                // $leaves->days=$annualleaveBalance;
                                $msg = 'You Have Insufficient Annual  Accrued Days';
                                return $url->with('msg', $msg);
                            }
                        }

                        // For Paternity
                        if ($request->nature != 5 && $request->nature != 1) {

                            $leaves->days = $different_days;
                        }
                        if ($request->nature == 5) {

                            // Incase the employee had already applied paternity before
                            $paternity = Leaves::where('empID', $empID)->where('nature', $nature)->where('sub_category', $request->sub_cat)->first();
                            if ($paternity) {
                                $d1 = $paternity->created_at;
                                $d2 = new DateTime();
                                $interval = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
                                $range = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);

                                $month = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
                                // Incase an Employee has less than four working month since the last applied paternity
                                if ($month < 112) {
                                    $max_days = 7;
                                    if ($total_leave_days < $max_days) {
                                        // Case reqested days are less than the balance
                                        if ($different_days <= $max_days) {
                                            $leaves->days = $different_days;
                                        }
                                        // Case requested days are more than the balance
                                        else {
                                            $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                            return $url->with('msg', $msg);
                                        }

                                    } else {

                                        $leave_type = LeaveType::where('id', $nature)->first();
                                        $type_name = $leave_type->type;
                                        $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance2";
                                        return $url->with('msg', $msg);

                                    }

                                }
                                // For Employees who have attained 4 working months
                                else {
                                    $max_days = 10;

                                    if ($different_days < $max_days) {
                                        $leaves->days = $different_days;
                                    } else {
                                        $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                        return $url->with('msg', $msg);
                                    }

                                }
                            }
                            // Incase an employee is applying for paternity for the first time
                            else {
                                // Checking if employee has less than 4 working months
                                if ($day < 112) {
                                    $max_days = 7;
                                    if ($total_leave_days < $max_days) {
                                        if ($different_days <= $max_days) {
                                            $leaves->days = $different_days;
                                        } else {
                                            $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                            return $url->with('msg', $msg);
                                        }

                                    } else {

                                        $leave_type = LeaveType::where('id', $nature)->first();
                                        $type_name = $leave_type->type;
                                        $msg = "Sorry, You have Insufficient  " . $type_name . " Leave Days Balance";
                                        return $url->with('msg', $msg);

                                    }

                                }
                                // For Employee with more than 4 working months
                                else {
                                    $max_days = 10;

                                    if ($different_days < $max_days) {
                                        $leaves->days = $different_days;
                                    } else {
                                        $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                        return $url->with('msg', $msg);
                                    }

                                }
                            }

                        }
                        $leaves->reason = $request->reason;
                        $leaves->remaining = $remaining;

                        $leaves->sub_category = $request->sub_cat;
                        $leaves->application_date = date('Y-m-d');
                        // START
                        if ($request->hasfile('image')) {
                            $request->validate([
                                // 'image' => 'required|clamav',
                            ]);
                            $request->validate([
                                'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                            ]);

                            $newImageName = $request->image->hashName();
                            $request->image->move(public_path('storage/leaves'), $newImageName);
                            $leaves->attachment = $newImageName;

                        }

                        $leaves->save();
                        $autheniticateduser = auth()->user()->emp_id;
                        $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);


                        //fetch Line manager data from employee table and send email
                        $linemanager = LeaveApproval::where('empID', $empID)->first();
                        $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                        $employee_data = SysHelpers::employeeData($empID);
                        $fullname = $linemanager_data['full_name'];
                        $email_data = array(
                            'subject' => 'Employee Leave Approval',
                            'view' => 'emails.linemanager.leave-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                            'employee_name' => $employee_data['full_name'],
                            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                        );
                        try {
                            PushNotificationController::bulksend([
                                'title' => '2',
                                'body' => 'Dear '.$linemanager_data['full_name'].',You have a leave request to approve of ' . $employee_data['full_name'],
                                'img' => '',
                                'id' => $linemanager->level1,
                                'leave_id' => $leaves->id,
                                'overtime_id' => '',
                            ]);

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                        } catch (Exception $exception) {

                            dd($exception->getMessage());


                            $leave_type = LeaveType::where('id', $nature)->first();
                            $type_name = $leave_type->type;
                            $msg = $type_name . " Leave Request is submitted successfully But Email not sent(SMTP Problem)!";
                            return $url->with('msg', $msg);
                        }

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;
                        $msg = $type_name . " Leave Request is submitted successfully!";
                        return $url->with('msg', $msg);
                    } else {

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;
                        $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance3";
                        return $url->with('msg', $msg);

                    }

                }

            }
            // For Employee with more than 12 Month
            else {

                $total_leave_days = $leaves + $different_days;

                if ($total_leave_days < $max_leave_days) {
                    $remaining = $max_leave_days - ($leave_balance + $different_days);
                    $leaves = new Leaves();
                    $empID = Auth::user()->emp_id;
                    $leaves->empID = $empID;
                    $leaves->start = $request->start;
                    $leaves->end = $request->end;
                    $leaves->status = 1;
                    $leaves->leave_address = $request->address;
                    $leaves->mobile = $request->mobile;
                    $leaves->nature = $request->nature;
                    $leaves->deligated = $request->deligate;

                    // for annual leave
                    if ($request->nature == 1) {

                        $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id, $employeeDate, date('Y-m-d'));

                        // checking annual leave balance
                        if ($different_days < $annualleaveBalance) {
                            $leaves->days = $different_days;
                            $remaining = $annualleaveBalance - $different_days;

                        } else {
                            $msg = 'You Have Insufficient Annual  Accrued Days';
                            return response(['msg' => $msg], 202);
                        }

                    }

                    if ($request->nature != 5 && $request->nature != 1) {

                        $leaves->days = $different_days;
                    }
                    // For Paternity leabe
                    if ($request->nature == 5) {

                        $paternity = Leaves::where('empID', $empID)->where('nature', 5)->where('sub_category', $request->sub_cat)->whereYear('created_at', date('Y'))->orderBy('created_at', 'desc')->first();
                        // Case an Employee has ever applied leave before
                        if ($paternity) {
                            $d1 = $paternity->created_at;
                            $d2 = new DateTime();
                            $interval = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);

                            $month = $interval;
                            // For Employee With Less Than 4 month of service and last application
                            if ($month < 112) {

                                $max_days = 7;
                                // Case Requested days are less than max-days
                                if ($total_leave_days <= $max_days) {
                                    if ($different_days < $max_days) {
                                        $leaves->days = $different_days;
                                    } else {
                                        $msg = "Sorry, You have Insufficient Leave Days Balance";
                                        return $url->with('msg', $msg);
                                    }

                                }
                                // case All Paternity days have been used up
                                else {

                                    $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance4";
                                    return $url->with('msg', $msg);
                                }

                            }
                            // For Employee who as attained more than 4 working days
                            else {
                                $max_days = 10;
                                if ($total_leave_days <= $max_days) {
                                    if ($different_days < $max_days) {
                                        $leaves->days = $different_days;
                                    } else {
                                        $msg = "Sorry, You have Insufficient Leave Days Balance";
                                        return $url->with('msg', $msg);
                                    }

                                }
                                // case All Paternity days have been used up
                                else {

                                    $excess = $total_leave_days - $max_days;
                                    // dd($excess);
                                    $msg = 'You requested for ' . $excess . ' extra days!';

                                    return $url->with('msg', $msg);
                                }
                            }
                        }
                        // Case an employee is applying paternity for the first time
                        else {
                            // Checking if employee has less than 4 working months
                            if ($day < 112) {
                                $max_days = 7;
                                if ($total_leave_days < $max_days) {
                                    if ($different_days <= $max_days) {
                                        $leaves->days = $different_days;
                                    } else {
                                        $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                        return $url->with('msg', $msg);
                                    }

                                } else {

                                    $leave_type = LeaveType::where('id', $nature)->first();
                                    $type_name = $leave_type->type;
                                    $msg = "Sorry, You have Insufficient  " . $type_name . " Leave Days Balance";
                                    return $url->with('msg', $msg);

                                }

                            }
                            // For Employee with more than 4 working months
                            else {
                                $max_days = 10;

                                if ($different_days < $max_days) {
                                    $leaves->days = $different_days;
                                } else {
                                    $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                    return $url->with('msg', $msg);
                                }

                            }
                        }

                    }

                    $leaves->reason = $request->reason;
                    $leaves->remaining = $remaining;
                    $leaves->sub_category = $request->sub_cat;
                    $leaves->application_date = date('Y-m-d');
                    if ($request->hasfile('image')) {
                        $request->validate([
                            // 'image' => 'required|clamav',
                        ]);
                        $request->validate([
                            'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                        ]);
                        $newImageName = $request->image->hashName();
                        $request->image->move(public_path('storage/leaves'), $newImageName);
                        $leaves->attachment = $newImageName;

                    }

                    $leaves->save();

                    $autheniticateduser = auth()->user()->emp_id;
                    $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);


                    $leave_type = LeaveType::where('id', $nature)->first();
                    $type_name = $leave_type->type;

                    //fetch Line manager data from employee table and send email
                    $linemanager = LeaveApproval::where('empID', $empID)->first();
                    $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                    $employee_data = SysHelpers::employeeData($empID);
                    $fullname = $linemanager_data['full_name'];
                    $email_data = array(
                        'subject' => 'Employee Leave Approval',
                        'view' => 'emails.linemanager.leave-approval',
                        'email' => $linemanager_data['email'],
                        'full_name' => $fullname,
                        'employee_name' => $employee_data['full_name'],
                        'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                    );
                    try {
                        PushNotificationController::bulksend([
                            'title' => '2',
                            'body' => 'Dear '.$linemanager_data['full_name'].',You have a leave request to approve of ' . $employee_data['full_name'],
                            'img' => '',
                            'id' => $linemanager->level1,
                            'leave_id' => $leaves->id,
                            'overtime_id' => '',
                        ]);

                        Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                    } catch (Exception $exception) {
                        dd($exception->getMessage());
                        $msg = $type_name . " Leave Request is submitted successfully but email not sent(SMTP Problem)!";
                        return $url->with('msg', $msg);
                    }
                    $msg = $type_name . " Leave Request is submitted successfully!";
                    return $url->with('msg', $msg);
                } else {

                    $leave_type = LeaveType::where('id', $nature)->first();
                    $type_name = $leave_type->type;
                    $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance";
                    return $url->with('msg', $msg);

                }

            }
        } else {
            $msg = "Error!! start date should be less than end date!";
            return redirect()->back()->with('msg', $msg);
        }

    }

    // start of leave approval
    public function approveLeave($id)
    {
        $leave = Leaves::find($id);
        // dd($leave);
        $empID = $leave->empID;
        $approval = LeaveApproval::where('empID', $empID)->first();
        $approver = Auth()->user()->emp_id;
        $employee = Auth()->user()->position;



        // chacking level 1
        if ($approval->level1 == $approver) {

            // For Deligation
            if ($leave->deligated != null) {
                $id = Auth::user()->emp_id;
                $this->attendance_model->save_deligated($leave->empID);

                $level1 = DB::table('leave_approvals')->Where('level1', $empID)->update(['level1' => $leave->deligated]);
                $level2 = DB::table('leave_approvals')->Where('level2', $empID)->update(['level2' => $leave->deligated]);
                $level3 = DB::table('leave_approvals')->Where('level3', $empID)->update(['level3' => $leave->deligated]);
                // dd($request->deligate);

            }

            $leave->status = 2;
            $leave->state = 0;

            // if(!$approval->level2){
            //     $leave->state = 0;
            //     }
            $position = Position::where('id', Auth()->user()->emp_id)->first();
            $leave->level1 = Auth()->user()->emp_id;
            $leave->position = 'Approved by Line Manager' ;
            $leave->updated_at = new DateTime();
            $leave->update();

            $request = new Request();
            $autheniticateduser = auth()->user()->emp_id;
            $auditLog = SysHelpers::AuditLog(2, "Leave aproval  by " . $autheniticateduser, $request);


        } elseif ($approval->level2 == $approver) {

            // For Deligation
            if ($leave->deligated != null) {
                $id = Auth::user()->emp_id;
                $this->attendance_model->save_deligated($leave->empID);

                $level1 = DB::table('leave_approvals')->Where('level1', $id)->update(['level1' => $leave->deligated]);
                $level2 = DB::table('leave_approvals')->Where('level2', $id)->update(['level2' => $leave->deligated]);
                $level3 = DB::table('leave_approvals')->Where('level3', $id)->update(['level3' => $leave->deligated]);
                // dd($request->deligate);

            }
            $leave->status = 3;

            // if(!$approval->level3){
            // $leave->state = 0;
            // }
            $leave->state = 0;

            $position = Position::where('id', Auth()->user()->emp_id)->first();

            $leave->level2 = Auth()->user()->emp_id;
            $leave->position = 'Approved by Line Manager' ;
            $leave->updated_at = new DateTime();
            $leave->update();
            $autheniticateduser = auth()->user()->emp_id;
            $auditLog = SysHelpers::AuditLog(2, "Leave approval  by " . $autheniticateduser, $request);

        } elseif ($approval->level3 == $approver) {

            // For Deligation
            if ($leave->deligated != null) {
                $id = Auth::user()->emp_id;
                $this->attendance_model->save_deligated($leave->empID);

                $level1 = DB::table('leave_approvals')->Where('level1', $id)->update(['level1' => $leave->deligated]);
                $level2 = DB::table('leave_approvals')->Where('level2', $id)->update(['level2' => $leave->deligated]);
                $level3 = DB::table('leave_approvals')->Where('level3', $id)->update(['level3' => $leave->deligated]);
                // dd($request->deligate);

            }
            $leave->status = 3;
            $leave->state = 0;
            $position = Position::where('id', Auth()->user()->emp_id)->first();
            $leave->level3 = Auth()->user()->emp_id;
            $leave->position = 'Approved by Line Manager' ;
            $leave->updated_at = new DateTime();
            $leave->update();
            $autheniticateduser = auth()->user()->emp_id;
            $request = new Request();
            $auditLog = SysHelpers::AuditLog(2, "Leave approval  by " . $autheniticateduser, $request);

        } else {

            $msg = 'Sorry, You are Not Authorized';

            return redirect('flex/attendance/leave')->with('msg', $msg);
        }

        $emp_data = SysHelpers::employeeData($empID);
        $email_data = array(
            'subject' => 'Employee leave Approval',
            'view' => 'emails.linemanager.approved_leave',
            'email' => $emp_data->email,
            'full_name' => $emp_data->fname, ' ' . $emp_data->mname . ' ' . $emp_data->lname,
        );

        try {
            PushNotificationController::bulksend([
                'title' => '3',
                'body' =>'Dear '.$emp_data->full_name.',Your leave request is successful approved by '.$position->name.'',
                'img' => '',
                'id' => $empID,
                'leave_id' => $leave->id,
                'overtime_id' => '',
                ]);

            Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));

        } catch (Exception $exception) {

            $msg = "Leave Request Has been Approved Successfully But Email is not sent(SMPT problem) !";
            // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
            return redirect('flex/attendance/leave')->with('msg', $msg);
        }

        $msg = "Leave Request Has been Approved Successfully !";
        // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
        return redirect('flex/attendance/leave')->with('msg', $msg);

    }

    public function revoke_authority()
    {
        $id = Auth::user()->emp_id;

        $del_level1 = Level1::all()->where('deligetor', $id);

        foreach ($del_level1 as $row) {
            $level1 = DB::table('leave_approvals')->Where('empID', $row->line_employee)->update(['level1' => $id]);

            // if($level1 > 0){
            Level1::where('line_employee', $row->line_employee)->delete();
            // }
        }

        $del_level2 = Level2::all()->where('deligetor', $id);

        foreach ($del_level2 as $row) {

            $level2 = DB::table('leave_approvals')->Where('empID', $row->line_employee)->update(['level2' => $id]);
            // if($level2 > 0){
            Level2::where('line_employee', $row->line_employee)->delete();
            // }
        }

        $del_level3 = Level3::all()->where('deligetor', $id);
        foreach ($del_level3 as $row) {
            $level3 = DB::table('leave_approvals')->Where('empID', $row->line_employee)->update(['level3' => $id]);
            //if($level3 > 0){
            Level3::where('line_employee', $row->line_employee)->delete();
            //}
        }

        return redirect()->back();

    }

    // For Cancel Leave

    // public function cancelLeave($id)
    // {

    // }

    public function apply_leave(Request $request)
    {

        $this->authenticateUser('apply-leave');
        // echo "<p class='alert alert-success text-center'>Record Added Successifully</p>";



        if ($request->method() == "POST") {

            // DATE MANIPULATION
            $start = $request->start;
            $end = $request->end;
            $datewells = explode("/", $start);
            $datewelle = explode("/", $end);
            $mms = $datewells[1];
            $dds = $datewells[0];
            $yyyys = $datewells[2];
            $dates = $yyyys . "-" . $mms . "-" . $dds;

            $mme = $datewelle[1];
            $dde = $datewelle[0];
            $yyyye = $datewelle[2];
            $datee = $yyyye . "-" . $mme . "-" . $dde;

            $limit = $request->limit;
            $date1 = date_create($dates);
            $date2 = date_create($datee);
            $date_today = date_create(date('Y-m-d'));

            $diff = date_diff($date1, $date2);
            $diff2 = date_diff($date_today, $date1);

            // START
            if ($request->hasfile('image')) {
                $request->validate([
                    'image' => 'required|clamav',
                ]);
                $request->validate([
                    'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                ]);
                $newImageName = $request->image->hashName();
                $request->image->move(public_path('storage/leaves'), $newImageName);
                // $employee->photo = $newImageName;
            }

            if ($request->start == $request->end) {
                echo "<p class='alert alert-warning text-center'>Invalid Start date or End date Selection</p>";
            } elseif ($request->nature == 1 && ($diff->format("%R%a")) > ($limit)) {
                echo "<p class='alert alert-warning text-center'>Days Requested Exceed the Allowed Days</p>";
            } elseif ($diff2->format("%R%a") < 0 || $diff->format("%R%a") < 0) {
                echo "<p class='alert alert-danger text-center'>Invalid Start date or End date Selection, Choose The Correct One</p>";
            } else {

                $data = array(
                    'empID' => Auth::user()->emp_id,
                    'start' => $dates,
                    'end' => $datee,
                    'leave_address' => $request->address,
                    'mobile' => $request->mobile,
                    'nature' => $request->nature,
                    'reason' => $request->reason,
                    'application_date' => date('Y-m-d'),
                    'attachment' => $newImageName,
                );
                // dd($data);

                $result = $this->attendance_model->applyleave($data);


                if ($result == true) {
                    $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);

                    echo "<p class='alert alert-success text-center'>Application Sent Added Successifully</p>";
                } else {echo "<p class='alert alert-danger text-center'>Application NOT Sent, Please Try Again</p>";}

            }
            // END

        }
    }

    ################## START LEAVE OPERATIONS ###########################
    public function cancelLeave($data)
    {
        $result = explode('|', $data);
        if (count($result) > 1) {
            $id = $result[0];
            $info = $result[1];
        } else {
            $id = $data;
            $info = '';
        }
        // dd($result);

        if ($id != '') {
            $leaveID = $id;
            $leave = Leaves::where('id', $leaveID)->first();
            if($info){
                $leave->position = 'Denied by '. SysHelpers::getUserPosition(Auth::user()->position);
                $leave->state = 5;
                $leave->level1 = Auth::user()->id;
                $leave->revoke_reason = $info;
            }else{

                $leave->state = 4;
                $leave->position = 'Cancelled by you';
            }

            if ($info != '') {
                //sending email specify the reason

                $employee_data = SysHelpers::employeeData($leave->empID);
                $fullname = $employee_data['full_name'];
                $email_data = array(
                    'subject' => 'Employee Leave Disapproval',
                    'view' => 'emails.linemanager.leave-rejection',
                    'email' => $employee_data['email'],
                    'full_name' => $fullname,
                    'info' => $info,
                );
                //dd($employee_data['email']);
                try {
                    PushNotificationController::bulksend([
                        'title' => '8',
                        'body' =>'Your leave request is Denied by '. SysHelpers::getUserPosition(Auth::user()->position).'',
                        'img' => '',
                        'id' =>$leave->empID,
                        'leave_id' => $leave->id,
                        'overtime_id' => '',

                        ]);

                    Notification::route('mail', $employee_data['email'])->notify(new EmailRequests($email_data));

                } catch (Exception $exception) {

                    echo "<p class='alert alert-primary text-center'>Email Not sent</p>";
                }
            }
            $leave->save();

            $msg = "Leave  Canceled Successfully !";

            // echo "<p class='alert alert-primary text-center'>Leave Was Canceled Successfully</p>";
            return json_encode(['status' => 'OK']);
            //  return redirect('flex/attendance/my-leaves')->with('msg', $msg);
        }
    }

    public function revokeLeave($id)
    {
        $particularLeave = Leaves::where('id', $id)->first();
        $data['particularLeave'] = $particularLeave;
        $data['startDate'] = $particularLeave->start;
        $data['id'] = $particularLeave->id;
        $data['endDate'] = $particularLeave->end;
        $data['days'] = $particularLeave->days;
        $data['nature'] = LeaveType::where('id', $particularLeave->nature)->value('type');
        $data['leaveReason'] = $particularLeave->reason;
        $data['mobile'] = $particularLeave->mobile;
        $data['expectedDate'] = $particularLeave->enddate_revoke;
        $data['revoke_status'] = $particularLeave->revoke_status;
        $data['leaveAddress'] = $particularLeave->leave_address;
        $login = Auth()->user()->empid;
        if ($particularLeave->level1 == $login || $particularLeave->level2 == $login) {
            $data['revoke_reason'] = $particularLeave->revoke_reason;
        } else {
            $data['revoke_reason'] = null;
        }
        if ($particularLeave->sub_category > 0) {
            $data['sub_category'] = LeaveSubType::where('id', $particularLeave->sub_category)->value('name');
        } else {
            $data['sub_category'] = 0;

        }
        $data['approvedBy'] = $particularLeave->position;
        return view('my-services/revokeLeave', $data);
    }

    public function cancelRevokeLeave($id)
    {
        $particularLeave = Leaves::where('id', $id)->first();
        $data['startDate'] = $particularLeave->start;
        $data['id'] = $particularLeave->id;
        $data['endDate'] = $particularLeave->end;
        $data['days'] = $particularLeave->days;
        $data['nature'] = LeaveType::where('id', $particularLeave->nature)->value('type');
        $data['leaveReason'] = $particularLeave->reason;
        $data['mobile'] = $particularLeave->mobile;
        $data['expectedDate'] = $particularLeave->enddate_revoke;
        $data['revoke_status'] = $particularLeave->revoke_status;
        $data['leaveAddress'] = $particularLeave->leave_address;
        $login = Auth()->user()->empid;
        if ($particularLeave->level2 == $login || $particularLeave->level3 == $login) {
            $data['revoke_reason'] = $particularLeave->revoke_reason;
        } else {
            $data['revoke_reason'] = null;
        }
        if ($particularLeave->sub_category > 0) {
            $data['sub_category'] = LeaveSubType::where('id', $particularLeave->sub_category)->value('name');
        } else {
            $data['sub_category'] = 0;

        }
        $data['approvedBy'] = $particularLeave->position;

        return view('my-services/cancelRevokeLeave', $data);
    }

    public function revokeApprovedLeave(Request $request)
    {
        $id = $request->input('terminationid');
        $message = $request->input('comment');
        $expectedDate = $request->input('expectedDate');

        $particularLeave = Leaves::where('id', $id)->first();
        $linemanager = LeaveApproval::where('empID', $particularLeave->empID)->first();
        $linemanager_position = Employee::where('emp_id',$linemanager->level1)->value('position');
        $position = Position::where('id', $linemanager_position)->first();
        $positionName = $position->name;


        if ($particularLeave) {
            $particularLeave->state = 2;
            $particularLeave->revoke_reason = $message;
            $particularLeave->enddate_revoke = $expectedDate;
            $particularLeave->revoke_status = 0;
            $particularLeave->status = 4;
            $particularLeave->revok_escalation_status = 1;
            $particularLeave->position = 'Pending Approve Revoke by '. $positionName;
            $particularLeave->revoke_created_at = now();
            $particularLeave->save();
        }

        $leave_type = LeaveType::where('id', $particularLeave->nature)->first();
        $type_name = $leave_type->type;

        //fetch Line manager data from employee table and send email
        $linemanager_data = Employee::where('emp_id',$linemanager->level1)->first();
        $employee_data =  Employee::where('emp_id',$particularLeave->empID)->first();
        $fullname = $linemanager_data['fname'];
        $email_data = array(
            'subject' => 'Employee Leave Revoke',
            'view' => 'emails.linemanager.leave-revoke',
            'email' => $linemanager_data['email'],
            'full_name' => $fullname,
            'employee_name' => $employee_data['fname'],
            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
        );

        try {
            PushNotificationController::bulksend([
                'title' => '6',
                'body' =>'Dear '.$linemanager_data['full_name'].''.$employee_data['full_name'].' has a leave revoke request',
                'img' => '',
                'id' => $linemanager->level1,
                'leave_id' => $particularLeave->id,
                'overtime_id' => '',

                ]);


            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

        } catch (Exception $exception) {
            $msg = $type_name . " Leave Revoke Request  Has been Requested But Email is not sent(SMTP Problem)!";
            return redirect('flex/attendance/leave')->with('msg', $msg);

        }
        $msg = $type_name . " Leave Request  Has been Requested Successfully!";
        return redirect('flex/attendance/leave')->with('msg', $msg);

    }

    public function revokeApprovedLeaveAdmin($id)
    {
        $particularLeave = Leaves::where('id', $id)->first();

        if ($particularLeave) {
            $particularLeave->state = 3;
            $particularLeave->revoke_status = 1;
            $particularLeave->status = 5;
            if ($particularLeave->enddate_revoke) {
                  $days = SysHelpers::countWorkingDays($particularLeave->start, $particularLeave->enddate_revoke);

                  $particularLeave->remaining = $particularLeave->remaining + $days;

                $particularLeave->end = $particularLeave->enddate_revoke;
            }
            $position = Position::where('id', Employee::where('emp_id', Auth()->user()->emp_id)->value('position'))->value('name');
            $particularLeave->position = 'Leave Revoke Approved by ' . $position;
            $particularLeave->level3 = Auth()->user()->emp_id;
            $particularLeave->revoke_created_at = now();
            $particularLeave->save();

            $emp_data = SysHelpers::employeeData($particularLeave->empID);

            $email_data = array(
                'subject' => 'Employee Leave Revoke Approval',
                'view' => 'emails.linemanager.approved_revoke_leave',
                'email' => $emp_data->email,
                'full_name' => $emp_data->fname, ' ' . $emp_data->mname . ' ' . $emp_data->lname,
            );

            try {

                Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));

                PushNotificationController::bulksend([
                    'title' => '7',
                    'body' =>'Dear '.$emp_data->full_name.',Your leave Revoke is successful approved by '.$position.'',
                    'img' => '',
                    'id' => $particularLeave->empID,
                    'leave_id' => $particularLeave->id,
                    'overtime_id' => '',

                    ]);
            } catch (Exception $exception) {
                $msg = " Revoke Leave Request Has been Approved Successfully But Email is not sent(SMPT problem) !";
                // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
                return redirect('flex/attendance/leave')->with('msg', $msg);
            }
        }

        return response()->json(['status' => 'NOT OK']);
    }
    public function revokeCancelLeaveAdmin($id)
    {
        $particularLeave = Leaves::where('id', $id)->first();

        if ($particularLeave) {
            $particularLeave->state = 0;
            $particularLeave->revoke_status = 3;
            $particularLeave->status = 3;
            $position = Position::where('id', Employee::where('emp_id', Auth()->user()->emp_id)->value('position'))->value('name');
            $particularLeave->position = 'Leave Revoke Requesy Canceled by ' . $position;
            $particularLeave->level3 = Auth()->user()->emp_id;
            $particularLeave->revoke_created_at = now();
            $particularLeave->save();

            $emp_data = SysHelpers::employeeData($particularLeave->empID);

            $email_data = array(
                'subject' => 'Employee Leave Revoke Canceled',
                'view' => 'emails.linemanager.approved_revoke_leave',
                'email' => $emp_data->email,
                'full_name' => $emp_data->fname, ' ' . $emp_data->mname . ' ' . $emp_data->lname,
            );

            try {
                PushNotificationController::bulksend([
                    'title' => '10',
                    'body' =>'Dear '.$emp_data->full_name.', Your  Leave  Revoke request is denied by '. $position.'',
                    'img' => '',
                    'id' => $particularLeave->empID,
                    'leave_id' => $particularLeave->id,
                    'overtime_id' => '',

                    ]);

                Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));


            } catch (Exception $exception) {
                $msg = " Revoke Leave Request Has been Cancel Successfully But Email is not sent(SMPT problem) !";
                // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
                return redirect('flex/attendance/leave')->with('msg', $msg);
            }
        }

        return response()->json(['status' => 'NOT OK']);
    }

    public function recommendLeave($id)
    {

        if ($id != '') {

            $leaveID = $id;
            $data = array(

                'approved_date_line' => date('Y-m-d'),
                'approved_by_line' => Auth::user()->emp_id,
                'status' => 1,
                'notification' => 3,
            );
            $this->attendance_model->update_leave($data, $leaveID);
            echo "<p class='alert alert-primary text-center'>Leave Recommended Successifully</p>";
        }
    }
    public function recommendLeaveByHod($id)
    {

        if ($id != '') {

            $leaveID = $id;
            $data = array(

                'approved_date_hod' => date('Y-m-d'),
                'approved_by_hod' => Auth::user()->emp_id,
                'status' => 6,
                'notification' => 5,
            );
            $this->attendance_model->update_leave($data, $leaveID);
            echo "<p class='alert alert-primary text-center'>Leave Recommended Successifully</p>";
        }
    }

    public function holdLeave($leaveID)
    {

        $leave = Leaves::where('id', $leaveID)->first();

        $emp_data = SysHelpers::employeeData($leave->empID);
        $email_data = array(
            'subject' => 'Employee Overtime Approval',
            'view' => 'emails.linemanager.cancel_leave',
            'email' => $emp_data->email,
            'full_name' => $emp_data->fname, ' ' . $emp_data->mname . ' ' . $emp_data->lname,
        );

        $leave->delete();
        try {

            Notification::route('mail', $emp_data->email)->notify(new EmailRequests($email_data));

        } catch (Exception $exception) {

            echo "<p class='alert alert-warning text-center'>Leave Canceled Successifully but email not sent</p>";
        }

        echo "<p class='alert alert-warning text-center'>Leave Canceled Successifully</p>";

    }

    //   public function approveLeave1($id)
    //     {

    //         if($id!=''){

    //       $leaveID = $id;
    //       $todate = date('Y-m-d');
    //       $data = array(
    //                'status' =>2,
    //                'notification' => 1
    //           );

    //         $result = $this->attendance_model->approve_leave($leaveID, Auth::user()->emp_id, $todate);
    //         if($result==true){
    //             echo "<p class='alert alert-success text-center'>Leave Approved Successifully</p>";
    //         } else {
    //             echo "<p class='alert alert-warning text-center'>Leave NOT Approved, Please Try Again</p>";
    //         }

    //         }
    //  }

    public function rejectLeave()
    {

        if ($this->uri->segment(3) != '') {

            $leaveID = $this->uri->segment(3);
            $data = array(
                'status' => 5,
                'notification' => 1,
            );
            $this->attendance_model->update_leave($data, $leaveID);
            echo "<p class='alert alert-danger text-center'>Leave Disapproved!</p>";
        }
    }

    ######################## END LEAVE OPERATIONS##############################

    public function leavereport()
    {
        $empID = Auth::user()->emp_id;

        $this->authenticateUser('view-unpaid-leaves');
        // $data['my_leave'] =  $this->attendance_model->my_leavereport($empID);
        $data['leaves'] = Leaves::where('state', 0)->latest()->get();

        if (session('conf_leave') != '' && session('line') != '') {
            $data['other_leave'] = $this->attendance_model->leavereport_hr();
        } elseif (session('line') != '') {
            $data['other_leave'] = $this->attendance_model->leavereport_line($empID);
        } elseif (session('conf_leave') != '') {
            $data['other_leave'] = $this->attendance_model->leavereport_hr();
        }
        $data['title'] = "Leaves";
        $data['today'] = date('Y-m-d');
        return view('app.leave_report', $data);

    }

    public function customleavereport()
    {
        if (isset($_POST['view'])) {

            // DATE MANIPULATION
            $start = $this->input->post("from");
            $end = $this->input->post("to");
            $datewells = explode("/", $start);
            $datewelle = explode("/", $end);
            $mms = $datewells[1];
            $dds = $datewells[0];
            $yyyys = $datewells[2];
            $dates = $yyyys . "-" . $mms . "-" . $dds;

            $mme = $datewelle[1];
            $dde = $datewelle[0];
            $yyyye = $datewelle[2];
            $datee = $yyyye . "-" . $mme . "-" . $dde;
            $today = date('Y-m-d');

            $target = $this->input->post("target");
            if ($target == 1) {
                $data['leave'] = $this->attendance_model->leavereport1_all($dates, $datee);
            } elseif ($target == 2) {
                $data['leave'] = $this->attendance_model->leavereport1_completed($dates, $datee, $today);
            } elseif ($target == 3) {
                $data['leave'] = $this->attendance_model->leavereport1_progress($dates, $datee, $today);
            }

            $data['title'] = "Leave";
            $data['showbox'] = 1;
            return view('app.customleave_report', $data);
        } elseif (isset($_POST['print'])) {

            // DATE MANIPULATION
            $start = $this->input->post("from");
            $end = $this->input->post("to");
            $datewells = explode("/", $start);
            $datewelle = explode("/", $end);
            $mms = $datewells[1];
            $dds = $datewells[0];
            $yyyys = $datewells[2];
            $dates = $yyyys . "-" . $mms . "-" . $dds;

            $mme = $datewelle[1];
            $dde = $datewelle[0];
            $yyyye = $datewelle[2];
            $datee = $yyyye . "-" . $mme . "-" . $dde;
            $today = date('Y-m-d');
            $target = $this->input->post("target");

            $this->load->model("reports_model");
            $data['info'] = $this->reports_model->company_info();

            if ($target == 1) {
                $data['leave'] = $this->reports_model->leavereport_all($dates, $datee);
            } elseif ($target == 2) {
                $data['leave'] = $this->reports_model->leavereport_completed($dates, $datee, $today);
            } elseif ($target == 3) {
                $data['leave'] = $this->reports_model->leavereport_progress($dates, $datee, $today);
            }

            $data['title'] = "List of Employees Who went to Leave From " . $dates . " to " . $datee;
            return view('app.reports/general_leave', $data);
        } elseif (isset($_POST['printindividual'])) {

            $id = $this->input->post("employee");

            $this->load->model("reports_model");
            $data['info'] = $this->reports_model->company_info();
            $customleave = $this->reports_model->customleave($id);
            foreach ($customleave as $key) {
                $empname = $key->NAME;
            }
            $data['title'] = "List of Leaves for " . $empname;
            $data['leave'] = $this->reports_model->leavereport2($id);
            return view('app.reports/general_leave', $data);

        } elseif (isset($_POST['viewindividual'])) {

            $id = $this->input->post("employee");
            //

            $data['showbox'] = 0;
            if (session('viewconfmedleave') != '') {
                $data['customleave'] = $this->attendance_model->customleave();
            } else {
                $data['customleave'] = $this->attendance_model->leavedropdown(Auth::user()->emp_id);}

            $data['leave'] = $this->attendance_model->leavereport2($id);
            return view('app.customleave_report', $data);

        }

        $data['showbox'] = 0;
        $data['leave'] = $this->attendance_model->leavereport2(Auth::user()->emp_id);
        $data['customleave'] = $this->attendance_model->leave_employees();
        $data['title'] = "Leave Reports";

        return view('app.customleave_report', $data);

    }

    // For Clear Old Leaves
    public function clear_leaves(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        // Handle the file upload and data extraction
        $year = $request->forfeit_year;
        $file = $request->file('file');
        Excel::import(new ClearLeavesImport($year), $file);

        return redirect()->back()->with('success', 'File uploaded and data extracted successfully.');
    }

    public function leave_remarks($id)
    {

        $data['data'] = $this->attendance_model->get_leave_application($id);
        $data['title'] = "Leave";
        return view('app.leave_remarks', $data);

        if (isset($_POST['edit_remarks'])) {

            $data = array(
                'remarks' => $this->input->post("remarks"),
            );

            $this->attendance_model->update_leave_application($data, $id);
            $reload = '/leave/leave';
            redirect($reload, 'refresh');

        }
    }

    public function leave_application_info($id, $empID)
    {

        $hireDate = $this->flexperformance_model->employee_hire_date($empID);
        $data['data'] = $this->attendance_model->get_leave_application($id);
        $data['leaveBalance'] = $this->attendance_model->getLeaveBalance($empID, $hireDate, date('Y-m-d'));

        $data['title'] = "Leave";
        $data['leave_type'] = $this->attendance_model->leave_type();
        return view('app.leave_application_info', $data);
    }

    public function updateLeaveReason()
    {
        if ($_POST && $this->input->post('leaveID') != '') {
            $leaveID = $this->input->post('leaveID');
            $updates = array(
                'reason' => $this->input->post('reason'),
                'status' => 0,
                'notification' => 2,
            );
            $result = $this->attendance_model->update_leave_application($updates, $leaveID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Reason Updated Successifully!</p>";
            } else {echo "<p class='alert alert-danger text-center'>Update Failed</p>";}

        }
    }

    public function updateLeaveAddress()
    {
        if ($_POST && $this->input->post('leaveID') != '') {
            $leaveID = $this->input->post('leaveID');
            $updates = array(
                'leave_address' => $this->input->post('address'),
            );
            $result = $this->attendance_model->update_leave_application($updates, $leaveID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Leave Address Updated Successifully!</p>";
            } else {echo "<p class='alert alert-danger text-center'>Update Failed</p>";}

        }
    }
    public function updateLeaveMobile()
    {
        if ($_POST && $this->input->post('leaveID') != '') {
            $leaveID = $this->input->post('leaveID');
            $updates = array(
                'mobile' => $this->input->post('mobile'),
            );
            $result = $this->attendance_model->update_leave_application($updates, $leaveID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Mobile Updated Successifully!</p>";
            } else {echo "<p class='alert alert-danger text-center'>Update Failed</p>";}

        }
    }
    public function updateLeaveType()
    {
        if ($_POST && $this->input->post('leaveID') != '') {
            $leaveID = $this->input->post('leaveID');
            $updates = array(
                'nature' => $this->input->post('type'),
                'status' => 0,
                'notification' => 2,
            );
            $result = $this->attendance_model->update_leave_application($updates, $leaveID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Leave Nature Updated Successifully!</p>";
            } else {echo "<p class='alert alert-danger text-center'>Update Failed</p>";}

        }
    }

    public function updateLeaveDateRange()
    {
        if ($_POST) {
            if ($this->input->post('leaveID') != '') {
                $leaveID = $this->input->post('leaveID');
                $nature = $this->input->post("nature");
                $start = str_replace('/', '-', $this->input->post('start'));
                $end = str_replace('/', '-', $this->input->post('end'));

                $dateStart = date('Y-m-d', strtotime($start));
                $dateEnd = date('Y-m-d', strtotime($end));
                $date_today = date('Y-m-d');

                $limit = $this->input->post("limit");
                $date1 = date_create($dateStart);
                $date2 = date_create($dateEnd);

                $diff = date_diff($date1, $date2);

                if ($dateEnd < $dateStart) {
                    echo "<p class='alert alert-danger text-center'>Invalid Date Selection, Please Choose the Approriate Date Range Between the Start Date and End Date</p>";
                } else {
                    if ($nature == 1 && ($diff->format("%R%a")) > ($limit)) {
                        echo "<p class='alert alert-danger text-center'>You Have Exceeded The Maximum Days That You Can Apply For Annual Leave!</p>";
                    } else {
                        $updates = array(
                            'start' => $dateStart,
                            'end' => $dateEnd,
                            'status' => 0,
                            'notification' => 2,
                        );
                        $result = $this->attendance_model->update_leave_application($updates, $leaveID);
                        if ($result == true) {
                            echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
                        } else {echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";}
                    }
                }
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Update, Reference Errors</p>";
            }
        }
    }

    public function current_leave_progress()
    {
        $data['leaveBalance'] = $this->attendance_model->getLeaveBalance(Auth::user()->emp_id, session('hire_date'), date('Y-m-d'));
        $data['myleave'] = $this->attendance_model->myleave_current(Auth::user()->emp_id);
        $this->attendance_model->update_leave_notification_staff(Auth::user()->emp_id);

        if (session('line') != '' && session('conf_leave') != '') {

            $data['otherleave'] = $this->attendance_model->leave_line_hr_current(Auth::user()->emp_id);
            $this->attendance_model->update_leave_notification_line_hr(Auth::user()->emp_id);
        } elseif (session('line') != '') {
            $data['otherleave'] = $this->attendance_model->leave_line_current(Auth::user()->emp_id);
            $this->attendance_model->update_leave_notification_line(Auth::user()->emp_id);

        } elseif (session('conf_leave') != '') {
            $data['otherleave'] = $this->attendance_model->leave_hr_current();
            $this->attendance_model->update_leave_notification_hr(Auth::user()->emp_id);

        }

        $data['title'] = 'Leave';
        $data['leave_type'] = $this->attendance_model->leave_type();
        return view('app.leave', $data);

    }

    public function leave_notification()
    {

        if (session('line') != 0 || session('confleave') != 0) {
            if (session('confleave') != 0 && session('line') != 0) {
                $counts1 = $this->attendance_model->leave_notification_employee(Auth::user()->emp_id);
                $counts2 = $this->attendance_model->leave_notification_line_manager(Auth::user()->emp_id);
                $counts3 = $this->attendance_model->leave_notification_hr();
                $counts = $counts1 + $counts2 + $counts3;
                if ($counts > 0) {
                    echo '<span class="badge bg-red">' . $counts . '</span>';} else {
                    echo "";
                }

            } elseif (session('line') != 0) {
                $counts1 = $this->attendance_model->leave_notification_line_manager(Auth::user()->emp_id);
                $counts2 = $this->attendance_model->leave_notification_employee(Auth::user()->emp_id);
                $counts = $counts1 + $counts2;
                if ($counts > 0) {
                    echo '<span class="badge bg-red">' . $counts . '</span>';} else {
                    echo "";
                }

            } elseif (session('confleave') != 0) {

                $counts1 = $this->attendance_model->leave_notification_employee(Auth::user()->emp_id);
                $counts2 = $this->attendance_model->leave_notification_hr();
                $counts = $counts1 + $counts2;
                if ($counts > 0) {
                    echo '<span class="badge bg-red">' . $counts . '</span>';} else {
                    echo "";
                }

            }
        } else {
            $counts = $this->attendance_model->leave_notification_employee(Auth::user()->emp_id);
            if ($counts > 0) {
                echo '<span class="badge bg-red">' . $counts . '</span>';} else {
                echo "";
            }

        }

    }

    public function getEmployeeGender($empID)
    {
        // Retrieve the gender of the employee using $empID (e.g., query your database)
        $employee = EMPL::where('emp_id', $empID)->first();

        if ($employee) {
            $gender = $employee->gender;

            return response()->json(['gender' => $gender]);
        } else {
            return response()->json(['gender' => null]);
        }
    }

    public function saveLeaveOnBehalf(Request $request)
    {

        request()->validate(
            [

                // start of name information validation

                //'mobile' => 'required|numeric',
                // 'leave_address' => 'nullable|alpha',
                // 'reason' => 'required|alpha',

            ]);
        $start = $request->start;
        $end = $request->end;
        // For Redirection Url
        $url = redirect('flex/attendance/leave');

        $employee = EMPL::where('emp_id', $request->empID)->first();
        // dd($employee);

        if ($start <= $end) {

            //For Gender
            $gender = $this->getEmployeeGender($request->empID);
            if ($gender == "Male") {$gender = 1;} else { $gender = 2;}
            // for checking balance
            $today = date('Y-m-d');
            $arryear = explode('-', $today);
            $year = $arryear[0];
            $nature = $request->nature;
            $empID = $request->empID;

            // Check if there is a pending leave in the given number of days (start,end)
            $pendingLeave = Leaves::where('empId', $empID)
                ->where('state', 1)
                ->whereDate('start', '<=', $start)
                ->whereDate('end', '>=', $start)
                ->first();

            $approvedLeave = Leaves::where('empId', $empID)
                ->where('state', 0)
                ->whereDate('start', '<=', $start)
            ->whereDate('end', '>=', $start)
                ->first();

            if ($pendingLeave || $approvedLeave) {
                $message = 'You have a ';

                if ($pendingLeave) {
                    $message .= 'pending ' . $pendingLeave->type->type . ' application ';
                }

                if ($approvedLeave) {
                    $message .= ($pendingLeave ? 'and ' : '') . 'approved ' . $approvedLeave->type->type . ' application ';
                }

                $message .= 'within the requested leave time';

                return $url->with('error', $message);
            }

            // Checking used leave days based on leave type and sub type
            $leaves = Leaves::where('empID', $empID)->where('nature', $nature)->where('sub_category', $request->sub_cat)->whereNot('reason', 'Automatic applied!')->whereYear('created_at', date('Y'))->sum('days');

            $leave_balance = $leaves;
            // For Leave Nature days
            $type = LeaveType::where('id', $nature)->first();
            $max_leave_days = $type->max_days;

            //$max_leave_days = 10000;
            $employeeHiredate = explode('-', $employee->hire_date);
            $employeeHireYear = $employeeHiredate[0];
            $employeeDate = '';

            if ($employeeHireYear == $year) {
                $employeeDate = $employee->hire_date;

            } else {
                $employeeDate = $year - 01 - 01;
            }
            // Annual leave accurated days
            $annualleaveBalance = $this->attendance_model->getLeaveBalance($empID, $employeeDate, date('Y-m-d'));

            // For  Requested days
            if ($nature == 1) {
                $holidays = SysHelpers::countHolidays($start, $end);
                $different_days = SysHelpers::countWorkingDays($start, $end) - $holidays;
            } else {
                // if($nature == 2){

                // }
                // $holidays=SysHelpers::countHolidays($start,$end);
                // $different_days = SysHelpers::countWorkingDays($start,$end)-$holidays;
                $holidays = SysHelpers::countHolidays($start, $end);
                $different_days = SysHelpers::countWorkingDays($start, $end) - $holidays;
                // $startDate = Carbon::parse($start);
                // $endDate = Carbon::parse($end);
                // $different_days = $endDate->diffInDays($startDate);
            }

            // For Total Leave days
            $total_remaining = $leaves + $different_days;

            // For Working days
            $d1 = new DateTime($employeeDate);
            $d2 = new DateTime();
            $interval = $d2->diff($d1);
            $day = SysHelpers::countWorkingDays($d1, $d2);

            $leave_type = LeaveType::where('id', $nature)->first();
            // For Employees with less than 12 months of employement
            if ($day <= 365 && $leave_type->type !== "Sick") {

                //  For Leaves with sub Category
                if ($request->sub_cat > 0) {

                    // For Sub Category details
                    $sub_cat = $request->sub_cat;
                    $sub = LeaveSubType::where('id', $sub_cat)->first();

                    $total_leave_days = $leaves + $different_days;
                    $maximum = $sub->max_days;
                    // Case hasnt used all days
                    if ($total_leave_days < $maximum) {
                        $leaves = new Leaves();
                        $leaves->empID = $request->empID;
                        $leaves->start = $request->start;
                        $leaves->status = 1;
                        $leaves->end = $request->end;
                        $leaves->leave_address = $request->address;
                        $leaves->mobile = $request->mobile;
                        $leaves->nature = $request->nature;

                        // For Study Leave
                        if ($request->nature == 6) {
                            $leaves->days = $different_days;
                        }
                        //For Compassionate and Maternity
                        else {
                            $leaves->days = $different_days;
                        }
                        $leaves->reason = $request->reason;
                        $leaves->sub_category = $request->sub_cat;
                        $leaves->remaining = $request->sub_cat;
                        $leaves->application_date = date('Y-m-d');
                        // For Leave Attachments
                        if ($request->hasfile('image')) {
                            $request->validate([
                                //  'image' => 'required|clamav',
                            ]);
                            $request->validate([
                                'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                            ]);
                            $newImageName = $request->image->hashName();
                            $request->image->move(public_path('storage/leaves'), $newImageName);
                            $leaves->attachment = $newImageName;

                        }
                        $leaves->save();
                        $autheniticateduser = auth()->user()->emp_id;
                        $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;

                        //fetch Line manager data from employee table and send email
                        $linemanager = LeaveApproval::where('empID', $empID)->first();
                        $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                        $employee_data = SysHelpers::employeeData($empID);
                        $fullname = $linemanager_data['full_name'];
                        $email_data = array(
                            'subject' => 'Employee Leave Approval',
                            'view' => 'emails.linemanager.leave-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                            'employee_name' => $employee_data['full_name'],
                            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                        );

                        try {

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                        } catch (Exception $exception) {
                            $msg = $type_name . " Leave Request  Has been Requested But Email is not sent(SMTP Problem)!";
                            return $url->with('msg', $msg);

                        }
                        $msg = $type_name . " Leave Request  Has been Requested Successfully!";
                        return $url->with('msg', $msg);

                    }
                    //  Case has used up all days or has less remaining leave days balance
                    else {

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;
                        $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance";

                        return $url->with('msg', $msg);
                    }

                }
                // For Leaves with no sub Category
                else {

                    $total_leave_days = $leaves + $different_days;

                    $leave_type = LeaveType::where('id', $nature)->first();
                    if ($total_leave_days < $max_leave_days || $request->nature == 1 && $leave_type->type !== 'Sick') {
                        $remaining = $max_leave_days - ($leave_balance + $different_days);
                        $leaves = new Leaves();
                        $leaves->empID = $empID;
                        $leaves->start = $request->start;
                        $leaves->status = 1;
                        $leaves->end = $request->end;
                        $leaves->leave_address = $request->address;
                        $leaves->mobile = $request->mobile;
                        $leaves->nature = $request->nature;
                        $leaves->deligated = $request->deligate;

                        // for annual leave
                        if ($request->nature == 1) {
                            $annualleaveBalance = $this->attendance_model->getLeaveBalance($empID, $employeeDate, date('Y-m-d'));

                            // checking annual leave balance
                            if ($different_days < $annualleaveBalance) {
                                $leaves->days = $different_days;
                                $remaining = $annualleaveBalance - $different_days;
                            } else {
                                // $leaves->days=$annualleaveBalance;
                                $msg = 'You Have Insufficient Annual  Accrued Days';
                                return $url->with('msg', $msg);
                            }
                        }

                        // For Paternity
                        if ($request->nature != 5 && $request->nature != 1) {

                            $leaves->days = $different_days;
                        }
                        if ($request->nature == 5) {

                            // Incase the employee had already applied paternity before
                            $paternity = Leaves::where('empID', $empID)->where('nature', $nature)->where('sub_category', $request->sub_cat)->first();
                            if ($paternity) {
                                $d1 = $paternity->created_at;
                                $d2 = new DateTime();
                                $interval = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
                                $range = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);

                                $month = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);
                                // Incase an Employee has less than four working month since the last applied paternity
                                if ($month < 112) {
                                    $max_days = 7;
                                    if ($total_leave_days < $max_days) {
                                        // Case reqested days are less than the balance
                                        if ($different_days <= $max_days) {
                                            $leaves->days = $different_days;
                                        }
                                        // Case requested days are more than the balance
                                        else {
                                            $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                            return $url->with('msg', $msg);
                                        }

                                    } else {

                                        $leave_type = LeaveType::where('id', $nature)->first();
                                        $type_name = $leave_type->type;
                                        $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance2";
                                        return $url->with('msg', $msg);

                                    }

                                }
                                // For Employees who have attained 4 working months
                                else {
                                    $max_days = 10;

                                    if ($different_days < $max_days) {
                                        $leaves->days = $different_days;
                                    } else {
                                        $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                        return $url->with('msg', $msg);
                                    }

                                }
                            }
                            // Incase an employee is applying for paternity for the first time
                            else {
                                // Checking if employee has less than 4 working months
                                if ($day < 112) {
                                    $max_days = 7;
                                    if ($total_leave_days < $max_days) {
                                        if ($different_days <= $max_days) {
                                            $leaves->days = $different_days;
                                        } else {
                                            $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                            return $url->with('msg', $msg);
                                        }

                                    } else {

                                        $leave_type = LeaveType::where('id', $nature)->first();
                                        $type_name = $leave_type->type;
                                        $msg = "Sorry, You have Insufficient  " . $type_name . " Leave Days Balance";
                                        return $url->with('msg', $msg);

                                    }

                                }
                                // For Employee with more than 4 working months
                                else {
                                    $max_days = 10;

                                    if ($different_days < $max_days) {
                                        $leaves->days = $different_days;
                                    } else {
                                        $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                        return $url->with('msg', $msg);
                                    }

                                }
                            }

                        }
                        $leaves->reason = $request->reason;
                        $leaves->remaining = $remaining;

                        $leaves->sub_category = $request->sub_cat;
                        $leaves->application_date = date('Y-m-d');
                        // START
                        if ($request->hasfile('image')) {
                            $request->validate([
                                // 'image' => 'required|clamav',
                            ]);
                            $request->validate([
                                'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                            ]);

                            $newImageName = $request->image->hashName();
                            $request->image->move(public_path('storage/leaves'), $newImageName);
                            $leaves->attachment = $newImageName;

                        }

                        $leaves->save();
                        $autheniticateduser = auth()->user()->emp_id;
                        $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);


                        //fetch Line manager data from employee table and send email
                        $linemanager = LeaveApproval::where('empID', $empID)->first();
                        $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                        $employee_data = SysHelpers::employeeData($empID);
                        $fullname = $linemanager_data['full_name'];
                        $email_data = array(
                            'subject' => 'Employee Leave Approval',
                            'view' => 'emails.linemanager.leave-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                            'employee_name' => $employee_data['full_name'],
                            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                        );
                        try {

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                        } catch (Exception $exception) {
                            $leave_type = LeaveType::where('id', $nature)->first();
                            $type_name = $leave_type->type;
                            $msg = $type_name . " Leave Request is submitted successfully But Email not sent(SMTP Problem)!";
                            return $url->with('msg', $msg);
                        }

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;
                        $msg = $type_name . " Leave Request is submitted successfully!";
                        return $url->with('msg', $msg);
                    } else {

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;
                        $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance3";
                        return $url->with('msg', $msg);

                    }

                }

            }
            // For Employee with more than 12 Month
            else {
                $total_leave_days = $leaves + $different_days;
                $leave_type = LeaveType::where('id', $nature)->first();

                if ($leave_type->type === "Sick") {

                    if ($total_leave_days >= $max_leave_days) {
                        $extradays = $total_leave_days - $max_leave_days;

                        // Specify the condition based on the `emp_id` to check if the record already exists.

                        $remaining = $max_leave_days - ($leave_balance + $different_days);

                        $leaves = new Leaves();
                        // $empID=Auth::user()->emp_id;
                        $leaves->empID = $empID;
                        $leaves->start = $request->start;
                        $leaves->end = $request->end;
                        $leaves->leave_address = $request->address;
                        $leaves->mobile = $request->mobile;
                        $leaves->nature = $request->nature;
                        $leaves->deligated = $request->deligate;
                        $leaves->status = 1;

                        $leaves->days = $different_days;

                        $leaves->reason = $request->reason;
                        $leaves->remaining = $remaining;
                        $leaves->sub_category = $request->sub_cat;
                        $leaves->application_date = date('Y-m-d');

                        if ($request->hasfile('image')) {
                            $request->validate([
                                // 'image' => 'required|clamav',
                            ]);
                            $request->validate([
                                'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                            ]);
                            $newImageName = $request->image->hashName();
                            $request->image->move(public_path('storage/leaves'), $newImageName);
                            $leaves->attachment = $newImageName;

                        }

                        $leaves->save();
                        $autheniticateduser = auth()->user()->emp_id;
                        $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);

                        // dd($leaves->nature);
                        $condition = [
                            'emp_id' => $empID,
                            'appliedBy' => Auth::user()->emp_id,
                            'leaveId' => $leaves->id,
                            'nature' => $leaves->nature,

                        ];
                        // dd($condition['leaveId']);
                        // Replace with the actual emp_id.

                        // Create data to insert for extra days.
                        $extraData = [
                            'emp_id' => $condition['emp_id'],
                            'appliedBy' => $condition['appliedBy'],
                            'leaveId' => $condition['leaveId'],
                            'nature' => $condition['nature'],
                            'forfeit_days' => $extradays];

                        DB::table('sick_leave_forfeit_days')->updateOrInsert($condition, array_merge($extraData, ['updated_at' => now(), 'created_at' => now()]));

                        // Add other fields as needed.
                        // Use the DB facade to insert or update the data directly into the table.

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;

                        $linemanager = LeaveApproval::where('empID', $empID)->first();
                        $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                        $employee_data = SysHelpers::employeeData($empID);
                        $fullname = $linemanager_data['full_name'];

                        $email_data = array(
                            'subject' => 'Employee Leave Approval',
                            'view' => 'emails.linemanager.leave-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                            'employee_name' => $employee_data['full_name'],
                            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                        );

                        try {

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                        } catch (Exception $exception) {
                            $msg = $type_name . " Leave Request is submitted successfully but email not sent(SMTP Problem)!";
                            return $url->with('msg', $msg);
                        }
                        $msg = $type_name . " Leave Request is submitted successfully!";
                        return $url->with('msg', $msg);
                    } else {
                        // dd($leaves->days);

                        // $leave_type=LeaveType::where('id',$nature)->first();
                        // $type_name=$leave_type->type;
                        // $msg="Sorry, You have Insufficient ".$type_name." Leave Days Balance";
                        // return $url->with('msg', $msg);

                        // Specify the condition based on the `emp_id` to check if the record already exists.

                        $remaining = $max_leave_days - ($leave_balance + $different_days);

                        $leaves = new Leaves();
                        // $empID=Auth::user()->emp_id;
                        $leaves->empID = $empID;
                        $leaves->start = $request->start;
                        $leaves->end = $request->end;
                        $leaves->status = 1;
                        $leaves->leave_address = $request->address;
                        $leaves->mobile = $request->mobile;
                        $leaves->nature = $request->nature;
                        $leaves->deligated = $request->deligate;

                        $leaves->days = $different_days;

                        $leaves->reason = $request->reason;
                        $leaves->remaining = $remaining;
                        $leaves->sub_category = $request->sub_cat;
                        $leaves->application_date = date('Y-m-d');

                        if ($request->hasfile('image')) {
                            $request->validate([
                                // 'image' => 'required|clamav',
                            ]);
                            $request->validate([
                                'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                            ]);
                            $newImageName = $request->image->hashName();
                            $request->image->move(public_path('storage/leaves'), $newImageName);
                            $leaves->attachment = $newImageName;

                        }

                        $leaves->save();
                        $autheniticateduser = auth()->user()->emp_id;
                        $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);

                        // dd($leaves->nature);
                        $condition = [
                            'emp_id' => $empID,
                            'appliedBy' => Auth::user()->emp_id,
                            'leaveId' => $leaves->id,
                            'nature' => $leaves->nature,

                        ];
                        // dd($condition['leaveId']);
                        // Replace with the actual emp_id.

                        // Create data to insert for extra days.
                        $extraData = [
                            'emp_id' => $condition['emp_id'],
                            'appliedBy' => $condition['appliedBy'],
                            'leaveId' => $condition['leaveId'],
                            'nature' => $condition['nature'],
                            'forfeit_days' => 0];

                        DB::table('sick_leave_forfeit_days')->updateOrInsert($condition, array_merge($extraData, ['updated_at' => now(), 'created_at' => now()]));

                        // Add other fields as needed.
                        // Use the DB facade to insert or update the data directly into the table.

                        $leave_type = LeaveType::where('id', $nature)->first();
                        $type_name = $leave_type->type;

                        $linemanager = LeaveApproval::where('empID', $empID)->first();
                        $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                        $employee_data = SysHelpers::employeeData($empID);
                        $fullname = $linemanager_data['full_name'];

                        $email_data = array(
                            'subject' => 'Employee Leave Approval',
                            'view' => 'emails.linemanager.leave-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                            'employee_name' => $employee_data['full_name'],
                            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                        );

                        try {

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                        } catch (Exception $exception) {
                            $msg = $type_name . " Leave Request is submitted successfully but email not sent(SMTP Problem)!";
                            return $url->with('msg', $msg);
                        }
                        $msg = $type_name . " Leave Request is submitted successfully!";
                        return $url->with('msg', $msg);
                    }

                }

            }

            if ($total_leave_days < $max_leave_days) {
                $remaining = $max_leave_days - ($leave_balance + $different_days);
                $leaves = new Leaves();
                // $empID=Auth::user()->emp_id;
                $leaves->empID = $empID;
                $leaves->start = $request->start;
                $leaves->end = $request->end;
                $leaves->leave_address = $request->address;
                $leaves->status = 1;
                $leaves->mobile = $request->mobile;
                $leaves->nature = $request->nature;
                $leaves->deligated = $request->deligate;

                // for annual leave
                if ($request->nature == 1) {

                    $annualleaveBalance = $this->attendance_model->getLeaveBalance($empID, $employeeDate, date('Y-m-d'));

                    // checking annual leave balance
                    if ($different_days < $annualleaveBalance) {
                        $leaves->days = $different_days;
                        $remaining = $annualleaveBalance - $different_days;

                    } else {
                        $msg = 'You Have Insufficient Annual  Accrued Days';
                        return response(['msg' => $msg], 202);
                    }

                }

                if ($request->nature != 5 && $request->nature != 1) {

                    $leaves->days = $different_days;
                }
                // For Paternity leabe
                if ($request->nature == 5) {

                    $paternity = Leaves::where('empID', $empID)->where('nature', 5)->where('sub_category', $request->sub_cat)->whereYear('created_at', date('Y'))->orderBy('created_at', 'desc')->first();
                    // Case an Employee has ever applied leave before
                    if ($paternity) {
                        $d1 = $paternity->created_at;
                        $d2 = new DateTime();
                        $interval = SysHelpers::countWorkingDaysForOtherLeaves($d1, $d2);

                        $month = $interval;
                        // For Employee With Less Than 4 month of service and last application
                        if ($month < 112) {

                            $max_days = 7;
                            // Case Requested days are less than max-days
                            if ($total_leave_days <= $max_days) {
                                if ($different_days < $max_days) {
                                    $leaves->days = $different_days;
                                } else {
                                    $msg = "Sorry, You have Insufficient Leave Days Balance";
                                    return $url->with('msg', $msg);
                                }

                            }
                            // case All Paternity days have been used up
                            else {

                                $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance4";
                                return $url->with('msg', $msg);
                            }

                        }
                        // For Employee who as attained more than 4 working days
                        else {
                            $max_days = 10;
                            if ($total_leave_days <= $max_days) {
                                if ($different_days < $max_days) {
                                    $leaves->days = $different_days;
                                } else {
                                    $msg = "Sorry, You have Insufficient Leave Days Balance";
                                    return $url->with('msg', $msg);
                                }

                            }
                            // case All Paternity days have been used up
                            else {

                                $excess = $total_leave_days - $max_days;
                                // dd($excess);
                                $msg = 'You requested for ' . $excess . ' extra days!';

                                return $url->with('msg', $msg);
                            }
                        }
                    }
                    // Case an employee is applying paternity for the first time
                    else {
                        // Checking if employee has less than 4 working months
                        if ($day < 112) {
                            $max_days = 7;
                            if ($total_leave_days < $max_days) {
                                if ($different_days <= $max_days) {
                                    $leaves->days = $different_days;
                                } else {
                                    $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                    return $url->with('msg', $msg);
                                }

                            } else {

                                $leave_type = LeaveType::where('id', $nature)->first();
                                $type_name = $leave_type->type;
                                $msg = "Sorry, You have Insufficient  " . $type_name . " Leave Days Balance";
                                return $url->with('msg', $msg);

                            }

                        }
                        // For Employee with more than 4 working months
                        else {
                            $max_days = 10;

                            if ($different_days < $max_days) {
                                $leaves->days = $different_days;
                            } else {
                                $msg = "Sorry, You have Insufficient  Leave Days Balance";
                                return $url->with('msg', $msg);
                            }

                        }
                    }

                }

                $leaves->reason = $request->reason;
                $leaves->remaining = $remaining;
                $leaves->sub_category = $request->sub_cat;
                $leaves->application_date = date('Y-m-d');
                if ($request->hasfile('image')) {
                    $request->validate([
                        // 'image' => 'required|clamav',
                    ]);
                    $request->validate([
                        'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                    ]);
                    $newImageName = $request->image->hashName();
                    $request->image->move(public_path('storage/leaves'), $newImageName);
                    $leaves->attachment = $newImageName;

                }

                $leaves->save();
                $autheniticateduser = auth()->user()->emp_id;
                $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);

                $leave_type = LeaveType::where('id', $nature)->first();
                $type_name = $leave_type->type;

                //fetch Line manager data from employee table and send email

                $linemanager = LeaveApproval::where('empID', $empID)->first();
                $linemanager_data = SysHelpers::employeeData($linemanager->level1);
                $employee_data = SysHelpers::employeeData($empID);
                $fullname = $linemanager_data['full_name'];
                $email_data = array(
                    'subject' => 'Employee Leave Approval',
                    'view' => 'emails.linemanager.leave-approval',
                    'email' => $linemanager_data['email'],
                    'full_name' => $fullname,
                    'employee_name' => $employee_data['full_name'],
                    'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
                );
                try {

                    Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

                } catch (Exception $exception) {
                    $msg = $type_name . " Leave Request is submitted successfully but email not sent(SMTP Problem)!";
                    return $url->with('msg', $msg);
                }
                $msg = $type_name . " Leave Request is submitted successfully!";
                return $url->with('msg', $msg);
            } else {

                $leave_type = LeaveType::where('id', $nature)->first();
                $type_name = $leave_type->type;
                $msg = "Sorry, You have Insufficient " . $type_name . " Leave Days Balance";
                return $url->with('msg', $msg);

            }

        } else {
            $msg = "Error!! start date should be less than end date!";
            return redirect()->back()->with('msg', $msg);
        }

    }
    public function saveLeaveOnBehalf2(Request $request)
    {
        request()->validate(
            []);
        $start = $request->start;
        $end = $request->end;

        // For Redirection Url
        $url = redirect('flex/attendance/leave');

        $employee = EMPL::where('emp_id', $request->empID)->first();

        if ($start <= $end) {
            $gender = $this->getEmployeeGender($request->empID);
            if ($gender == "Male") {$gender = 1;} else { $gender = 2;}
            // for checking balance
            $today = date('Y-m-d');
            $arryear = explode('-', $today);
            $year = $arryear[0];
            $nature = $request->nature;
            $empID = $request->empID;

            // Check if there is a pending leave in the given number of days (start,end)
            $pendingLeave = Leaves::where('empId', $empID)
                ->where('state', 1)
                ->whereDate('start', '<=', $start)
                ->whereDate('end', '>=', $start)
                ->first();

            $approvedLeave = Leaves::where('empId', $empID)
                ->where('state', 0)
                ->whereDate('start', '<=', $start)
                ->whereDate('end', '>=', $start)
                ->first();

            if ($pendingLeave || $approvedLeave) {
                $message = 'You have a ';

                if ($pendingLeave) {
                    $message .= 'pending ' . $pendingLeave->type->type . ' application ';
                }

                if ($approvedLeave) {
                    $message .= ($pendingLeave ? 'and ' : '') . 'approved ' . $approvedLeave->type->type . ' application ';
                }

                $message .= 'within the requested leave time';

                return $url->with('error', $message);
            }

            $leaves = Leaves::where('empID', $empID)->where('nature', $nature)->where('sub_category', $request->sub_cat)->whereNot('reason', 'Automatic applied!')->whereYear('created_at', date('Y'))->sum('days');

            $leave_balance = $leaves;
            $type = LeaveType::where('id', $nature)->first();
            $max_leave_days = $type->max_days;
            $employeeHiredate = explode('-', $employee->hire_date);
            $employeeHireYear = $employeeHiredate[0];
            $employeeDate = '';

            if ($employeeHireYear == $year) {
                $employeeDate = $employee->hire_date;

            } else {
                $employeeDate = $year . '-01-01';
            }
        }

        $annualleaveBalance = $this->attendance_model->getLeaveBalance($empID, $employeeDate, date('Y-m-d'));
        $holidays = SysHelpers::countHolidays($start, $end);
        $different_days = SysHelpers::countWorkingDays($start, $end) - $holidays;
        $total_leave_days = $leaves + $different_days;

        if ($type->type == "Annual") {
            $max_leave_days = $annualleaveBalance;
        }
        $extradays = $total_leave_days - $max_leave_days;

        if ($total_leave_days >= $max_leave_days) {

            if ($type->type == "Annual") {
                $remaining = $max_leave_days + $extradays - ($leave_balance + $different_days);

            } else {
                $remaining = $annualleaveBalance + $extradays - $different_days;
            }

            if ($remaining < 0) {
                $remaining == 0;
            }

            $leaves = new Leaves();
            // $empID=Auth::user()->emp_id;
            $leaves->empID = $empID;
            $leaves->start = $request->start;
            $leaves->end = $request->end;
            $leaves->leave_address = $request->address;
            $leaves->mobile = $request->mobile;
            $leaves->nature = $request->nature;
            $leaves->deligated = $request->deligate;
            $leaves->status = 1;

            $leaves->days = $different_days;

            $leaves->reason = $request->reason;
            $leaves->remaining = $remaining;
            if ($request->sub_cat > 0) {
                $leaves->sub_category = $request->sub_cat;
                // $sub=LeaveSubType::where('id',$sub_cat)->first();
            }

            $leaves->application_date = date('Y-m-d');
            if ($request->hasfile('image')) {

                $request->validate([
                    'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                ]);
                $newImageName = $request->image->hashName();
                $request->image->move(public_path('storage/leaves'), $newImageName);
                $leaves->attachment = $newImageName;

            }
            $leaves->save();

            $autheniticateduser = auth()->user()->emp_id;
            $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);


            $condition = [
                'emp_id' => $empID,
                'appliedBy' => Auth::user()->emp_id,
                'leaveId' => $leaves->id,
                'nature' => $leaves->nature,

            ];
            $extraData = [
                'emp_id' => $condition['emp_id'],
                'appliedBy' => $condition['appliedBy'],
                'leaveId' => $condition['leaveId'],
                'nature' => $condition['nature'],
                'forfeit_days' => $extradays];

            DB::table('sick_leave_forfeit_days')->updateOrInsert($condition, array_merge($extraData, ['updated_at' => now(), 'created_at' => now()]));
            $leave_type = LeaveType::where('id', $nature)->first();
            $type_name = $leave_type->type;
            $linemanager = LeaveApproval::where('empID', $empID)->first();
            $linemanager_data = SysHelpers::employeeData($linemanager->level1);
            $employee_data = SysHelpers::employeeData($empID);
            $fullname = $linemanager_data['full_name'];

            $email_data = array(
                'subject' => 'Employee Leave Approval',
                'view' => 'emails.linemanager.leave-approval',
                'email' => $linemanager_data['email'],
                'full_name' => $fullname,
                'employee_name' => $employee_data['full_name'],
                'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
            );
            try {

                Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

            } catch (Exception $exception) {
                $msg = $type_name . " Leave Request is submitted successfully but email not sent(SMTP Problem)!";
                return $url->with('msg', $msg);
            }
            $msg = $type_name . " Leave Request is submitted successfully!";
            return $url->with('msg', $msg);

        } else {
            $extradays = 0;

            if ($type->type != "Annual") {
                $remaining = $max_leave_days + $extradays - ($leave_balance + $different_days);
            } else {
                $remaining = $annualleaveBalance + $extradays - $different_days;
            }

            $leaves = new Leaves();
            // $empID=Auth::user()->emp_id;
            $leaves->empID = $empID;
            $leaves->start = $request->start;
            $leaves->end = $request->end;
            $leaves->leave_address = $request->address;
            $leaves->mobile = $request->mobile;
            $leaves->nature = $request->nature;
            $leaves->deligated = $request->deligate;
            $leaves->status = 1;

            $leaves->days = $different_days;

            $leaves->reason = $request->reason;
            $leaves->remaining = $remaining;
            if ($request->sub_cat > 0) {
                $leaves->sub_category = $request->sub_cat;
                // $sub = LeaveSubType::where('id', $sub_cat)->first();
            }

            $leaves->application_date = date('Y-m-d');
            if ($request->hasfile('image')) {

                $request->validate([
                    'image' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                ]);
                $newImageName = $request->image->hashName();
                $request->image->move(public_path('storage/leaves'), $newImageName);
                $leaves->attachment = $newImageName;

            }
            $leaves->save();
            $autheniticateduser = auth()->user()->emp_id;
            $auditLog = SysHelpers::AuditLog(2, "Leave application  by " . $autheniticateduser, $request);


            $condition = [
                'emp_id' => $empID,
                'appliedBy' => Auth::user()->emp_id,
                'leaveId' => $leaves->id,
                'nature' => $leaves->nature,

            ];
            $extraData = [
                'emp_id' => $condition['emp_id'],
                'appliedBy' => $condition['appliedBy'],
                'leaveId' => $condition['leaveId'],
                'nature' => $condition['nature'],
                'forfeit_days' => $extradays];

            DB::table('sick_leave_forfeit_days')->updateOrInsert($condition, array_merge($extraData, ['updated_at' => now(), 'created_at' => now()]));
            $leave_type = LeaveType::where('id', $nature)->first();
            $type_name = $leave_type->type;
            $linemanager = LeaveApproval::where('empID', $empID)->first();
            $linemanager_data = SysHelpers::employeeData($linemanager->level1);
            $employee_data = SysHelpers::employeeData($empID);
            $fullname = $linemanager_data['full_name'];

            $email_data = array(
                'subject' => 'Employee Leave Approval',
                'view' => 'emails.linemanager.leave-approval',
                'email' => $linemanager_data['email'],
                'full_name' => $fullname,
                'employee_name' => $employee_data['full_name'],
                'next' => parse_url(route('attendance.leave'), PHP_URL_PATH),
            );
            try {

                Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));

            } catch (Exception $exception) {
                $msg = $type_name . " Leave Request is submitted successfully but email not sent(SMTP Problem)!";
                return $url->with('msg', $msg);
            }
            $msg = $type_name . " Leave Request is submitted successfully!";
            return $url->with('msg', $msg);

        }

    }

}
