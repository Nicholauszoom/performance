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
$pdf->SetAuthor('Cits');
$pdf->SetTitle('P9-'.date('d/m/Y'));
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
if (@file_exists(dirname(__FILE__).base_url().'/application/libraries/tcpdf/examples/lang/eng.php')) {
               require_once(dirname(__FILE__).base_url().'/application/libraries/tcpdf/examples/lang/eng.php');
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

$pdf->SetXY(70, 15);
$path=FCPATH.'uploads/logo/TRAheader.png';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 80, '', '', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetXY(20, 45);
$header1 = <<<"EOD"
<p align="center"><b>P.A.Y.E.</b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $header1, 0, 1, 0, true, '', true);

$pdf->SetXY(25,53);
$header2 = <<<"EOD"
<p align="center"><b>STATEMENT AND PAYMENT OF TAX WITHHELD</b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $header2, 0, 1, 0, true, '', true);
 
// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2,
//  'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));



 // YEAR

$pdf->SetXY(30, 62);
$year = <<<"EOD"
<p align="center"><b>YEAR: </b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $year, 0, 1, 0, true, '', true);

$pdf->SetXY(125, 62);
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
		$plot_no = $key->plot_no;
		$block_no = $key->block_no;
		$branch = $key->branch;
		$street = $key->street;
		 
}

$pdf->SetXY(30, 71);
$TIN1 = <<<"EOD"
<p align="center"><b>TIN: </b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $TIN1, 0, 1, 0, true, '', true);

$pdf->SetXY(125, 72);
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
 
// Set some content to print



// MYSQL DATA
// $html = '<table align="center" border="1px">';
// $html .= '<tr>	<th ><b>ID</b></th>
// 				<th ><b>Name</b></th>
//  				<th ><b>Relationship</b></th>
//  				<th ><b>Excessp</b></th>
//  				</tr>';

// 	foreach($taxable->result() as $key){
// $html .= '<tr>
//           <td>'.$key->minimum.'</td>
//           <td>'.$key->maximum.'</td>
//           <td>'.$key->rate.'</td>
//           <td>'.$key->excess_added.'</td>
//        </tr>';
// }

// $html .= '</table>';
// MYSQL DATA

$pdf->SetXY(10, 82);
$htm = "<h2><b>Period: <small>(Please tick the appropriate box)<small></h2></b>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $htm, 0, 1, 0, true, '', true);

$pdf->SetXY(20, 93);
$html1 = "<h3><b>From 1 January to 30 June</b></h3>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);


// Option 1

$pdf->SetXY(10, 93);
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
$pdf->SetXY(20, 105);
$html2 = "<p><b>From 1 July to 31 December</b></p>";
$pdf->writeHTMLCell(0, 0, '', '', $html2, 0, 1, 0, true, '', true);
$pdf->SetXY(10, 105);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(7, 7, '', 1, 'L', 1, 0, '', '', true);



$pdf->SetXY(10, 120);
$txt = "<p><b>
Name of Employer:</p></b>";
$NAME = strtoupper($name);
// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);
$pdf->SetXY(10, 128);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(177, 10, $NAME, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(10, 140);
$po_box = "<p><b>
Postal Address:</p>
<p> P.O. Box</p></b>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $po_box, 0, 1, 0, true, '', true);

$pdf->SetXY(37, 150);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $postal_address, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(110, 150);
$postal = <<<"EOD"
<p >Postal City</p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $postal, 0, 1, 0, true, '', true);

$pdf->SetXY(137, 150);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $postal_city, 1, 'C', 1, 0, '', '', true);



// Contact Number
$pdf->SetXY(10, 165);
$po_box = "<p><b>
Contact Numbers:</p>
<p> Phone Number</p></b>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $po_box, 0, 1, 0, true, '', true);

$pdf->SetXY(45, 175);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $phone_no1, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(115, 175);
$postal = <<<"EOD"
<p >Second Phone</p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $postal, 0, 1, 0, true, '', true);

$pdf->SetXY(142, 175);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $phone_no2, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(12, 187);
$thirdphone = <<<"EOD"
<p >Third Phone</p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $thirdphone, 0, 1, 0, true, '', true);

$pdf->SetXY(45, 187);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $phone_no3, 1, 'C', 1, 0, '', '', true);



// FAX NUMBER
$pdf->SetXY(115, 187);
$thirdphone = <<<"EOD"
<p >Fax Number</p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $thirdphone, 0, 1, 0, true, '', true);

