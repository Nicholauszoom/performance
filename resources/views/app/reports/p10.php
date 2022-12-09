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
date_default_timezone_set('Africa/Dar_es_Salaam');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Cits');
$pdf->SetTitle('P10-'.date('d/m/Y'));
$pdf->SetSubject('PAYE');
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
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__). url('').'/application/libraries/tcpdf/examples/lang/eng.php')) {
               require_once(dirname(__FILE__). url('').'/application/libraries/tcpdf/examples/lang/eng.php');
               $pdf->setLanguageArray($l);
}
 
// ---------------------------------------------------------
 
// set default font subsetting mode
$pdf->setFontSubsetting(true);
 
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 14, '', true);

// FIRST PAGE
$pdf->AddPage();

$pdf->SetXY(70, 5);
$path=FCPATH.'uploads/logo/TRAheader.png';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 80, '', '', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetXY(20, 34);
$header1 = <<<"EOD"
<p align="center"><b>SKILLS AND DEVELOPMENT LEVY </b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $header1, 0, 1, 0, true, '', true);

$pdf->SetXY(23,42);
$header2 = <<<"EOD"
<p align="center"><b>EMPLOYER'S HALF YEAR CERTIFICATE</b></p'>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $header2, 0, 1, 0, true, '', true);
 
// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2,
//  'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));



 // YEAR

$pdf->SetXY(30, 52);
$year = <<<"EOD"
<p align="center"><b>YEAR: </b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $year, 0, 1, 0, true, '', true);

$pdf->SetXY(125, 52);
// set font
// $pdf->SetFont('times', '', 12);

$Year = date('Y');

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(5, 4, $Year[0], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $Year[1], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $Year[2], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $Year[3], 1, 'L', 1, 0, '', '', true);

// YEAR


$pdf->SetXY(10, 67);
$line = <<<"EOD"
<hr>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $line, 0, 1, 0, true, '', true);


$pdf->SetXY(10, 54);
$line = <<<"EOD"
<small><p align = "center">(To be submitted to the TRA office within 30 days after the end of each six-month calendar period)</p></small>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $line, 0, 1, 0, true, '', true);


$pdf->SetXY(10, 75);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(70, 7, "EMPLOYER'S INFORMATION", 1, 'C', 1, 0, '', '', true);


// TIN NUMBER

foreach($info as $key){
		$name = $key->cname;
		$tin = $key->tin;
		$postal_address = $key->postal_address;
		$postal_city = $key->postal_city;
		$phone_no1 = $key->phone_no1;
		$phone_no2 = $key->phone_no2;
		$phone_no3 = $key->phone_no3;
		$fax_no = $key->fax_no;
		$email = $key->email;
		$street = $key->street;
		$plot_no = $key->plot_no;
		$block_no = $key->block_no;
		$company_type = $key->company_type;
		$businessnature = $key->business_nature;
		 
		 
}

$pdf->SetXY(10, 90);
$TIN1 = <<<"EOD"
<p><b>TIN: </b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $TIN1, 0, 1, 0, true, '', true);

$pdf->SetXY(35, 90);
// set font
$pdf->SetFont('times', '', 12);

$tinNo1 = $tin;

// add a page
// $pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(5, 4, $tinNo1[0], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo1[1], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo1[2], 1, 'L', 1, 0, '', '', true);

// set color for background
$pdf->SetFillColor(0, 2, 25);

// Multicell test
$pdf->MultiCell(5, 4, '', 1, 'L', 1, 0, '', '', true);


// set color for background
$pdf->SetFillColor(255, 255, 255);

// Multicell test
$pdf->MultiCell(5, 4, $tinNo1[3], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo1[4], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo1[5], 1, 'L', 1, 0, '', '', true);


// set color for background
$pdf->SetFillColor(0, 0, 0);

// Multicell test
$pdf->MultiCell(5, 4, '', 1, 'L', 1, 0, '', '', true);


// set color for background
$pdf->SetFillColor(255, 255, 255);

// Multicell test
$pdf->MultiCell(5, 4, $tinNo1[6], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo1[7], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo1[8], 1, 'L', 1, 0, '', '', true);

// TIN NUMBER

$pdf->SetXY(10, 105);
$txt = "<p><b>
Name of Employer:</p></b>";
// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);
$pdf->SetXY(10, 113);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(177, 10, $name, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(10, 125);
$po_box = "<p><b>
Postal Address:</p>
<p> P.O. Box</p></b>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $po_box, 0, 1, 0, true, '', true);

