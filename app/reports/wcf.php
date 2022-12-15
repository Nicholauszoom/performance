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
$pdf->SetTitle('WCF-Report');
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


// EMPLOYER INFO
foreach($info as $key){
        $name = $key->cname;
        // $tin = $key->tin;
        $postal_address = $key->postal_address;
        $postal_city = $key->postal_city;
        $phone_no1 = $key->phone_no1;
        // $phone_no2 = $key->phone_no2;
        // $phone_no3 = $key->phone_no3;
        // $fax_no = $key->fax_no;
        $email = $key->email;
        // $plot_no = $key->plot_no;
        // $block_no = $key->block_no;
        // $branch = $key->branch;
        // $street = $key->street;
        // $heslbcode = $key->heslb_code_no;
         
}
foreach ($totalwcf as $row){
    $total_salary= $row->totalsalary;
    $total_gross= $row->totalgross;
    $total_cont= $row->totalwcf;

  }

$totalg = 0;
foreach ($wcf as $row){
    $grossT= ($row->allowances+$row->salary);
    $totalg += $grossT;
}



$pdf->SetXY(180, 8);
$attachmentNo = "
<p align='left'>WCP-1</p>";
$pdf->writeHTMLCell(0, 0, '', '', $attachmentNo, 0, 1, 0, true, '', true);


// foreach ($total as $row) {
//      $total_salary=$row->TOTAL_SALARY;
//      $total_amount1=$row->TOTAL_AMOUNT1;
//      $total_amount2=$row->TOTAL_AMOUNT2;
//      $overall_contribution=$row->OVERALL_CONTRIBUTION;
//   }



$pdf->SetXY(80, 8);
$header1 = "
<p align='center'>UNITED REPUBLIC OF TANZANIA</p>";
$pdf->writeHTMLCell(0, 0, '', '', $header1, 0, 1, 0, true, '', true);


$pdf->SetXY(76, 13);
$header2 = "
<p align='center'>WORKERS COMPASATION FUND(WCF)</p>";
$pdf->writeHTMLCell(0, 0, '', '', $header2, 0, 1, 0, true, '', true);

$pdf->SetXY(76, 17);
$path=public_path().'/img/logo/wcf.png';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 75, 30, '', '', 'T', false, 300, '', false, false, '', false, false, false);

$pdf->SetXY(15, 51); //(+3)
$headertable = "
<p><b>EMPLOYER'S CONTRIBUTION FORM</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);


$pdf->SetXY(15, 55);
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(177, 10, "Employer's Particulars", 1, 'L', 1, 0, '', '', true);

$pdf->SetXY(15, 68);
$hea = "
<p>Name<br><br>
WCF Reg No. (If available)<br><br>
Address<br><br>
Phone<br><br>
Email</p>";
$pdf->writeHTMLCell(0, 12, '', '', $hea, 0, 1, 0, true, '', true);



$pdf->SetXY(15, 113);
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(177, 10, "Remittance Summary", 1, 'L', 1, 0, '', '', true);



$pdf->SetXY(15, 123);
$rem = "
<p><br>Amount Paid (USD/TZS): Tsh<br><br>
Payment Date:<br><br>
Applicable Months:<br><br>
Bank Name:<br><br>
Remittence Method:<br>
(Electronic transfer, cheque etc):</p>";
$pdf->writeHTMLCell(0, 12, '', '', $rem, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 12, 75, 126, number_format($totalg*0.01, 2), 0, 1, 0, true, '', true);
 



 $pdf->SetXY(15, 183);
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(177, 10, "Employer's Authorizing Officer", 1, 'L', 1, 0, '', '', true);


// LINES

$style4 = array('B' => array('width' => 0, 'cap' => 'square', 'join' => 'miter', 'dash' => 0));
$pdf->Rect(70, 133, 100, 0, '', $style4);
$pdf->Rect(70, 143, 100, 0, '', $style4);
$pdf->Rect(70, 152, 100, 0, '', $style4);
$pdf->Rect(70, 162, 100, 0, '', $style4);
$pdf->Rect(70, 172, 100, 0, '', $style4);


$pdf->Rect(70, 213, 100, 0, '', $style4);
$pdf->Rect(70, 222, 100, 0, '', $style4);
$pdf->Rect(70, 231, 100, 0, '', $style4);
$pdf->Rect(70, 241, 60, 0, '', $style4);


$pdf->SetXY(15, 199);
$auth = "
<p>I hereby certify that to the best of my knowledge all particulars in this return are complete, true and correct.<br><br>
Name<br><br>
Position<br><br>
Signature of Employer<br><br>
Date</p>";
$pdf->writeHTMLCell(0, 12, '', '', $auth, 0, 1, 0, true, '', true);



