<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\ReportModel;
use App\Models\ProjectModel;
use Elibyy\TCPDF\Facades\TCPDF;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Models\AttendanceModel;

use Barryvdh\DomPDF\Facade\Pdf;
use SebastianBergmann\Timer\Duration;

// use PDF;
// use App\Helpers\SysHelpers;
class ReportController extends Controller
{
    public function __construct($payroll_model = null, $flexperformance_model = null, $reports_model = null)
    {
        $this->payroll_model = new Payroll();
        $this->reports_model = new ReportModel;
        $this->attendance_model = new AttendanceModel;
        $this->flexperformance_model = new FlexPerformanceModel;
        $this->project_model = new ProjectModel();
    }

    function payroll_report(Request $request)
    {
        if ($request->pdate) {
            $payrollMonth = base64_decode($request->pdate);

            $data['info'] = $this->reports_model->company_info();
            $data['authorization'] = $this->reports_model->payrollAuthorization($payrollMonth);
            $toDate = date('Y-m-d');
            $data['employee_list'] = $this->reports_model->pay_checklist($payrollMonth);
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

            $info = $data['info'];
            $authorization = $data['authorization'];

            $employee_list = $data['employee_list'];
            $take_home = $data['take_home'];
            $payroll_totals = $data['payroll_totals'];
            $total_allowances = $data['total_allowances'];
            $total_bonuses = $data['total_bonuses'];
            $total_loans = $data['total_loans'];
            $total_deductions = $data['total_deductions'];
            $total_overtimes = $data['total_overtimes'];
            $payroll_date = $data['payroll_date'];
            $payroll_month = $data['payroll_month'];
            $total_heslb = $data['total_heslb'];
            include app_path() . '/reports/payroll_report.php';
            //return view('app.reports.payroll_report',$data);

        }
    }

    function payroll_report1(Request $request)
    {
        if ($request->pdate) {
            $payrollMonth = base64_decode($request->pdate);

            $data['info'] = $this->reports_model->company_info();
            $data['authorization'] = $this->reports_model->payrollAuthorization($payrollMonth);
            $toDate = date('Y-m-d');
            $data['employee_list'] = $this->reports_model->pay_checklist($payrollMonth);
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

            $info = $data['info'];
            $authorization = $data['authorization'];

            $employee_list = $data['employee_list'];
            $take_home = $data['take_home'];
            $payroll_totals = $data['payroll_totals'];
            $total_allowances = $data['total_allowances'];
            $total_bonuses = $data['total_bonuses'];
            $total_loans = $data['total_loans'];
            $total_deductions = $data['total_deductions'];
            $total_overtimes = $data['total_overtimes'];
            $payroll_date = $data['payroll_date'];
            $payroll_month = $data['payroll_month'];
            $total_heslb = $data['total_heslb'];
            include app_path() . '/reports/payroll_report1.php';
            //return view('app.reports.payroll_report',$data);

        }
    }

    function pay_checklist(Request $request)
    {
        ;
        if (1) {
            $payroll_date = $request->input('payrolldate');
            $isReady = $this->reports_model->payCheklistStatus($payroll_date);
            $reportType = 1;
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2
            if ($isReady == true) {
                $data['info'] = $this->reports_model->company_info();
                $toDate = date('Y-m-d');
                $data["strategyProgress"] = 23;
                $data['payroll_month'] = $payroll_date;
                if ($reportType == 1) {
                    $data['employee_list'] = $this->reports_model->staff_pay_checklist($payroll_date);
                    $data['take_home'] = $this->reports_model->staff_sum_take_home($payroll_date);
                } else {
                    $data['employee_list'] = $this->reports_model->temporary_pay_checklist($payroll_date);
                    $data['take_home'] = $this->reports_model->temporary_sum_take_home($payroll_date);
                }
                return view('app.reports/pay_checklist', $data);
            } else {
                session('note', "<p class='alert alert-warning text-center'>Sorry the Pay Checklist for the Selected Payroll Month is Not Ready</font></p>");
                return redirect('/flex/cipay/financial_reports/');
            }
        }
    }

    function all_arrears(Request $request)
    {
        if ($request->input('print')) {
            $start = $request->input('start');
            $finish = $request->input('finish');

            $data['info'] = $this->reports_model->company_info();
            $data['dateStart'] = $start;
            $data['dateFinish'] = $finish;
            $data['arrears'] = $this->payroll_model->arrears($start, $finish);
            return view('app.reports/all_arrears', $data);
        } else {
            exit("Invalid Method Access");
        }
    }

    function employee_arrears(Request $request)
    {
        $empID = base64_decode($request->input('empid'));
        if ($empID == '' || ($this->reports_model->employeeInfo($empID)) == false) {
            exit("Employee ID Not Found");
        } else {
            $data['info'] = $this->reports_model->company_info();
            $data['arrears'] = $this->payroll_model->employee_arrears($empID);
            $data['employee'] = $this->reports_model->employeeInfo($empID);
            return view('app.reports/employee_arrears', $data);
        }
    }

    function p9(Request $request)
    {
        $reportType = 1;
        $reportformat = $request->input('type');

        if (1) {
            $payrolldate = $request->input('payrolldate');
            $reportType = 1;
             //Staff = 1, temporary = 2
            if ($reportType == 1) {
                $data['paye'] = $this->reports_model->s_p9($payrolldate);
                $data['total'] = $this->reports_model->s_totalp9($payrolldate);
            } else {

                $data['paye'] = $this->reports_model->v_p9($payrolldate);
                $data['total'] = $this->reports_model->v_totalp9($payrolldate);
            }
            $data['info'] = $this->reports_model->company_info();
            $data['reportType'] = $reportType;
            $data['payroll_date'] = $payrolldate;
            // dd("here");

            $paye = $data['paye'];
            $total = $data['total'];
            $info = $data['info'];
            $payroll_date = $data['payroll_date'];

            if($reportformat == 1)
            include(app_path() . '/reports/p9.php');
            else
         return view('reports/p9', $data);
        }
    }

    function p10(Request $request)
    {
        $reportType = 1;  //Staff = 1, temporary = 2
        $reportformat = $request->input('type');

         //  dd($reportformat);

        $period = $request->input('period');
        //dd($period);
        $year = $request->input('payrolldate');

        $period1start = $year . "-01-01";
        $period1end = $year . "-06-30";
        $period2start = $year . "-07-01";
        $period2end = $year . "-12-31";

        $checkup1 = $this->reports_model->p10check($year, $year);
        $checkup2 = $this->reports_model->p10check($year, $year);
        if ($period == 1 && $checkup1 >= 1) {
            // exit($date1start."<br>".$date1end);
            $data['info'] = $this->reports_model->company_info();
            if ($reportType == 1) {
                $data['paye'] = $this->reports_model->s_p91($year, $year);
                $data['sdl'] = $this->reports_model->s_p10($year, $year);
                $data['total'] = $this->reports_model->s_totalp10($year, $year);
            } else {
                $data['paye'] = $this->reports_model->v_p91($year, $year);
                $data['sdl'] = $this->reports_model->v_p10($year, $year);
                $data['total'] = $this->reports_model->v_totalp10($year, $year);
            }

            $paye = $data['paye'];
            $sdl = $data['sdl'];
            $total = $data['total'];
            $info = $data['info'];

            if($reportformat == 1)
            include app_path() . '/reports/p10.php';
            else
            return view('reports/p10', $data);
        } elseif ($period == 2 && $checkup2 >= 1) {
            // exit($date2start."<br>".$date2end);
            if ($reportType == 1) {
                $data['paye'] = $this->reports_model->s_p91($year, $year);
                $data['sdl'] = $this->reports_model->s_p10($year, $year);
                $data['total'] = $this->reports_model->s_totalp10($year, $year);
            } else {
                $data['paye'] = $this->reports_model->v_p91($year, $year);
                $data['sdl'] = $this->reports_model->v_p10($year, $year);
                $data['total'] = $this->reports_model->v_totalp10($year, $year);
            }
            $data['info'] = $this->reports_model->company_info();

            $paye = $data['paye'];
            $sdl = $data['sdl'];
            $total = $data['total'];
            $info = $data['info'];

            if($reportformat == 1)
            include app_path() . '/reports/p10.php';
            else
            return view('reports/p10', $data);

        } else {
            exit('NO PAYROLL');
        }
    }

    function heslb(Request $request)
    {
        $reportType = 1;
        $payrolldate = $request->input('payrolldate');
        $reportformat = $request->input('type'); //Staff = 1, temporary = 2
        if ($reportType == 1) {
            $data['heslb'] = $this->reports_model->s_heslb($payrolldate);
            $data['total'] = $this->reports_model->s_totalheslb($payrolldate);
        } else {
            $data['heslb'] = $this->reports_model->v_heslb($payrolldate);
            $data['total'] = $this->reports_model->v_totalheslb($payrolldate);
        }
        $data['info'] = $this->reports_model->company_info();
        $data['payrolldate'] = $payrolldate;
        $payrolldate = $data['payrolldate'];
        $heslb = $data['heslb'];
        $total = $data['total'];
        $info = $data['info'];

        if($reportformat == 1)
        include(app_path() . '/reports/heslb.php');
        else
        return view('reports/heslb', $data);
    }

    function payroll_inputs(Request $request){
        $date = $request->date;
        $data['summary'] = $this->reports_model->get_payroll_temp_summary($date);

        $payrollMonth = $request->date;
        $pensionFund = 2;
        $reportType = 1; //Staff = 1, temporary = 2

        $datewell = explode("-", $payrollMonth);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];
        $date = $yyyy . "-" . $mm;

        if ($reportType == 1) {
            $data['pension'] = $this->reports_model->s_pension($date, $pensionFund);
            $data['total'] = $this->reports_model->s_totalpension($date, $pensionFund);
        } else {
            $data['pension'] = $this->reports_model->v_pension($date, $pensionFund);
            $data['total'] = $this->reports_model->v_totalpension($date, $pensionFund);
        }

        $data['info'] = $this->reports_model->company_info();
        $data['payroll_month'] = $date;
        $data['pension_fund'] = $pensionFund;
        $data['employees'] = $this->flexperformance_model->Employee();
        $data['payrollMonth'] = $request->date;


        $info = $this->reports_model->company_info();

        $data['payroll_date'] = $request->date;

        $summary = $data['summary'];