$pdf->SetXY(142, 187);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $fax_no, 1, 'C', 1, 0, '', '', true);

 

// EMAIL ADDRESS
$pdf->SetXY(12, 200);
$email_ = <<<"EOD"
<p ><b>Email Addess: </b></p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $email_, 0, 1, 0, true, '', true);

$pdf->SetXY(45, 200);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(147, 9, $email, 1, 'C', 1, 0, '', '', true);


// PHYSICAL ADDRESS

$pdf->SetXY(10, 220);
$physical = "<p><b>
Physical Address:</p>
<p>Plot Number</p></b>";

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $physical, 0, 1, 0, true, '', true);

$pdf->SetXY(45, 230);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $plot_no, 1, 'C', 1, 0, '', '', true);


$pdf->SetXY(110, 230);
$block = <<<"EOD"
<p >Block Number</p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $block, 0, 1, 0, true, '', true);

$pdf->SetXY(142, 230);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(50, 9, $block_no, 1, 'C', 1, 0, '', '', true);


// Street Location
$pdf->SetXY(12, 243);
$email = <<<"EOD"
<p >Street/Location: </p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $email, 0, 1, 0, true, '', true);

$pdf->SetXY(45, 243);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(147, 9, $street, 1, 'C', 1, 0, '', '', true);


// Branch Name
$pdf->SetXY(12, 257);
$branch_ = <<<"EOD"
<p >Name Branch: </p>
EOD;

// print a block of text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $branch_, 0, 1, 0, true, '', true);

$pdf->SetXY(45, 257);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
// $pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// Multicell test
$pdf->MultiCell(147, 9, $branch, 1, 'C', 1, 0, '', '', true);













// ###################SECOND PAGE#############################

// This method has several options, check the source code documentation for more information.
// $pdf->AddPage();
$pdf->AddPage('L', 'A4');
// $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');

// $pdf->SetXY(75, 10);
// $path=base_url().'uploads/logo/cits.png';
// $pdf->Image($path, 90, 10, 30, 30, '', '', 'T', false, 300, '', false, false, 1, false, false, false);

$pdf->SetXY(0, 10);
$header1 = <<<"EOD"
<p align="center"><b>P.A.Y.E. - DETAILS OF PAYMENT OF TAX WITHHELD</b></p>
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
$employer = "<p><b>Name of Employer:  ".$NAME." as of " .$payroll_date."</b></p>";
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
 				<th><b>BASIC PAY</b></th>
 				<th><b>GROSS PAY</b></th>
 				<th><b>DEDUCTIONS</b></th>
 				<th><b>TAXABLE AMOUNT</b></th>
 				<th><b>TAX DUE</b></th>
 				</tr></thead>
EOD;


	foreach($paye as $key){ 
		$salary = $key->salary;
		$gross = $key->salary + $key->allowances;
		$name = $key->name;
		$deductions = $key->pension_employee;
		$taxable = $key->salary + $key->allowances - $key->pension_employee; 
		$taxdue = $key->taxdue;
		$tin = $key->tin;
		$national_id = $key->national_id;

$html .= '<tr>
          <td width="50">'.$key->sNo.'</td>
          <td width="180" align="left">'.$name.'</td>
          <td align="left">'.$tin.'</td>
          <td align="left">'.$national_id.'</td>
          <td align="right">'.number_format($salary,2).'</td>
          <td align="right">'.number_format($gross,2).'</td>
          <td align="right">'.number_format($deductions,2).'</td>
          <td align="right">'.number_format($taxable,2).'</td>
          <td align="right">'.number_format($taxdue,2).'</td>
       </tr>';
}
foreach($total as $key){
		$salary = $key->sum_salary;
		$gross = $key->sum_gross;
		$deductions = $key->sum_deductions;
		$taxable = $key->sum_taxable; 
		$taxdue = $key->sum_taxdue; 
$html .= '<tr>
          <td colspan ="2" style="background-color:#FFFF00;">TOTAL</td>
          <td align="right"></td>
          <td align="right"></td>
          <td align="right">'.number_format($salary,2).'</td>
          <td align="right">'.number_format($gross,2).'</td>
          <td align="right">'.number_format($deductions,2).'</td>
          <td align="right">'.number_format($taxable,2).'</td>
          <td align="right">'.number_format($taxdue,2).'</td>
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