$pdf->SetXY(45, 133);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $postal_address, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(110, 133);
$postal = <<<"EOD"
<p >Postal City</p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $postal, 0, 1, 0, true, '', true);

$pdf->SetXY(137, 133);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $postal_city, 1, 'C', 1, 0, '', '', true);






// PHYSICAL ADDRESS

$pdf->SetXY(10, 150);
$physical = "<p><b>
Physical Address:</p>
<p>Plot Number</p></b>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(55, 160);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $plot_no, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(110, 160);
$block = <<<"EOD"
<p >Block Number</p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $block, 0, 1, 0, true, '', true);

$pdf->SetXY(142, 160);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(45, 9, $block_no, 1, 'C', 1, 0, '', '', true);


// Street Location
$pdf->SetXY(12, 173);
$email = <<<"EOD"
<p >Street/Location: </p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $email, 0, 1, 0, true, '', true);

$pdf->SetXY(55, 173);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(100, 9, $street, 1, 'C', 1, 0, '', '', true);


// Branch Name
$pdf->SetXY(12, 185);
$branch_ = <<<"EOD"
<p ><b>Nature of Business:</b> </p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $branch_, 0, 1, 0, true, '', true);

$pdf->SetXY(55, 185);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(130, 9, $businessnature, 1, 'C', 1, 0, '', '', true);


// Branch Name
$pdf->SetXY(12, 197);
$businesstype = <<<"EOD"
<p ><b>State whether an Entity or Individual:</b></p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $businesstype, 0, 1, 0, true, '', true);

