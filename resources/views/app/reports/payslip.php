<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
// Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Miraji Issa');
$pdf->SetTitle('Payslip');
$pdf->SetSubject('Cipay');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data

// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001',
//  PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
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
$pdf->AddPage('P','A4');



foreach( $slipinfo as $row){
    $id = $row->empID;
    $old_id = $row->oldID;
    if($row->oldID==0) $employeeID = $row->empID; else $employeeID = $row->oldID;
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
$hire=date_create($hiredate);
$today=date_create($payroll_month);
$diff=date_diff($hire, $today);
$accrued = 37*$diff->format("%a%")/365;
$totalAccrued = (number_format((float)$accrued, 2,'.','')); //3,04days

$balance = $totalAccrued - $annualLeaveSpent; //days
if($balance<0){
    $balance=0;
}


// $dateconvert =$payroll_date;
/*$datewell = explode("-",$payroll_month);
$mm = $datewell[1];
$dd = $datewell[2];
$yyyy = $datewell[0];
$outstanding_date = $dd."-".$mm."-".$yyyy;
*/


$pdf->SetXY(85, 5);

$path=FCPATH.'uploads/logo/logo.png';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 30, 25, '', '', 'T', false, 300, '', false, false, '', false, false, false);


$pdf->SetXY(86, $pdf->GetY()+25); //(+3)
$header = "
<p align='center'><b>Employee Payslip</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);

// SET THE FONT FAMILY
$pdf->SetFont('courier', '', 10, '', true);
// SET THE STYLE FOR DOTTED LINES
$style4 = array('B' => array('width' => 0, 'cap' => 'square', 'join' => 'miter', 'dash' => 3));

$pdf->SetXY(15, $pdf->GetY()-6); //(+3)
$header = "
<p><b>Payslip For :<b> &nbsp;&nbsp;&nbsp;".date('F, Y', strtotime($payroll_month))."</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);
$pdf->Rect(16, $pdf->GetY()-7, 175, 0, '', $style4);  //Dotted LIne


// Employee Info
$pdf->SetXY(0, $pdf->GetY()-10);
$subtitle1 = "
<p><br>EMPLOYEE DETAILS:";


$employee_info = '
<table width = "100%">
    <tr align="left">
        <th width="110"><b>ID:</b></th>
        <th width="230">'.$employeeID.'</th>
        <th width="120"><b>Pension Fund:</b></th>
        <th width="180">'.$pension_fund_abbrv.'</th>
    </tr>
    <tr align="left">
        <td align "left"><b>Name:</b></td>
        <td align "left">'.$name.'</td>
        <td align "left"><b>Membership No:</b></td>
        <td align "left">'.$membership_no.'</td>
    </tr>
    <tr align="left">
        <td align "left"><b>Department:</b></td>
        <td align "left">'.$department.'</td>
        <td align "left"><b>Bank:</b></td>
        <td align "left">'.$bank.' </td>
    </tr>
    <tr align="left">
        <td align "left"><b>Position:</b></td>
        <td align "left">'.$position.'</td>
        <td align "left"><b>Acc No:</b></td>
        <td align "left">'.$account_no.'</td>
    </tr>
    <tr align="left">
        <td align "left"><b>Branch:</b></td>
        <td align "left">'.$branch.'</td>
    </tr>
</table>';
$pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle1, 0, 1, 0, true, '', true);

$pdf->writeHTMLCell(0, 12, '',$pdf->GetY()-3, $employee_info, 0, 1, 0, true, '', true);
$pdf->Rect(16, $pdf->GetY()+2, 175, 0, '', $style4);  //Dotted LIne


//START EARNINGS AND PAYMENTS
$pdf->SetXY(15, $pdf->GetY());
$out = "<p><br>PAYMENTS/EARNINGS:";
$allowance = '
<table width = "100%">
    <tr>
        <td width="500" align="left"><b>Basic Salary</b></td>
        <td width="100" align="right">'.number_format($salary, 2).'</td>
    </tr>';
foreach($allowances as $row){
    $allowance  .='
    <tr>
        <td width="500" align "left"><b>'.$row->description.'</b></td>
        <td width="100" align "right">'.number_format($row->amount, 2).'</td>
    </tr>'; }

$allowance  .='</table>';

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $out, 0, 1, 0, true, '', true);

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()-4, $allowance, 0, 1, 0, true, '', true);

