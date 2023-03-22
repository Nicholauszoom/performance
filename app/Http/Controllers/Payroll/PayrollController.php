<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Payroll\ReportModel;
use App\Helpers\SysHelpers;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailRequests;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{

    protected $payroll_model;
    protected $reports_model;
    protected $flexperformance_model;

    public function __construct($payroll_model = null, $flexperformance_model = null, $reports_model = null)
    {
        $this->payroll_model = new Payroll();
        $this->reports_model = new ReportModel;
        $this->flexperformance_model = new FlexPerformanceModel;
    }


    public function initPayroll(Request $request)
    {

        if ($request->post()) {

            $pendingPayroll = $this->payroll_model->pendingPayrollCheck();

            if ($pendingPayroll > 0) {
                echo "<p class='alert alert-warning text-center'>FAILED! There is Pending Payroll which Needs To be Confirmed Before Another Payroll is Run</p>";
            } else {

                // DATE MANIPULATION
                $calendar = $request->payrolldate;
                $datewell = explode("/", $calendar);
                $mm = $datewell[1];
                $dd = $datewell[0];
                $yyyy = $datewell[2];
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
                            'payroll_date' => $payroll_date
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
                                    'amount_last_paid' => $last_paid
                                );
                                $this->payroll_model->updateArrear($arrear_id->arrear_id, $arrears_update);
                            }
                        }
                    }
                    $this->payroll_model->truncateArrearsPending();

                    if ($result == true) {
                        // $linemanager_data = SysHelpers::employeeData(auth()->user()->full_name);

                        $description  = "Run payroll of date " . $payroll_date;
                        // dd('Payroll Run and Email has been sent');
                        //$result = SysHelpers::auditLog(1,$description,$request);

                        echo "<p class='alert alert-info text-center'>Period Changed Successfull</p>";
                    } else {
                        echo "<p class='alert alert-danger text-center'>Failed To run the Payroll, Please Try again, If the Error persists Contact Your System Admin</p>";
                    }
                } else {
                    echo "<p class='alert alert-warning text-center'>" . $payroll_month . "Sorry The Payroll for This Month is Already Procesed, Try another Month!</p>";
                }
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
        if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {

            $title = 'Employee Payslip';
            $parent = 'Payroll';
            $child = 'Payslip';
            $data['payrollList'] = $this->payroll_model->payrollMonthList();
            $data['month_list'] = $this->payroll_model->payroll_month_list();
            $data['employee'] = $this->payroll_model->customemployee();

            return view('payroll.employee_payslip', compact('data', 'title', 'parent', 'child'));
        } else {
            echo 'Unauthorised Access';
        }
    }

    public function payroll()
    {
        // if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {



        $data['pendingPayroll_month'] = $this->payroll_model->pendingPayroll_month();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['payroll'] = $this->payroll_model->pendingPayroll();
        $data['pending_overtime'] = $this->flexperformance_model->pending_overtime();

        $data['payrollList'] = $this->payroll_model->payrollMonthList();
        $data['title'] = "Payroll";

        // dd($data['pendingPayroll']);
        //echo $data['pendingPayroll_month'];



        return view('payroll.payroll', [
            'data' => $data,
            'parent' => 'Payroll',
            'child' => 'Payroll'

        ]);

        // } else {
        //     echo 'Unauthorised Access';
        // }

    }

    public function payslip()
    {
        return view('payroll.payslip', [
            'parent' => 'Payroll',
            'child' => 'Payslip'
        ]);
    }

    public function incentives()
    {
        return view('payroll.incentives', [
            'parent' => 'Payroll',
            'child' => 'Incentives'
        ]);
    }

    public function partialPayment()
    {
        return view('payroll.partial-payment', [
            'parent' => 'Payroll',
            'child' => 'Partial Payment'
        ]);
    }


    public function temp_payroll_info(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);

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

        return view('payroll.payroll_info',$data);
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
        $reportType = 1;  //Staff = 1, temporary = 2
        $reportformat = $request->input('type'); //Staff = 1, temporary = 2
        $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
        $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

        // dd($previous_payroll_month_raw);
        $data['payroll_date'] = $request->payrolldate;
        $data['total_previous_gross'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;

        $data['total_current_gross'] = $this->reports_model->s_grossMonthly1($current_payroll_month);
        $data['count_previous_month'] = !empty($previous_payroll_month) ? $this->reports_model->s_count($previous_payroll_month):0;
        $data['count_current_month'] = $this->reports_model->s_count1($current_payroll_month);
        $data['total_previous_overtime'] = $this->reports_model->s_overtime1($previous_payroll_month);
        $data['total_current_overtime'] = $this->reports_model->s_overtime1($current_payroll_month);
        $data['terminated_employee'] = $this->reports_model->terminated_employee($previous_payroll_month);

        if($data['terminated_employee'] > 0){

            $data['termination_salary'] = $this->reports_model->terminated_salary($previous_payroll_month);


        }
        $total_allowances = $this->reports_model->total_allowance1($current_payroll_month, $previous_payroll_month);
        $descriptions = [];
         foreach($total_allowances as $row){
            if($row->allowance == "N-Overtime"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'N-Overtime');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);
            }elseif($row->allowance == "S-Overtime"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'S-Overtime');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);
            }
            elseif($row->allowance == "House Rent"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'house_allowance');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);

            }
            elseif($row->allowance == "Leave Allowance"){

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'leave_allowance');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);

            }
            elseif($row->allowance == "Teller Allowance"){

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'teller_allowance');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);

            }
            elseif($row->allowance == "Arrears"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'arreas');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);
            }
            elseif($row->allowance == "Long Serving allowance"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'long_serving');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);
            }

         }

         $all_terminal_allowance = $this->reports_model->all_terminated_allowance($current_payroll_month, $previous_payroll_month);

         $result = $this->arrayRecursiveDiff($all_terminal_allowance, $descriptions);

         foreach($result as $row){

           array_push($total_allowances,(object)['description'=>$row['description'],
                                        'allowance'=>$row['description'],
                                        'current_amount'=>$row['current_amount'],
                                       'previous_amount'=>$row['previous_amount'],
                                       'difference'=>$row['current_amount']-$row['previous_amount']]);
         }





         $data['total_allowances'] = $total_allowances;
        // $data['total_allowances'] = $this->reports_model->total_allowance($current_payroll_month, $previous_payroll_month);



        $data['total_previous_basic'] = !empty($previous_payroll_month) ? $this->reports_model->total_basic($previous_payroll_month) : 0;
        $data['total_current_basic'] = !empty($current_payroll_month) ? $this->reports_model->total_basic1($current_payroll_month) : 0;