        return view('payroll.payroll_inputs',$data);
    }
    function get_payroll_temp_summary(Request $request)
    {
       // $data['payroll_state'] = 1;
        $date = $request->date;
        $data['summary'] = $this->reports_model->get_payroll_temp_summary($date);

        $payrollMonth = $request->date;
        $pensionFund = 2;
        $reportType = 1; //Staff = 1, temporary = 2

        $datewell = explode("-", $payrollMonth);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];
        $date = $yyyy . "-" . $mm;

        if ($reportType == 1) {
            $data['pension'] = $this->reports_model->s_pension($date, $pensionFund);
            $data['total'] = $this->reports_model->s_totalpension($date, $pensionFund);
        } else {
            $data['pension'] = $this->reports_model->v_pension($date, $pensionFund);
            $data['total'] = $this->reports_model->v_totalpension($date, $pensionFund);
        }

        $data['info'] = $this->reports_model->company_info();
        $data['payroll_month'] = $date;
        $data['pension_fund'] = $pensionFund;

        $data['payrollMonth'] = $request->date;


        $info = $this->reports_model->company_info();

        $data['payroll_date'] = $request->date;

        $summary = $data['summary'];

        if($request->type == 1)

        return view('payroll.payroll_details', $data);

        return view('reports.payroll_details', $data);

        // include(app_path() . '/reports/temp_payroll.php');
    }
    function get_payroll_temp_summary1($date)
    {

        $data['summary'] = $this->reports_model->get_payroll_temp_summary1($date);

        $payrollMonth = $date;
        $pensionFund = 2;
        $reportType = 1; //Staff = 1, temporary = 2

        $datewell = explode("-", $payrollMonth);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];
        $date = $yyyy . "-" . $mm;



        $data['info'] = $this->reports_model->company_info();
        $data['payroll_month'] = $payrollMonth;
        $data['pension_fund'] = $pensionFund;


        $info = $this->reports_model->company_info();



        $summary = $data['summary'];
         if($request->type ==1){

         }
        return view('reports.temp_payroll1', $data);

        // include(app_path() . '/reports/temp_payroll.php');
    }

    function get_payroll_inputs(Request $request){

      if($request->nature == 1)
      $data = $this->reports_model->get_payroll_inputs_before_payroll($request->empID);
      else
      $data = $this->reports_model->get_payroll_inputs_after_payroll($request->empID);



      echo json_encode($data);
    }

    function employee_pension(Request $request){
        $id = $request->emp_id;
        $data['employee_pension'] = $this->reports_model->employee_pension($id);
        $data['years'] = $this->reports_model->get_pension_years($id);

        $pdf = Pdf::loadView('reports.employee_pension',$data)->setPaper('a4', 'potrait');
        return $pdf->download("employee_pension.pdf");


    }

    function pension(Request $request)
    {
        $reportType = 1;
        $reportformat = $request->input('type');


        $payrollMonth = $request->input('payrolldate');
        $pensionFund = $request->input('fund');

        $datewell = explode("-", $payrollMonth);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];
        $date = $yyyy . "-" . $mm;

        if ($reportType == 1) {
            $data['pension'] = $this->reports_model->s_pension($date, $pensionFund);
            $data['total'] = $this->reports_model->s_totalpension($date, $pensionFund);
        } else {
            $data['pension'] = $this->reports_model->v_pension($date, $pensionFund);
            $data['total'] = $this->reports_model->v_totalpension($date, $pensionFund);
        }

        $data['info'] = $this->reports_model->company_info();
        $data['payroll_month'] = $payrollMonth;
        $data['pension_fund'] = $pensionFund;

        $pension = $data['pension'];
        $total = $data['total'];
        $info = $data['info'];
        $payroll_month = $data['payroll_month'];
        $pension_fund = $data['pension_fund'];

        if($reportformat == 1)
        include(app_path() . '/reports/pension.php');
        else
        return view('reports/pension', $data);

    }

    function wcf(Request $request)
    {
        $reportformat = $request->input('type');


        // dd($request->all());
        $reportType = 1;
        if (1) {
            $calendar = $request->input('payrolldate');
            $datewell = explode("-", $calendar);

            $mm = $datewell[1];
            $dd = $datewell[2];
            $yyyy = $datewell[0];
            $date = $yyyy . "-" . $mm;

            if ($reportType == 1) {
                $data['wcf'] = $this->reports_model->s_wcf($date);
                $data['totalwcf'] = $this->reports_model->s_totalwcf($date);
            } else {
                $data['wcf'] = $this->reports_model->v_wcf($date);
                $data['totalwcf'] = $this->reports_model->v_totalwcf($date);
            }

            $data['info'] = $this->reports_model->company_info();
            $data['payroll_month'] = $yyyy . "-" . $mm . "-" . $dd;

            $wcf = $data['wcf'];
            $totalwcf = $data['totalwcf'];
            $info = $data['info'];
            $payroll_month = $data['payroll_month'];
            if($reportformat == 1)
            include(app_path() . '/reports/wcf.php');
            else
            return view('reports/wcf', $data);
        }
    }

    // function employment_cost_old(Request $request)  {
    //     //if (1) {

    //         //DATE MANIPULATION
    //         $calendar =$request->input('payrolldate');
    //         $datewell = explode("-",$calendar);
    //         $mm = $datewell[1];
    //         $dd = $datewell[2];
    //         $yyyy = $datewell[0];
    //         $date = $yyyy."-".$mm;
    //         $payrollDate = '2019-09-28'; // $yyyy."-".$mm."-".$dd;

    //         $check = $this->reports_model->employmentCostCheck($date);

    //         if($check>0){
    //             $data['cost']= $this->reports_model->employmentCost($date);
    //             $data['total_cost']= $this->reports_model->totalEmploymentCost($date);
    //             $data['info']= $this->reports_model->company_info();
    //             $data['payrollMonth'] = $payrollDate;
    //              return view('app.reports/employment_cost_old', $data);
    //         } else exit("No Payroll Available in This Month and Year");
    //     //}

    // }

    function employment_cost(Request $request)
    {
        $payrollMonth = '2009-01-22'; //base64_decode($request->input("pdate"));
        $data['info'] = $this->reports_model->company_info();
        $data['authorization'] = $this->reports_model->payrollAuthorization($payrollMonth);
        $toDate = date('Y-m-d');
        $data['employee_list'] = $this->reports_model->new_employment_cost_employee_list($payrollMonth);
        $data['take_home'] = $this->reports_model->sum_take_home($payrollMonth);
        $data['payroll_totals'] = $this->payroll_model->payrollTotals("payroll_logs", $payrollMonth);
        $data['total_allowances'] = $this->payroll_model->total_allowances("allowance_logs", $payrollMonth);
        $data['total_bonuses'] = $this->payroll_model->total_bonuses($payrollMonth);
        $data['total_loans'] = $this->payroll_model->total_loans("loan_logs", $payrollMonth);
        $data['total_deductions'] = $this->payroll_model->total_deductions("deduction_logs", $payrollMonth);
        $data['total_overtimes'] = $this->payroll_model->total_overtimes($payrollMonth);
        $data['payroll_date'] = $payrollMonth;
        $data['payroll_month'] = $payrollMonth;
        // echo json_encode($data);

        $info = $data['info'];
        $authorization = $data['authorization'];
        $employee_list = $data['employee_list'];
        $take_home = $data['take_home'];
        $payroll_totals = $data['payroll_totals'];
        $total_allowances = $data['total_allowances'];
        $total_bonuses = $data['total_bonuses'];
        $total_loans = $data['total_loans'];
        $total_deductions = $data['total_deductions'];
        $total_overtimes = $data['total_overtimes'];
        $payroll_date = $data['payroll_date'];
        $payroll_month = $data['payroll_month'];

        include app_path() . '/reports/employment_cost.php';
        //  return view('app.reports/employment_cost', $data);
        //}

    }

    public function loanreport(Request $request)
    {

        if ($request->input('print')) {

            $type = $request->input("type");

            // DATE MANIPULATION
            $start = $request->input("from");
            $end = $request->input("to");
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

            $data['info'] = $this->reports_model->company_info();

            if ($type == 3) {
                $data['loan'] = $this->reports_model->loanreport1($dates, $datee);
                $data['title'] = "List of ALL Loans From " . $dates . " to " . $datee;
            } elseif ($type == 1) {
                $data['loan'] = $this->reports_model->loanreport2($dates, $datee);
                $data['title'] = "List of ONPROGRESS Loans From " . $dates . " to " . $datee;
            } elseif ($type == 0) {
                $data['loan'] = $this->reports_model->loanreport3($dates, $datee);
                $data['title'] = "List of COMPLETED Loans From " . $dates . " to " . $datee;
            }

            $loan = $data['loan'];
            $title = $data['title'];
            include app_path() . '/reports/loan_report.php';

            //  return view('app.reports/loan_report', $data);
        }
    }

    public function customleavereport(Request $request)
    {
        if ($request->input('print')) {

            // DATE MANIPULATION
            $start = $request->input("from");
            $end = $request->input("to");
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

            $this->load->model("attendance_model");
            $data['leave'] = $this->attendance_model->leavereport1($dates, $datee);
            $data['title'] = "List of Employees Who went to Leave From " . $dates . " to " . $datee;
            $data['showbox'] = 1;

            $showbox = $data['showbox'];
            $leave = $data['leave'];
            $title = $data['title'];

            include app_path() . '/reports/customleave_report.php';
            //  return view('app.customleave_report', $data);
        } elseif ($request->input('viewindividual')) {

            $id = $request->input("employee");
            //

            $this->load->model("attendance_model");

            $data['showbox'] = 0;
            $data['customleave'] = $this->attendance_model->customleave();
            $data['leave'] = $this->attendance_model->leavereport2($id);
            //    return view('app.customleave_report', $data);

            $showbox = $data['showbox'];
            $leave = $data['leave'];
            $title = $data['title'];

            include app_path() . '/reports/customleave_report.php';
        }

        $data['showbox'] = 0;
        $data['leave'] = $this->attendance_model->leavereport2(session('emp_id'));
        $data['customleave'] = $this->attendance_model->customleave();
        //    return view('app.customleave_report', $data);

        $showbox = $data['showbox'];
        $leave = $data['leave'];
        $title = $data['title'];

        include app_path() . '/reports/customleave_report.php';
    }

    public function payslip(Request $request)
    {
        //dd($request->all());
        $empID = $request->input("employee");

        if ($empID != "Select Employee") {

            // DATE MANIPULATION
            $empID = $request->input("employee");
            $start = $request->input("payrolldate");
            $profile = $request->input("profile"); //For redirecting Purpose
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
                $data['payroll_date'] = $request->input("payrolldate");

                $date = explode('-',$payroll_date);
                $payroll_month = $date[0].'-'.$date[1];

                $data['bank_loan'] = $this->reports_model->bank_loans($empID, $payroll_month);
                $data['total_bank_loan'] = $this->reports_model->sum_bank_loans($empID, $payroll_month);

                //include(app_path() . '/reports/customleave_report.php');
                // include app_path() . '/reports/payslip.php';

                //return view('payroll.payslip2', $data);
                $pdf = Pdf::loadView('payroll.payslip2',$data)->setPaper('a4', 'potrait');

                return $pdf->download('payslip_for_'.$empID.'.pdf');
            }
        } else {
            // DATE MANIPULATION
            $start = $request->input("payrolldate");
            $date_separate = explode("-", $start);
            $reportType = 1;  //Staff = 1, temporary = 2
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2

            $mm = $date_separate[1];
            $yyyy = $date_separate[0];
            $dd = $date_separate[2];
            $one_year_back = $date_separate[0] - 1;

            $payroll_date = $yyyy . "-" . $mm . "-" . $dd;
            $payroll_month_end = $yyyy . "-" . $mm . "-31";
            $payroll_month = $yyyy . "-" . $mm;

            $check = $this->reports_model->payslipcheckAll($payroll_month);

            if ($check == 0) {
                session('note', "<p class='alert alert-warning text-center'>Sorry No Payroll Records Found For This Employee under the Selected Month</font></p>");
                return redirect('/flex/cipay/employee_payslip/');
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

                    include app_path() . '/reports/payslip.php';
                    // }
                }

                $data_all['emp_id'] = $payroll_emp_ids;

                return view('app.reports/payslip_all', $data_all);
            }
        }
    }

    function temp_payslip(Request $request)
    {

        // DATE MANIPULATION
        $empID = $request->input("employee");
        $start = $request->input("payrolldate");
        $profile = $request->input("profile"); //For redirecting Purpose
        $date_separate = explode("-", $start);

        $mm = $date_separate[1];
        $yyyy = $date_separate[0];
        $dd = $date_separate[2];
        $one_year_back = $date_separate[0] - 1;

        $payroll_date = $yyyy . "-" . $mm . "-" . $dd;
        $payroll_month_end = $yyyy . "-" . $mm . "-31";
        $payroll_month = $yyyy . "-" . $mm;

        $check = $this->reports_model->temp_payslipcheck($payroll_month, $empID);

        if ($check == 0) {
            if ($profile == 0) {
                session('note', "<p class='alert alert-warning text-center'>Sorry No Payroll Records Found For This Employee under the Selected Month</font></p>");
                return redirect('/flex/cipay/employee_payslip/');
            } else {
                session('note', "<p class='alert alert-warning text-center'>Sorry No Payroll Records Found For This Employee under the Selected Month</font></p>");
                return redirect('/flex/cipay/userprofile/?id=' . $empID);
            }
        } else {
            $data['slipinfo'] = $this->reports_model->temp_payslip_info($empID, $payroll_month_end, $payroll_month);
            $data['leaves'] = $this->reports_model->leaves($empID, $payroll_month_end);
            $data['annualLeaveSpent'] = $this->reports_model->annualLeaveSpent($empID, $payroll_month_end);
            $data['allowances'] = $this->reports_model->temp_allowances($empID, $payroll_month);
            $data['deductions'] = $this->reports_model->temp_deductions($empID, $payroll_month);
            $data['loans'] = $this->reports_model->temp_loans($empID, $payroll_month);
            $data['salary_advance_loan'] = $this->reports_model->temp_loansPolicyAmount($empID, $payroll_month);
            $data['total_allowances'] = $this->reports_model->temp_total_allowances($empID, $payroll_month);
            $data['total_pensions'] = $this->reports_model->temp_total_pensions($empID, $payroll_date);
            $data['total_deductions'] = $this->reports_model->temp_total_deductions($empID, $payroll_month);
            $data['companyinfo'] = $this->reports_model->company_info();
            $data['arrears_paid'] = $this->reports_model->employeeArrearByMonth($empID, $payroll_date);
            $data['arrears_paid_all'] = $this->reports_model->employeeArrearAllPaid($empID, $payroll_date);
            $data['arrears_all'] = $this->reports_model->employeeArrearAll($empID, $payroll_date);
            $data['arrears_paid'] = $this->reports_model->employeeArrearByMonth($empID, $payroll_date);
            $data['paid_with_arrears'] = $this->reports_model->employeePaidWithArrear($empID, $payroll_date);
            $data['paid_with_arrears_d'] = $this->reports_model->employeeArrearPaidAll($empID, $payroll_date);
            $data['salary_advance_loan_remained'] = $this->reports_model->temp_loansAmountRemained($empID, $payroll_date);

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

            include app_path() . '/reports/payslip.php';
            //  return view('app.reports/payslip', $data);

        }
    }

    function backup_payslip(Request $request)
    {

        if ($request->input('print')) {

            // DATE MANIPULATION
            $empID = $request->input("employee");
            $start = $request->input("payrolldate");
            $date_separate = explode("-", $start);

            // exit($start);

            $mm = $date_separate[1];
            $yyyy = $date_separate[0];
            $one_year_back = $date_separate[0] - 1;

            $dates = $yyyy . "-" . $mm . "-01";
            $datee = $yyyy . "-" . $mm . "-31";

            $year_month = $yyyy . "-" . $mm;
            $date_one_year_back = $one_year_back . "-" . $mm . "-01";

            $check = $this->reports_model->payslipcheck($year_month, $empID);

            if ($check == 0) {
                exit("No Payroll Records Found For This Employee under This Month");
                // session('note', "<p class='alert alert-warning text-center'>Sorry There is No Payroll or any Payment Informations to Appear in Your Salary Slip For the Year and Month Selected</font></p>");
                // return redirect('/flex/cipay/employee/');
            } else {
                $data['slipinfo'] = $this->reports_model->payslip_info($empID, $datee, $year_month, $date_one_year_back);
                $data['companyinfo'] = $this->reports_model->company_info();

                $slipinfo = $data['slipinfo'];
                $companyinfo = $data['companyinfo'];

                include app_path() . '/reports/payslip_test.php';
            }
        }
    }

    function kpi(Request $request)
    {
        $empID = $request->input('empID');

        $data['strategies'] = $this->reports_model->allStrategies($empID);
        $data['adhocs'] = $this->reports_model->adhocTasks($empID);
        $data['empInfo'] = $this->reports_model->employeeInfo($empID);
        $data['empID'] = $empID;

        $strategies = $data['strategies'];
        $adhocs = $data['adhocs'];
        $empInfo = $data['empInfo'];
        $empID = $data['empID'];

        include app_path() . '/reports/payslip_test.php';
        //  return view('app.reports/kpi', $data);

    }

    function attendance(Request $request)
    {

        //  dd($request->all());

        if ($request->input('print')) {

            // DATE MANIPULATION
            $calendar = $request->input('start');
            $datewell = explode("/", $calendar);
            $mm = $datewell[1];
            $dd = $datewell[0];
            $yyyy = $datewell[2];
            $attendance_date = $yyyy . "-" . $mm . "-" . $dd;

            $data['info'] = $this->reports_model->company_info();
            $toDate = date('Y-m-d');
            $data['employee_list'] = $this->reports_model->attendance_list($attendance_date);
            $data['payroll_month'] = $attendance_date;

            $info = $data['info'];
            $employee_list = $data['employee_list'];
            $payroll_month = $data['payroll_month'];

            include app_path() . '/reports/attendance_report.php';
            //  return view('app.reports/attendance_report', $data);
        }
    }

    ##############################################################################
    #################################END PROJECT REPORTS##############################

    public function payrollInputJournalExport(Request $request)
    {
        // dd($request->all());

        if (1) {
            $payroll_date = $request->input('payrolldate');
            $reportType = 1;
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2

            //start
            $todayDate = date('d/m/Y');
            $object = new Spreadsheet();
            if ($reportType == 1) {
                $filename = "staffPayrollInputJournalExport" . date('Y_m_d_H_i_s') . ".xls";
            } else {
                $filename = "temporaryPayrollInputJournalExport" . date('Y_m_d_H_i_s') . ".xls";
            }
            $object->setActiveSheetIndex(0);

            $styleArray = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => 'FFFFFF'),
                    //'size'  => 15,
                    //'name'  => 'Verdana'
                )
            );

            // $object->getActiveSheet()->getCell('A1')->setValue('Some text');

            $table_columns = array(
                "", "", "Transaction Reference", "Transaction Date", "Account Code", "Period", "Staff Names",
                "Transaction Amount", "Currency Code", "Job Position", "Employee Total Gross", "Percentage Allocation", "SDL", "WCF", "NSSF", "Cost Centre", "Project", "Grant", "Activity",
                "Individual Identity", "VSO Office", "Match Fund",
            );
            //23 columns

            $cells = array("C2", "D2", "C4", "C5", "D4", "D5", "G2", "G3", "H2", "H3");

            foreach ($cells as $value) {
                $object->getActiveSheet()->getStyle("$value")->getFont()->setBold(true);

                $object->getActiveSheet()->getStyle("$value")->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => Border::BORDER_THIN,
                                'color' => array('rgb' => '000000'),
                            ),
                        ),
                    )
                );
            }

            $cells = array("C2", "C4", "C5", "G2", "G3");

            foreach ($cells as $value) {
                $object->getActiveSheet()->getStyle("$value")->getFont()->setBold(true);
                //                $object->getActiveSheet()->getStyle("$value")->applyFromArray($styleArray);

                $object->getActiveSheet()->getStyle("$value")->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'AD0076'),
                        ),
                    )
                );
            }

            $object->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "Business Unit");
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "TZA");

            $object->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "Import Reference");
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, 5, "Journal Type");
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "");
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, 5, "PAYMT");

            $object->getActiveSheet()->getCell("G2")->setValue("Import Message");
            $object->getActiveSheet()->getCell("G3")->setValue("Import Error Message");
            $object->getActiveSheet()->getCell("H2")->setValue("");
            $object->getActiveSheet()->getCell("H3")->setValue("");

            $from = "B9";
            $to = "U9";
            $object->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, 8, "1;3");

            //Set Row Width
            $object->getActiveSheet()->getRowDimension("9")->setRowHeight(25);
            foreach (range('A', 'U') as $columnID) {
                $object->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            //Set ACTIVE SHEET
            $object->getActiveSheet()->getStyle("$from:$to")->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => Border::BORDER_THIN,
                            'color' => array('rgb' => '000000'),
                        ),
                    ),
                )
            );

            //Set Cell Background Color AND Font Color
            //            $object->getActiveSheet()->getStyle("B9:H9")->applyFromArray($styleArray);
            $object->getActiveSheet()->getStyle("B9:H9")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AD0076'),
                    ),
                )
            );
            $object->getActiveSheet()->getStyle("I9:N9")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFFF00'),
                    ),
                )
            );

            //            $object->getActiveSheet()->getStyle("O9:U9")->applyFromArray($styleArray);
            $object->getActiveSheet()->getStyle("O9:U9")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AD0076'),
                    ),
                )
            );
            $column = 0;
            foreach ($table_columns as $field) {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 9, $field);
                $column++;
            }

            //FROM DATABASE
            if ($reportType == 1) {
                $records = $this->reports_model->staffPayrollInputJournalExport($payroll_date);
                $take_home = $this->reports_model->staff_sum_take_home($payroll_date);
                $payroll_totals = $this->payroll_model->staffPayrollTotals("payroll_logs", $payroll_date);
                $total_heslb = $this->reports_model->staffTotalheslb($payroll_date);
                $net_total = $this->netTotalSummation($payroll_date)[1];
            } else {
                $records = $this->reports_model->temporaryPayrollInputJournalExport($payroll_date);
                $take_home = $this->reports_model->temporary_sum_take_home($payroll_date);
                $payroll_totals = $this->payroll_model->temporaryPayrollTotals("payroll_logs", $payroll_date);
                $total_heslb = $this->reports_model->temporaryTotalheslb($payroll_date);
                $net_total_1 = $this->netTotalSummation($payroll_date)[0];
                $net_total_2 = $this->netTotalSummation($payroll_date)[2];
                $net_total = $net_total_1 + $net_total_2;
            }

            $data_row = 10;
            $serialNo = 1;
            $total = 0.00;

            foreach ($payroll_totals as $row) {
                $salary = $row->salary;
                $pension_employee = $row->pension_employee;
                $pension_employer = $row->pension_employer;
                $medical_employee = $row->medical_employee;
                $medical_employer = $row->medical_employer;
                $sdl = $row->sdl;
                $wcf = $row->wcf;
                $allowances = $row->allowances;
                $taxdue = $row->taxdue;
                $meals = $row->meals;
            }
            foreach ($take_home as $row) {
                $net = $row->takehome;
                $net_less = $row->takehome_less;
                //              $arrears= $row->arrears_payment;
            }

            $paidheslb = 0;
            foreach ($total_heslb as $row) {
                $paidheslb = $row->total_paid;
            }

            foreach ($records as $row) {
                if ($row->mname == ' ' || $row->mname == '' || $row->mname == null) {
                    $empName = trim($row->fname) . ' ' . trim($row->lname);
                } else {
                    $empName = trim($row->fname) . ' ' . trim($row->mname) . ' ' . trim($row->lname);
                }

                $grantCode = $row->grant_code;
                if ($grantCode == "VSO") {
                    $grantCode = "#";
                }

                $percent = round(($row->percent / 100), 2);

                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $data_row, "6;7");
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $data_row, "PAYMTTZP010067");
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $data_row, $todayDate);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $data_row, "3520");
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $data_row, "");
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $data_row, $empName . " " . date('F Y', strtotime($row->payroll_date)) . " Salary");
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $data_row, number_format((($row->allowances + $row->salary) * $percent), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $data_row, "TZS");
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $data_row, $row->positionName);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $data_row, number_format(($row->allowances + $row->salary), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $data_row, ($percent * 100));
                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $data_row, number_format(($percent * $row->sdl), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $data_row, number_format(($percent * $row->wcf), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(14, $data_row, number_format(($percent * $row->pension_employee), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(15, $data_row, "200");
                $object->getActiveSheet()->setCellValueByColumnAndRow(16, $data_row, $row->project_code);
                $object->getActiveSheet()->setCellValueByColumnAndRow(17, $data_row, $grantCode);
                $object->getActiveSheet()->setCellValueByColumnAndRow(18, $data_row, $row->activity_code);
                $object->getActiveSheet()->setCellValueByColumnAndRow(19, $data_row, $row->empID);
                $object->getActiveSheet()->setCellValueByColumnAndRow(20, $data_row, "TZA");
                $object->getActiveSheet()->setCellValueByColumnAndRow(21, $data_row, "");

                for ($i = 'A'; $i < 'V'; $i++) {
                    $object->getActiveSheet()->getStyle("$i$data_row")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000'),
                                ),
                            ),
                        )
                    );
                }
                $total = $total + (($row->allowances + $row->salary) * $percent);
                $data_row++;
            }

            //Seven Rows at the Bottom For Summation and Summary
            $summaryRowssum = 0;
            $countSummaryRows = 0;
            for ($i = $data_row; $i <= $data_row + 6; $i++) {
                if ($countSummaryRows == 0) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("Net Salaries Payable " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$net_total, 2));
                    $summaryRowssum = $summaryRowssum - $net_total;
                }
                if ($countSummaryRows == 1) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("PAYE Payable " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$taxdue, 2));
                    $summaryRowssum = $summaryRowssum - $taxdue;
                }
                if ($countSummaryRows == 2) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("Employee Pension contribution " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$pension_employee, 2));
                    $summaryRowssum = $summaryRowssum - $pension_employee;
                }
                if ($countSummaryRows == 3) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("HESLB Payable " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$paidheslb, 2));
                    $summaryRowssum = $summaryRowssum - $paidheslb;
                }
                if ($countSummaryRows == 4) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("Net Salaries " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format($net_total, 2));
                    $summaryRowssum = $summaryRowssum + $net_total;
                }
                if ($countSummaryRows == 5) {
                    // $object->getActiveSheet()->getStyle("D$i:H$i")->applyFromArray(
                    //     // array(
                    //     //     'fill' => array(
                    //     //         'type' => Fill::FILL_SOLID,
                    //     //         'color' => array('rgb' => 'AAD08E')
                    //     //     )
                    //     // )
                    // );
                    $object->getActiveSheet()->getCell("F$i")->setValue("Net Salaries Payable to VSO Staff in " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$net_total, 2));
                    $object->getActiveSheet()->getCell("D$i")->setValue("CBTZ001");
                    $object->getActiveSheet()->getCell("H$i")->setValue("TZS");
                    $object->getActiveSheet()->getCell("T$i")->setValue("TZA");

                    $summaryRowssum = $summaryRowssum - $net_total;
                }
                if ($countSummaryRows == 6) {
                    // $object->getActiveSheet()->getStyle("F$i:H$i")->applyFromArray(
                    //     // array(
                    //     //     'fill' => array(
                    //     //         'type' => Fill::FILL_SOLID,
                    //     //         'color' => array('rgb' => 'ED7C31')
                    //     //     )
                    //     // )
                    // );
                    $sum = 0.00 + $summaryRowssum + $total;

                    // if($sum < 1.00 && 1.00-$sum < 1.00){
                    //     $sum = 0.00;
                    // }
                    $object->getActiveSheet()->getCell("F$i")->setValue("Check Balance");
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format($sum, 2));
                }
                $countSummaryRows++;
            }

            $startRow = $data_row + 1;
            $endRow = $startRow + 6;
            $count = $startRow;
            for ($n = $startRow; $n <= $endRow; $n++) {
                $repeated = $n - 2;
                $object->getActiveSheet()->getCell("A$repeated")->setValue("6;7");
                $object->getActiveSheet()->getCell("B$repeated")->setValue("PAYMTTZP010067");
                $object->getActiveSheet()->getCell("C$repeated")->setValue("" . $todayDate);

                $nextRepeated = $repeated + 1;
                if ($count < ($endRow - 1)) {
                    $object->getActiveSheet()->getCell("D$nextRepeated")->setValue("1717");
                    $object->getActiveSheet()->getCell("H$nextRepeated")->setValue("TZS");
                    $object->getActiveSheet()->getCell("S$nextRepeated")->setValue("#");
                    $object->getActiveSheet()->getCell("T$nextRepeated")->setValue("TZA");
                    // $object->getActiveSheet()->getStyle("D$nextRepeated:H$nextRepeated")->applyFromArray(
                    //     // array(
                    //     //     'fill' => array(
                    //     //         'type' => Fill::FILL_SOLID,
                    //     //         'color' => array('rgb' => 'FFFF00')
                    //     //     )
                    //     // )
                    // );
                }
                for ($i = 'A'; $i < 'V'; $i++) {
                    $p = ($n - 1);
                    $object->getActiveSheet()->getStyle("$i$p")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000'),
                                ),
                            ),
                        )
                    );
                }
                $count++;
            }

            $writer = new Xls($object); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            ob_start();
            $writer->save('php://output'); // download file
            //$object_writer->save($save_path);
            //chmod($save_path, 0777);

            // if($result==true) {
            //     echo "<p class='alert alert-success text-center'>Audit Trails Cleared Successifully!</p>";
            //     } else { echo "<p class='alert alert-danger text-center'>FAILED to clear audit logs, Try Again</p>"; }

            //end
        } else {
            exit("Invalid Resource Access");
        }
    }

    public function payrollInputJournalExportTime(Request $request)
    {
       // dd($request->all());
        if (1) {
            $payroll_date = $request->input('payrolldate');
            $reportType = 1;  //Staff = 1, temporary = 2
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2

            //start
            $todayDate = date('d/m/Y');
            $object = new Spreadsheet();
            if ($reportType == 1) {
                $filename = "staffPayrollInputJournalExportTime" . date('Y_m_d_H_i_s') . ".xls";
            } else {
                $filename = "temporaryPayrollInputJournalExportTime" . date('Y_m_d_H_i_s') . ".xls";
            }
            $object->setActiveSheetIndex(0);

            $styleArray = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => 'FFFFFF'),
                    //'size'  => 15,
                    //'name'  => 'Verdana'
                )
            );

            // $object->getActiveSheet()->getCell('A1')->setValue('Some text');

            $table_columns = array(
                "", "", "Transaction Reference", "Transaction Date", "Account Code", "Period", "Staff Names",
                "Transaction Amount", "Currency Code", "Job Position", "Employee Total Gross", "Time Allocation", "SDL", "WCF", "NSSF", "Cost Centre", "Project", "Grant", "Activity",
                "Individual Identity", "VSO Office", "Match Fund",
            );
            //23 columns

            $cells = array("C2", "D2", "C4", "C5", "D4", "D5", "G2", "G3", "H2", "H3");

            foreach ($cells as $value) {
                $object->getActiveSheet()->getStyle("$value")->getFont()->setBold(true);

                $object->getActiveSheet()->getStyle("$value")->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => Border::BORDER_THIN,
                                'color' => array('rgb' => '000000'),
                            ),
                        ),
                    )
                );
            }

            $cells = array("C2", "C4", "C5", "G2", "G3");

            foreach ($cells as $value) {
                $object->getActiveSheet()->getStyle("$value")->getFont()->setBold(true);
                //                $object->getActiveSheet()->getStyle("$value")->applyFromArray($styleArray);

                $object->getActiveSheet()->getStyle("$value")->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'AD0076'),
                        ),
                    )
                );
            }

            $object->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "Business Unit");
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "TZA");

            $object->getActiveSheet()->setCellValueByColumnAndRow(2, 4, "Import Reference");
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, 5, "Journal Type");
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, 4, "");
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, 5, "PAYMT");

            $object->getActiveSheet()->getCell("G2")->setValue("Import Message");
            $object->getActiveSheet()->getCell("G3")->setValue("Import Error Message");
            $object->getActiveSheet()->getCell("H2")->setValue("");
            $object->getActiveSheet()->getCell("H3")->setValue("");

            $from = "B9";
            $to = "U9";
            $object->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, 8, "1;3");

            //Set Row Width
            $object->getActiveSheet()->getRowDimension("9")->setRowHeight(25);
            foreach (range('A', 'U') as $columnID) {
                $object->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            //Set ACTIVE SHEET
            $object->getActiveSheet()->getStyle("$from:$to")->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => Border::BORDER_THIN,
                            'color' => array('rgb' => '000000'),
                        ),
                    ),
                )
            );

            //Set Cell Background Color AND Font Color
            //            $object->getActiveSheet()->getStyle("B9:H9")->applyFromArray($styleArray);
            $object->getActiveSheet()->getStyle("B9:H9")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AD0076'),
                    ),
                )
            );
            $object->getActiveSheet()->getStyle("I9:N9")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFFF00'),
                    ),
                )
            );

            //            $object->getActiveSheet()->getStyle("O9:U9")->applyFromArray($styleArray);
            $object->getActiveSheet()->getStyle("O9:U9")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'AD0076'),
                    ),
                )
            );
            $column = 0;
            foreach ($table_columns as $field) {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 9, $field);
                $column++;
            }

            //FROM DATABASE
            if ($reportType == 1) {
                $records = $this->reports_model->staffPayrollInputJournalExportTime($payroll_date);
                $take_home = $this->reports_model->staff_sum_take_home($payroll_date);
                $payroll_totals = $this->payroll_model->staffPayrollTotals("payroll_logs", $payroll_date);
                $total_heslb = $this->reports_model->staffTotalheslb($payroll_date);
                $net_total = $this->netTotalSummation($payroll_date)[1];
            } else {
                $records = $this->reports_model->temporaryPayrollInputJournalExportTime($payroll_date);
                $take_home = $this->reports_model->temporary_sum_take_home($payroll_date);
                $payroll_totals = $this->payroll_model->temporaryPayrollTotals("payroll_logs", $payroll_date);
                $total_heslb = $this->reports_model->temporaryTotalheslb($payroll_date);
                $net_total_1 = $this->netTotalSummation($payroll_date)[0];
                $net_total_2 = $this->netTotalSummation($payroll_date)[2];
                $net_total = $net_total_1 + $net_total_2;
            }

            $data_row = 10;
            $serialNo = 1;
            $total = 0.00;

            foreach ($payroll_totals as $row) {
                $salary = $row->salary;
                $pension_employee = $row->pension_employee;
                $pension_employer = $row->pension_employer;
                $medical_employee = $row->medical_employee;
                $medical_employer = $row->medical_employer;
                $sdl = $row->sdl;
                $wcf = $row->wcf;
                $allowances = $row->allowances;
                $taxdue = $row->taxdue;
                $meals = $row->meals;
            }
            foreach ($take_home as $row) {
                $net = $row->takehome;
                $net_less = $row->takehome_less;
                //              $arrears= $row->arrears_payment;
            }

            $paidheslb = 0;
            foreach ($total_heslb as $row) {
                $paidheslb = $row->total_paid;
            }

            foreach ($records as $row) {

                //check assignment task
                $project_activity = $this->reports_model->employeeProjectActivity($payroll_date, $row->empID);

                if ($project_activity) {

                    foreach ($project_activity as $p_a) {

                        $total_hour = 0;
                        $total_min = 0;

                        $total_hour_p = 0;
                        $total_min_p = 0;

                        $project_activity_time = $this->reports_model->employeeProjectActivityTime($payroll_date, $row->empID, $p_a->project, $p_a->activity);

                        if ($project_activity_time) {

                            foreach ($project_activity_time as $p_a_t) {
                                try {
                                    $d1 = new DateTime($p_a_t->start_date);
                                    $d2 = new DateTime($p_a_t->end_date);
                                    $diff = $d2->diff($d1);

                                    if (($p_a_t->project == $p_a->project) && ($p_a_t->activity == $p_a->activity) && ($row->empID == $p_a->emp_id)) {
                                        $total_hour += explode('-', $diff->format('%h-%i'))[0];
                                        $total_min += explode('-', $diff->format('%h-%i'))[1];

                                        if ($total_min >= 60) {
                                            $total_hour += 1;
                                            $total_min = 0;
                                        }
                                    }

                                    if (($p_a_t->project == $p_a->project) && ($row->empID == $p_a->emp_id)) {
                                        $total_hour_p += explode('-', $diff->format('%h-%i'))[0];
                                        $total_min_p += explode('-', $diff->format('%h-%i'))[1];

                                        if ($total_min_p >= 60) {
                                            $total_hour_p += $total_min_p;
                                        }
                                    }
                                } catch (Exception $e) {
                                    echo 'error';
                                }
                            }
                        }

                        //draw your rows here

                        if ($row->mname == ' ' || $row->mname == '' || $row->mname == null) {
                            $empName = trim($row->fname) . ' ' . trim($row->lname);
                        } else {
                            $empName = trim($row->fname) . ' ' . trim($row->mname) . ' ' . trim($row->lname);
                        }

                        $grantCode = $row->grant_code;
                        if ($grantCode == "VSO") {
                            $grantCode = "#";
                        }

                        $percent = round(($total_hour / $total_hour_p), 2);

                        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $data_row, "6;7");
                        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $data_row, "PAYMTTZP010067");
                        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $data_row, $todayDate);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $data_row, "3520");
                        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $data_row, "");
                        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $data_row, $empName . " " . date('F Y', strtotime($row->payroll_date)) . " Salary");
                        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $data_row, number_format((($row->allowances + $row->salary) * $percent), 2));
                        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $data_row, "TZS");
                        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $data_row, $row->positionName);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $data_row, number_format(($row->allowances + $row->salary), 2));
                        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $data_row, ($total_hour . ' Hours'));
                        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $data_row, number_format(($percent * $row->sdl), 2));
                        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $data_row, number_format(($percent * $row->wcf), 2));
                        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $data_row, number_format(($percent * $row->pension_employee), 2));
                        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $data_row, "200");
                        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $data_row, $p_a->project);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $data_row, '');
                        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $data_row, $p_a->activity);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(19, $data_row, $row->empID);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(20, $data_row, "TZA");
                        $object->getActiveSheet()->setCellValueByColumnAndRow(21, $data_row, "");

                        for ($i = 'A'; $i < 'V'; $i++) {
                            $object->getActiveSheet()->getStyle("$i$data_row")->applyFromArray(
                                array(
                                    'borders' => array(
                                        'allborders' => array(
                                            'style' => Border::BORDER_THIN,
                                            'color' => array('rgb' => '000000'),
                                        ),
                                    ),
                                )
                            );
                        }
                        $total = $total + (($row->allowances + $row->salary) * $percent);
                        $data_row++;
                    }
                }
            }

            //            Seven Rows at the Bottom For Summation and Summary
            $summaryRowssum = 0;
            $countSummaryRows = 0;
            for ($i = $data_row; $i <= $data_row + 6; $i++) {
                if ($countSummaryRows == 0) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("Net Salaries Payable " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$net_total, 2));
                    $summaryRowssum = $summaryRowssum - $net_total;
                }
                if ($countSummaryRows == 1) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("PAYE Payable " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$taxdue, 2));
                    $summaryRowssum = $summaryRowssum - $taxdue;
                }
                if ($countSummaryRows == 2) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("Employee Pension contribution " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$pension_employee, 2));
                    $summaryRowssum = $summaryRowssum - $pension_employee;
                }
                if ($countSummaryRows == 3) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("HESLB Payable " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$paidheslb, 2));
                    $summaryRowssum = $summaryRowssum - $paidheslb;
                }
                if ($countSummaryRows == 4) {
                    $object->getActiveSheet()->getCell("F$i")->setValue("Net Salaries " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format($net_total, 2));
                    $summaryRowssum = $summaryRowssum + $net_total;
                }
                if ($countSummaryRows == 5) {
                    // $object->getActiveSheet()->getStyle("D$i:H$i")->applyFromArray(
                    //     // array(
                    //     //     'fill' => array(
                    //     //         'type' => Fill::FILL_SOLID,
                    //     //         'color' => array('rgb' => 'AAD08E')
                    //     //     )
                    //     // )
                    // );
                    $object->getActiveSheet()->getCell("F$i")->setValue("Net Salaries Payable to VSO Staff in " . date('F, Y', strtotime($row->payroll_date)));
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format(-$net_total, 2));
                    $object->getActiveSheet()->getCell("D$i")->setValue("CBTZ001");
                    $object->getActiveSheet()->getCell("H$i")->setValue("TZS");
                    $object->getActiveSheet()->getCell("T$i")->setValue("TZA");

                    $summaryRowssum = $summaryRowssum - $net_total;
                }
                if ($countSummaryRows == 6) {
                    // $object->getActiveSheet()->getStyle("F$i:H$i")->applyFromArray(
                    //     // array(
                    //     //     'fill' => array(
                    //     //         'type' => Fill::FILL_SOLID,
                    //     //         'color' => array('rgb' => 'ED7C31')
                    //     //     )
                    //     // )
                    // );
                    $sum = 0.00 + $summaryRowssum + $total;

                    // if($sum < 1.00 && 1.00-$sum < 1.00){
                    //     $sum = 0.00;
                    // }
                    $object->getActiveSheet()->getCell("F$i")->setValue("Check Balance");
                    $object->getActiveSheet()->getCell("G$i")->setValue(number_format($sum, 2));
                }
                $countSummaryRows++;
            }

            $startRow = $data_row + 1;
            $endRow = $startRow + 6;
            $count = $startRow;
            for ($n = $startRow; $n <= $endRow; $n++) {
                $repeated = $n - 2;
                $object->getActiveSheet()->getCell("A$repeated")->setValue("6;7");
                $object->getActiveSheet()->getCell("B$repeated")->setValue("PAYMTTZP010067");
                $object->getActiveSheet()->getCell("C$repeated")->setValue("" . $todayDate);

                $nextRepeated = $repeated + 1;
                if ($count < ($endRow - 1)) {
                    $object->getActiveSheet()->getCell("D$nextRepeated")->setValue("1717");
                    $object->getActiveSheet()->getCell("H$nextRepeated")->setValue("TZS");
                    $object->getActiveSheet()->getCell("S$nextRepeated")->setValue("#");
                    $object->getActiveSheet()->getCell("T$nextRepeated")->setValue("TZA");
                    // $object->getActiveSheet()->getStyle("D$nextRepeated:H$nextRepeated")->applyFromArray(
                    //     // array(
                    //     //     'fill' => array(
                    //     //         'type' => Fill::FILL_SOLID,
                    //     //         'color' => array('rgb' => 'FFFF00')
                    //     //     )
                    //     // )
                    // );
                }
                for ($i = 'A'; $i < 'V'; $i++) {
                    $p = ($n - 1);
                    $object->getActiveSheet()->getStyle("$i$p")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000'),
                                ),
                            ),
                        )
                    );
                }
                $count++;
            }

            $writer = new Xls($object); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            ob_start();
            $writer->save('php://output'); // download file

            // if($result==true) {
            //     echo "<p class='alert alert-success text-center'>Audit Trails Cleared Successifully!</p>";
            //     } else { echo "<p class='alert alert-danger text-center'>FAILED to clear audit logs, Try Again</p>"; }

            //end
        } else {
            exit("Invalid Resource Access");
        }
    }

    public function staffPayrollBankExport(Request $request)
    {
        //dd($request->all());
        if (1) {
            $payroll_date = $request->input('payrolldate');
            $reportType = 1;  //Staff = 1, temporary = 2
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2
            $suffix = "";
            if ($reportType == 1) {
                $suffix = "Salary";
                $filename = "staffPayrollBankExport" . date('Y_m_d_H_i_s') . ".xls";
            } else {
                $suffix = "Allowance";
                $filename = "temporaryPayrollBankExport" . date('Y_m_d_H_i_s') . ".xls";
            }

            //start
            $todayDate = date('d/m/Y');
            $object = new Spreadsheet();
            $object->setActiveSheetIndex(0);

            $table_columns = array(
                "", "Payment Type", "Payment Date", "Debit Account Number", "Beneficiary Name", "Payment Amount", "Payment Details", "Beneficiary Account Number", "Beneficiary Bank Name", "Beneficiary Bank Code", "Beneficiary Bank Local Clearing Branch Code", "Debit Account City code", "Debit Account Country Code", "Payment Currency", "Beneficiary Email ID",
            );

            $column = 0;
            foreach ($table_columns as $field) {
                //$object->getActiveSheet()->getCell("H2")->setValue("");

                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);

                $column++;
            }
            $j = 2;
            for ($i = 'A'; $i <= 'N'; $i++) {
                $object->getActiveSheet()->getColumnDimension("$i")->setAutoSize(true);
                $object->getActiveSheet()->getStyle("$i$j")->getFont()->setBold(true);
                $object->getActiveSheet()->getStyle("$i$j")->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => Border::BORDER_THIN,
                                'color' => array('rgb' => '000000'),
                            ),
                        ),
                    )
                );
            }

            //FROM DATABASE
            $payroll_totals = $this->reports_model->staffPayrollBankExport($payroll_date);
            if ($reportType == 1) {
                $payroll_totals = $this->reports_model->staffPayrollBankExport($payroll_date);
            } else {
                $payroll_totals = $this->reports_model->temporaryPayrollBankExport($payroll_date);
            }

            $data_row = 3;
            $serialNo = 1;

            foreach ($payroll_totals as $row) {
                $amount = $row->salary + $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;

                if ($row->mname == ' ' || $row->mname == '' || $row->mname == null) {
                    $empName = trim($row->fname) . ' ' . trim($row->lname);
                } else {
                    $empName = trim($row->fname) . ' ' . trim($row->mname) . ' ' . trim($row->lname);
                }

                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $data_row, "PAY");
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $data_row, $todayDate);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $data_row, "0108006211500");
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $data_row, $empName);
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $data_row, number_format($amount, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $data_row, "" . date('F Y', strtotime($row->payroll_date)) . " " . $suffix);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $data_row, $row->account_no);
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $data_row, $row->bankName);
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $data_row, $row->bankCode);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $data_row, $row->bankLoalClearingCode);
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $data_row, $row->debitAccountCityCode);
                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $data_row, $row->debitAccountCountryCode);
                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $data_row, $row->paymentCurrency);
                $object->getActiveSheet()->setCellValueByColumnAndRow(14, $data_row, $row->email);

                for ($i = 'A'; $i <= 'N'; $i++) {
                    $object->getActiveSheet()->getStyle("$i$data_row")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000'),
                                ),
                            ),
                        )
                    );
                }
                $data_row++;
            }

            $writer = new Xls($object); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            ob_start();
            $writer->save('php://output'); // download file

            //end
        } else {
            exit("Invalid Resource Access");
        }
    }

    public function payrollReconciliationDetails(Request $request){
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
        $today = date('Y-m-d');

        $current_payroll_month = $request->input('payrolldate');
        $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
        $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);


        $count_previous_month = $this->reports_model->s_count($previous_payroll_month);
        $count_current_month = $this->reports_model->s_count($current_payroll_month);

        $current_decrease =  $this->reports_model->basic_decrease($previous_payroll_month,$current_payroll_month);
        $current_increase = $this->reports_model->basic_increase($previous_payroll_month,$current_payroll_month);




        if($count_current_month > $count_previous_month){
            //increase of employee
            $data['employee_increase'] = $this->reports_model->employee_increase($current_payroll_month, $previous_payroll_month);

        }elseif($count_previous_month > $count_current_month){
           //decrease of employee
           $data['employee_decrease'] = $this->reports_model->employee_decrease($current_payroll_month, $previous_payroll_month);
           dd($$data['employee_increase']);
        }

        if($current_increase['basic_increase'] > 0){
            //add increase in basic pay
            $data['basic_increase'] = $this->reports_model->employee_basic_increase($current_payroll_month, $previous_payroll_month);


        }
        if ($current_decrease['basic_decrease'] > 0){
            //less decrease in basic pay
            $data['basic_decrease'] = $this->reports_model->employee_basic_decrease($current_payroll_month, $previous_payroll_month);
           // dd($data['basic_decrease']);

        }





        //allowances
        $data['summary'] = $this->reports_model->allowance_by_employee($current_payroll_month, $previous_payroll_month);
        $raw_name = [];
        $required_allowance = [];

        foreach($data['summary'] as $row){

         if($row->previous_amount + $row->current_amount != 0 ){
            array_push($raw_name,$row->description);
            array_push($required_allowance,$row);
         }
        }
        $names = array_unique($raw_name);

        $data['names'] = $names;
        $data['allowances'] = $required_allowance;


        $data['payroll_date'] = $calendar;

        $pdf = Pdf::loadView('reports.payroll_reconciliation_details',$data)->setPaper('a4', 'potrait');

        return $pdf->download('payroll_reconciliation_details.pdf');

    }

    public function payrollReconciliationSummary(Request $request)
    {

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


        //$pdf = Pdf::loadView('reports.payroll_reconciliation_summary1', $data);
        // $pdf = Pdf::loadView('reports.payroll_details',$data);



        //return $pdf->download('sam.pdf');
         $pdf = Pdf::loadView('reports.payroll_reconciliation_summary1',$data)->setPaper('a4', 'potrait');

         return $pdf->download('payroll_reconciliation_summary.pdf');
        //return view('reports.payroll_reconciliation_summary1', $data);

       // return view('reports.samplepdf', $data);
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

    #################################END PROJECT REPORTS##############################

    ############################################################################
    ################################  PHP MAILER ################################
    function dynamic_pdf(Request $request)
    {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $payrolldate = "2019-06-05";
        $heslb = $this->reports_model->heslb($payrolldate);
        $info = $this->reports_model->company_info();
        $payrolldate = $payrolldate;
        $total = $this->reports_model->totalheslb($payrolldate);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Cits');
        $pdf->SetTitle('P9-' . date('d/m/Y'));
        $pdf->SetSubject('PAYE');
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
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once dirname(__FILE__) . '/lang/eng.php';
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('times', '', 12, '', true);

        // TIN NUMBER

        foreach ($info as $key) {
            $name = $key->cname;
            $tin = $key->tin;
            $postal_address = $key->postal_address;
            $postal_city = $key->postal_city;
            $phone_no1 = $key->phone_no1;
            $phone_no2 = $key->phone_no2;
            $phone_no3 = $key->phone_no3;
            $fax_no = $key->fax_no;
            $email = $key->email;
            $plot_no = $key->plot_no;
            $block_no = $key->block_no;
            $branch = $key->branch;
            $street = $key->street;
        }

        // This method has several options, check the source code documentation for more information.
        // $pdf->AddPage();
        $pdf->AddPage('L', 'A4');
        // $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');

        $pdf->SetXY(0, 18);
        $header1 = <<<"EOD"
<p align="center">HESLB LOAN REPAYMENT SCHEDULE<br>(To be submitted duly completed with every payment to HESLB)</p>
EOD;
        $pdf->writeHTMLCell(0, 12, '', '', $header1, 0, 1, 0, true, '', true);

        // EMPLOYER
        foreach ($info as $key) {
            $name = $key->cname;
            $tin = $key->tin;
            $postal_address = $key->postal_address;
            $postal_city = $key->postal_city;
            $phone_no1 = $key->phone_no1;
            $phone_no2 = $key->phone_no2;
            $phone_no3 = $key->phone_no3;
            $fax_no = $key->fax_no;
            $email = $key->email;
            $plot_no = $key->plot_no;
            $block_no = $key->block_no;
            $branch = $key->branch;
            $street = $key->street;
            $heslbcode = $key->heslb_code_no;
        }
        $payrollmonth = date('F, Y', strtotime($payrolldate));

        $pdf->SetFont('times', '', 10, '', true);
        $pdf->SetXY(40, 34);
        $header = "<p><b>NAME OF EMPLOYER:&nbsp;&nbsp;</b>  " . strtoupper($name) . "<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>POSTAL ADDRESS:&nbsp;&nbsp;&nbsp;</b>" . $postal_address . "<br><br><br>";

        $pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);

        $pdf->SetXY(55, 54);
        $htm = "<p><b>TELEPHONE:&nbsp;&nbsp;&nbsp;</b>" . $phone_no1 . "<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>EMAIL:&nbsp;&nbsp;&nbsp;</b>" . $email . "</p>";
        $pdf->writeHTMLCell(0, 12, '', '', $htm, 0, 1, 0, true, '', true);

        $pdf->SetXY(190, 34);
        $header2 = "<p><b>EMPLOYER HESLB CODE NO:&nbsp;&nbsp;</b>&nbsp;&nbsp;&nbsp;" . $heslbcode . "<br><br><br><br>
      <b>PAYROLL MONTH:&nbsp;&nbsp;</b>" . $payrollmonth;
        $pdf->writeHTMLCell(0, 12, '', '', $header2, 0, 1, 0, true, '', true);

        $pdf->SetFont('times', '', 12, '', true);
        // Set some content to print
        $pdf->SetXY(38, 30);

        $html = '<table align="center" border="1px">';

        $html .= '<tr>
        <th colspan="5"><br><br><br><br><br><br><br><br></th>
    </tr>';

        $html .= '<tr>
        <th width = "40px" >S/NO</th>
        <th>INDEX NUMBER</th>
        <th >PF/CHECK NO</th>
        <th width = "200px">NAME OF LOANEE</th>
        <th width = "160px">AMOUNT DEDUCTED</th>
        <th >OUTSNDING BALANCE</th>
    </tr>';

        // MYSQL DATA

        foreach ($heslb as $key) {
            $index = $key->form_four_index_no;
            $pf = "N/A";
            $name = $key->name;
            $amountdeducted = $key->paid;
            $out = $key->remained;

            $html .= '<tr>
          <td width= "40px">' . $key->SNo . '</td>
          <td >' . $index . '</td>
          <td >' . $pf . '</td>
          <td width = "200px">' . $name . '</td>
          <td width = "160px">' . number_format($amountdeducted, 2) . '</td>
          <td >' . number_format($out, 2) . '</td>
       </tr>';
        }

        foreach ($total as $key) {
            $sum1 = $key->total_paid;
            $sum2 = $key->total_remained;
        }
        $html .= "<tr>
      <td></td>
          <td >TOTAL DEDUCTIONS</td>
          <td></td>
          <td></td>
          <td>" . number_format($sum1, 2) . "</td>
          <td>" . number_format($sum2, 2) . "</td>
          </tr>";

        $html .= '</table>
      <table border="1px">
      <tr>
      <td><br><br><br>Paid by Cheque Number................................................................
      Dated:...........................................
      Paid in by:................................................<br><br>
      HESLB Receipt No. Issued: ..........................................................
      Date of Receipt.................................
      Receipted By.......................................</td>
      </tr>
      </table>';
        // MYSQL DATA

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        // $pdf->Output('heslb-'.date('d/m/Y').'.pdf', 'I');
        $pdfString = $pdf->Output('quotation.pdf', 'S');

        // SEND EMAIL
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mirajissa1@gmail.com';
        $mail->Password = 'Mirajissa1@1994';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

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
        $mail->AddStringAttachment($pdfString, 'some_filename.pdf');

        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent SUCCESSIFULLY';
        }

        // SEND EMAIL

        //============================================================+
        // END OF FILE
        //============================================================+
    }

    function employeeReport(Request $request)
    {
        if ($request->input('print')) {
            $empID = $request->input("employee");
            $data['employee_info'] = $this->reports_model->employeeProfile($empID);
            return view('app.reports/employee_profile', $data);
        }
    }

    public function employeeCostExport(Request $request)
    {
        dd($request->all());
        if (1) {
            $payroll_date = $request->input('payrolldate');
            $reportType = 1;  //Staff = 1, temporary = 2
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2
            $suffix = "";
            if ($reportType == 1) {
                $suffix = "Salary";
                $filename = "staffEmployeeCostExport" . date('Y_m_d_H_i_s') . ".xls";
            } else {
                $suffix = "Allowance";
                $filename = "temporaryEmployeeCostExport" . date('Y_m_d_H_i_s') . ".xls";
            }

            //start
            $todayDate = date('d/m/Y');
            $object = new Spreadsheet();
            $object->setActiveSheetIndex(0);

            $table_columns = array(
                "", "Employee Name", "Employee ID", "Monthly Basic", "Allowances", "Gross Salary", "Employee Pension",
                "Taxable Amount", "Tax Payable(PAYE)", "Employee Medical", "Deductions (HESLB, Advance)",
                "Net Salary", "Employer Pension", "Employer Medical", "SDL", "WCF", "Total Pension", "Total Medical",
                "Total Employment Cost",
                //                "Salary After Tax","Provident Fund Contr (Employee)","HESLB","Loan Deduction","Total Take Home Salary"
            );

            $column = 0;
            foreach ($table_columns as $field) {
                //$object->getActiveSheet()->getCell("H2")->setValue("");

                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);

                $column++;
            }
            $j = 2;
            for ($i = 'A'; $i <= 'N'; $i++) {
                $object->getActiveSheet()->getColumnDimension("$i")->setAutoSize(true);
                $object->getActiveSheet()->getStyle("$i$j")->getFont()->setBold(true);
                $object->getActiveSheet()->getStyle("$i$j")->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => Border::BORDER_THIN,
                                'color' => array('rgb' => '000000'),
                            ),
                        ),
                    )
                );
            }

            //FROM DATABASE
            if ($reportType == 1) {
                $payroll_totals = $this->reports_model->s_new_employment_cost_employee_list1($payroll_date);
            } else {
                $payroll_totals = $this->reports_model->v_new_employment_cost_employee_list1($payroll_date);
            }
            $paye = $this->reports_model->paye();
            $data_row = 3;
            $serialNo = 1;

            foreach ($payroll_totals as $row) {

                $non_pensionable_employee = $this->reports_model->nonPensionableEmployee($row->empID);

                if ($non_pensionable_employee) {
                    $pension = 0;
                } else {
                    $pension = (($row->salary + $row->allowances) * 0.1);
                }

                if ($row->mname == ' ' || $row->mname == '' || $row->mname == null) {
                    $empName = trim($row->fname) . ' ' . trim($row->lname);
                } else {
                    $empName = trim($row->fname) . ' ' . trim($row->mname) . ' ' . trim($row->lname);
                }
                $taxable_amount = ($row->salary + $row->allowances) - $pension;

                $less_tax = $taxable_amount;
                $tax_rate = 0;
                $excess_tax = 0;
                foreach ($paye as $item) {
                    switch ($taxable_amount) {
                        case ($item->minimum <= $taxable_amount) && ($taxable_amount <= $item->maximum):
                            $less_tax = $item->minimum;
                            $tax_rate = $item->rate;
                            $excess_tax = $item->excess_added;
                            break;
                    }
                }
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $data_row, $empName);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $data_row, $row->empID);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $data_row, number_format($row->salary, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $data_row, number_format($row->allowances, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $data_row, number_format($row->salary + $row->allowances, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $data_row, number_format($pension, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $data_row, number_format(($row->salary + $row->allowances) - ($pension), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $data_row, number_format(((($taxable_amount - $less_tax) * $tax_rate)) + $excess_tax, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $data_row, number_format($row->medical_employee, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $data_row, number_format(($row->heslb_loans) + ($row->loans), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $data_row, number_format(((($row->salary + $row->allowances) - ($pension)) - (((($taxable_amount - $less_tax) * $tax_rate)) + $excess_tax)) - ($row->loans) - ($row->heslb_loans), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $data_row, number_format($row->pension_employer, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $data_row, number_format($row->medical_employer, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(14, $data_row, number_format($row->sdl, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(15, $data_row, number_format($row->wcf, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(16, $data_row, number_format($pension + $row->pension_employer, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(17, $data_row, number_format($row->medical_employee + $row->medical_employer, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(18, $data_row, number_format(($row->salary + $row->allowances) + $row->sdl + $row->wcf + $row->pension_employer + $row->medical_employer, 2));

                for ($i = 'A'; $i <= 'N'; $i++) {
                    $object->getActiveSheet()->getStyle("$i$data_row")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000'),
                                ),
                            ),
                        )
                    );
                }
                $data_row++;
            }

            $writer = new Xls($object); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            ob_start();
            $writer->save('php://output'); // download file

            //end
        } else {
            exit("Invalid Resource Access");
        }
    }

    public function employeeCostExport_temp(Request $request)
    {
        if ($request->input('payrolldate')) {
            $payroll_date = $request->input('payrolldate');
            $filename = "employeeCostExport" . date('Y_m_d_H_i_s') . ".xls";

            //start
            $todayDate = date('d/m/Y');
            $object = new Spreadsheet();
            $object->setActiveSheetIndex(0);

            $table_columns = array(
                "", "Employee Name", "Employee ID", "Monthly Basic", "Allowances", "Gross Salary", "Employee Pension",
                "Taxable Amount", "Tax Payable(PAYE)", "Employee Medical", "Deductions (HESLB, Advance)",
                "Net Salary", "Employer Pension", "Employer Medical", "SDL", "WCF", "Total Pension", "Total Medical",
                "Total Employment Cost",
                //                "Salary After Tax","Provident Fund Contr (Employee)","HESLB","Loan Deduction","Total Take Home Salary"
            );

            $column = 0;
            foreach ($table_columns as $field) {
                //$object->getActiveSheet()->getCell("H2")->setValue("");

                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);

                $column++;
            }
            $j = 2;
            for ($i = 'A'; $i <= 'N'; $i++) {
                $object->getActiveSheet()->getColumnDimension("$i")->setAutoSize(true);
                $object->getActiveSheet()->getStyle("$i$j")->getFont()->setBold(true);
                $object->getActiveSheet()->getStyle("$i$j")->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => Border::BORDER_THIN,
                                'color' => array('rgb' => '000000'),
                            ),
                        ),
                    )
                );
            }

            //FROM DATABASE
            $payroll_totals = $this->reports_model->a_new_employment_cost_employee_list1_temp($payroll_date);

            $paye = $this->reports_model->paye();
            $data_row = 3;
            $serialNo = 1;

            foreach ($payroll_totals as $row) {

                $non_pensionable_employee = $this->reports_model->nonPensionableEmployee($row->empID);

                if ($non_pensionable_employee) {
                    $pension = 0;
                } else {
                    $pension = (($row->salary + $row->allowances) * 0.1);
                }

                if ($row->mname == ' ' || $row->mname == '' || $row->mname == null) {
                    $empName = trim($row->fname) . ' ' . trim($row->lname);
                } else {
                    $empName = trim($row->fname) . ' ' . trim($row->mname) . ' ' . trim($row->lname);
                }
                $taxable_amount = ($row->salary + $row->allowances) - $pension;

                $less_tax = $taxable_amount;
                $tax_rate = 0;
                $excess_tax = 0;
                foreach ($paye as $item) {
                    switch ($taxable_amount) {
                        case ($item->minimum <= $taxable_amount) && ($taxable_amount <= $item->maximum):
                            $less_tax = $item->minimum;
                            $tax_rate = $item->rate;
                            $excess_tax = $item->excess_added;
                            break;
                    }
                }
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $data_row, $empName);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $data_row, $row->empID);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $data_row, number_format($row->salary, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $data_row, number_format($row->allowances, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $data_row, number_format($row->salary + $row->allowances, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $data_row, number_format($pension, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $data_row, number_format(($row->salary + $row->allowances) - ($pension), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $data_row, number_format(((($taxable_amount - $less_tax) * $tax_rate)) + $excess_tax, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $data_row, number_format($row->medical_employee, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $data_row, number_format(($row->heslb_loans) + ($row->loans), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $data_row, number_format(((($row->salary + $row->allowances) - ($pension)) - (((($taxable_amount - $less_tax) * $tax_rate)) + $excess_tax)) - ($row->loans) - ($row->heslb_loans), 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $data_row, number_format($row->pension_employer, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $data_row, number_format($row->medical_employer, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(14, $data_row, number_format($row->sdl, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(15, $data_row, number_format($row->wcf, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(16, $data_row, number_format($pension + $row->pension_employer, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(17, $data_row, number_format($row->medical_employee + $row->medical_employer, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(18, $data_row, number_format(($row->salary + $row->allowances) + $row->sdl + $row->wcf + $row->pension_employer + $row->medical_employer, 2));

                for ($i = 'A'; $i <= 'N'; $i++) {
                    $object->getActiveSheet()->getStyle("$i$data_row")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000'),
                                ),
                            ),
                        )
                    );
                }
                $data_row++;
            }

            $writer = new Xls($object); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            ob_start();
            $writer->save('php://output'); // download file

            //end
        } else {
            exit("Invalid Resource Access");
        }
    }

    public function employeeBioDataExport(Request $request)
    {
        dd($request->all());

        if (1 && $request->input('status') != '') {
            $payroll_date = $request->input('payrolldate');
            $reportType = 1;
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2
            $status = $request->input('status'); //active = 1, exited = 4
            $suffix = "";

            if ($reportType == 1) {
                $suffix = "Salary";
                $filename = "staffEmployeeBioDataExport" . date('Y_m_d_H_i_s') . ".xls";
            } else {
                $suffix = "Allowance";
                $filename = "temporaryEmployeeBioDataExport" . date('Y_m_d_H_i_s') . ".xls";
            }

            //start
            $todayDate = date('d/m/Y');
            $object = new Spreadsheet();
            $object->setActiveSheetIndex(0);

            $table_columns = array(
                "Employee Name", "Employee ID", "Date of Birth", "Gender", "Grade", "Date Joined", "Date End of Service",
                "Department ", "Position", "Branch", "Contract Type", "Basic Salary", "Pension Fund Name",
                "Pension Fund #", "Bank Account Name", "Bank Account #", "Employee Mobile #", "Available leave days"
            );

            $column = 0;
            foreach ($table_columns as $field) {
                //$object->getActiveSheet()->getCell("H2")->setValue("");

                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);

                $column++;
            }
            $j = 2;
            for ($i = 'A'; $i <= 'N'; $i++) {
                $object->getActiveSheet()->getColumnDimension("$i")->setAutoSize(true);
                $object->getActiveSheet()->getStyle("$i$j")->getFont()->setBold(true);
                $object->getActiveSheet()->getStyle("$i$j")->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => Border::BORDER_THIN,
                                'color' => array('rgb' => '000000'),
                            ),
                        ),
                    )
                );
            }

            //FROM DATABASE
            if ($reportType == 1) {
                if ($status == 1) {
                    $payroll_totals = $this->reports_model->s_employee_bio_data_active($payroll_date);
                } else {
                    $payroll_totals = $this->reports_model->s_employee_bio_data_inactive($payroll_date);
                }
            } else {
                if ($status == 1) {
                    $payroll_totals = $this->reports_model->v_employee_bio_data_active($payroll_date);
                } else {
                    $payroll_totals = $this->reports_model->v_employee_bio_data_inactive($payroll_date);
                }
            }
            $paye = $this->reports_model->paye();
            $data_row = 3;
            $serialNo = 1;

            foreach ($payroll_totals as $row) {

                if ($row->mname == ' ' || $row->mname == '' || $row->mname == null) {
                    $empName = trim($row->fname) . ' ' . trim($row->lname);
                } else {
                    $empName = trim($row->fname) . ' ' . trim($row->mname) . ' ' . trim($row->lname);
                }

                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $data_row, $empName);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $data_row, $row->empID);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $data_row, $row->birthdate);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $data_row, $row->gender);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $data_row, '');
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $data_row, $row->hire_date);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $data_row, $row->contract_end);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $data_row, $row->department);
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $data_row, $row->position);
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $data_row, $row->branch);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $data_row, $row->contract);
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $data_row, number_format($row->salary, 2));
                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $data_row, $row->pension);
                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $data_row, $row->pf_membership_no);
                $object->getActiveSheet()->setCellValueByColumnAndRow(14, $data_row, $row->bank);
                $object->getActiveSheet()->setCellValueByColumnAndRow(15, $data_row, $row->account_no);
                $object->getActiveSheet()->setCellValueByColumnAndRow(16, $data_row, $row->mobile);
                $object->getActiveSheet()->setCellValueByColumnAndRow(17, $data_row, '');

                for ($i = 'A'; $i <= 'N'; $i++) {
                    $object->getActiveSheet()->getStyle("$i$data_row")->applyFromArray(
                        array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => Border::BORDER_THIN,
                                    'color' => array('rgb' => '000000'),
                                ),
                            ),
                        )
                    );
                }
                $data_row++;
            }

            $writer = new Xls($object); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            ob_start();
            $writer->save('php://output'); // download file

            //end
        } else {
            exit("Invalid Resource Access");
        }
    }

    public function grossReconciliation(Request $request)
    {
        // dd($request->all());

        if (1) {
            $current_payroll_month = $request->input('payrolldate');
            $reportType = 1;  //Staff = 1, temporary = 2
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2
            $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
            $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

            if ($reportType == 1) {
                $payroll_employees = $this->reports_model->s_payrollEmployee($current_payroll_month, $previous_payroll_month);
                $total_previous_gross = $this->reports_model->s_grossMonthly($previous_payroll_month);
                $total_current_gross = $this->reports_model->s_grossMonthly($current_payroll_month);
            } else {
                $payroll_employees = $this->reports_model->v_payrollEmployee($current_payroll_month, $previous_payroll_month);
                $total_previous_gross = $this->reports_model->v_grossMonthly($previous_payroll_month);
                $total_current_gross = $this->reports_model->v_grossMonthly($current_payroll_month);
            }

            foreach ($payroll_employees as $employee) {
                if ($reportType == 1) {
                    $data['current_payroll'][$employee->empID] = $this->reports_model->s_employeeGross($current_payroll_month, $employee->empID);
                    $data['previous_payroll'][$employee->empID] = $this->reports_model->s_employeeGross($previous_payroll_month, $employee->empID);
                } else {
                    $data['current_payroll'][$employee->empID] = $this->reports_model->v_employeeGross($current_payroll_month, $employee->empID);
                    $data['previous_payroll'][$employee->empID] = $this->reports_model->v_employeeGross($previous_payroll_month, $employee->empID);
                }
            }

            $data['emp_ids'] = $payroll_employees;
            $data['total_previous_gross'] = $total_previous_gross;
            $data['total_current_gross'] = $total_current_gross;
            return view('app.gross_recon', $data);
        }
    }

    public function netReconciliation(Request $request)
    {
        //dd($request->all());

        if (1) {
            $reportType = 1;
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2
            $current_payroll_month = $request->input('payrolldate');
            $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));
            $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);
            if ($reportType == 1) {
                $payroll_employees = $this->reports_model->s_payrollEmployee($current_payroll_month, $previous_payroll_month);
                $total_previous_net = $this->reports_model->staff_sum_take_home($previous_payroll_month);
                $total_current_net = $this->reports_model->staff_sum_take_home($current_payroll_month);
            } else {
                $payroll_employees = $this->reports_model->v_payrollEmployee($current_payroll_month, $previous_payroll_month);
                $total_previous_net = $this->reports_model->temporary_sum_take_home($previous_payroll_month);
                $total_current_net = $this->reports_model->temporary_sum_take_home($current_payroll_month);
            }

            foreach ($payroll_employees as $employee) {
                if ($reportType == 1) {
                    $data['current_payroll'][$employee->empID] = $this->reports_model->s_employeeNet($current_payroll_month, $employee->empID);
                    $data['previous_payroll'][$employee->empID] = $this->reports_model->s_employeeNet($previous_payroll_month, $employee->empID);
                } else {
                    $data['current_payroll'][$employee->empID] = $this->reports_model->v_employeeNet($current_payroll_month, $employee->empID);
                    $data['previous_payroll'][$employee->empID] = $this->reports_model->v_employeeNet($previous_payroll_month, $employee->empID);
                }
            }

            $data['emp_ids'] = $payroll_employees;
            $data['total_previous_net'] = $total_previous_net;
            $data['total_current_net'] = $total_current_net;
            return view('app.net_recon', $data);
        }
    }

    public function loanReports(Request $request)
    {
        //dd($request->all());

        if (1) {
            $payroll_date = $request->input('payrolldate');
            $reportType = 1;
            $reportformat = $request->input('type'); //Staff = 1, temporary = 2
            $suffix = "";
            if ($reportType == 1) {
                $suffix = "Salary";
                $data['loans'] = $this->reports_model->s_loanReport($payroll_date);
            } else {
                $suffix = "Allowance";
                $data['loans'] = $this->reports_model->v_loanReport($payroll_date);
            }
            $data['info'] = $this->reports_model->company_info();
            $data['payroll_date'] = $payroll_date;

            return view('app.reports/loan_report_new', $data);
        }
    }

    function payrolldetails(Request $request)
    {

        $date = $request->payrolldate;
        $data['summary'] = $this->reports_model->get_payroll_summary($date);
        $data['termination'] = $this->reports_model->get_termination($date);

        $payrollMonth = $date;
        $pensionFund = 2;
        $reportType = 1; //Staff = 1, temporary = 2

        $datewell = explode("-", $payrollMonth);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];
        $date = $yyyy . "-" . $mm;

        $data['payroll_date'] = $request->payrolldate;



        $summary = $data['summary'];

        //$data = ['title' => 'Welcome to ItSolutionStuff.com'];

         $pdf = Pdf::loadView('reports.payroll_details',$data)->setPaper('a4', 'landscape');



         return $pdf->download('payrolldetails.pdf');
        //  if($request->type != 1)
        //  return view('reports.payrolldetails_datatable',$data);
        //  else
        // return view('reports.payroll_details', $data);

        // include(app_path() . '/reports/temp_payroll.php');
    }

    public function payrollReportLogs(Request $request)
    {
        $date = explode('-',$request->payrolldate);
        $month = $date[0].'-'.$date[1];
        $data['payroll_date'] = $request->payrolldate;
        $data['payrollMonth'] = $request->payrolldate;


        $data['logs'] = $this->flexperformance_model->financialLogs($month);

        $data['title'] = 'Payroll Input Changes Approval Report';
        $data['parent'] = 'Payroll Log Report';
        if($request->type == 1)
        return view('reports.input_approval', $data);
        elseif($request->type = 2)
        return view('payroll.payroll_changes',$data);
        else
        return view('audit-trail.financial_logs', $data);


    }

    public function annualleave1(Request $request)
{
    $data = $this->attendance_model->get_anual_leave_position($request->duration);

    //dd($request->duration);
}


    public function annualleave(Request $request)
    {
        // dd("hello");


        // dd($request->duration);

        if ($request->leave_employee == Null || $request->leave_employee == "All") {
            // $employee= Employee::all();

            $employees = Employee::where('state', '=', 1)->get();

            foreach ($employees  as $employee) {

                // $d1 = new \DateTime(date($employee->hire_date));

                // $d2 =new \DateTime("now");
                // $diff = $d1->diff($d2);

                // $years=$diff->y;
                // $months=$diff->m;
                // $days=$diff->d;

                // $days_this_month = intval(date('t', strtotime(date(''))));
                // $accrual_days = $days*$employee->accrual_rate/$days_this_month;

                $employee->maximum_days = $this->attendance_model->getLeaveTaken($employee->emp_id, $employee->hire_date, $request->duration);

                // $accrual_days = $days*$employee->accrual_rate/$days_this_month;
                $employee->day_entitled = $employee->leave_days_entitled;

                $employee->rate = $employee->salary/$employee->leave_days_entitled;

                $employee->accrual_days = $employee->accrual_rate;

                $employee->opening_balance = $this->attendance_model->getOpeningLeaveBalance($employee->emp_id, $employee->hire_date, $request->duration);


                $employee->current_balance = $this->attendance_model->getClossingLeaveBalance($employee->emp_id, $employee->hire_date, $request->duration);

                // $employee->current_balance = $this->attendance_model->getLeaveBalance($employee->emp_id, $employee->hire_date, $request->duration);

               // $employee->current_balance = $this->attendance_model->getLeaveBalance($employee->emp_id, $employee->hire_date, $request->duration);
            }
            // dd("all here");
        } else {

            $employees = Employee::where('emp_id', $request->leave_employee)->where('state', '=', 1)->get();

            foreach ($employees  as $employee) {

                $d1 = new \DateTime(date($employee->hire_date));

                $d2 = new \DateTime("now");
                $diff = $d1->diff($d2);

                $years = $diff->y;
                $months = $diff->m;
                $days = $diff->d;

                $days_this_month = intval(date('t', strtotime(date(''))));

                $employee->maximum_days = $this->attendance_model->getLeaveTaken($employee->emp_id, $employee->hire_date, $request->duration);

                $accrual_days = $days * $employee->accrual_rate / $days_this_month;

                $employee->accrual_days = $accrual_days;

                $employee->opening_balance = $this->attendance_model->getOpeningLeaveBalance($employee->emp_id, $employee->hire_date, $request->duration);

                $employee->current_balance = $this->attendance_model->getLeaveBalance($employee->emp_id, $employee->hire_date, $request->duration);
            }
        }
        // dd($employees);

        return view('reports.leave_balance', ['employees' => $employees]);
    }

     public function annualLeaveData(Request $request)
    {
        # code...

        $date = explode('-',$request->duration);
        // $dur = $date[0].'-'.$date[1];
        $year =$date[0];
        $month =$date[1];
        // $dur = date('Y-m', strtotime($month));
        // dd($dur);
        $leave_data = $this->attendance_model->getMonthlyLeave();
        // dd($leave_data);
        return view('app.reports.annual_leave_data', compact('leave_data'));
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

        return [$amount_mwp, $amount_staff_bank, $amount_temporary_bank];
    }
}