$pdf->SetXY(95, 197);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(80, 9, $company_type, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(12, 210);
$TITLE = <<<"EOD"
<p ><b>SUMMARY OF GROSS EMOLUMENTS AND TAX PAID DURING THE YEAR</b></p>
EOD;
// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $TITLE, 0, 1, 0, true, '', true);





// // MYSQL DATA
$html = '<table align="center" border="1px">
		<thead>';
$html .= "<tr>	
 				<th width='70'><b>Month</b></th>
 				<th ><b>Payment to Permanent employees TZS</b></th>
 				<th ><b>Payment to Casual employees TZS</b></th>
 				<th ><b>Total Gross Emoluments TZS</b></th>
 				<th ><b>Amount of SDL Paid TZS</b></th>
 				</tr></thead>";

			foreach($sdl as $key){
		          $month = $key->payroll_date;
		          $permanent = $key->sum_salary;
		          $casual = 0;
		          $total_gross = $key->sum_gross;
		          $sdl_paid = $key->sum_sdl;

$html .= '<tr>
          <td ><b>'.date('F', strtotime($month)).'</b></td>
          <td align="right">'.number_format($total_gross,2).'</td>
          <td align="right">'.number_format($casual,2).'</td>
          <td align="right">'.number_format($total_gross + $casual,2).'</td>
          <td align="right">'.number_format($sdl_paid,2).'</td>
       </tr>';
}
foreach($total as $key){
		$totalpermanent = $key->total_salary;
		$totalcasual = 0.00;
		$totalgross = $key->total_gross;
		$totalsdl = $key->total_sdl; 
		$rate = (($totalsdl/$totalpermanent)*100); 
$html .= '<tr>
			<td>TOTAL</td>
          <td align="right">'.number_format($totalgross,2).'</td>
          <td align="right">'.number_format($totalcasual,2).'</td>
          <td align="right">'.number_format($totalgross+$totalcasual,2).'</td>
          <td align="right">'.number_format($totalsdl,2).'</td>
          </tr>';
      }

$html .= '</table>';
// // MYSQL DATA

 
// // Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


// ###################SECOND PAGE#############################

// This method has several options, check the source code documentation for more information.
// $pdf->AddPage();
$pdf->AddPage('L', 'A4');
// $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');

// $pdf->SetXY(75, 10);
// $path= url('').'uploads/logo/cits.png';
// $pdf->Image($path, 90, 10, 30, 30, '', '', 'T', false, 300, '', false, false, 1, false, false, false);

$pdf->SetXY(0, 10);
$header1 = <<<"EOD"
<p align="center"><b>SDL - DETAILS OF EMPLOYEE</b></p>

EOD;
$pdf->writeHTMLCell(0, 12, '', '', $header1, 0, 1, 0, true, '', true);

// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2,
//  'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// EMPLOYER
foreach($info as $key){
    $name = $key->cname;
    $tin = $key->tin;

}

$pdf->SetXY(8, 24);
$employer = "<p><b>SDL of VSO Employees as of:  ".date('Y-m-d', strtotime($month))."</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $employer, 0, 1, 0, true, '', true);

// TIN NUMBER

$pdf->SetXY(200, 23);
$TIN = "<p><b>TIN </b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $TIN, 0, 1, 0, true, '', true);

$pdf->SetXY(214, 22);
// set font
$pdf->SetFont('times', '', 12, '', true);

$tinNo = $tin;

// add a page
// $pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(5, 4, $tinNo[0], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo[1], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo[2], 1, 'L', 1, 0, '', '', true);

// set color for background
$pdf->SetFillColor(0, 2, 25);

// Multicell test
$pdf->MultiCell(5, 4, '', 1, 'L', 1, 0, '', '', true);


// set color for background
$pdf->SetFillColor(255, 255, 255);

// Multicell test
$pdf->MultiCell(5, 4, $tinNo[3], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo[4], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo[5], 1, 'L', 1, 0, '', '', true);


// set color for background
$pdf->SetFillColor(0, 0, 0);

// Multicell test
$pdf->MultiCell(5, 4, '', 1, 'L', 1, 0, '', '', true);


// set color for background
$pdf->SetFillColor(255, 255, 255);

// Multicell test
$pdf->MultiCell(5, 4, $tinNo[6], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo[7], 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(5, 4, $tinNo[8], 1, 'L', 1, 0, '', '', true);

// TIN NUMBER

// Set some content to print
$pdf->SetXY(5, 30);
$html = <<<EOD
<html>

<body>
EOD;

$html = <<<EOD
<table align="center" border="1px">
		<thead>
<tr>	<td width="50"><b>S/NO</b></td>
				<th width="180"><b>NAME OF EMPLOYEE</b></th>
				<th><b>TIN</b></th>
				<th><b>NATIONAL ID</b></th>		
 				<th><b>POSTAL ADDRESS</b></th>
 				<th><b>POSTAL CITY</b></th>
 				<th><b>BASIC PAY</b></th>
 				<th><b>GROSS PAY</b></th>
 				<th><b>SDL</b></th>
 				</tr></thead>
EOD;


foreach($paye as $key){
    $salary = $key->salary;
    $gross = $key->salary + $key->allowances;
    $name = $key->name;
    $deductions = $key->pension_employee;
    $taxable = $key->salary + $key->allowances - $key->pension_employee;
    $taxdue = $key->taxdue;
    $sdl = 0.04 * $gross;
    $tin = $key->tin;
    $national_id = $key->national_id;

    $html .= '<tr>
          <td width="50">'.$key->sNo.'</td>
          <td width="180" align="left">'.$name.'</td>
          <td align="left">'.$tin.'</td>
          <td align="left">'.$national_id.'</td>
          <td align="left">'.$key->postal_address.'</td>
          <td align="left">'.$key->postal_city.'</td>
          <td align="right">'.number_format($salary,2).'</td>
          <td align="right">'.number_format($gross,2).'</td>
          <td align="right">'.number_format($sdl,2).'</td>
       </tr>';
}
foreach($total as $key){
    $salary = $key->total_salary;
    $gross = $key->total_gross;
    $total_sdl = $key->total_sdl;
//    $taxable = $key->sum_taxable;
//    $taxdue = $key->sum_taxdue;
    $html .= '<tr>
          <td colspan ="4" style="background-color:#FFFF00;">TOTAL</td>
          <td align="right"></td>
          <td align="right"></td>
          <td align="right">'.number_format($salary,2).'</td>
          <td align="right">'.number_format($gross,2).'</td>
          <td align="right">'.number_format($total_sdl,2).'</td>

          </tr>';
}

$html .= '</table>';
// MYSQL DATA


// $txt = <<<EOD
// TCPDF Example 003

// Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
// EOD;

// // print a block of text using Write()
// $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);




// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('p9-'.date('d/m/Y').'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
















#######################SECOND PAGE##################################
$pdf->Addpage();


$pdf->SetXY(10, 10);
$htm = "<p>The amount of gross emoluments paid during the period from (please tick the appropriate box)</p>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $htm, 0, 1, 0, true, '', true);

$pdf->SetXY(20, 21);
$html1 = "<p>From 1st January to 30th June</p>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);


// Option 1

$pdf->SetXY(10, 21);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(7, 7, '', 1, 'L', 1, 0, '', '', true);


// Option 2
$pdf->SetXY(20, 33);
$html2 = "<p>From 1st July to 31st December</p>";
$pdf->writeHTMLCell(0, 0, '', '', $html2, 0, 1, 0, true, '', true);
$pdf->SetXY(10, 33);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(7, 7, '', 1, 'L', 1, 0, '', '', true);




$pdf->SetXY(10, 43);
$physical = "<p>added up to TZS:</p>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(55, 43);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, number_format($totalgross,2), 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(110, 43);
$block ="<p> and ".number_format($rate,2)."% thereof is </p>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $block, 0, 1, 0, true, '', true);

$pdf->SetXY(148, 43);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(45, 9, number_format($totalsdl,2), 1, 'C', 1, 0, '', '', true);



// DECLARATION
$pdf->SetXY(10, 60);
$declaration = <<<"EOD"
<p><b>DECLARATION: </b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $declaration, 0, 1, 0, true, '', true);


$pdf->SetXY(10, 70);
$htm = "<p>I certify that the particulars on the form SDL already submitted monthly for the perion indicated above are correct<br><br> Name of the Employer/Paying Officer<br>
	...........................................................................................................................................................................</p>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $htm, 0, 1, 0, true, '', true);


