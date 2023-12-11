<?php

namespace App\Http\Controllers\Payroll;

use App\Helpers\SysHelpers;
use App\Http\Controllers\Controller;
use App\Models\AttendanceModel;
use App\models\Employee;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\ReportModel;
use App\Notifications\EmailPayslip;
use App\Notifications\EmailRequests;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PayrollController extends Controller
{

    protected $payroll_model;
    protected $reports_model;
    protected $flexperformance_model;
    protected $attendance_model;

    public function __construct($payroll_model = null, $flexperformance_model = null, $reports_model = null)
    {
        $this->payroll_model = new Payroll();
        $this->reports_model = new ReportModel;
        $this->flexperformance_model = new FlexPerformanceModel;
        $this->attendance_model = new AttendanceModel();

    }

    public function authenticateUser($permissions)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->can($permissions)) {

            abort(Response::HTTP_UNAUTHORIZED, '500|Page Not Found');
        }
    }

    public function initPayroll(Request $request)
    {

        if ($request->post()) {

            $pendingInputs = $this->payroll_model->checkInputs($request->payrolldate);
            $pendingInputs = 2;
            if ($pendingInputs > 0) {
                $pendingPayroll = $this->payroll_model->pendingPayrollCheck();

                if ($pendingPayroll > 0) {
                    echo "<p class='alert alert-warning text-center'>FAILED! There is Pending Payroll which Needs To be Confirmed Before Another Payroll is Run</p>";
                } else {

                    // DATE MANIPULATION
                    $calendar = $request->payrolldate;
                    
                    $datewell = explode("-", $calendar);
                  
                    $mm = $datewell[1];
                    $dd = $datewell[2];
                    $yyyy = $datewell[0];
                    $payroll_date = $yyyy . "-" . $mm . "-" . $dd;
                    $payroll_month = $yyyy . "-" . $mm;
                    $empID = auth()->user()->emp_id;
                    $today = date('Y-m-d');

                    $check = $this->payroll_model->payrollcheck($payroll_month);
                    if ($check == 0) {
                        $result = $this->payroll_model->initPayroll($today, $payroll_date, $payroll_month, $empID);
                        //notify the finance

                        /*copy allocation table to logs*/

                        $all_allocations = $this->flexperformance_model->getAllocation();

                        foreach ($all_allocations as $all_allocation) {
                            $data_allocation_log = array(
                                'empID' => $all_allocation->empID,
                                'activity_code' => $all_allocation->activity_code,
                                'grant_code' => $all_allocation->grant_code,
                                'percent' => $all_allocation->percent,
                                'isActive' => $all_allocation->isActive,
                                'payroll_date' => $payroll_date,
                            );

                            $this->payroll_model->insertAllocation($data_allocation_log);
                        }

                        //copying arrears pending
                        $arrears_pending = $this->payroll_model->arrearsPending();
                        if ($arrears_pending) {

                            foreach ($arrears_pending as $arrear_pending) {
                                $data_copy_arrear_pendings = array(
                                    'arrear_id' => $arrear_pending->arrear_id,
                                    'amount_paid' => $arrear_pending->amount,
                                    'init_by' => $arrear_pending->init_by,
                                    'confirmed_by' => $arrear_pending->confirmed_by,
                                    'payment_date' => $payroll_date,
                                    'payroll_date' => $payroll_date,
                                );

                                $this->payroll_model->insertArrearLog($data_copy_arrear_pendings);
                            }
                        }

                        $arrears_id = $this->payroll_model->arrearsPendingByArrearId();
                        if ($arrears_id) {
                            foreach ($arrears_id as $arrear_id) {
                                $arrear_logs = $this->payroll_model->getArrearLog($arrear_id->arrear_id);

                                if ($arrear_logs) {
                                    $total_paid = 0;
                                    $last_paid = 0;
                                    foreach ($arrear_logs as $arrear_log) {
                                        $total_paid += $arrear_log->amount_paid;
                                        $last_paid = $arrear_log->amount_paid;
                                    }

                                    $arrears_update = array(
                                        'paid' => $total_paid,
                                        'amount_last_paid' => $last_paid,
                                    );
                                    $this->payroll_model->updateArrear($arrear_id->arrear_id, $arrears_update);
                                }
                            }
                        }
                        $this->payroll_model->truncateArrearsPending();

                        if ($result == true) {
                            // $linemanager_data = SysHelpers::employeeData(auth()->user()->full_name);

                            $description = "Run payroll of date " . $payroll_date;
                            // dd('Payroll Run and Email has been sent');
                            //$result = SysHelpers::auditLog(1,$description,$request);

                            echo "<p class='alert alert-info text-center'>Period Changed Successfull</p>";
                        } else {
                            echo "<p class='alert alert-danger text-center'>Failed To run the Payroll, Please Try again, If the Error persists Contact Your System Admin</p>";
                        }
                    } else {
                        echo "<p class='alert alert-warning text-center'>" . $payroll_month . " Sorry The Payroll for This Month is Already Procesed, Try another Month!</p>";
                    }
                }
            } else {
                echo "<p class='alert alert-warning text-center'>FAILED! There is Pending Payroll Inputs Needs To be Submitted Before  Payroll is Run</p>";
            }
        }
    }

    public function financial_reports()
    {
        //
        $data['month_list'] = $this->payroll_model->payroll_month_list();
        $data['year_list'] = $this->payroll_model->payroll_year_list();
        $data['employee'] = $this->payroll_model->customemployee();
        $data['title'] = "Financial Reports";
        return view('app.financial_reports', $data);
    }

    public function employee_payslip()
    {

        $this->authenticateUser('view-payslip');

        // if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {

        $title = 'Employee Payslip';
        $parent = 'Payroll';
        $child = 'Payslip';
        $data['payrollList'] = $this->payroll_model->payrollMonthList();
        $data['month_list'] = $this->payroll_model->payroll_month_list();
        $data['employee'] = $this->payroll_model->customemployee();

        return view('payroll.employee_payslip', compact('data', 'title', 'parent', 'child'));
        // } else {
        //     echo 'Unauthorised Access';
        // }
    }

    public function payroll()
    {
        // if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {

        $this->authenticateUser('view-payroll');

        $data['pendingPayroll_month'] = $this->payroll_model->pendingPayroll_month();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['payroll'] = $this->payroll_model->pendingPayroll();
        $data['pending_overtime'] = $this->flexperformance_model->pending_overtime();

        $data['payrollList'] = $this->payroll_model->payrollMonthList();
        $data['title'] = "Payroll";

        // dd($data);

        // dd($data['pendingPayroll']);
        //echo $data['pendingPayroll_month'];

        return view('payroll.payroll', [
            'data' => $data,
            'parent' => 'Payroll',
            'child' => 'Payroll',

        ]);

        // } else {
        //     echo 'Unauthorised Access';
        // }

    }

    public function payslip()
    {
        return view('payroll.payslip', [
            'parent' => 'Payroll',
            'child' => 'Payslip',
        ]);
    }

    public function incentives()
    {
        return view('payroll.incentives', [
            'parent' => 'Payroll',
            'child' => 'Incentives',
        ]);
    }

    public function partialPayment()
    {
        return view('payroll.partial-payment', [
            'parent' => 'Payroll',
            'child' => 'Partial Payment',
        ]);
    }

    public function temp_payroll_info(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);
        //$payrollMonth = '2023-07-17';

        $data['payroll_details'] = $this->payroll_model->getPayroll($payrollMonth);
        $data['payroll_month_info'] = $this->payroll_model->payroll_month_info($payrollMonth);
        // $data['payroll_list'] =  $this->payroll_model->employeePayrollList("temp_payroll_logs",$payrollMonth);
        $data['payroll_list'] = $this->payroll_model->employeePayrollList($payrollMonth, "temp_allowance_logs", "temp_deduction_logs", "temp_loan_logs", "temp_payroll_logs");
        $data['payroll_date'] = $payrollMonth;
        $data['payroll_totals'] = $this->payroll_model->temp_payrollTotals("temp_payroll_logs", $payrollMonth);

        $data['total_allowances'] = $this->payroll_model->total_allowances("allowance_logs", $payrollMonth);
        $data['total_bonuses'] = $this->payroll_model->total_bonuses($payrollMonth);
        $data['total_loans'] = $this->payroll_model->total_loans("loan_logs", $payrollMonth);
        $data['total_overtimes'] = $this->payroll_model->total_overtimes($payrollMonth);

        $data['total_allowances'] = $this->payroll_model->total_allowances("temp_allowance_logs", $payrollMonth);
        //      $data['total_loans'] =  $this->payroll_model->total_loans("temp_loan_logs",$payrollMonth);
        $data['total_loans'] = $this->payroll_model->total_loans_separate("temp_loan_logs", $payrollMonth);
        $data['total_deductions'] = $this->payroll_model->total_deductions("temp_deduction_logs", $payrollMonth);
        $data['payroll_state'] = $data['payroll_month_info'][0]->state;
        $data['title'] = "Payroll Info";

        // dd($data);

        return view('payroll.payroll_info', $data);
    }

    public function get_reconsiliation_summary(Request $request)
    {

        $calendar = $request->payrolldate;

        $previousDate = date('Y-m-d', strtotime($calendar . ' -1 months'));

        $data['payroll_state'] = $request->payrollState;

        $datewell = explode("-", $calendar);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];

        $termination_date = $yyyy . "-" . $mm . "-" . $dd;
        $j_mm = "01";
        $j_dd = "01";
        $january_date = $yyyy . "-" . $j_mm . "-" . $j_dd;
        $termination_month = $yyyy . "-" . $mm;
        $empID = auth()->user()->emp_id;
        $today = date('Y-m-d');

        $current_payroll_month = $request->input('payrolldate');
        $reportType = 1; //Staff = 1, temporary = 2
        $reportformat = $request->input('type'); //Staff = 1, temporary = 2
        $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
        $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

        // dd($previous_payroll_month_raw);
        $data['payroll_date'] = $request->payrolldate;
        $data['total_previous_gross'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;

        $data['total_current_gross'] = $this->reports_model->s_grossMonthly1($current_payroll_month);
        $data['count_previous_month'] = !empty($previous_payroll_month) ? $this->reports_model->s_count($previous_payroll_month) : 0;
        $data['count_current_month'] = $this->reports_model->s_count1($current_payroll_month);
        $data['total_previous_overtime'] = $this->reports_model->s_overtime1($previous_payroll_month);
        $data['total_current_overtime'] = $this->reports_model->s_overtime1($current_payroll_month);
        $data['terminated_employee'] = $this->reports_model->terminated_employee($previous_payroll_month);

        $data['new_employee'] = $this->reports_model->new_employee1($current_payroll_month, $previous_payroll_month);
        //dd($data['new_employee']);
        if ($data['new_employee'] > 0) {

            $data['new_employee_salary'] = $this->reports_model->new_employee_salary1($current_payroll_month, $previous_payroll_month);
        }
        if ($data['terminated_employee'] > 0) {

            $data['termination_salary'] = $this->reports_model->terminated_salary($previous_payroll_month);
        }
        $total_allowances = $this->reports_model->total_allowance1($current_payroll_month, $previous_payroll_month); //Last month

        // dd($current_payroll_month, $previous_payroll_month);

        $descriptions = [];

        //This month
        foreach ($total_allowances as $row) {

            if ($row->allowance == "N-Overtime") {

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'N-Overtime');

                // dd($allowance);
                if (count($allowance) > 0) {
                    for ($i = 0; $i < count($allowance); $i++) {
                        $row->current_amount += $allowance[$i]->current_amount;
                        $row->previous_amount += $allowance[$i]->previous_amount;
                        $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                        array_push($descriptions, $row->description);
                    }
                }
            } elseif ($row->allowance == "S-Overtime") {
                if ($row->current_amount != $row->previous_amount) {
                    $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'S-Overtime');
                    if (count($allowance) > 0) {
                        for ($i = 0; $i < count($allowance); $i++) {
                            $row->current_amount += $allowance[$i]->current_amount;
                            $row->previous_amount += $allowance[$i]->previous_amount;
                            $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                            array_push($descriptions, $row->description);
                        }
                    }
                }
            } elseif ($row->allowance == "House Rent") {
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'house_allowance');
                if (count($allowance) > 0) {
                    for ($i = 0; $i < count($allowance); $i++) {
                        $row->current_amount += $allowance[$i]->current_amount;
                        $row->previous_amount += $allowance[$i]->previous_amount;
                        $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                        array_push($descriptions, $row->description);
                    }
                }
            } elseif ($row->allowance == "Leave Allowance") {

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'leave_allowance');
                if (count($allowance) > 0) {
                    for ($i = 0; $i < count($allowance); $i++) {
                        $row->current_amount += $allowance[$i]->current_amount;
                        $row->previous_amount += $allowance[$i]->previous_amount;
                        $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                        array_push($descriptions, $row->description);
                    }
                }
            } elseif ($row->allowance == "Teller Allowance") {

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'teller_allowance');
                if (count($allowance) > 0) {
                    for ($i = 0; $i < count($allowance); $i++) {
                        $row->current_amount += $allowance[$i]->current_amount;
                        $row->previous_amount += $allowance[$i]->previous_amount;
                        $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                        array_push($descriptions, $row->description);
                    }
                }
            } elseif ($row->allowance == "Transport Allowance") {

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'transport_allowance');

                if (count($allowance) > 0) {
                    for ($i = 0; $i < count($allowance); $i++) {
                        $row->current_amount += $allowance[$i]->current_amount;
                        $row->previous_amount += $allowance[$i]->previous_amount;
                        $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                        array_push($descriptions, $row->description);
                    }
                }
            } elseif ($row->allowance == "Night Shift Allowance") {

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'nightshift_allowance');

                if (count($allowance) > 0) {
                    for ($i = 0; $i < count($allowance); $i++) {
                        $row->current_amount += $allowance[$i]->current_amount;
                        $row->previous_amount += $allowance[$i]->previous_amount;
                        $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                        array_push($descriptions, $row->description);
                    }
                }
            } elseif ($row->allowance == "Arrears") {
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'arreas');
                if (count($allowance) > 0) {
                    for ($i = 0; $i < count($allowance); $i++) {
                        $row->current_amount += $allowance[$i]->current_amount;
                        $row->previous_amount += $allowance[$i]->previous_amount;
                        $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                        array_push($descriptions, $row->description);
                    }
                }
            } elseif ($row->allowance == "Long Serving allowance") {
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'long_serving');
                if (count($allowance) > 0) {
                    for ($i = 0; $i < count($allowance); $i++) {
                        $row->current_amount += $allowance[$i]->current_amount;
                        $row->previous_amount += $allowance[$i]->previous_amount;
                        $row->difference += ($allowance[$i]->current_amount - $allowance[$i]->previous_amount);

                        array_push($descriptions, $row->description);
                    }
                }
            }
        }

        // dd($total_allowances);
        $all_terminal_allowance = $this->reports_model->all_terminated_allowance($current_payroll_month, $previous_payroll_month);

        $result = $this->arrayRecursiveDiff($all_terminal_allowance, $descriptions);

        foreach ($result as $row) {

            array_push($total_allowances, (object) [
                'description' => $row['description'],
                'allowance' => $row['description'],
                'current_amount' => $row['current_amount'],
                'previous_amount' => $row['previous_amount'],
                'difference' => $row['current_amount'] - $row['previous_amount'],
            ]);
        }

        $data['total_allowances'] = $total_allowances;

        $data['total_previous_basic'] = !empty($previous_payroll_month) ? $this->reports_model->total_basic($previous_payroll_month) : 0;
        $data['total_current_basic'] = !empty($current_payroll_month) ? $this->reports_model->total_basic1($current_payroll_month) : 0;
        $data['total_previous_net'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;
        $data['total_current_net'] = $this->reports_model->s_grossMonthly1($current_payroll_month);

        $data['current_decrease'] = $this->reports_model->basic_decrease1($previous_payroll_month, $current_payroll_month);

        $data['current_increase'] = $this->reports_model->basic_increase_temp($previous_payroll_month, $current_payroll_month);

        $data['termination'] = $this->reports_model->get_termination($current_payroll_month);

        if ($request->type == 1) {
            return view('payroll.reconsiliation_summary', $data);
        }

        $pdf = Pdf::loadView('reports.payroll_reconciliation_summary1', $data)->setPaper('a4', 'potrait');
        return $pdf->download('payroll_reconciliation_summary.pdf');

        return view('payroll.reconsiliation_summary', $data);
    }

    public function arrayRecursiveDiff($aArray1, $aArray2)
    {
        $aReturn = array();
        //bool in_array( $val, $array_name, $mode );
        for ($i = 0; $i < count($aArray1); $i++) {
            if (in_array($aArray1[$i]['description'], $aArray2)) {
                unset($aArray1[$i]);
                // dd($row['description']);
            } else {
                // array_push($aRetur)
            }
        }

        return $aArray1;
    }

    public function get_reconsiliation_summary1(Request $request)
    {

        $data['payroll_state'] = 1;
        $calendar = $request->payrolldate;
        $calendar = $request->payrolldate;

        $data['payroll_date'] = $calendar;

        //dd($calendar);

        $previousDate = date('Y-m-d', strtotime($calendar . ' -1 months'));

        $datewell = explode("-", $calendar);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];

        $termination_date = $yyyy . "-" . $mm . "-" . $dd;
        $j_mm = "01";
        $j_dd = "01";
        $january_date = $yyyy . "-" . $j_mm . "-" . $j_dd;
        $termination_month = $yyyy . "-" . $mm;
        $empID = auth()->user()->emp_id;
        $today = date('Y-m-d');

        $current_payroll_month = $request->payrolldate;
        $reportType = 1; //Staff = 1, temporary = 2
        //$reportformat = $request->input('type'); //Staff = 1, temporary = 2
        $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
        $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

        // dd($previous_payroll_month_raw);

        $data['total_previous_gross'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;
        $data['total_current_gross'] = $this->reports_model->s_grossMonthly($current_payroll_month);
        $data['count_previous_month'] = !empty($previous_payroll_month) ? $this->reports_model->s_count($previous_payroll_month) : 0;
        $data['count_current_month'] = $this->reports_model->s_count($current_payroll_month);
        $data['total_previous_overtime'] = $this->reports_model->s_overtime($previous_payroll_month);
        $data['total_current_overtime'] = $this->reports_model->s_overtime($current_payroll_month);

        $data['terminated_employee'] = $this->reports_model->terminated_employee($previous_payroll_month);

        $data['new_employee'] = $this->reports_model->new_employee($current_payroll_month, $previous_payroll_month);
        //dd($data['new_employee']);
        if ($data['new_employee'] > 0) {

            $data['new_employee_salary'] = $this->reports_model->new_employee_salary($current_payroll_month, $previous_payroll_month);
        }

        if ($data['terminated_employee'] > 0) {

            $data['termination_salary'] = $this->reports_model->terminated_salary($previous_payroll_month);
        }
        $total_allowances = $this->reports_model->total_allowance($current_payroll_month, $previous_payroll_month);
        $descriptions = [];
        foreach ($total_allowances as $row) {
            if ($row->allowance == "N-Overtime") {

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'N-Overtime');
                if (count($allowance) > 0) {
                    $row->current_amount += $allowance[0]->current_amount;
                    $row->current_amount += $allowance[0]->current_amount;
                    array_push($descriptions, $row->description);
                }
            } elseif ($row->allowance == "S-Overtime") {
                if ($row->current_amount != $row->previous_amount) {
                    $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'S-Overtime');
                    if (count($allowance) > 0) {
                        $row->current_amount += $allowance[0]->current_amount;
                        $row->current_amount += $allowance[0]->current_amount;
                        array_push($descriptions, $row->description);
                    }
                }
            } elseif ($row->allowance == "House Rent") {
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'house_allowance');
                if (count($allowance) > 0) {
                    $row->current_amount += $allowance[0]->current_amount;
                    $row->current_amount += $allowance[0]->current_amount;
                    array_push($descriptions, $row->description);
                }
            } elseif ($row->allowance == "Leave Allowance") {

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'leave_allowance');
                if (count($allowance) > 0) {
                    $row->current_amount += $allowance[0]->current_amount;
                    $row->current_amount += $allowance[0]->current_amount;
                    array_push($descriptions, $row->description);
                }
            } elseif ($row->allowance == "Teller Allowance") {

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'teller_allowance');
                if (count($allowance) > 0) {
                    $row->current_amount += $allowance[0]->current_amount;
                    $row->current_amount += $allowance[0]->current_amount;
                    array_push($descriptions, $row->description);
                }
            } elseif ($row->allowance == "Arrears") {
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'arreas');
                if (count($allowance) > 0) {
                    $row->current_amount += $allowance[0]->current_amount;
                    $row->current_amount += $allowance[0]->current_amount;
                    array_push($descriptions, $row->description);
                }
            } elseif ($row->allowance == "Long Serving allowance") {
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'long_serving');
                if (count($allowance) > 0) {
                    $row->current_amount += $allowance[0]->current_amount;
                    $row->current_amount += $allowance[0]->current_amount;
                    array_push($descriptions, $row->description);
                }
            }
        }

        $all_terminal_allowance = $this->reports_model->all_terminated_allowance($current_payroll_month, $previous_payroll_month);

        $result = $this->arrayRecursiveDiff($all_terminal_allowance, $descriptions);

        foreach ($result as $row) {

            array_push($total_allowances, (object) [
                'description' => $row['description'],
                'allowance' => $row['description'],
                'current_amount' => $row['current_amount'],
                'previous_amount' => $row['previous_amount'],
                'difference' => $row['current_amount'] - $row['previous_amount'],
            ]);
        }

        $data['total_allowances'] = $total_allowances;
        // $data['total_allowances'] = $this->reports_model->total_allowance($current_payroll_month, $previous_payroll_month);

        $data['total_previous_basic'] = !empty($previous_payroll_month) ? $this->reports_model->total_basic($previous_payroll_month) : 0;
        $data['total_current_basic'] = !empty($current_payroll_month) ? $this->reports_model->total_basic($current_payroll_month) : 0;

        $data['total_previous_net'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;
        $data['total_current_net'] = $this->reports_model->s_grossMonthly($current_payroll_month);

        $data['current_decrease'] = $this->reports_model->basic_decrease($previous_payroll_month, $current_payroll_month);
        // dd($data['previous_decrease']);
        // $data['current_decrease'] = $this->reports_model->basic_decrease($current_payroll_month);

        // $data['previous_increase'] = $this->reports_model->basic_increase($previous_payroll_month);
        $data['current_increase'] = $this->reports_model->basic_increase($previous_payroll_month, $current_payroll_month);

        ($data['current_increase']);
        $data['termination'] = $this->reports_model->get_termination($current_payroll_month);

        $data['payroll_state'] = $request->payrollState;

        if ($request->type == 1) {
            return view('payroll.reconsiliation_summary', $data);
        }

        $pdf = Pdf::loadView('reports.payroll_reconciliation_summary1', $data)->setPaper('a4', 'potrait');
        return $pdf->download('payroll_reconciliation_summary.pdf');
    }

    public function payroll_info(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);

        $data['payroll_details'] = $this->payroll_model->getPayroll($payrollMonth);
        $data['payroll_list'] = $this->payroll_model->employeePayrollList($payrollMonth, "allowance_logs", "deduction_logs", "loan_logs", "payroll_logs");
        $data['payroll_totals'] = $this->payroll_model->payrollTotals("payroll_logs", $payrollMonth);

        $data['total_allowances'] = $this->payroll_model->total_allowances("allowance_logs", $payrollMonth);
        $data['total_bonuses'] = $this->payroll_model->total_bonuses($payrollMonth);
        //      $data['total_loans'] =  $this->payroll_model->total_loans("loan_logs",$payrollMonth);
        $data['total_loans'] = $this->payroll_model->total_loans_separate("loan_logs", $payrollMonth);
        $data['total_deductions'] = $this->payroll_model->total_deductions("deduction_logs", $payrollMonth);
        $data['total_overtimes'] = $this->payroll_model->total_overtimes($payrollMonth);
        $data['payroll_month_info'] = $this->payroll_model->payroll_month_info($payrollMonth);

        $data['payroll_date'] = $payrollMonth;
        $data['payrollMonth'] = $payrollMonth;
        // dd($data['payrollMonth']);
        $data['payroll_state'] = $data['payroll_month_info'][0]->state;
        $data['title'] = "Payroll Info";

        $data['title'] = "Payroll Info";

        $calendar = $payrollMonth;
        $datewell = explode("-", $calendar);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];

        $termination_date = $yyyy . "-" . $mm . "-" . $dd;
        $j_mm = "01";
        $j_dd = "01";
        $january_date = $yyyy . "-" . $j_mm . "-" . $j_dd;
        $termination_month = $yyyy . "-" . $mm;
        $empID = auth()->user()->emp_id;
        $today = date('Y-m-d');

        return view('payroll.payroll_info', $data);
    }

    public function payroll_info1(Request $request)
    {
        $data['payroll_state'] = 1;
        $calendar = base64_decode($request->pdate);

        $data['payroll_date'] = $calendar;
        $data['payrollMonth'] = $calendar;

        $datewell = explode("-", $calendar);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];

        $termination_date = $yyyy . "-" . $mm . "-" . $dd;
        $j_mm = "01";
        $j_dd = "01";
        $january_date = $yyyy . "-" . $j_mm . "-" . $j_dd;
        $termination_month = $yyyy . "-" . $mm;
        $empID = auth()->user()->emp_id;
        $today = date('Y-m-d');

        $current_payroll_month = $calendar;
        $reportType = 1; //Staff = 1, temporary = 2
        $reportformat = $request->input('type'); //Staff = 1, temporary = 2
        $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
        $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

        // dd($previous_payroll_month_raw);
        $data['payroll_date'] = $request->payrolldate;
        $data['total_previous_gross'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;
        $data['total_current_gross'] = $this->reports_model->s_grossMonthly($current_payroll_month);

        $data['count_previous_month'] = $this->reports_model->s_count($previous_payroll_month);
        $data['count_current_month'] = $this->reports_model->s_count($current_payroll_month);

        $data['total_allowances'] = $this->reports_model->total_allowance($current_payroll_month, $previous_payroll_month);

        $data['total_previous_basic'] = !empty($previous_payroll_month) ? $this->reports_model->total_basic($previous_payroll_month) : 0;
        $data['total_current_basic'] = !empty($current_payroll_month) ? $this->reports_model->total_basic($current_payroll_month) : 0;

        //$data['total_previous_net'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;
        // $data['total_current_net'] = $this->reports_model->s_grossMonthly($current_payroll_month);

        $data['previous_decrease'] = $this->reports_model->basic_decrease($previous_payroll_month);
        $data['current_decrease'] = $this->reports_model->basic_decrease($current_payroll_month);

        $data['previous_increase'] = $this->reports_model->basic_increase($previous_payroll_month);
        $data['current_increase'] = $this->reports_model->basic_increase($current_payroll_month);

        //$pdf = Pdf::loadView('reports.payroll_reconciliation_summary1', $data);
        // $pdf = Pdf::loadView('reports.payroll_details',$data);

        //return $pdf->download('sam.pdf');
        // $pdf = Pdf::loadView('reports.samplepdf')->setPaper('a4', 'potrait');
        //return $pdf->download('CARGO SALES NO # ' .  $purchases->pacel_number . ".pdf");

        // return $pdf->download('payroll_reconciliation_summary.pdf');
        return view('payroll.reconsiliation_summary', $data);
    }
    // public function temp_less_payments(Request $request)  {
    //   $payrollMonth = base64_decode($request->input('pdate'));
    //   $data['payroll_list'] =  $this->payroll_model->employeePayrollList($payrollMonth, "temp_allowance_logs", "temp_deduction_logs", "temp_loan_logs", "temp_payroll_logs");
    //   $data['confirmed'] =1;
    //   $data['payroll_date']= $payrollMonth;
    //   $data['title']="Payroll Info";
    //    return view('app.less_payments', $data);

    // }

    public function ADVtemp_less_payments(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);
        $payrollMonthRecent = $this->payroll_model->recent_payroll_month1(date('Y-m-d'));

        if ($payrollMonthRecent) {
            $data['payroll_date'] = $payrollMonthRecent;
            $data['previous'] = true;
        } else {
            $data['previous'] = false;
            $data['payroll_date'] = $payrollMonth;
        }
        $data['payroll_list'] = $this->payroll_model->employeeTempPayrollList($payrollMonth, "temp_allowance_logs", "temp_deduction_logs", "temp_loan_logs", "temp_payroll_logs", "temp_arrears");
        $data['confirmed'] = 1;
        $data['payroll_state'] = 0;
        $title = "Payroll Info";
        $parent = "Payroll";
        $child = "Payroll Info";

        return view('payroll.less_payments', compact('title', 'data', 'parent', 'child'));
    }

    public function less_payments(Request $request)
    {
        $payrollMonth = base64_decode($request->input('pdate'));
        $data['payroll_list'] = $this->payroll_model->employeeTempPayrollList($payrollMonth, "temp_allowance_logs", "temp_deduction_logs", "temp_loan_logs", "temp_payroll_logs", "temp_arrears");
        // /*check if temp payroll*/
        //     $temp_check = $this->payroll_model->temp_payroll_check($payrollMonth);
        //     if ($temp_check){
        //         $temp_check_flag = 1;
        //     }else{
        //         $temp_check_flag = 0;
        //     }
        //     $data['temp_check'] = $temp_check_flag;
        if ($data['payroll_list']) {
            $data['confirmed'] = 1;
            $data['payroll_state'] = 1;
            $data['payroll_date'] = $payrollMonth;
            $data['title'] = "Payroll Info";
        } else {
            $data['payroll_list'] = $this->payroll_model->employeeTempPayrollList1($payrollMonth, "allowance_logs", "deduction_logs", "loan_logs", "payroll_logs", "temp_arrears");
            $data['confirmed'] = 1;
            $data['payroll_state'] = 1;
            $data['payroll_date'] = $payrollMonth;
            $data['title'] = "Payroll Info";
        }
        return view('app.less_payments', $data);
    }

    public function less_payments_print(Request $request)
    {

        $payrollMonth = base64_decode($request->input('pdate'));
        $data['employee_list'] = $this->reports_model->temp_pay_checklist($payrollMonth);
        $data['authorization'] = $this->reports_model->payrollAuthorization($payrollMonth);
        //$data['employee_list'] =  $this->payroll_model->employeeTempPayrollList($payrollMonth, "temp_allowance_logs", "temp_deduction_logs", "temp_loan_logs", "temp_payroll_logs", "temp_arrears");
        $data['info'] = $this->reports_model->company_info();

        $employee_list = $this->reports_model->temp_pay_checklist($payrollMonth);
        $authorization = $this->reports_model->payrollAuthorization($payrollMonth);
        //$data['employee_list'] =  $this->payroll_model->employeeTempPayrollList($payrollMonth, "temp_allowance_logs", "temp_deduction_logs", "temp_loan_logs", "temp_payroll_logs", "temp_arrears");
        $info = $this->reports_model->company_info();
        if ($data['employee_list']) {

            $toDate = date('Y-m-d');
            $data['confirmed'] = 1;
            $data['payroll_date'] = $payrollMonth;
            $data['title'] = "Payroll Info";
            $data['take_home'] = $this->reports_model->sum_take_home($payrollMonth);
            $data['payroll_totals'] = $this->payroll_model->payrollTotals("temp_payroll_logs", $payrollMonth);
            $data['total_allowances'] = $this->payroll_model->total_allowances("temp_allowance_logs", $payrollMonth);
            $data['total_bonuses'] = $this->payroll_model->total_bonuses($payrollMonth);
            $data['total_loans'] = $this->payroll_model->total_loans("temp_loan_logs", $payrollMonth);
            $data['total_deductions'] = $this->payroll_model->total_deductions("temp_deduction_logs", $payrollMonth);
            $data['total_overtimes'] = $this->payroll_model->total_overtimes($payrollMonth);
            $data['payroll_date'] = $payrollMonth;
            $data['payroll_month'] = $payrollMonth;

            $data['total_heslb'] = $this->payroll_model->total_heslb("loan_logs", $payrollMonth);

            $confirmed = 1;
            $payroll_date = $payrollMonth;
            $title = "Payroll Info";
            $take_home = $this->reports_model->sum_take_home($payrollMonth);
            $payroll_totals = $this->payroll_model->payrollTotals("temp_payroll_logs", $payrollMonth);
            $total_allowances = $this->payroll_model->total_allowances("temp_allowance_logs", $payrollMonth);
            $total_bonuses = $this->payroll_model->total_bonuses($payrollMonth);
            $total_loans = $this->payroll_model->total_loans("temp_loan_logs", $payrollMonth);
            $total_deductions = $this->payroll_model->total_deductions("temp_deduction_logs", $payrollMonth);
            $total_overtimes = $this->payroll_model->total_overtimes($payrollMonth);
            $payroll_date = $payrollMonth;
            $payroll_month = $payrollMonth;

            $account_nototal_heslb = $this->payroll_model->total_heslb("loan_logs", $payrollMonth);
        } else {
            $data['authorization'] = $this->reports_model->payrollAuthorization($payrollMonth);
            $toDate = date('Y-m-d');
            $data['employee_list'] = $this->reports_model->pay_checklist($payrollMonth);
            //$data['employee_list'] =  $this->payroll_model->employeeTempPayrollList1($payrollMonth, "allowance_logs", "deduction_logs", "loan_logs", "payroll_logs", "temp_arrears");
            $data['confirmed'] = 1;
            $data['payroll_date'] = $payrollMonth;
            $data['title'] = "Payroll Info";
            $data['take_home'] = $this->reports_model->sum_take_home($payrollMonth);
            $data['payroll_totals'] = $this->payroll_model->payrollTotals("payroll_logs", $payrollMonth);
            $data['total_allowances'] = $this->payroll_model->total_allowances("allowance_logs", $payrollMonth);
            $data['total_bonuses'] = $this->payroll_model->total_bonuses($payrollMonth);
            $data['total_loans'] = $this->payroll_model->total_loans("loan_logs", $payrollMonth);
            $data['total_deductions'] = $this->payroll_model->total_deductions("deduction_logs", $payrollMonth);
            $data['total_overtimes'] = $this->payroll_model->total_overtimes($payrollMonth);
            $data['payroll_date'] = $payrollMonth;
            $data['payroll_month'] = $payrollMonth;
            $data['total_heslb'] = $this->payroll_model->total_heslb("loan_logs", $payrollMonth);

            $authorization = $this->reports_model->payrollAuthorization($payrollMonth);
            $toDate = date('Y-m-d');
            $employee_list = $this->reports_model->pay_checklist($payrollMonth);
            //$employee_list =  $this->payroll_model->employeeTempPayrollList1($payrollMonth, "allowance_logs", "deduction_logs", "loan_logs", "payroll_logs", "temp_arrears");
            $confirmed = 1;
            $payroll_date = $payrollMonth;
            $title = "Payroll Info";
            $take_home = $this->reports_model->sum_take_home($payrollMonth);
            $payroll_totals = $this->payroll_model->payrollTotals("payroll_logs", $payrollMonth);
            $total_allowances = $this->payroll_model->total_allowances("allowance_logs", $payrollMonth);
            $total_bonuses = $this->payroll_model->total_bonuses($payrollMonth);
            $total_loans = $this->payroll_model->total_loans("loan_logs", $payrollMonth);
            $total_deductions = $this->payroll_model->total_deductions("deduction_logs", $payrollMonth);
            $total_overtimes = $this->payroll_model->total_overtimes($payrollMonth);
            $payroll_date = $payrollMonth;
            $payroll_month = $payrollMonth;
            $total_heslb = $this->payroll_model->total_heslb("loan_logs", $payrollMonth);
        }

        include app_path() . '/reports/payroll_info_view.php';
    }

    public function concatArrays($arrays)
    {
        $buf = [];
        foreach ($arrays as $arr) {
            foreach ($arr as $v) {
                $buf[$v->empID] = $v;
            }
        }

        return $buf;
    }

    public function grossReconciliation(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);
        if (isset($payrollMonth)) {
            $current_payroll_month = $payrollMonth;
            $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
            $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

            $payroll_employees1 = $this->reports_model->payrollEmployee_temp($current_payroll_month, $previous_payroll_month);
            $payroll_employees2 = $this->reports_model->payrollEmployee_temp1($current_payroll_month, $previous_payroll_month);
            $total_previous_gross = $this->reports_model->grossMonthly_temp1($previous_payroll_month);
            $total_current_gross = $this->reports_model->grossMonthly_temp($current_payroll_month);

            $payroll_employees = array_values($this->concatArrays([$payroll_employees1, $payroll_employees2]));

            foreach ($payroll_employees as $employee) {

                $data['current_payroll'][$employee->empID] = $this->reports_model->employeeGross_temp($current_payroll_month, $employee->empID);
                $data['previous_payroll'][$employee->empID] = $this->reports_model->employeeGross_temp1($previous_payroll_month, $employee->empID);
            }

            $data['emp_ids'] = $payroll_employees;
            $data['total_previous_gross'] = $total_previous_gross;
            $data['total_current_gross'] = $total_current_gross;
            $data['title'] = "Gross Reconciliation";
            $data['parent'] = "Payroll";
            $data['child'] = "Gross Reconciliation";

            return view('app.gross_recon', $data);
        }
    }

    public function netReconciliation(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);
        if (isset($payrollMonth)) {
            $current_payroll_month = $payrollMonth;
            $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
            $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

            $payroll_employees1 = $this->reports_model->payrollEmployee_temp($current_payroll_month, $previous_payroll_month);
            $payroll_employees2 = $this->reports_model->payrollEmployee_temp1($current_payroll_month, $previous_payroll_month);
            $total_previous_net = $this->reports_model->temp_sum_take_home1($previous_payroll_month);
            $total_current_net = $this->reports_model->temp_sum_take_home($current_payroll_month);

            $payroll_employees = array_values($this->concatArrays([$payroll_employees1, $payroll_employees2]));

            foreach ($payroll_employees as $employee) {

                $data['current_payroll'][$employee->empID] = $this->reports_model->employeeNetTemp($current_payroll_month, $employee->empID);
                $data['previous_payroll'][$employee->empID] = $this->reports_model->employeeNetTemp1($previous_payroll_month, $employee->empID);
            }

            $data['emp_ids'] = $payroll_employees;
            $data['total_previous_net'] = $total_previous_net;
            $data['total_current_net'] = $total_current_net;

            //            echo json_encode($data);

            return view('app.net_recon', $data);
        }
    }

    public function sendReviewEmail(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);

        if (isset($payrollMonth)) {
            $empID = auth()->user()->emp_id;
            /*hr*/
            if (session('mng_paym')) {
                $hr = '%569acdfijkmnr%';
                $roles = $this->payroll_model->role($hr);
                if ($roles) {
                    foreach ($roles as $role) {
                        $employees = $this->payroll_model->employeeRole($role->id);
                        if ($employees) {
                            foreach ($employees as $employee) {
                                if ($employee->empID != $empID) {
                                    if ($employee->email) {
                                        //                                        $empEmail,$empName,$email,$subject,$message
                                        $message = "<p>Hello <b>" . $employee->fname . "</b>,</p>
                    <p>Be informed payroll of : <b>" . $payrollMonth . "</b> has been prepared by <b>" . session('fname') . "</b> and ready for your review</p>
                    Please visit <a href =" . base_url() . 'index.php/cipay/approved_financial_payments' . " >Fléx Performance</a>
                    <p>
                        <br><br>
                        Thank you,<br>
                        Fléx Performance.
                        </p>";
                                        $this->sendMail(
                                            session('email'),
                                            session('fname'),
                                            $employee->email,
                                            'Reviewed Payroll',
                                            $message
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }

            /*finance*/
            if (session('recom_paym')) {
                $fn = '%8ghop%';
                $roles = $this->payroll_model->role($fn);
                if ($roles) {
                    foreach ($roles as $role) {
                        $employees = $this->payroll_model->employeeRole($role->id);
                        if ($employees) {
                            foreach ($employees as $employee) {
                                if ($employee->empID != $empID) {
                                    if ($employee->email) {
                                        $message = "<p>Hello <b>" . $employee->fname . "</b>,</p>
                    <p>Be informed payroll of : <b>" . $payrollMonth . "</b> has been recommended by <b>" . session('fname') . "</b> and ready for your review</p>
                    Please visit <a href =" . base_url() . 'index.php/cipay/approved_financial_payments' . " >Fléx Performance</a>
                    <p>
                        <br><br>
                        Thank you,<br>
                        Fléx Performance.
                        </p>";
                                        $this->sendMail(
                                            session('email'),
                                            session('fname'),
                                            $employee->email,
                                            'Reviewed Payroll',
                                            $message
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }

            /*director*/
            if (session('appr_paym')) {
                $dr = '%lq%';
                $roles = $this->payroll_model->role($dr);
                if ($roles) {
                    foreach ($roles as $role) {
                        $employees = $this->payroll_model->employeeRole($role->id);
                        if ($employees) {
                            foreach ($employees as $employee) {
                                if ($employee->empID != $empID) {
                                    if ($employee->email) {
                                        $message = "<p>Hello <b>" . $employee->fname . "</b>,</p>
                    <p>Be informed payroll of : <b>" . $payrollMonth . "</b> has been reviewed by <b>" . session('fname') . "</b> and approved</p>
                    <p>
                        <br><br>
                        Thank you,<br>
                        Fléx Performance.
                        </p>";
                                        $this->sendMail(
                                            session('email'),
                                            session('fname'),
                                            $employee->email,
                                            'Reviewed Payroll',
                                            $message
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getComment($date)
    {

        $data = $this->flexperformance_model->get_comment($date);

        return json_encode($data);
    }

    public function sendMail($empEmail, $empName, $email, $subject, $message)
    {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load(); // PHPMailer object

        $senderInfo = $this->payroll_model->senderInfo();

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
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = $smtpsecure;
        $mail->Port = $port;

        $mail->setFrom($senderEmail, $senderName);
        $mail->addReplyTo($empEmail, $empName);

        // Add a recipient
        $mail->addAddress($email);

        // Email subject
        $mail->Subject = $subject;

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = $message;
        $mail->Body = $mailContent;

        if (!$mail->send()) {
            //            echo 'Mail error';
            //            echo 'Mailer Error: ' . $mail->ErrorInfo;
            // session::put('email_sent') = 'false';
            session(['email_sent' => 'false']);
            //    return redirect(Request::server('HTTP_REFERER'));
            return redirect()->back();
        } else {
            //            $response_array['status'] = 'SENT';
            //            echo json_encode($response_array);
            // session::put('email_sent') = 'true';
            session(['email_sent' => 'true']);
            // return redirect(Request::server('HTTP_REFERER'));
            return redirect()->back();
        }
    }

    public function comission_bonus()
    {
        if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {
            $data['bonus'] = $this->payroll_model->selectBonus();
            $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
            $data['incentives'] = $this->payroll_model->employee_bonuses();
            $data['employee'] = $this->payroll_model->customemployee();
            $data["title"] = "Comission and Bonuses";
            $data["parent"] = "Payroll";
            $data["child"] = "Incentives";

            return view('app.comission_bonus', $data);
        } else {
            echo "Unauthorized Access";
        }
    }

    public function partial_payment()
    {
        // if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {
        $data['bonus'] = $this->payroll_model->selectBonus();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['incentives'] = $this->payroll_model->employee_bonuses();
        $data['employee'] = $this->payroll_model->customemployee();
        $data['partial_payments'] = $this->payroll_model->partial_payment_list();
        $title = "Comission and Bonuses";
        $parent = "Comission and Bonuses";
        $child = "Comission and Bonuses";

        return view('payroll.partial_payment', compact('title', 'parent', 'child', 'data'));
        // } else {
        //     echo "Unauthorized Access";
        // }
    }

    public function salary_calculator()
    {
        if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {
            $data['allowances'] = $this->payroll_model->selectAllowances();
            $data['pensions'] = $this->payroll_model->pensionAll();
            $data['title'] = "Salary Calculator";
            return view('app.salary_calculator', $data);
        } else {
            echo 'Unauthorised Access';
        }
    }

    public function calculateSalary()
    {
        if ($_POST) {

            $type = $request->input('pay_type');
            $gross = $allowancePayment = $pension = $rate = $excess_added = $minimum = $totalPay = 0;
            $allowances = $request->input('allowances');
            $pensionFund = $request->input('pension');
            $salary = $request->input('basic_salary');

            foreach ($allowances as $key => $value) {
                $allowancePayment += $this->payroll_model->getAllowanceAmount($salary, $value);
            }

            if ($pensionFund == 2) {
                $pensionDeduction = $this->payroll_model->getPensionAmount($pensionFund);
                foreach ($pensionDeduction as $row) {
                    if ($row->deduction_from == 1) {
                        $pension = $salary * $row->amount_employee;
                    } else {
                        $pension = ($salary + $allowancePayment) * $row->amount_employee;
                    }
                }
            } else {
                $pension = 0;
            }
            $insurance = ($this->payroll_model->getHealthInsuranceAmount() * $salary);

            $taxableAmount = ($salary + $allowancePayment - $pension);
            $payeRates = $this->payroll_model->getPayeAmount($taxableAmount);
            foreach ($payeRates as $row) {
                $rate = $row->rate;
                $excess_added = $row->excess_added;
                $minimum = $row->minimum;
            }

            $paye = ($rate * ($taxableAmount - $minimum)) + $excess_added;
            if ($type == 1) {
                $totalPay = ($salary + $allowancePayment) - ($pension + $insurance + $paye);
            } else {
                $totalPay = ($salary + $allowancePayment) - ($pension + $insurance + $paye);
            }

            // echo "Salary: ".$salary."<br>";
            // echo "Allowance: ".$allowancePayment."<br>";
            // echo "Pension: ".$pension."<br>";
            // echo "Health Insurance: ".$insurance."<br>";
            // echo "PAYE: ".$paye."<br>";
            // echo "TAKE HOME: ".$takeHome."<br>";

            if ($totalPay) {
                echo "<h4 class='modal-title' id='amountTakeHome'><b>Net pay: " . number_format($totalPay, 2) . " /=<br><br></h4>";
            } else {
                echo "Failed To Calculate Salary";
            }
        }
    }

    public function recommendpayrollByFinance($pdate, $message)
    {

        $payrollMonth = $pdate;
        $state = 1;

        if ($payrollMonth != "") {
            $empID = auth()->user()->emp_id;
            $todate = date('Y-m-d');

            $check = $this->payroll_model->pendingPayrollCheck();
            if ($check > 0) {
                $result = $this->payroll_model->recommendPayroll($empID, $todate, $state, $message);
                if ($result == true) {
                    // recommend to Head of Finance email
                    $position_data = SysHelpers::position('Managing Director');

                    if ($position_data) {

                        $fullname = $position_data['full_name'];
                        $email_data = array(
                            'subject' => 'Payroll Run Notification',
                            'view' => 'emails.head-human.notification',
                            'email' => $position_data['email'],
                            'full_name' => $fullname,
                        );

                        //kmarealle@bancabc.co.tz
                        Notification::route('mail', $email_data['email'])->notify(new EmailRequests($email_data));

                    }

                    $description = "Recommendation of payroll of date " . $todate;

                    //  $result = SysHelpers::auditLog(1,$description,$request);

                    $response_array['status'] = "OK";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Payroll was Recommended Successifully </p>";
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED! Payroll NOT Recommended, Please Try again, If the Error persists Contact Your System Admin</p>";
                }
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-warning text-center'>Sorry The Payroll for This Month is Already Procesed, Try another Month!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }
    public function recommendpayrollByHr($pdate, $message)
    {

        $payrollMonth = $pdate;
        $state = 3;

        if ($payrollMonth != "") {
            $empID = auth()->user()->emp_id;
            $todate = date('Y-m-d');

            $check = $this->payroll_model->pendingPayrollCheck();
            if ($check > 0) {
                $result = $this->payroll_model->recommendPayroll($empID, $todate, $state, $message);
                if ($result == true) {
                    // recommend to Head of HR email
                    $position_data = SysHelpers::position('Country Head: Finance & Procurement');

                    $fullname = $position_data['full_name'];
                    $email_data = array(
                        'subject' => 'Payroll Run Notification',
                        'view' => 'emails.head-human.notification',
                        'email' => $position_data['email'],
                        'full_name' => $fullname,
                    );

                    //kmarealle@bancabc.co.tz
                    Notification::route('mail', $email_data['email'])->notify(new EmailRequests($email_data));
                    // dd("Email sent successfully");
                    $description = "Recommendation of payroll of date " . $todate;

                    //  $result = SysHelpers::auditLog(1,$description,$request);

                    $response_array['status'] = "OK";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Payroll was Recommended Successifully </p>";
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED! Payroll NOT Recommended, Please Try again, If the Error persists Contact Your System Admin</p>";
                }
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-warning text-center'>Sorry The Payroll for This Month is Already Procesed, Try another Month!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function runpayroll($pdate)
    { //
        // return false;
        // $fullname = $position_data['full_name'];
        // $email_data = array(
        //     'subject' => 'Payroll Run Notification',
        //     'view' => 'emails.head-human.notification',
        //     'email' => $position_data['email'],
        //     'full_name' => $fullname,
        // );

        //kmarealle@bancabc.co.tz
        // Notification::route('mail', $email_data['email'])->notify(new EmailRequests($email_data));

        $payrollMonth = $pdate;
        if ($payrollMonth != "") {

            // DATE MANIPULATION
            $payroll_date = $payrollMonth;
            $payroll_month = date('Y-m', strtotime($payrollMonth));
            $todate = date('Y-m-d');
            $empID = auth()->user()->emp_id;

            $check = $this->payroll_model->payrollcheck($payroll_month);
            if ($check == 0) {
                $this->flexperformance_model->updatePartialPayment($payroll_date);
                $result = $this->payroll_model->run_payroll($payroll_date, $payroll_month, $empID, $todate);
                if ($result == true) {
                    //assignment task logs
                    $this->flexperformance_model->assignment_task_log($payroll_date);
                    //deduct the grant
                    /*code*/
                    //check for partial payments
                    $result = $this->partial_payment_manipulation($payroll_date);
                    if ($result) {

                        $description = "Approved payment of payroll of date " . $payroll_date;
                        //SENDING EMAIL BACK TO PREVIOUS RECOMMENDED EMPLOYEES
                        $position1 = "Country Head: Finance & Procurement";
                        $position2 = "Human Capital";
                        $position_data = SysHelpers::approvalEmp($position1, $position2);
                        // dd($position_data[3]->employees[0]);
                        foreach ($position_data as $position) {
                            # code...
                            foreach ($position->employees as $employee) {
                                $fullname = $employee->full_name;
                                $email_data = array(
                                    'subject' => 'Payroll Approval Notification',
                                    'view' => 'emails.payroll-approval',
                                    'email' => $employee->email,
                                    'full_name' => $fullname,
                                );
                                Notification::route('mail', $email_data['email'])->notify(new EmailRequests($email_data));
                            }
                        }

                        // dd('Email sent successfully');

                        //  $result = SysHelpers::auditLog(1,$description,$request);

                        $response_array['status'] = "OK";
                        $response_array['message'] = "<p class='alert alert-success text-center'>Payroll was Run and Approved Successifully (Loans, Deductions and Salaries Updated!)</p>";
                    }
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED! Payroll NOT Approved, Please Try again, If the Error persists Contact Your System Admin</p>";
                }
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-warning text-center'>Sorry The Payroll for This Month is Already Procesed, Try another Month!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    private function partial_payment_manipulation($payroll_date)
    {
        //pull all partial payment in present payroll
        $partial_payments = $this->flexperformance_model->presentPartialPayment($payroll_date);
        if ($partial_payments) {
            foreach ($partial_payments as $partial_payment) {
                $payroll_log = $this->flexperformance_model->employeePayrollLog($partial_payment->empID, $payroll_date);
                $employee_pension = $this->flexperformance_model->employeePension($payroll_log->pension_fund);
                $paye = $this->reports_model->paye();
                $employer_sdl = $this->payroll_model->sdl_contribution();
                $employer_wcf = $this->payroll_model->wcf_contribution();

                //get the tax rate
                $partial_salary = (($partial_payment->days * $payroll_log->salary) / 30);
                $partial_gross = $partial_salary + $payroll_log->allowances;
                $taxable_amount = ($partial_salary + $payroll_log->allowances) - (($partial_salary + $payroll_log->allowances) * $employee_pension->amount_employee);
                $less_tax = $taxable_amount;
                $tax_rate = 0;
                $excess_tax = 0;
                foreach ($paye as $item) {
                    switch ($payroll_log->salary) {
                        case ($item->minimum <= $taxable_amount) && ($taxable_amount <= $item->maximum):
                            $less_tax = $item->minimum;
                            $tax_rate = $item->rate;
                            $excess_tax = $item->excess_added;
                            break;
                    }
                }

                $partial_pension_employee = $partial_gross * $employee_pension->amount_employee;
                $partial_pension_employer = $partial_gross * $employee_pension->amount_employer;
                $partial_taxdue = ((($taxable_amount - $less_tax) * $tax_rate)) + $excess_tax;
                $partial_sdl = $partial_gross * $employer_sdl;
                $partial_wcf = $partial_gross * $employer_wcf;

                $data_update_payroll_log = array(
                    'salary' => $partial_salary,
                    'pension_employee' => $partial_pension_employee,
                    'pension_employer' => $partial_pension_employer,
                    'taxdue' => $partial_taxdue,
                    'sdl' => $partial_sdl,
                    'wcf' => $partial_wcf,
                );

                $this->flexperformance_model->updatePayrollLog($partial_payment->empID, $payroll_date, $data_update_payroll_log);
            }
            return true;
        } else {
            return true;
        }
    }

    public function generate_checklist(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);
        $result = false;
        if ($payrollMonth != '') {
            $updates = array(
                'pay_checklist' => 1,
            );

            $arrears = $this->payroll_model->approved_arrears();
            if ($arrears) {
                foreach ($arrears as $row) {
                    $amountPaid = $row->amount;
                    $amountAlreadyPaid = $row->paid;
                    $arrearID = $row->arrear_id;
                    $init = $row->init_by;
                    $confirmed = $row->confirmed_by;
                    $payment_date = $row->date_confirmed;
                    $payroll_date = $row->payroll_date;

                    $dataLogs = array(
                        'arrear_id' => $arrearID,
                        'amount_paid' => $amountPaid,
                        'init_by' => $init,
                        'confirmed_by' => $confirmed,
                        'payment_date' => $payment_date,
                        'payroll_date' => $payrollMonth,
                    );

                    $dataUpdates = array(
                        'paid' => $amountPaid + $amountAlreadyPaid,
                        'amount_last_paid' => $amountPaid,
                        'last_paid_date' => $payment_date,
                    );
                    $result = $this->payroll_model->update_payroll_month_only($updates, $payrollMonth, $arrearID, $dataLogs, $dataUpdates);
                }
            } else {
                $result = $this->payroll_model->update_payroll_month_only($updates, $payrollMonth);
            }
            if ($result == true) {
                $position_data = SysHelpers::position('Country Head: Human Capital');

                $fullname = $position_data['full_name'];
                $email_data = array(
                    'subject' => 'Payroll Run Notification',
                    'view' => 'emails.head-human.notification',
                    'email' => $position_data['email'],
                    'full_name' => $fullname,
                );

                //kmarealle@bancabc.co.tz
                Notification::route('mail', $email_data['email'])->notify(new EmailRequests($email_data));
                $description = "Generating checklist of full payment of payroll of date " . $payrollMonth;
                //$result = SysHelpers::auditLog(2,$description,$request);

                $response_array['status'] = 1;
                $response_array['message'] = "<p class='alert alert-success text-center'>Pay Checklist Generated)</p>";
            } else {
                $response_array['status'] = 0;
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED! Payroll Checklist NOT Generated, Please Try again, If the Error persists Contact Your System Admin</p>";
            }
        } else {
            $response_array['status'] = 0;
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED! No Payroll Month addressed, Payroll Checklist NOT Generated, Please Try again, If the Error persists Contact Your System Admin</p>";
        }
        header('Content-type: application/json');
        return $response_array;
    }

    public function arrearsPayment()
    {
        if ($_POST) {
            $result = false;
            $empID = $request->input('empID');
            $counts = $request->input('arrears_counts');
            $payment_date = date('Y-m-d');
            $arrears = $this->payroll_model->approved_arrears();

            foreach ($arrears as $row) {
                $amountPaid = $row->amount;
                $amountAlreadyPaid = $row->paid;
                $arrearID = $row->arrear_id;
                $init = $row->init_by;
                $confirmed = $row->confirmed_by;
                $payment_date = $row->date_confirmed;

                $dataLogs = array(
                    'arrear_id' => $arrearID,
                    'amount_paid' => $amountPaid,
                    'init_by' => $init,
                    'confirmed_by' => $confirmed,
                    'payment_date' => $payment_date,
                );

                $dataUpdates = array(
                    'paid' => $amountPaid + $amountAlreadyPaid,
                    'amount_last_paid' => $amountPaid,
                    'last_paid_date' => $payment_date,
                );
                $result = $this->payroll_model->arrearsPayment($arrearID, $dataLogs, $dataUpdates);
            }

            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Arrears Payment Has Scheduled Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED! Arrears Payment Has Failed, Please Try again, If the Error persists Contact Your System Admin</p>";
            }
        }
    }

    public function temp_submitLessPayments()
    {
        $payrollMonth = $request->input('payroll_date');
        $result = false;
        $updates = array(
            'arrears' => 1,
            'pay_checklist' => 1,
        );
        $empList = $this->payroll_model->employeePayrollList($payrollMonth, "temp_allowance_logs", "temp_deduction_logs", "temp_loan_logs", "temp_payroll_logs");
        foreach ($empList as $row) {
            $empID = $row->empID;
            $expected_takehome = $request->input('expected_takehome' . $empID);
            $actual_takehome = $request->input('actual_takehome' . $empID);
            if ($expected_takehome == $actual_takehome) {
                continue;
            }

            $update_arrears = array(
                'empID' => $empID,
                'amount' => $expected_takehome - $actual_takehome,
                'paid' => 0,
                'amount_last_paid' => 0,
                'last_paid_date' => date("Y-m-d"),
                'payroll_date' => $payrollMonth,
            );
            $update_payroll_months = array(
                'arrears' => 1,
                'pay_checklist' => 1,
            );
            $update_payroll_logs = array(
                'less_takehome' => $expected_takehome - $actual_takehome,
            );
            $result = $this->payroll_model->temp_lessPayments($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth);
        }

        if ($result == true) {
            $logData = array(
                'empID' => auth()->user()->emp_id,
                'description' => "Generating checklist with arrears payment of payroll of date " . $payrollMonth,
                'agent' => session('agent'),
                'platform' => $this->agent->platform(),
                'ip_address' => $this->input->ip_address(),
            );

            $result = $this->flexperformance_model->insertAuditLog($logData);

            $response_array['status'] = 1;
            $response_array['message'] = "<p class='alert alert-success text-center'>Pay Checklist Generated)</p>";
        } else {
            $response_array['status'] = 0;
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed! Payroll Checklist NOT Generated, Please Try again, If the Error persists Contact Your System Admin</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    public function submitLessPayments()
    {
        $payrollMonth = $request->input('payroll_date');
        $result = false;
        $updates = array(
            'arrears' => 1,
            'pay_checklist' => 1,
        );
        $empList = $this->payroll_model->employeePayrollList($payrollMonth, "allowance_logs", "deduction_logs", "loan_logs", "payroll_logs");
        foreach ($empList as $row) {
            $empID = $row->empID;
            $expected_takehome = $request->input('expected_takehome' . $empID);
            $actual_takehome = $request->input('actual_takehome' . $empID);
            if ($expected_takehome == $actual_takehome) {
                continue;
            }

            $update_arrears = array(
                'empID' => $empID,
                'amount' => $expected_takehome - $actual_takehome,
                'paid' => 0,
                'amount_last_paid' => 0,
                'last_paid_date' => date("Y-m-d"),
                'payroll_date' => $payrollMonth,
            );
            $update_payroll_months = array(
                'arrears' => 1,
                'pay_checklist' => 1,
            );
            $update_payroll_logs = array(
                'less_takehome' => $expected_takehome - $actual_takehome,
            );
            $result = $this->payroll_model->lessPayments($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth);
        }

        if ($result == true) {
            $logData = array(
                'empID' => auth()->user()->emp_id,
                'description' => "Generating checklist with arrears payment of payroll of date " . $payrollMonth,
                'agent' => session('agent'),
                'platform' => $this->agent->platform(),
                'ip_address' => $this->input->ip_address(),
            );

            $result = $this->flexperformance_model->insertAuditLog($logData);

            $response_array['status'] = 1;
            $response_array['message'] = "<p class='alert alert-success text-center'>Pay Checklist Generated)</p>";
        } else {
            $response_array['status'] = 0;
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED! Payroll Checklist NOT Generated, Please Try again, If the Error persists Contact Your System Admin</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    public function arrearsPayment_schedule()
    {
        if ($_POST) {
            $result = false;
            $empID = $request->input('empID');
            $counts = $request->input('arrears_counts');
            $payment_date = date('Y-m-d');
            for ($i = 1; $i <= $counts; $i++) {
                $amountPaid = $request->input('amount_pay' . $i);
                $amountAlreadyPaid = $request->input('amount_already_paid' . $i);
                $max_amount = $request->input('max_amount' . $i);
                $arrearID = $request->input('arrearID' . $i);

                if ($amountPaid > 0) {
                    $isExists = $this->payroll_model->checkPendingArrearPayment($arrearID);
                    if ($isExists) {
                        $updates = array(
                            'amount' => $amountPaid,
                            'status' => 0,
                            'confirmed_by' => "",
                        );
                        $result = $this->payroll_model->updatePendingArrear($arrearID, $updates);
                    } else {

                        $data = array(
                            'arrear_id' => $arrearID,
                            'amount' => $amountPaid,
                            'init_by' => auth()->user()->emp_id,
                            'date_confirmed' => $payment_date,
                        );

                        $result = $this->payroll_model->arrearsPayment_schedule($data);
                    }
                }
            }

            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Arrears Payment Has Scheduled Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED! Arrears Payment Has Failed, Please Try again, If the Error persists Contact Your System Admin</p>";
            }
        }
    }

    public function monthlyArrearsPayment_schedule()
    {
        $payroll_month = $request->input('payroll_month');
        $payment_date = date('Y-m-d');
        $employees = $this->payroll_model->monthly_arrears($payroll_month);
        $result = false;
        foreach ($employees as $employee) {
            $arrearID = $employee->id;
            $outstanding = $employee->amount - $employee->paid;
            $isExists = $this->payroll_model->checkPendingArrearPayment($arrearID);
            if ($isExists) {
                $updates = array(
                    'amount' => $outstanding,
                    'status' => 0,
                    'confirmed_by' => "",
                );
                $result = $this->payroll_model->updatePendingArrear($arrearID, $updates);
            } else {
                $data = array(
                    'arrear_id' => $arrearID,
                    'amount' => ($employee->amount - $employee->paid),
                    'init_by' => auth()->user()->emp_id,
                    'date_confirmed' => $payment_date,
                );

                $result = $this->payroll_model->arrearsPayment_schedule($data);
            }
        }
        if ($result == true) {
            //$this->flexperformance_model->audit_log("Requested Deactivation of an Employee with ID =".$empID."");
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Deactivation Request For This Employee Has Been Sent Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Deactivation Request Not Sent</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function cancelArrearsPayment()
    {

        if ($this->uri->segment(3) != '') {
            $updates = array(
                'status' => 0,
                'confirmed_by' => auth()->user()->emp_id,
            );

            $arrearID = $this->uri->segment(3);
            $result = $this->payroll_model->confirmPendingArrear($arrearID, $updates);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Arrears Payment Cancelled Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
            }
        }
    }

    public function confirmArrearsPayment()
    {

        if ($this->uri->segment(3) != '') {
            $updates = array(
                'status' => 1,
                'confirmed_by' => auth()->user()->emp_id,
            );

            $arrearID = $this->uri->segment(3);

            $result = $this->payroll_model->confirmPendingArrear($arrearID, $updates);

            $arrear = $this->payroll_model->getArrear($arrearID);

            if ($arrear) {
                foreach ($arrear as $arr) {

                    //                $arrear1 = $this->payroll_model->getArrear1($arr->arrear_id);
                    //
                    //                $arrear_log_data = array(
                    //                    'arrear_id' => $arr->arrear_id,
                    //                    'amount_paid' => $arr->amount,
                    //                    'init_by' => $arr->init_by,
                    //                    'confirmed_by' => $arr->confirmed_by,
                    //                    'payment_date' => $arr->date_confirmed,
                    //                    'payroll_date' => $arrear1[0]->payroll_date
                    //                );
                    //
                    //                $this->payroll_model->insertArrearLog($arrear_log_data);

                    $arrear_logs = $this->payroll_model->getArrearLog($arr->arrear_id);

                    if ($arrear_logs) {
                        $total_paid = 0;
                        $last_paid = 0;
                        foreach ($arrear_logs as $arrear_log) {
                            $total_paid += $arrear_log->amount_paid;
                            $last_paid = $arrear_log->amount_paid;
                        }

                        $arrears_update = array(
                            'paid' => $total_paid,
                            'amount_last_paid' => $last_paid,
                        );
                        $this->payroll_model->updateArrear($arrear[0]->arrear_id, $arrears_update);
                    }
                }
            }

            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Arrears Payment Confirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
            }
        }
    }

    public function recommendArrearsPayment()
    {

        if ($this->uri->segment(3) != '') {
            $updates = array(
                'status' => 2,
                'recommended_by' => auth()->user()->emp_id,
            );

            $arrearID = $this->uri->segment(3);
            $result = $this->payroll_model->confirmPendingArrear($arrearID, $updates);
            if ($result == true) {

                $logData = array(
                    'empID' => auth()->user()->emp_id,
                    'description' => "Recommendation of Arreas on date " . date('Y-m-d'),
                    'agent' => session('agent'),
                    'platform' => $this->agent->platform(),
                    'ip_address' => $this->input->ip_address(),
                );

                $result = $this->flexperformance_model->insertAuditLog($logData);

                echo "<p class='alert alert-success text-center'>Arrears Payment Confirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
            }
        }
    }

    public function cancelpayroll($type)
    {


        // dd("I am here");
        //dd($type);
        /*get the payroll month*/
        $result_month = $this->payroll_model->getPayrollMonth1();
        $this_payroll = $this->payroll_model->payrollMonthListpending();
        $payroll_id = $this_payroll[0]->id;

        $cancel_date='';
        foreach ($result_month as $item) {
            $cancel_date = $item->payroll_date;
        }
        foreach ($this_payroll as $item) {
            $payroll_id = $item->id;
        }

        $initial_delete = $this->payroll_model->deleteArrears($cancel_date);
        if ($initial_delete) {
            $result = $this->payroll_model->cancel_payroll();
            if ($type == 'none') {

                return redirect(route('payroll.payroll'));
            }
            if ($result == true) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Payroll CANCELLED Successfully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED! Payroll NOT Approved, Please Try again, If the Error persists Contact Your System Admin</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED! Payroll NOT Approved, Please Try again, If the Error persists Contact Your System Admin</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    ############################################################################
    ################## SEND EMPLOYEE PAYSLIP VIA PHP MAILER ####################

    public function temp_payroll_review()
    {
        $empID = base64_decode($request->input('id'));
        $payrollMonth = base64_decode($request->input('pdate'));
        if ($empID == '') {
        } else {
            $data['overall_review'] = $this->payroll_model->payroll_review($empID, "temp_payroll_logs", $payrollMonth);
            $data['allowances_review'] = $this->payroll_model->allowances_review($empID, "temp_allowance_logs", $payrollMonth);
            $data['deductions_review'] = $this->payroll_model->deductions_review($empID, "temp_deduction_logs", $payrollMonth);
            $data['loans_review'] = $this->payroll_model->loans_review($empID, "temp_loan_logs", $payrollMonth);
            $data['sdl_contribution'] = $this->payroll_model->sdl_contribution();
            $data['wcf_contribution'] = $this->payroll_model->wcf_contribution();

            $data['total_allowances'] = $this->payroll_model->total_allowances_review($empID, "temp_allowance_logs", $payrollMonth);
            $data['total_deductions'] = $this->payroll_model->total_deductions_review($empID, "temp_deduction_logs", $payrollMonth);
            $data['total_loans'] = $this->payroll_model->total_loans_review($empID, "temp_loan_logs", $payrollMonth);
            $data['title'] = "Payroll Preview";
            return view('app.payroll_review', $data);
        }
    }

    public function payroll_review()
    {
        $empID = base64_decode($request->input('id'));
        $payrollMonth = base64_decode($request->input('pdate'));
        if ($empID == '') {
        } else {
            $data['overall_review'] = $this->payroll_model->payroll_review($empID, "payroll_logs", $payrollMonth);
            $data['allowances_review'] = $this->payroll_model->allowances_review($empID, "allowance_logs", $payrollMonth);
            $data['deductions_review'] = $this->payroll_model->deductions_review($empID, "deduction_logs", $payrollMonth);
            $data['loans_review'] = $this->payroll_model->loans_review($empID, "loan_logs", $payrollMonth);
            $data['sdl_contribution'] = $this->payroll_model->sdl_contribution();
            $data['wcf_contribution'] = $this->payroll_model->wcf_contribution();

            $data['total_allowances'] = $this->payroll_model->total_allowances_review($empID, "allowance_logs", $payrollMonth);
            $data['total_deductions'] = $this->payroll_model->total_deductions_review($empID, "deduction_logs", $payrollMonth);
            $data['total_loans'] = $this->payroll_model->total_loans_review($empID, "loan_logs", $payrollMonth);
            $data['title'] = "Payroll Preview";
            return view('app.payroll_review', $data);
        }
    }

    public function send_payslip_email($date, $employee)
    {
        //dd($request->all());
        $empID = $employee->empID;
        //For redirecting Purpose

        // $profile = $request->input("profile"); //For redirecting Purpose
        $date_separate = explode("-", $date);

        $start = $date;

        $mm = $date_separate[1];
        $yyyy = $date_separate[0];
        $dd = $date_separate[2];
        $one_year_back = $date_separate[0] - 1;

        $payroll_date = $yyyy . "-" . $mm . "-" . $dd;
        $payroll_month_end = $yyyy . "-" . $mm . "-31";
        $payroll_month = $yyyy . "-" . $mm;

        $check = $this->reports_model->payslipcheck($payroll_month, $empID);

        $emp = Employee::where('emp_id', $empID)->first();
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
        $data['leaveBalance'] = $this->attendance_model->getLeaveBalance($empID, $emp->hire_date, $payroll_month_end);

        $data['payroll_date'] = $date;

        $date = explode('-', $payroll_date);
        $payroll_month = $date[0] . '-' . $date[1];

        $data['bank_loan'] = $this->reports_model->bank_loans($empID, $payroll_month);
        $data['total_bank_loan'] = $this->reports_model->sum_bank_loans($empID, $payroll_month);

        //include(app_path() . '/reports/customleave_report.php');
        // include app_path() . '/reports/payslip.php';

        //return view('payroll.payslip_details_pdf', $data);
        // $pdf = Pdf::loadView('payroll.payslip', $data)->setPaper('a4', 'potrait');

        $pdf = Pdf::loadView('payroll.payslip_details_pdf', $data)->setPaper('a4', 'potrait');

        // $pdf = Pdf::loadView('payroll.payslip2', $data)->setPaper('a4', 'potrait');

        // $pdf->stream('payslip_for_' . $empID . '.pdf'),

        $timestamp = strtotime($data['payroll_date']); // Convert the date to a Unix timestamp
        $monthName = date('F', $timestamp); // Get the month name

        // return $monthName;

        $email_data = array(
            'subject' => 'Payslip for ' . $monthName . ' ' . $date_separate[0],
            'view' => 'emails.payslip',
            'email' => "",
            'pdf' => $pdf,
            'month' => $monthName . ' ' . $date_separate[0],
            'full_name' => $emp->fname,
        );

        Notification::route('mail', $employee->email)->notify(new EmailPayslip($email_data));

        // $data_all['emp_id'] = $payroll_emp_ids;

        // return view('app.reports/payslip_all', $data_all);
    }

    public function send_payslips(Request $request)
    {

        $payrollDate = $request->input("payrollDate");
        //Get All Employee Emails
        // $payrollDate = $this->uri->segment(3);

        $employees = $this->payroll_model->send_payslips($payrollDate);
        $this->payroll_model->updatePayrollMail($payrollDate);
        $response_array = [];
        foreach ($employees as $employee) {

            $this->send_payslip_email($payrollDate, $employee);
        }
        echo json_encode($response_array);
    }

    public function mailConfiguration()
    {
        if (session('vw_settings')) {
            $data['mails'] = $this->payroll_model->mailConfig();
            $data['title'] = "Mail Configuration";
            return view('app.mail_config', $data);
        } else {
            echo "Unauthorized Access";
        }
    }

    public function saveMail()
    {
        if ($_POST) {
            $id = $request->input('id');
            $data = array(
                'host' => $request->input('host'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'name' => $request->input('name'),
                'secure' => $request->input('encryption'),
                'port' => $request->input('port'),
                'email' => $request->input('username'),
            );

            try {
                $transport = new Swift_SmtpTransport($request->input('host'), $request->input('port'), $request->input('encryption'));
                $transport->setUsername($request->input('username'));
                $transport->setPassword($request->input('password'));
                $mailer = new Swift_Mailer($transport);
                $mailer->getTransport()->start();

                $result = $this->payroll_model->saveMail($id, $data);

                if ($result > 0) {
                    $response_array['status'] = "OK";
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                } else {
                    $response_array['status'] = "ERR";
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }
            } catch (Exception $e) {
                $response_array['status'] = "ERRR";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function employeeFilter()
    {
        $type = $this->uri->segment(3);

        if ($type == 1) {
            $data = $this->payroll_model->customemployee();
        } else {
            $data = $this->payroll_model->customemployeeExit();
        }

        echo json_encode($data);
    }

    public function password_generator($size)
    {
        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
        $init = strlen($char);
        $init--;

        $result = null;

        for ($x = 1; $x <= $size; $x++) {
            $index = rand(0, $init);
            $result .= substr($char, $index, 1);
        }

        return $result;
    }

    public function TestMail()
    {
        $this->load->library('Phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'chi-node11.websitehostserver.net';
        $mail->SMTPAuth = true;
        //        $mail->SMTPDebug = 3;
        $mail->Username = 'flex@cits.co.tz';
        $mail->Password = 'cits@2020';

        //For server uses
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //For localhost uses
        // $mail->SMTPSecure = 'ssl';
        // $mail->Port     = 465;

        $mail->setFrom('flex@cits.co.tz', "My NAme is Miraji");
        $mail->addReplyTo('flex@cits.co.tz', 'CodexWorld');

        // Add a recipient
        $mail->addAddress('maricaneston38@gmail.com');

        // Add cc or bcc
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Email subject
        $mail->Subject = 'My Subject';

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "Hello!  Please Find The Attached Payslip For the  Payroll Month";
        $mail->Body = $mailContent;
        //$mail->AddStringAttachment($payslip, 'payslip.pdf');
        if (!$mail->send()) {
            echo 'Message could not be sent.<br>';
            echo 'Mailer Error: =><br>' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent SUCCESSIFULLY';
        }

        //echo $mail->send(); // Send email
    }
}
