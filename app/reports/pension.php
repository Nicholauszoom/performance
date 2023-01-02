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
$pdf->SetTitle('Pension Report');
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
foreach($info as $key){
    $name = $key->cname;
    $nssf_control_number = $key->nssf_control_number;
    $nssf_reg = $key->nssf_reg;
    // $tin = $key->tin;
    // $postal_address = $key->postal_address;
    // $postal_city = $key->postal_city;
    // $phone_no1 = $key->phone_no1;
    // $phone_no2 = $key->phone_no2;
    // $phone_no3 = $key->phone_no3;
    // $fax_no = $key->fax_no;
    // $email = $key->email;
    // $plot_no = $key->plot_no;
    // $block_no = $key->block_no;
    // $branch = $key->branch;
    // $street = $key->street;
    // $heslbcode = $key->heslb_code_no;
     
}




foreach ($total as $row) {
    $total_salary=$row->totalsalary;
    $total_amount1=$row->totalpension_employee;
    $total_amount2=$row->totalpension_employer;
    $overall_contribution=($row->totalpension_employee+$row->totalpension_employee);
  }

$pdf->SetXY(117, 6);
if($pension_fund==1){
  $path=public_path().'/img/logo/psssf.png';
  // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
  $pdf->Image($path, '', '', 43, 45, '', '', 'T', false, 300, '', false, false, '', false, false, false);
}else{
  $path=public_path().'/img/logo/nssf.png';
  // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
  $pdf->Image($path, '', '', 43, 45, '', '', 'T', false, 300, '', false, false, '', false, false, false);
}

$pdf->SetXY(25, 20);
$headerleft = <<<"EOD"
<p>Director General<br>
PPF<br>
P.O Box 72473<br>
<b>Dar es Salaam, Tanzania</b><br>
Tel: 2113919/22.2110642<br>
Fax:2117772</p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $headerleft, 0, 1, 0, true, '', true);


$pdf->SetXY(210, 25);
$headeright = "
<p>Control Number: ".$nssf_control_number."<br><br>
Cheque No: <br><br>
Date of Chq: <br><br>
Amount: 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".number_format($overall_contribution,2)."&nbsp;&nbsp;TZS</p>";
$pdf->writeHTMLCell(0, 12, '', '', $headeright, 0, 1, 0, true, '', true);

// LINES
$style4 = array('B' => array('width' => 0.5, 'cap' => 'square', 'join' => 'miter', 'dash' => 0));
$pdf->Rect(240, 52, 40, 0, '', $style4);
$pdf->Rect(240, 41, 40, 0, '', $style4);
$pdf->Rect(240, 31, 40, 0, '', $style4);
$pdf->Rect(115, 70, 40, 0, '', $style4);

$payrollMonth = date('F, Y', strtotime($payroll_month));


$pdf->SetXY(30, 65);
$headertable = "
<p><b>CONTRIBUTION FOR THE MONTH OF: &nbsp;&nbsp;&nbsp; ".$payrollMonth ."<br><br>Name of Employer: &nbsp;&nbsp;&nbsp;&nbsp;</b>".strtoupper($name)." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>NSSF Registration Number</b>: &nbsp;&nbsp;&nbsp;&nbsp;</b>".$nssf_reg."<br><br><br>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);
 

 
// Set some content to print
$pdf->SetXY(15, 85);
$html = '
<table border="1px">
  <tr align="center">
    <th rowspan="2" width="37px"><b>S/N</b></th>
    <th rowspan="2" width="120"><b>Membership No.</b></th>
    <th rowspan="2" width="190" ><b>Full Name</b></th>
    <th rowspan="2" ><b>Monthly Gross Salary</b></th>
    <th colspan="2" width="160" ><b>Members Contribution</b></th>
    <th colspan="2" width="160" ><b>Employers Contribution</b></th>
    <th rowspan="2" width="160" ><b>Total Contribution</b></th>
  </tr>
  <tr align="center">
    <th width="45"><b>Rate</b></th>
    <th width="115"><b>Amount</b></th>
    <th width="45"><b>Rate</b></th>
    <th width="115"><b>Amount</b></th>
  </tr>';

  foreach ($pension as $row){
    $name= $row->name;
    $member_no= $row->pf_membership_no;
    $salary= $row->salary + $row->allowances;
    if($salary == 0)dd($row->emp_id);
    $rate1= ($row->pension_employee/$salary);
    $rate2= ($row->pension_employer/$salary);
    $amount1= $row->pension_employee;
    $amount2= $row->pension_employer;
    $total_contribution= ($row->pension_employer+$row->pension_employee);
    # code...
  

  $html .='<tr>
    <td width="37px" align="center">'.$row->SNo.'</td>
    <td>&nbsp;'.$member_no.'</td>
    <td width="190">&nbsp;'.$name.'</td>
    <td align="right">&nbsp;'.number_format($salary,2).'</td>
    <td align="right">&nbsp;'.number_format($rate1,2).'</td>
    <td align="right">&nbsp;'.number_format($amount1,2).'</td>
    <td align="right">&nbsp;'.number_format($rate2,2).'</td>
    <td align="right">&nbsp;'.number_format($amount2,2).'</td>
    <td align="right">&nbsp;'.number_format($total_contribution,2).'</td>
  </tr>';
}
// money_format('%i', $number)
 

  // setlocale(LC_MONETARY, 'en_US');

 $html .=' <tr>
  <td colspan="3" align="center"><b>TOTAL</b></td>
    <td align="right"><b>&nbsp;'.number_format($total_salary,2).'</b></td>
    <td></td>
    <td align="right"><b>&nbsp;'.number_format($total_amount1,2).'</b></td>
    <td></td>
    <td align="right"><b>&nbsp;'.number_format($total_amount2,2).'</b></td>
    <td align="right"><b>&nbsp;'.number_format($overall_contribution,2).'</b></td>
  </tr>';
  $html .="</table ><br><table border='1px'><tr>
  <td colspan='4'><br><br><b>Remittance</b><br><br>Employer's Signature............................................... 
  </td>
  <td></td>
  <td colspan='4'><br><br><br><br>Date: .....................................</td>
  </tr>
</table>";





// MYSQL DATA
// $html = '<table align="center" border="1px">';
// $html .= '<tr> <th ><b>ID</b></th>
//        <th ><b>Name</b></th>
//          <th ><b>Relationship</b></th>
//          <th ><b>Excessp</b></th>
//          </tr>';

//  foreach($taxable->result() as $key){
// $html .= '<tr>
//           <td>'.$key->minimum.'</td>
//           <td>'.$key->maximum.'</td>
//           <td>'.$key->rate.'</td>
//           <td>'.$key->excess_added.'</td>
//        </tr>';
// }

// $html .= '</table>';
// // MYSQL DATA

// $html .= "<h1>This is a Heading</h1>
// <p>This is a paragraph.</p>

// </body>
// </html>";


// $txt = <<<EOD
// TCPDF Example 003

// Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
// EOD;

// // print a block of text using Write()
// $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);



 
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------

// $pdf->setCellPaddings(1, 1, 1, 1);

// // set cell margins
// // $pdf->setCellMargins(1, 1, 1, 1);

// // set color for background
// $pdf->SetFillColor(255, 255, 255);

// // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// // Multicell test
// $pdf->MultiCell(177, 10, 'TEST MODE', 1, 'C', 1, 0, '', '', true);

 
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('p9-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 