$pdf->SetXY(15, $pdf->GetY()+3);
$pay1 = "<p><br><br>TOTAL EARNINGS(GROSS)</p>";

$gross = '<table width="100" align "right"><tr width="100" align "left" align="left"><th>'.number_format($sum_allowances+$salary,2).'</th></tr></table>';

$pdf->Rect(148, $pdf->GetY(), 46, 0, '', $style4);
$pdf->writeHTMLCell(0, 12, 155, $pdf->GetY()+0.5, $gross, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()-20, $pay1, 0, 1, 0, true, '', true);
$pdf->Rect(16.5, $pdf->GetY(), 177.5, 0, '', $style4);

//END EARNINGS AND PAYMENTS




//START DEDUCTIONS
$pdf->SetXY(15, $pdf->GetY());
$subtitle2 = "<p><br>DEDUCTIONS:";
$deduction = '
<table width = "100%">
    <tr>
        <td width="500" align="left"><b>Pension ('.$pension_fund_abbrv.')</b></td>
        <td width="100" align="right">'.number_format($pension_employee, 2).'</td>
    </tr>
    <tr>
        <td width="500" align="left"><b>PAYE AMOUNT</b></td>
        <td width="100" align="right">'.number_format($taxdue, 2).'</td>
    </tr>';
//    <tr>
//        <td width="500" align "left"><b>MEALS</b></td>
//        <td width="100" align "right">'.number_format($meals, 2).'</td>
//    </tr>';
if ($meals > 0) {
    $deduction .= '<tr>
               <td width="500" align="left"><b>MEALS</b></td>
               <td width="100" align="right">'.number_format($meals, 2).'</td>
        </tr>';
}

foreach($deductions as $row){
    $deduction  .='
    <tr>
        <td width="500" align="left"><b>'.$row->description.'</b></td>
        <td width="100" align="right">'.number_format($row->paid, 2).'</td>
    </tr>'; }

foreach($loans as $row){

    $paid = $row->paid;
    if ($row->remained == 0){
        $get_remainder = $row->paid / $row->policy;
        $array = explode('.',$get_remainder);
        if(isset($array[1])){
            $num = '0'.'.'.$array[1];
        }else{
            $num = '0';
        }
//        $paid = $num*$row->policy;
        $paid = $salary_advance_loan_remained;
    }

    

    $deduction  .='
    <tr>
        <td width="500" align="left"><b>'.$row->description.'</b></td>
        <td width="100" align="right">'.number_format($paid, 2).'</td>
    </tr>';
    $sum_loans = ($sum_loans+$paid);

}

$deduction  .='</table>';

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle2, 0, 1, 0, true, '', true);

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()-4, $deduction, 0, 1, 0, true, '', true);

$pdf->SetXY(15, $pdf->GetY()+3);
$subtitle3 = "<p><br><br>TOTAL DEDUCTIONS</p>";

$alldeduction = '<table width="100" align "right"><tr width="100" align "left" align="left"><th>'.number_format(($pension_employee+$taxdue+$sum_deductions+$sum_loans+$meals),2).'</th></tr></table>';

$pdf->Rect(148, $pdf->GetY(), 46, 0, '', $style4);
$pdf->writeHTMLCell(0, 12, 155, $pdf->GetY()+0.5, $alldeduction, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()-20, $subtitle3, 0, 1, 0, true, '', true);
$pdf->Rect(16.5, $pdf->GetY(), 177.5, 0, '', $style4);
//END DEDUCTIONS

// START TAKE HOME
$amount_takehome = ($sum_allowances+$salary) - ($sum_loans+$pension_employee+$taxdue+$sum_deductions+$meals);

$paid_salary = $amount_takehome;
foreach ($paid_with_arrears as $paid_with_arrear){
    if ($paid_with_arrear->with_arrears){
        $with_arr = $paid_with_arrear->with_arrears; //with held
        $paid_salary = $amount_takehome - $with_arr; //paid amount
    }else{
        $with_arr = 0;//with held
    }
}

foreach ($arrears_paid as $arrear_paid){
    if ($arrear_paid->arrears_paid){
        $paid_salary = $amount_takehome + $arrear_paid->arrears_paid - $with_arr;
        $paid_arr = $arrear_paid->arrears_paid;
    }else{
        $paid_arr = 0;
    }
}