//dd($data['total_current_basic'],$data['total_previous_basic']);
        $data['total_previous_net'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;
        $data['total_current_net'] = $this->reports_model->s_grossMonthly1($current_payroll_month);

        $data['current_decrease'] =  $this->reports_model->basic_decrease1($previous_payroll_month,$current_payroll_month);
       // dd($data['previous_decrease']);
       // $data['current_decrease'] = $this->reports_model->basic_decrease($current_payroll_month);

       // $data['previous_increase'] = $this->reports_model->basic_increase($previous_payroll_month);
        $data['current_increase'] = $this->reports_model->basic_increase1($previous_payroll_month,$current_payroll_month);


        $data['termination'] = $this->reports_model->get_termination($current_payroll_month);


        //$pdf = Pdf::loadView('reports.payroll_reconciliation_summary1', $data);
        // $pdf = Pdf::loadView('reports.payroll_details',$data);


        if($request->type == 1)
        return view('payroll.reconsiliation_summary', $data);

        $pdf = Pdf::loadView('reports.payroll_reconciliation_summary1',$data)->setPaper('a4', 'potrait');
        return $pdf->download('payroll_reconciliation_summary.pdf');

        //return $pdf->download('sam.pdf');
         //$pdf = Pdf::loadView('reports.payroll_reconciliation_summary1',$data)->setPaper('a4', 'potrait');

         //return $pdf->download('payroll_reconciliation_summary.pdf');
        //return view('reports.payroll_reconciliation_summary1', $data);

       // return view('reports.samplepdf', $data);
    //    dd($data['payroll_state']);
        return view('payroll.reconsiliation_summary', $data);
    }


    function arrayRecursiveDiff($aArray1, $aArray2) {
        $aReturn = array();
;
//bool in_array( $val, $array_name, $mode );
      for($i = 0;$i<count($aArray1); $i++){
        if(in_array($aArray1[$i]['description'], $aArray2)){
            Unset($aArray1[$i]);
           // dd($row['description']);
        }else{
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

        $current_payroll_month = $request->input('payrolldate');
        $reportType = 1;  //Staff = 1, temporary = 2
        $reportformat = $request->input('type'); //Staff = 1, temporary = 2
        $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
        $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

        // dd($previous_payroll_month_raw);
        $data['payroll_date'] = $request->payrolldate;
        $data['total_previous_gross'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;
        $data['total_current_gross'] = $this->reports_model->s_grossMonthly($current_payroll_month);
        $data['count_previous_month'] = !empty($previous_payroll_month) ? $this->reports_model->s_count($previous_payroll_month):0;
        $data['count_current_month'] = $this->reports_model->s_count($current_payroll_month);
        $data['total_previous_overtime'] = $this->reports_model->s_overtime($previous_payroll_month);
        $data['total_current_overtime'] = $this->reports_model->s_overtime($current_payroll_month);

        $total_allowances = $this->reports_model->total_allowance($current_payroll_month, $previous_payroll_month);
        $descriptions = [];
         foreach($total_allowances as $row){
            if($row->allowance == "N-Overtime"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'N-Overtime');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);
            }elseif($row->allowance == "S-Overtime"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'S-Overtime');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);
            }
            elseif($row->allowance == "House Rent"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'house_allowance');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);

            }
            elseif($row->allowance == "Leave Allowance"){

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'leave_allowance');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);

            }
            elseif($row->allowance == "Teller Allowance"){

                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'teller_allowance');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);

            }
            elseif($row->allowance == "Arrears"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'arreas');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);
            }
            elseif($row->allowance == "Long Serving allowance"){
                $allowance = $this->reports_model->total_terminated_allowance($current_payroll_month, $previous_payroll_month, 'long_serving');
                $row->current_amount +=$allowance[0]->current_amount;
                $row->current_amount +=$allowance[0]->current_amount;
                array_push($descriptions,$row->description);
            }

         }

         $all_terminal_allowance = $this->reports_model->all_terminated_allowance($current_payroll_month, $previous_payroll_month);

         $result = $this->arrayRecursiveDiff($all_terminal_allowance, $descriptions);

         foreach($result as $row){

           array_push($total_allowances,(object)['description'=>$row['description'],
                                        'allowance'=>$row['description'],
                                        'current_amount'=>$row['current_amount'],
                                       'previous_amount'=>$row['previous_amount'],
                                       'difference'=>$row['current_amount']-$row['previous_amount']]);
         }





         $data['total_allowances'] = $total_allowances;
        // $data['total_allowances'] = $this->reports_model->total_allowance($current_payroll_month, $previous_payroll_month);



        $data['total_previous_basic'] = !empty($previous_payroll_month) ? $this->reports_model->total_basic($previous_payroll_month) : 0;
        $data['total_current_basic'] = !empty($current_payroll_month) ? $this->reports_model->total_basic($current_payroll_month) : 0;

        $data['total_previous_net'] = !empty($previous_payroll_month) ? $this->reports_model->s_grossMonthly($previous_payroll_month) : 0;
        $data['total_current_net'] = $this->reports_model->s_grossMonthly($current_payroll_month);

        $data['current_decrease'] =  $this->reports_model->basic_decrease($previous_payroll_month,$current_payroll_month);
       // dd($data['previous_decrease']);
       // $data['current_decrease'] = $this->reports_model->basic_decrease($current_payroll_month);

       // $data['previous_increase'] = $this->reports_model->basic_increase($previous_payroll_month);
        $data['current_increase'] = $this->reports_model->basic_increase($previous_payroll_month,$current_payroll_month);


        $data['termination'] = $this->reports_model->get_termination($current_payroll_month);

        $data['payroll_state'] = $request->payrollState;



         if($request->type == 1)
         return view('payroll.reconsiliation_summary', $data);

         $pdf = Pdf::loadView('reports.payroll_reconciliation_summary1',$data)->setPaper('a4', 'potrait');
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







        return view('payroll.payroll_info',$data);
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
        $reportType = 1;  //Staff = 1, temporary = 2
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

    function concatArrays($arrays)
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

    function sendMail($empEmail, $empName, $email, $subject, $message)
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

    function calculateSalary()
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

    function recommendpayrollByFinance($pdate, $message)
    {

        $payrollMonth = $pdate;
        $state = 1;

        if ($payrollMonth != "") {
            $empID = session('emp_id');
            $todate = date('Y-m-d');

            $check = $this->payroll_model->pendingPayrollCheck();
            if ($check > 0) {
                $result = $this->payroll_model->recommendPayroll($empID, $todate, $state, $message);
                if ($result == true) {
                    // recommend to Head of Finance email
                    $position_data = SysHelpers::position('Managing Director');

                    $fullname = $position_data['full_name'];
                    $email_data = array(
                        'subject' => 'Payroll Run Notification',
                        'view' => 'emails.head-human.notification',
                        'email' => $position_data['email'],
                        'full_name' => $fullname,
                    );

                    //kmarealle@bancabc.co.tz
                    Notification::route('mail', $email_data['email'])->notify(new EmailRequests($email_data));

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
    function recommendpayrollByHr($pdate, $message)
    {

        $payrollMonth = $pdate;
        $state = 3;

        if ($payrollMonth != "") {
            $empID = session('emp_id');
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

    function runpayroll($pdate)
    {           //
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
            $empID = session('emp_id');

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
                    'wcf' => $partial_wcf
                );

                $this->flexperformance_model->updatePayrollLog($partial_payment->empID, $payroll_date, $data_update_payroll_log);
            }
            return true;
        } else {
            return true;
        }
    }

    function generate_checklist(Request $request)
    {
        $payrollMonth = base64_decode($request->pdate);
        $result = false;
        if ($payrollMonth != '') {
            $updates = array(
                'pay_checklist' => 1
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
                        'payroll_date' => $payrollMonth
                    );

                    $dataUpdates = array(
                        'paid' => $amountPaid + $amountAlreadyPaid,
                        'amount_last_paid' => $amountPaid,
                        'last_paid_date' => $payment_date
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
        return  $response_array;
    }

    function arrearsPayment()
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
                    'payment_date' => $payment_date
                );

                $dataUpdates = array(
                    'paid' => $amountPaid + $amountAlreadyPaid,
                    'amount_last_paid' => $amountPaid,
                    'last_paid_date' => $payment_date
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

    function temp_submitLessPayments()
    {
        $payrollMonth = $request->input('payroll_date');
        $result = false;
        $updates = array(
            'arrears' => 1,
            'pay_checklist' => 1
        );
        $empList = $this->payroll_model->employeePayrollList($payrollMonth, "temp_allowance_logs", "temp_deduction_logs", "temp_loan_logs", "temp_payroll_logs");
        foreach ($empList as $row) {
            $empID = $row->empID;
            $expected_takehome = $request->input('expected_takehome' . $empID);
            $actual_takehome = $request->input('actual_takehome' . $empID);
            if ($expected_takehome == $actual_takehome) continue;
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
                'pay_checklist' => 1
            );
            $update_payroll_logs = array(
                'less_takehome' => $expected_takehome - $actual_takehome
            );
            $result = $this->payroll_model->temp_lessPayments($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth);
        }


        if ($result == true) {
            $logData = array(
                'empID' => session('emp_id'),
                'description' => "Generating checklist with arrears payment of payroll of date " . $payrollMonth,
                'agent' => session('agent'),
                'platform' => $this->agent->platform(),
                'ip_address' => $this->input->ip_address()
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

    function submitLessPayments()
    {
        $payrollMonth = $request->input('payroll_date');
        $result = false;
        $updates = array(
            'arrears' => 1,
            'pay_checklist' => 1
        );
        $empList = $this->payroll_model->employeePayrollList($payrollMonth, "allowance_logs", "deduction_logs", "loan_logs", "payroll_logs");
        foreach ($empList as $row) {
            $empID = $row->empID;
            $expected_takehome = $request->input('expected_takehome' . $empID);
            $actual_takehome = $request->input('actual_takehome' . $empID);
            if ($expected_takehome == $actual_takehome) continue;
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
                'pay_checklist' => 1
            );
            $update_payroll_logs = array(
                'less_takehome' => $expected_takehome - $actual_takehome
            );
            $result = $this->payroll_model->lessPayments($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth);
        }


        if ($result == true) {
            $logData = array(
                'empID' => session('emp_id'),
                'description' => "Generating checklist with arrears payment of payroll of date " . $payrollMonth,
                'agent' => session('agent'),
                'platform' => $this->agent->platform(),
                'ip_address' => $this->input->ip_address()
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

    function arrearsPayment_schedule()
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
                            'confirmed_by' => ""
                        );
                        $result = $this->payroll_model->updatePendingArrear($arrearID, $updates);
                    } else {

                        $data = array(
                            'arrear_id' => $arrearID,
                            'amount' => $amountPaid,
                            'init_by' => session('emp_id'),
                            'date_confirmed' => $payment_date
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
                    'confirmed_by' => ""
                );
                $result = $this->payroll_model->updatePendingArrear($arrearID, $updates);
            } else {
                $data = array(
                    'arrear_id' => $arrearID,
                    'amount' => ($employee->amount - $employee->paid),
                    'init_by' => session('emp_id'),
                    'date_confirmed' => $payment_date
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
                'confirmed_by' => session('emp_id')
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
                'confirmed_by' => session('emp_id')
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
                            'amount_last_paid' => $last_paid
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
                'recommended_by' => session('emp_id')
            );

            $arrearID = $this->uri->segment(3);
            $result = $this->payroll_model->confirmPendingArrear($arrearID, $updates);
            if ($result == true) {

                $logData = array(
                    'empID' => session('emp_id'),
                    'description' => "Recommendation of Arreas on date " . date('Y-m-d'),
                    'agent' => session('agent'),
                    'platform' => $this->agent->platform(),
                    'ip_address' => $this->input->ip_address()
                );

                $result = $this->flexperformance_model->insertAuditLog($logData);

                echo "<p class='alert alert-success text-center'>Arrears Payment Confirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
            }
        }
    }

    function cancelpayroll($type)
    {
        //dd($type);
        /*get the payroll month*/
        $result_month = $this->payroll_model->getPayrollMonth1();
        $this_payroll = $this->payroll_model->payrollMonthListpending();
        $payroll_id = $this_payroll[0]->id;
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
                $response_array['message'] = "<p class='alert alert-success text-center'>Payroll CANCELLED Successifully</p>";
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

    function send_payslips()
    {

        //Get All Employee Emails
        $payrollDate = $this->uri->segment(3);
        $employees = $this->payroll_model->send_payslips($payrollDate);
        $this->payroll_model->updatePayrollMail($payrollDate);
        $response_array = [];
        foreach ($employees as $row) {
            $payroll_date = $row->payroll_date;
            $empID = $row->empID;
            $email = $row->email;
            $month = date('Y-m', strtotime($row->payroll_date));
            $payroll_month = $month;
            $payroll_month_end = $month . "-31";
            $empName = $row->empName;
            if ($row->email) {
                $result = $this->payslip_attachments($empID, $email, $payroll_date, $payroll_month, $payroll_month_end, $empName);

                if ($result) {
                    $response_array['status'] = 'SENT';
                } else {
                    $response_array['status'] = 'ERR';
                }
            }
        }

        echo json_encode($response_array);
    }

    function payslip_attachments($empID, $email, $payroll_date, $payroll_month, $payroll_month_end, $empName)
    {

        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load(); // PHPMailer object

        //START PAYSLIP SECTION
        $payrollMonth = date('F/Y', strtotime($payroll_date));
        // Payslip details
        $slipinfo = $this->reports_model->payslip_info($empID, $payroll_month_end, $payroll_month);
        $leaves = $this->reports_model->leaves($empID, $payroll_month_end);
        $annualLeaveSpent = $this->reports_model->annualLeaveSpent($empID, $payroll_month_end);
        $allowances = $this->reports_model->allowances($empID, $payroll_month);
        $deductions = $this->reports_model->deductions($empID, $payroll_month);
        $loans = $this->reports_model->loans($empID, $payroll_month);
        $salary_advance_loan = $this->reports_model->loansPolicyAmount($empID, $payroll_month);
        $total_allowances = $this->reports_model->total_allowances($empID, $payroll_month);
        $total_pensions = $this->reports_model->total_pensions($empID, $payroll_date);
        $total_deductions = $this->reports_model->total_deductions($empID, $payroll_month);
        $companyinfo = $this->reports_model->company_info();
        $arrears_paid = $this->reports_model->employeeArrearByMonth($empID, $payroll_date);
        $arrears_paid_all = $this->reports_model->employeeArrearAllPaid($empID, $payroll_date);
        $arrears_all = $this->reports_model->employeeArrearAll($empID, $payroll_date);
        $arrears_paid = $this->reports_model->employeeArrearByMonth($empID, $payroll_date);
        $paid_with_arrears = $this->reports_model->employeePaidWithArrear($empID, $payroll_date);
        $paid_with_arrears_d = $this->reports_model->employeeArrearPaidAll($empID, $payroll_date);
        $salary_advance_loan_remained = $this->reports_model->loansAmountRemained($empID, $payroll_date);
        $senderInfo = $this->payroll_model->senderInfo();
        $employee_details = $this->flexperformance_model->getEmployeeNameByemail($email);
        if ($employee_details) {

            foreach ($employee_details as $info) {
                $userpassword = $this->password_generator(5);
            }

            // START PAYSLIP
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetProtection(null, $userpassword, "vso-password", 0, null);
            $pdf->SetAuthor('Miraji Issa');
            $pdf->SetTitle('Payslip');
            $pdf->SetSubject('Cipay');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            // set default header data

            // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001',
            //  PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
            $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(true);

            // set header and footer fonts
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set default font subsetting mode
            $pdf->setFontSubsetting(true);

            // Set font
            // dejavusans is a UTF-8 Unicode font, if you only need to
            // print standard ASCII chars, you can use core fonts like
            // helvetica or times to reduce file size.
            $pdf->SetFont('times', '', 10, '', true);

            // Add a page
            // This method has several options, check the source code documentation for more information.
            $pdf->AddPage('P', 'A4');


            foreach ($slipinfo as $row) {
                $id = $row->empID;
                $old_id = $row->oldID;
                if ($row->oldID == 0) $employeeID = $row->empID;
                else $employeeID = $row->oldID;
                $hiredate = $row->hire_date;
                $name = $row->name;
                $position = $row->position_name;
                $department = $row->department_name;
                $branch = $row->branch_name;
                $salary = $row->salary;
                $pension_fund = $row->pension_fund_name;
                $pension_fund_abbrv = $row->pension_fund_abbrv;
                $membership_no = $row->membership_no;
                $bank = $row->bank_name;
                $account_no = $row->account_no;
                $hiredate = $row->hire_date;
                $payroll_month = $row->payroll_date;
                $pension_employee = $row->pension_employee;
                $meals = $row->meals;
                $taxdue = $row->taxdue;
            }

            foreach ($companyinfo as $row) {
                $companyname = $row->cname;
            }

            foreach ($total_pensions as $row) {
                $uptodate_pension_employee = $row->total_pension_employee;
                $uptodate_pension_employer = $row->total_pension_employer;
            }

            $sum_allowances = $total_allowances;
            $sum_deductions = $total_deductions;
            $sum_loans = 0;

            // DATE MANIPULATION
            $hire = date_create($hiredate);
            $today = date_create($payroll_month);
            $diff = date_diff($hire, $today);
            $accrued = 37 * $diff->format("%a%") / 365;
            $totalAccrued = (number_format((float)$accrued, 2, '.', '')); //3,04days

            $balance = $totalAccrued - $annualLeaveSpent; //days
            if ($balance < 0) {
                $balance = 0;
            }


            // $dateconvert =$payroll_date;
            /*$datewell = explode("-",$payroll_month);
            $mm = $datewell[1];
            $dd = $datewell[2];
            $yyyy = $datewell[0];
            $outstanding_date = $dd."-".$mm."-".$yyyy;
            */


            $pdf->SetXY(85, 5);

            $path = FCPATH . 'uploads/logo/logo.png';
            // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
            $pdf->Image($path, '', '', 30, 25, '', '', 'T', false, 300, '', false, false, '', false, false, false);


            $pdf->SetXY(86, $pdf->GetY() + 25); //(+3)
            $header = "
<p align='center'><b>Employee Payslip</b></p>";
            $pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);

            // SET THE FONT FAMILY
            $pdf->SetFont('courier', '', 10, '', true);
            // SET THE STYLE FOR DOTTED LINES
            $style4 = array('B' => array('width' => 0, 'cap' => 'square', 'join' => 'miter', 'dash' => 3));

            $pdf->SetXY(15, $pdf->GetY() - 6); //(+3)
            $header = "
<p><b>Payslip For :<b> &nbsp;&nbsp;&nbsp;" . date('F, Y', strtotime($payroll_month)) . "</b></p>";
            $pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);
            $pdf->Rect(16, $pdf->GetY() - 7, 175, 0, '', $style4);  //Dotted LIne


            // Employee Info
            $pdf->SetXY(0, $pdf->GetY() - 10);
            $subtitle1 = "
<p><br>EMPLOYEE DETAILS:";


            $employee_info = '
<table width = "100%">
    <tr align="left">
        <th width="110"><b>ID:</b></th>
        <th width="230">' . $employeeID . '</th>
        <th width="120"><b>Pension Fund:</b></th>
        <th width="180">' . $pension_fund_abbrv . '</th>
    </tr>
    <tr align="left">
        <td align "left"><b>Name:</b></td>
        <td align "left">' . $name . '</td>
        <td align "left"><b>Membership No:</b></td>
        <td align "left">' . $membership_no . '</td>
    </tr>
    <tr align="left">
        <td align "left"><b>Department:</b></td>
        <td align "left">' . $department . '</td>
        <td align "left"><b>Bank:</b></td>
        <td align "left">' . $bank . ' </td>
    </tr>
    <tr align="left">
        <td align "left"><b>Position:</b></td>
        <td align "left">' . $position . '</td>
        <td align "left"><b>Acc No:</b></td>
        <td align "left">' . $account_no . '</td>
    </tr>
    <tr align="left">
        <td align "left"><b>Branch:</b></td>
        <td align "left">' . $branch . '</td>
    </tr>
</table>';
            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle1, 0, 1, 0, true, '', true);

            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 3, $employee_info, 0, 1, 0, true, '', true);
            $pdf->Rect(16, $pdf->GetY() + 2, 175, 0, '', $style4);  //Dotted LIne


            //START EARNINGS AND PAYMENTS
            $pdf->SetXY(15, $pdf->GetY());
            $out = "<p><br>PAYMENTS/EARNINGS:";
            $allowance = '
<table width = "100%">
    <tr>
        <td width="500" align="left"><b>Basic Salary</b></td>
        <td width="100" align="right">' . number_format($salary, 2) . '</td>
    </tr>';
            foreach ($allowances as $row) {
                $allowance .= '
    <tr>
        <td width="500" align "left"><b>' . $row->description . '</b></td>
        <td width="100" align "right">' . number_format($row->amount, 2) . '</td>
    </tr>';
            }

            $allowance .= '</table>';

            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $out, 0, 1, 0, true, '', true);

            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 4, $allowance, 0, 1, 0, true, '', true);

            $pdf->SetXY(15, $pdf->GetY() + 3);
            $pay1 = "<p><br><br>TOTAL EARNINGS(GROSS)</p>";

            $gross = '<table width="100" align "right"><tr width="100" align "left" align="left"><th>' . number_format($sum_allowances + $salary, 2) . '</th></tr></table>';

            $pdf->Rect(148, $pdf->GetY(), 46, 0, '', $style4);
            $pdf->writeHTMLCell(0, 12, 155, $pdf->GetY() + 0.5, $gross, 0, 1, 0, true, '', true);
            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 20, $pay1, 0, 1, 0, true, '', true);
            $pdf->Rect(16.5, $pdf->GetY(), 177.5, 0, '', $style4);

            //END EARNINGS AND PAYMENTS


            //START DEDUCTIONS
            $pdf->SetXY(15, $pdf->GetY());
            $subtitle2 = "<p><br>DEDUCTIONS:";
            $deduction = '
<table width = "100%">
    <tr>
        <td width="500" align="left"><b>Pension (' . $pension_fund_abbrv . ')</b></td>
        <td width="100" align="right">' . number_format($pension_employee, 2) . '</td>
    </tr>
    <tr>
        <td width="500" align="left"><b>PAYE AMOUNT</b></td>
        <td width="100" align="right">' . number_format($taxdue, 2) . '</td>
    </tr>';
            //    <tr>
            //        <td width="500" align "left"><b>MEALS</b></td>
            //        <td width="100" align "right">'.number_format($meals, 2).'</td>
            //    </tr>';
            if ($meals > 0) {
                $deduction .= '<tr>
               <td width="500" align="left"><b>MEALS</b></td>
               <td width="100" align="right">' . number_format($meals, 2) . '</td>
        </tr>';
            }

            foreach ($deductions as $row) {
                $deduction .= '
    <tr>
        <td width="500" align="left"><b>' . $row->description . '</b></td>
        <td width="100" align="right">' . number_format($row->paid, 2) . '</td>
    </tr>';
            }

            foreach ($loans as $row) {

                $paid = $row->paid;
                if ($row->remained == 0) {
                    $get_remainder = $row->paid / $row->policy;
                    $array = explode('.', $get_remainder);
                    $num = '0' . '.' . $array[1];
                    //        $paid = $num*$row->policy;
                    $paid = $salary_advance_loan_remained;
                }


                $deduction .= '
    <tr>
        <td width="500" align="left"><b>' . $row->description . '</b></td>
        <td width="100" align="right">' . number_format($paid, 2) . '</td>
    </tr>';
                $sum_loans = ($sum_loans + $paid);
            }

            $deduction .= '</table>';

            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle2, 0, 1, 0, true, '', true);

            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 4, $deduction, 0, 1, 0, true, '', true);

            $pdf->SetXY(15, $pdf->GetY() + 3);
            $subtitle3 = "<p><br><br>TOTAL DEDUCTIONS</p>";

            $alldeduction = '<table width="100" align "right"><tr width="100" align "left" align="left"><th>' . number_format(($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals), 2) . '</th></tr></table>';

            $pdf->Rect(148, $pdf->GetY(), 46, 0, '', $style4);
            $pdf->writeHTMLCell(0, 12, 155, $pdf->GetY() + 0.5, $alldeduction, 0, 1, 0, true, '', true);
            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 20, $subtitle3, 0, 1, 0, true, '', true);
            $pdf->Rect(16.5, $pdf->GetY(), 177.5, 0, '', $style4);
            //END DEDUCTIONS

            // START TAKE HOME
            $amount_takehome = ($sum_allowances + $salary) - ($sum_loans + $pension_employee + $taxdue + $sum_deductions + $meals);

            $paid_salary = $amount_takehome;
            foreach ($paid_with_arrears as $paid_with_arrear) {
                if ($paid_with_arrear->with_arrears) {
                    $with_arr = $paid_with_arrear->with_arrears; //with held
                    $paid_salary = $amount_takehome - $with_arr; //paid amount
                } else {
                    $with_arr = 0; //with held
                }
            }

            foreach ($arrears_paid as $arrear_paid) {
                if ($arrear_paid->arrears_paid) {
                    $paid_salary = $amount_takehome + $arrear_paid->arrears_paid - $with_arr;
                    $paid_arr = $arrear_paid->arrears_paid;
                } else {
                    $paid_arr = 0;
                }
            }

            foreach ($paid_with_arrears_d as $paid_with_arrear_d) {
                if ($paid_with_arrear_d->arrears_paid) {
                    $paid_arr_all = $paid_with_arrear_d->arrears_paid;
                } else {
                    $paid_arr_all = 0;
                }
            }

            if ($with_arr > 0) {
                foreach ($arrears_all as $arrear_all) {

                    if ($arrear_all->arrears_all) {
                        $due_arr = $arrear_all->arrears_all - $paid_arr_all;
                    } else {
                        $due_arr = 0;
                    }
                }
            } else {
                foreach ($arrears_all as $arrear_all) {

                    if ($arrear_all->arrears_all) {
                        $due_arr = $arrear_all->arrears_all - $paid_arr_all;
                    } else {
                        $due_arr = 0;
                    }
                }
            }


            $takehome = '
