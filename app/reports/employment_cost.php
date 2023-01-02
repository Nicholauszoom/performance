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
$pdf->SetTitle('Payroll Report');
$pdf->SetSubject('TCPDF Tutorial');
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
$pdf->SetFont('times', '', 12, '', true);
 
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L','A4');


// EMPLOYER INFO
foreach ($info as $row) {
      $logo = $row->logo;
      $companyname = $row->cname;
}
 

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
}

foreach ($total_loans as $key) {
  $paid = $key->paid;
  $remained = $key->remained;
} 
foreach ($authorization as $row) {
  $init = $row->initName;
  $conf = $row->confName;
  $initDate = date('d-M-Y', strtotime($row->init_date));
  $confDate = date('d-M-Y', strtotime($row->appr_date));
} 


foreach ($take_home as $row) {
  $net = $row->takehome;
  $net_less = $row->takehome_less;
  $arrears= $row->arrears_payment;
} 
if ($net>=$net_less) {
  $amount_takehome = $net;
  if($arrears>0) $hint = "(Including Arrears Payments)"; else $hint="; 

}else{
 $amount_takehome = $net_less; 
 $hint = "(Less)";
}

// define style for border
$style = array('width' => 0.25, 'dash' => 0, 'color' => array(0, 0, 0));

$date = date('F, Y', strtotime($payroll_month));
$pdf->SetXY(127, 10);
$path=public_path().'/img/logo/logo.png';

$pdf->Image($path, '', '',  35, 30, '', '', 'T', false, 300, '', false, false, '', false, false, false);

$pdf->SetY($pdf->GetY()+25);
$headertable = <<<"EOD"
<p align="center"><h3>Employment Cost Report For $date</h3></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);


$pdf->SetXY(20, $pdf->GetY()+3);

// REPORT HEADER

// SET THE STYLE FOR DOTTED LINES
$style4 = array('B' => array('width' => 0, 'cap' => 'square', 'join' => 'miter', 'dash' => 3));

$pdf->SetXY(15, $pdf->GetY()-6);
$header = "
<p><b>AUTHORIZATION AND APPROVAL:</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);
$pdf->Rect(16, $pdf->GetY()-6, 275, 0, '', $style4);  //Dotted LIne


// Employee Info
$pdf->SetXY(0, $pdf->GetY());

$authorization = '
<table width = "100%">
    <tr align="left">
        <th width="110"><b>Initiated By:</b></th>
        <th width="230">'.$init.'</th>
        <th width="120"><b>Date:</b></th>
        <th width="180">'.$initDate.'</th>
    </tr>
    <tr align="left">
        <td align "left"><b>Approved By:</b></td>
        <td align "left">'.$conf.'</td>
        <td align "left"><b>Date:</b></td>
        <td align "left">'.$confDate.'</td>
    </tr>
</table>';

$pdf->writeHTMLCell(0, 12, '',$pdf->GetY()-3, $authorization, 0, 1, 0, true, '', true);

$pdf->SetFont('courier', '', 8, '', true);
$pdf->SetXY(15, $pdf->GetY()+4);
$summary_header = "
<p><b>PAYROLL SUMMARY:</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $summary_header , 0, 1, 0, true, '', true);
$pdf->Rect(16, $pdf->GetY()-5, 275, 0, '', $style4);

$summary = '
<table width = "100%">
    <tr align="left">
        <th width="180"><b>Basic Salaries:</b></th>
        <th width="200" align="right">'.number_format($salary,2).'</th>
        <th width="180"><b>Allowances</b></th>
        <th width="150" align="right">'.number_format($allowances,2).'</th>
        <th width="150"></th>
        <th width="150"></th>
    </tr>
    <tr align="left">
        <td align="left"><b>Gross Salary:</b></td>
        <td align="right">'.number_format(($allowances+$salary),2).'</td>
        <td align="left"><b>Taxdue:</b></td>
        <td align="right">'.number_format($taxdue,2).'</td>
    </tr>
    <tr align="left">
        <td align="left"><b>Pension (Employee):</b></td>
        <td align="right">'.number_format($pension_employee,2).'</td>
        <td align="left"><b>Pension (Employer):</b></td>
        <td align="right">'.number_format($pension_employer,2).'</td>
        <td align="left"><b>Total Pension:</b></td>
        <td align="right">'.number_format(($pension_employer+$pension_employee),2).'</td>
    </tr>
    <tr align="left">
        <td align="left"><b>Medical (Employee):</b></td>
        <td align="right">'.number_format($medical_employee,2).'</td>
        <td align="left"><b>Medical (Employer):</b></td>
        <td align="right">'.number_format($medical_employer,2).'</td>
        <td align="left"><b>Total Medical:</b></td>
        <td align="right">'.number_format(($medical_employer+$medical_employee),2).'</td>
    </tr>
    <tr align="left">
        <td align="left"><b>WCF:</b></td>
        <td align="right">'.number_format($wcf,2).'</td>
        <td align="left"><b>SDL:</b></td>
        <td align="right">'.number_format($sdl,2).'</td>
    </tr>
</table>';

$pdf->writeHTMLCell(0, 12, '',$pdf->GetY()-3, $summary, 0, 1, 0, true, '', true);

$pdf->SetXY(15, $pdf->GetY()+3);
$pdf->Rect(16, $pdf->GetY()+1, 275, 0, '', $style4);
$takehome_txt = "<p><b>EMPLOYEE TAKE HOME ".$hint.":</b></p>";
$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()+2, $takehome_txt , 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 12, 165, $pdf->GetY()-12, number_format($amount_takehome ,2) , 0, 1, 0, true, '', true);
$pdf->Rect(16, $pdf->GetY()-5, 275, 0, '', $style4);

