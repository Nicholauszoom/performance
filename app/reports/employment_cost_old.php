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
$pdf->SetTitle('Total Employment Cost');
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
$pdf->SetFont('times', '', 12, '', true);
 
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L','A4');


// EMPLOYER INFO
foreach($info as $key){
    $name = $key->cname;
}

$date = $payrollMonth;
$date = date('F, Y', strtotime($date));




$pdf->SetXY(100, 10);
$headertable = "
<p align='center'><h1>CITS TOTAL EMPLOYMENT COST REPORT</h1></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);

$pdf->SetXY(20, 35);
$headertable = "
<p><b>FOR THE THE MONTH OF:&nbsp;&nbsp;&nbsp;&nbsp;".$date."<br><br>Name&nbsp;&nbsp;&nbsp;&nbsp;</b>.....................................................<br><br>
<b>Signature:</b> &nbsp;&nbsp;&nbsp;&nbsp;..................................................&nbsp;&nbsp;&nbsp;&nbsp;<b>Position</b>&nbsp;&nbsp;&nbsp;&nbsp;....................................................<br></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);
 

 
// Set some content to print
$pdf->SetXY(5, 65);

$pdf->SetFont('times', '', 7, '', true);
$html = '
<table align="center" border="1px">
  <tr>
    <th rowspan="2" width="18px"><b>S/N</b></th>
    <th colspan="2" width="160px"><b>EMPLOYEE INFO</b></th>
    <th colspan="3" width="153px"><b>INCOME</b></th>
    <th colspan="10"><b>DEDUCTIONS</b></th>
    <th rowspan="2" width="60px"><b>EMPLOYEE TAKE HOME</b></th>
    <th rowspan="2" width="70px"><b>TOTAL EMPLOYMENT COST</b></th>
  </tr>
  <tr>
    <th width="110px"><b>Name of Employee</b></th>
    <th width="50px"><b>Payroll #</b></th>

    <th width="50px"><b>Basic Pay</b></th>
    <th width="50px"><b>Allowance</b></th>
    <th width="53px"><b>Gross Pay</b></th>

    <th><b>Employee Pension</b></th>
    <th><b>Employer Pension</b></th>
    <th><b>Total Pension</b></th>
    <th><b>Employer SDL</b></th>
    <th><b>Compasation Fund</b></th>
    <th><b>Employer Medical</b></th>
    <th><b>Employee Medical</b></th>
    <th><b>Total medical</b></th>
    <th><b>Taxable Amount</b></th>
    <th ><b>Tax Due (PAYEE)</b></th>
  </tr>';

  foreach($cost as $row){
              $take_home = $row->basic_salary+$row->allowance+$row->other_benefits-$row->loans-$row->pension_employee-$row->taxdue-$row->medical_employee;
              $taxdue = $row->taxdue;
              $taxable = $row->basic_salary+$row->allowance+$row->other_benefits-$row->pension_employee;
              $total_pension = $row->pension_employee+$row->pension_employer;
              $total_medical = $row->medical_employee+$row->medical_employer;
              $employee_medical = $row->medical_employee;
              $employer_medical = $row->medical_employer;
              $employee_pension = $row->pension_employee;
              $employer_pension = $row->pension_employer;
              $sdl = $row->sdl;
              $compasation_fund = $row->wcf;
              $empid = $row->empID;
              $name = $row->NAME;
              $basic_pay = $row->basic_salary;
              $housing = $row->allowance;
              $gross = $row->basic_salary+$row->allowance+$row->other_benefits;
              $employment_cost = $row->basic_salary+$row->allowance+$row->other_benefits+$row->pension_employer+$row->medical_employer+$row->wcf+$row->sdl;
  

  $html .='<tr align="right">
    <td align ="center" width="18px">'.$row->sNo.'</td>
    <td align="left" width="110px">'.$name.'</td>
    <td width="50px">'.$empid.' </td>

    <td width="50px">'.$basic_pay.'</td>
    <td width="50px">'.$housing.'</td>
    <td width="53px">'.$gross.'</td>

    <td>'.$employee_pension.'</td>
    <td>'.$employer_pension.'</td>
    <td>'.$total_pension.'</td>
    <td>'.$sdl.'</td>
    <td>'.$compasation_fund.'</td>
    <td>'.$employer_medical.'</td>
    <td>'.$employee_medical.'</td>
    <td>'.$total_medical.'</td>
    <td>'.$taxable.'</td>
    <td >'.$taxdue.'</td>
    <td width="60px">'.$take_home.'</td>
    <td width="70px">'.$employment_cost.'</td>
  </tr>';
}

foreach($total_cost as $row){
              $total_take_home = $row->basic_salary_total+$row->allowance_total+$row->other_benefits_total-$row->loans_total-$row->pension_employee_total-$row->taxdue_total-$row->medical_employee_total;
              $total_taxdue = $row->taxdue_total;
              $total_taxable = $row->pension_employee_total+$row->pension_employer_total;
              $total_total_pension = $row->pension_employee_total+$row->pension_employer_total;
              $total_total_medical = $row->medical_employee_total+$row->medical_employee_total;
              $total_employee_medical = $row->medical_employee_total;
              $total_employer_medical = $row->medical_employer_total;
              $total_employee_pension = $row->pension_employee_total;
              $total_employer_pension = $row->pension_employer_total;
              $total_sdl = $row->sdl_total;
              $total_compasation_fund = $row->wcf_total;
              $total_basic_pay = $row->basic_salary_total;
              $total_housing = $row->allowance_total;
              $total_gross = $row->gross_total;
              $total_employment_cost = $row->basic_salary_total+$row->allowance_total+$row->wcf_total+$row->sdl_total+$row->pension_employer_total+$row->medical_employer_total;

}



  $html .='<tr align="right">
  <td colspan ="3" align="center">TOTAL</td>
  <td>'.$total_basic_pay.'</td>
    <td>'.$total_housing.'</td>

    <td>'.$total_gross.'</td>
    <td>'.$total_employee_pension.'</td>
    <td>'.$total_employer_pension.'</td>
    <td>'.$total_pension.'</td>
    <td>'.$total_sdl.'</td>
    <td>'.$total_compasation_fund.'</td>
    <td>'.$total_employee_medical.'</td>
    <td>'.$total_employer_medical.'</td>
    <td>'.$total_medical.'</td>
    <td>'.$total_taxable.'</td>
    <td>'.$total_taxdue.'</td>
    <td>'.$total_take_home.'</td>
    <td>'.$total_employment_cost.'</td>
  </tr>
</table>';

 
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
 
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Total Employment Cost-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 