<table width = "100%">';
            // foreach($loans as $row){
            $takehome .= '
    <tr>
        <td width="500" align="left"><b>Net Pay</b></td>
        <td width="100" align="right">' . number_format($amount_takehome, 2) . '</td>
    </tr>';

            if ($paid_salary > 0) {
                $takehome .= '<tr>
                    <td width="500" align="left"><b>Paid Amount</b></td>
                    <td width="100" align="right">' . number_format($paid_salary, 2) . '</td>
                </tr>';
            }

            if ($paid_arr > 0) {
                $takehome .= '<tr>
                <td width="500" align="left"><b>Arrears Paid</b></td>
                <td width="100" align="right">' . number_format($paid_arr, 2) . '</td>
            </tr>';
            }

            if ($with_arr > 0) {
                $takehome .= '<tr>
                    <td width="500" align="left"><b>Arrears Withheld</b></td>
                    <td width="100" align="right">' . number_format($with_arr, 2) . '</td>
                </tr>';
            }

            if ($due_arr > 0) {
                $takehome .= '<tr>
                    <td width="500" align="left"><b>Arrears Due</b></td>
                    <td width="100" align="right">' . number_format($due_arr, 2) . '</td>
                </tr>';
            }


            $takehome .= '<tr>
                    <td width="500" align="left"></td>
                    <td width="100" align="right"></td>
                </tr>';

            $takehome .= '</table>';

            $pdf->writeHTMLCell(0, 12, '', $pdf->GetY() + 2, $takehome, 0, 1, 0, true, '', true);

            $pdf->Rect(16.5, $pdf->GetY() - 5, 177.5, 0, '', $style4);
            // END TAKE HOME

            //OUTSTANDING LOANS

            if (!empty($loans)) {
                $pdf->SetXY(15, $pdf->GetY() - 6);
                $subtitle4 = "<p><br>OUTSTANDINGS(SALARY ADVANCE AND LOANS):";
                $outstandings = '
  <table width = "100%">';
                foreach ($loans as $row) {
                    $outstandings .= '
      <tr>
          <td width="500" align="left"><b>' . $row->description . '</b></td>
          <td width="100" align="right">' . number_format($row->remained, 2) . '</td>
      </tr>';
                }

                $outstandings .= '
      <tr>
          <td width="500" align="left"></td>
          <td width="100" align="right"></td>
      </tr>';


                $outstandings .= '</table>';

                $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle4, 0, 1, 0, true, '', true);

                $pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 2, $outstandings, 0, 1, 0, true, '', true);

                $pdf->Rect(16.5, $pdf->GetY() - 5, 177.5, 0, '', $style4);
            }
            //END OUTSTANDING LOANS

            //UPTODATE PENSIONS
            // $pdf->SetXY(15, $pdf->GetY()-5);
            // $uptodates_title = "<p><br>UP TODATE CONTRIBUTIONS:";
            // $uptodatepension = '
            // <table width = "100%">
            //     <tr>
            //         <td width="500" align="left"><b>'.$pension_fund_abbrv.' Contributed By Employee</b></td>
            //         <td width="105" align="right">'.number_format($uptodate_pension_employee, 2).'</td>
            //     </tr>
            //     <tr>
            //         <td width="500" align="left"><b>'.$pension_fund_abbrv.' Contributed By Employer</b></td>
            //         <td width="105" align="right">'.number_format($uptodate_pension_employer, 2).'</td>
            //     </tr>
            // </table>';

            // $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $uptodates_title , 0, 1, 0, true, '', true);

            // $pdf->writeHTMLCell(0, 12, '', $pdf->GetY()-4, $uptodatepension, 0, 1, 0, true, '', true);

            // $pdf->SetXY(15, $pdf->GetY());
            // $uptodates = "<p><br><br>TOTAL PENSION CONTRIBUTIONS</p>";

            // $sumpensions = '<table width="120" align "right"><tr width="120" align "left" align="left"><th>'.number_format($uptodate_pension_employee+$uptodate_pension_employer,2).'</th></tr></table>';

            // $pdf->Rect(148, $pdf->GetY(), 46, 0, '', $style4);
            // $pdf->writeHTMLCell(0, 12, 155, $pdf->GetY()+2, $sumpensions, 0, 1, 0, true, '', true);
            // $pdf->writeHTMLCell(0, 12, '', $pdf->GetY()-20, $uptodates, 0, 1, 0, true, '', true);
            // $pdf->Rect(16.5, $pdf->GetY(), 177.5, 0, '', $style4);

            //END UPTODATE PENSIONS


            //START LEAVES
            //             $pdf->SetXY(15, $pdf->GetY());

            //             $subtitle5 = "<p><br>LEAVES:";
            //             $leave = '
            // <table width = "100%">
            //     <tr>
            //         <td width="500" align="left"><b>Annual Leave Balance(Days)</b></td>
            //         <td width="100" align="right">' . $balance . '</td>
            //     </tr>';
            //             foreach ($leaves as $row) {
            //                 if ($row->type == 1) continue;
            //                 $leave .= '
            //     <tr>
            //         <td width="500" align="left"><b>' . $row->nature . '</b></td>
            //         <td width="100" align="right">' . $row->days . '</td>
            //     </tr>';
            //             }
            //             $leave .= '</table>';

            //             $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle5, 0, 1, 0, true, '', true);

            //             $pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 1, $leave, 0, 1, 0, true, '', true);

            //             $pdf->Rect(16.5, $pdf->GetY() + 2, 177.5, 0, '', $style4);

            //END LEAVES


            // Close and output PDF document
            // This method has several options, check the source code documentation for more information.
            $payslip = $pdf->Output('payslip-' . $empID . '-' . $payrollMonth . '.pdf', 'S');

            //============================================================+
            // END OF FILE
            //============================================================+

            // END PAYSLIP SECTION


            // SEND EMAIL
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
            // $mail->addReplyTo('mirajissa1@gmail.com', 'CodexWorld');

            // Add a recipient
            $mail->addAddress($email);

            // Email subject
            $mail->Subject = $payrollMonth . '-PAYSLIP';

            // Set email format to HTML
            $mail->isHTML(true);

            // Email body content
            $mailContent = "<h1>Hello! &nbsp; " . $empName . "</h1>
            <p>Please Find The Attached Payslip For the <b>" . $payrollMonth . "</b> Payroll Month. The required password is <b>" . $userpassword . "</b> .</p>";
            $mail->Body = $mailContent;
            $mail->AddStringAttachment($payslip, 'payslip.pdf');

            // Send email
            if (!$mail->send()) {
                //                echo 'Message could not be sent.';
                //                echo 'Mailer Error: ' . $mail->ErrorInfo;
                return false;
            } else {
                return true;
            }
            // SEND EMAIL
        }
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
                'email' => $request->input('username')
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

    function employeeFilter()
    {
        $type = $this->uri->segment(3);

        if ($type == 1) {
            $data = $this->payroll_model->customemployee();
        } else {
            $data = $this->payroll_model->customemployeeExit();
        }

        echo json_encode($data);
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

    function TestMail()
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