$pdf->SetXY(10, 102);
$title = "<p>Title:</p>";
$pdf->writeHTMLCell(0, 0, '', '', $title, 0, 1, 0, true, '', true);

$pdf->SetXY(60, 102);
$physical = "<p>Mr.</p>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(70, 100);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(10, 9, '', 1, 'C', 1, 0, '', '', true);



$pdf->SetXY(85, 102);
$physical = "<p>Mrs.</p>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(95, 100);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(10, 9, '', 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(110, 102);
$physical = "<p>Ms.</p>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(120, 100);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(10, 9, '', 1, 'C', 1, 0, '', '', true);


#####################NAME BOXES###################

$pdf->SetXY(13, 120);
$physical = "<p>First Name.</p>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(10, 112);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(53, 9, '', 1, 'C', 1, 0, '', '', true);



$pdf->SetXY(77, 120);
$physical = "<p>Middle Name Name.</p>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(77, 112);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(53, 9, '', 1, 'C', 1, 0, '', '', true);



$pdf->SetXY(149, 120);
$physical = "<p>Surname.</p>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(145, 112);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(53, 9, '', 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(10, 130);
$htm = "<p>Signature and rubber stamp of the Employer/Paying Officer
<br><br><br><br>.........................................................................</p>";


// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $htm, 0, 1, 0, true, '', true);


 // YEAR

$pdf->SetXY(10, 170);
$year = <<<"EOD"
<p>Date:</p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $year, 0, 1, 0, true, '', true);

$pdf->SetXY(25, 163);
$year = <<<"EOD"
<p>Day:</p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $year, 0, 1, 0, true, '', true);

$pdf->SetXY(23, 170);
// set font
// $pdf->SetFont('times', '', 12);

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(8, 4, '', 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(8, 4, '', 1, 'L', 1, 0, '', '', true);




$pdf->SetXY(46, 163);
$year = <<<"EOD"
<p>Month:</p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $year, 0, 1, 0, true, '', true);

$pdf->SetXY(44, 170);
// set font
// $pdf->SetFont('times', '', 12);

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(8, 4, '', 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(8, 4, '', 1, 'L', 1, 0, '', '', true);



$pdf->SetXY(82, 163);
$year = <<<"EOD"
<p>Year:</p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $year, 0, 1, 0, true, '', true);

$pdf->SetXY(74, 170);
// set font
// $pdf->SetFont('times', '', 12);

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(8, 4, '', 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(8, 4, '', 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(8, 4, '', 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(8, 4, '', 1, 'L', 1, 0, '', '', true);

// YEAR





 
// // ---------------------------------------------------------
 
// // Close and output PDF document
// // This method has several options, check the source code documentation for more information.
$pdf->Output('p10-'.date('d/m/Y').'.pdf', 'I');
 
// //============================================================+
// // END OF FILE
// //============================================================+