$pdf->SetXY(130, 237);
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(57, 35, "Your Official Stemp", 1, 'L', 1, 0, '', '', true);
// Set some content to print
// $pdf->SetXY(15, 85);



################### SECOND PAGE ###########################


$pdf->SetFont('times', '', 9, '', true);
$pdf->AddPage('P','A4');

$pdf->SetXY(130, 20);
$attachmentref = "
<p align='left'>ATTACHMENT TO PAGE No. WCP-1</p>";
$pdf->writeHTMLCell(0, 0, '', '', $attachmentref, 0, 1, 0, true, '', true);


// foreach ($total as $row) {
//    $total_salary=$row->TOTAL_SALARY;
//    $total_amount1=$row->TOTAL_AMOUNT1;
//    $total_amount2=$row->TOTAL_AMOUNT2;
//    $overall_contribution=$row->OVERALL_CONTRIBUTION;
//   }



$pdf->SetFont('times', '', 10, '', true);
$pdf->SetXY(60, 30);
$header2 = "
<p align='center'><b>WORKERS COMPASATION FUND (WCF)</b></p>";
$pdf->writeHTMLCell(0, 0, '', '', $header2, 0, 1, 0, true, '', true);





$pdf->SetXY(15, 45);
$rem = "
<p><br><b>List of amount contributed for each employee<br><br>
Employer's Name: ".$name."<br><br>
WCF Reg No. (If available)<br><br>
Applicable Month: ".date('d-m-Y', strtotime($payroll_month))."<br><br>
Applicable Contribution During 2015/16:</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $rem, 0, 1, 0, true, '', true);

$pdf->SetXY(105, 80);
$rem2 = "
<p><br><b>(1% of gross pay for private entities)<br>
(0.5% of gross pay for public entities)</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $rem2, 0, 1, 0, true, '', true);



$html = '
<table border="1px">
  <tr align="center">
    <th width="50" align="center"><b>S/N</b></th>
    <th width="60"><b>Employee ID</b></th>
    <th width="150"><b>Employee Name</b></th>
    <th><b>Tin</b></th>
	<th><b>National ID</b></th>	
    <th><b>Employee Basic Salary</b></th>
    <th><b>Employee Gross Salary</b></th>
    </tr>';


foreach ($wcf as $row){
    $emp_id= $row->emp_id;
    $name= $row->name;
    $salary= $row->salary;
    $gross= ($row->allowances+$row->salary);
    $tin = $row->tin;
    $national_id = $row->national_id;
  

  $html .='<tr align="right">
    <td width="50" align="center">'.$row->SNo.'</td>
    <td width="60" align="center">'.$emp_id.'</td>
    <td width="150" align ="left">'.$name.'</td>
     <td align="left">'.$tin.'</td>
     <td align="left">'.$national_id.'</td>
    <td align="right">'.number_format($salary,2).'</td>
    <td align="right">'.number_format($gross,2).'</td>
    </tr>';
}

  $html .='<tr align="right">
    <td colspan="3" align="center"><b>Total</b></td>
    <td align="right"></td>
    <td align="right"></td>
    <td align="right"><b>'.number_format($total_salary,2).'</b></td>
    <td align="right"><b>'.number_format($totalg,2).'</b></td>
    </tr>
    <tr align="Center">
    <td colspan="6"><b>Total Contribution Due</b></td>
    <td align="right"><b>'.number_format($totalg*0.01,2).'</b></td>
    </tr>
    </table>';


 
// Print text using writeHTMLCell()

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------



// $pdf->GetX(15, 199);

$pdf->MultiCell(177, 8, "Employer's Authorizing Officer", 1, 'L', 1, 0, '', $pdf->GetY()+5, true);
$auth2 = "
<p>I hereby certify that to the best of my knowledge all particulars in this return are complete, true and correct.<br><br>
Name:<br><br>
Position:<br><br>
Signature of Employer:<br><br>
Date:</p>";

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()+10, $auth2, 0, 1, 0, true, '', true);

// LINES

$style4 = array('B' => array('width' => 0, 'cap' => 'square', 'join' => 'miter', 'dash' => 0));
$pdf->Rect(60, $pdf->GetY()-3, 100, 0, '', $style4);
$pdf->Rect(60, $pdf->GetY()-12, 100, 0, '', $style4);
$pdf->Rect(60, $pdf->GetY()-21, 100, 0, '', $style4);
$pdf->Rect(60, $pdf->GetY()-30, 100, 0, '', $style4);

// $pdf->Rect(70, 231, 100, 0, '', $style4);
// $pdf->Rect(70, 241, 60, 0, '', $style4);




// $pdf->SetXY(130, 237);
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(57, 35, 'Your Official Stamp', 1, 'L', 1, 0, 130, $pdf->GetY(), true);


 
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('WCF-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 