foreach ($paid_with_arrears_d as $paid_with_arrear_d){
    if ($paid_with_arrear_d->arrears_paid){
        $paid_arr_all = $paid_with_arrear_d->arrears_paid;
    }else{
        $paid_arr_all = 0;
    }
}

if ($with_arr > 0){
    foreach ($arrears_all as $arrear_all){

        if ($arrear_all->arrears_all){
            $due_arr = $arrear_all->arrears_all - $paid_arr_all;

        }else{
            $due_arr = 0;
        }
    }
}else{
    foreach ($arrears_all as $arrear_all){

        if ($arrear_all->arrears_all){
            $due_arr = $arrear_all->arrears_all - $paid_arr_all;

        }else{
            $due_arr = 0;
        }
    }
}



$takehome = '
<table width = "100%">';
// foreach($loans as $row){
$takehome  .='
    <tr>
        <td width="500" align="left"><b>Net Pay</b></td>
        <td width="100" align="right">'.number_format($amount_takehome, 2).'</td>
    </tr>';

if ($paid_salary > 0){
    $takehome .= '<tr>
                    <td width="500" align="left"><b>Paid Amount</b></td>
                    <td width="100" align="right">'.number_format($paid_salary, 2).'</td>
                </tr>';
}

if ($paid_arr > 0){
    $takehome .= '<tr>
                <td width="500" align="left"><b>Arrears Paid</b></td>
                <td width="100" align="right">'.number_format($paid_arr, 2).'</td>
            </tr>';
}

if ($with_arr > 0){
    $takehome .= '<tr>
                    <td width="500" align="left"><b>Arrears Withheld</b></td>
                    <td width="100" align="right">'.number_format($with_arr, 2).'</td>
                </tr>';
}

if ($due_arr > 0){
    $takehome .= '<tr>
                    <td width="500" align="left"><b>Arrears Due</b></td>
                    <td width="100" align="right">'.number_format($due_arr, 2).'</td>
                </tr>';
}


$takehome .= '<tr>
                    <td width="500" align="left"></td>
                    <td width="100" align="right"></td>
                </tr>';

$takehome  .='</table>';

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()+2, $takehome, 0, 1, 0, true, '', true);

$pdf->Rect(16.5, $pdf->GetY()-5, 177.5, 0, '', $style4);
// END TAKE HOME

//OUTSTANDING LOANS

if(!empty($loans)){
    $pdf->SetXY(15, $pdf->GetY()-6);
    $subtitle4 = "<p><br>OUTSTANDINGS(SALARY ADVANCE AND LOANS):";
    $outstandings = '
  <table width = "100%">';
    foreach($loans as $row){
        $outstandings  .='
      <tr>
          <td width="500" align="left"><b>'.$row->description.'</b></td>
          <td width="100" align="right">'.number_format($row->remained, 2).'</td>
      </tr>';
    }

    $outstandings  .='
      <tr>
          <td width="500" align="left"></td>
          <td width="100" align="right"></td>
      </tr>';


    $outstandings  .='</table>';

    $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle4, 0, 1, 0, true, '', true);

    $pdf->writeHTMLCell(0, 12, '', $pdf->GetY()-2, $outstandings, 0, 1, 0, true, '', true);

    $pdf->Rect(16.5, $pdf->GetY()-5, 177.5, 0, '', $style4);

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
// $pdf->SetXY(15, $pdf->GetY());

// $subtitle5 = "<p><br>LEAVES:";
// $leave = '
// <table width = "100%">
//     <tr>
//         <td width="500" align="left"><b>Annual Leave Balance(Days)</b></td>
//         <td width="100" align="right">'.$balance.'</td>
//     </tr>';
// foreach($leaves as $row){
//     if($row->type==1) continue;
//     $leave  .='
//     <tr>
//         <td width="500" align="left"><b>'.$row->nature.'</b></td>
//         <td width="100" align="right">'.$row->days.'</td>
//     </tr>'; }
// $leave  .='</table>';

// $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle5, 0, 1, 0, true, '', true);

// $pdf->writeHTMLCell(0, 12, '', $pdf->GetY()-1, $leave, 0, 1, 0, true, '', true);

// $pdf->Rect(16.5, $pdf->GetY()+2, 177.5, 0, '', $style4);

//END LEAVES



// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('payslip-'.date('d/m/Y').'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
 