$pdf->SetXY(15, $pdf->GetY()-5);
// $pdf->Rect(16, $pdf->GetY()+1, 275, 0, '', $style4);
$txt_employmentcost = "<p><b>TOTAL EMPLOYEMENT COST:</b></p>";
$employmentcost = ($salary+$allowances+$pension_employer+$medical_employer+$wcf+$sdl);
$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()+2, $txt_employmentcost , 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 12, 165, $pdf->GetY()-12, number_format($employmentcost,2) , 0, 1, 0, true, '', true);
$pdf->Rect(16, $pdf->GetY()-5, 275, 0, '', $style4);
// END REPORT HEADER

$pdf->SetXY(15, $pdf->GetY()+2);
$employees = "
<p><b>EMPLOYEE LIST(Head Counts ".count($employee_list)."):</b></p>";
$pdf->writeHTMLCell(0, '','', '', '', $employees , 0, 1, 0, true, '', true);
 
 
$html = '
<table border="1px">
<thead>
  <tr style="background-color:#14141f;color:#FFFFFF;" align="center">
    <th width="25"><b>S/N</b></th>
    <th width="70"><b>Employee ID</b></th>
    <th width="150"><b>Name</b></th>
    <th width="75"><b>Basic Salary</b></th>
    <th width="70"><b>Housing Allowance</b></th>
    <th width="70"><b>Other Payment</b></th>
    <th width="70"><b>Allowances</b></th>
    <th width="70"><b>Overtime</b></th>
    <th width="70"><b>Gross</b></th>
    <th width="70"><b>TaxableAmount</b></th>
    <th width="65"><b>PAYE</b></th>
    <th width="70"><b>Pension</b></th>
    <th width="90"><b>Net Pay</b></th>
  </tr>
 </thead>';
$sno = 1;
  foreach($employee_list as $row){
    $empID =  $row->empID;
    $name = $row->name;
    $housingAllowance = $row->housingAllowance;
    $allowances = $row->allowances;
    $salary = $row->salary;
    $paye = $row->taxdue;
    $nhif = 0; //$row->taxdue;
    $taxable = 0; //$row->taxdue;
    $overtime = $row->overtimes;
    $gross = $row->allowances + $row->salary;
    $loan = $row->loans;
    $deductions = 0; //$row->taxdue;
    $pension = $row->pension;
    $advance = 0; //$row->taxdue;
    // $less_takehome = $row->less_takehome;
    $account_no = $row->account_no;
    //if($less_takehome==0){
    $amount = $row->salary + $row->allowances-$row->pension-$row->loans-$row->deductions-$row->taxdue; //} else $amount = $less_takehome;
    if  ($sno % 2 == 0) { $background = "#d3d3d3;"; } else { $background = "#FFFFFF;"; }

  $html .='<tbody>
      <tr nobr="true" style="background-color:'.$background.'">
            <td width="25" align="center">'.$sno.'</td>
            <td width="70">&nbsp;'.$empID.'</td>
            <td width="150">&nbsp;'.$name.'</td>
            <td width="75" align="right">&nbsp;'.number_format($salary,2).'</td>
            <td width="70" align="right">&nbsp;'.number_format($housingAllowance,2).'</td>
            <td width="70"  align="right">&nbsp;'.number_format($paye,2).'</td>
            <td width="70" align="right">&nbsp;'.number_format($allowances,2).'</td>
            <td width="70" align="right">&nbsp;'.number_format($overtime,2).'</td>
            <td width="70" align="right">&nbsp;'.number_format($gross,2).'</td>
            <td width="70" align="right">&nbsp;'.number_format($taxable,2).'</td>
            <td width="65"  align="right">&nbsp;'.number_format($paye,2).'</td>
            <td width="70"  align="right">&nbsp;'.number_format($pension,2).'</td>
            <td width="85" align="right">&nbsp;'.number_format($amount,2).'</td>
    </tr>
    </tbody>';
    $sno++;
    
}

  $html .="</table>";
  // <th width="125"><b>Advance</b></th>
  //   <th width="125"><b>Loan</b></th>
  //   <th width="125"><b>Medical</b></th>
  //   <th width="125"><b>Deductions</b></th>

  //           <td width="1"  align="center">&nbsp;'.$advance.'</td>
  //           <td width="1"  align="center">&nbsp;'.$loan.'</td>
  //           <td width="1"  align="center">&nbsp;'.$nhif.'</td>
  //           <td width="1"  align="center">&nbsp;'.$deductions.'</td>
  
 //HTML2
 
$signatory = '
<table width="100%" >
<thead>
  <tr align="left">
    <th width="332"><b>SIGNATORIES</b></th>
    <th width="312"><b></b></th>
    <th width="312"><b></b></th>
  </tr>
 </thead>';
  $signatory .='
      <tr nobr="true">
            <td width="332" align="left"><br><br>Signatory 1.........................</td>
            <td width="320"><br><br>Signature..................</td>
            <td width="295"><br><br>Date.......................</td>
    </tr>';
      
  $signatory .='<tbody>
      <tr nobr="true">
            <td width="332" align="left"><br><br><br><br>Signatory 2........................</td>
            <td width="312"><br><br><br><br>Signature....................</td>
            <td width="312"><br><br><br><br>Date.........................</td>
    </tr>
    </tbody>';

  $signatory .="</table>";
 
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()-5, $html, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+10, $signatory, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
 
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('payroll_report-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 
