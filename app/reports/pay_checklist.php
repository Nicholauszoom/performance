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
$pdf->SetTitle('Strategy Report_Task');
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

foreach ($take_home as $row) {
  $net = $row->takehome;
  $net_less = $row->takehome_less;
}

$amount_takehome = 0.00;


// define style for border
$style = array('width' => 0.25, 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->SetDrawColor(127, 255, 127);
$pdf->SetFillColor(0, 255, 0);

/*$pdf->SetXY(120, 5);
$headertable = "
<p align='center'><h4>EWURA CCC</h4></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);
*/

$pdf->SetXY(117, 10);
$path=public_path().'/img/logo/logo.png';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '',  35, 30, '', '', 'T', false, 300, '', false, false, '', false, false, false);

$totalStrategyProgress = number_format($strategyProgress, 2);
$pdf->SetXY(113,  $pdf->GetY()+25);
$headertable = "
<p align='center'><h3>PAY CHECKLIST</h3></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);
$date = date('F, Y', strtotime($payroll_month));

$pdf->SetXY(20, $pdf->GetY()+2);
$headertable = "<p><b>Payroll Month: &nbsp;&nbsp;&nbsp;</b>".$date."</p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);


 

 
// Set some content to print
// $pdf->SetXY(15, 85);
$html = '
<table border="1px">
<thead>
  <tr style="background-color:#14141f;color:#FFFFFF;" align="center">
    <th><b>S/N</b></th>
    <th><b>Employee ID</b></th>
    <th><b>Name</b></th>
    <th><b>Amount</b></th>
    <th><b>Bank</b></th>
    <th><b>Branch</b></th>
    <th><b>Swiftcode</b></th>
    <th><b>Account No.</b></th>
  </tr>
 </thead>';

  foreach($employee_list as $row){
    $sno = $row->SNo;
    $empID =  $row->empID;
    $name = $row->name;
    $bank = $row->bank;
    $branch = $row->branch;
    $swiftcode = $row->swiftcode;
    $less_takehome = $row->less_takehome;
    $account_no = $row->account_no;
    if($less_takehome==0){
    $amount = $row->salary + $row->allowances-$row->pension-$row->loans-$row->deductions-$row->meals-$row->taxdue; } else $amount = $less_takehome;
    if  ($sno % 2 == 0) { $background = "#d3d3d3;"; } else { $background = "#FFFFFF;"; }

    $amount_takehome = $amount_takehome + $amount;
      
  $html .='<tbody>
      <tr nobr="true" style="background-color:'.$background.'">
            <td align="center">'.$sno.'</td>
            <td>&nbsp;'.$empID.'</td>
            <td>&nbsp;'.$name.'</td>
            <td align="right">&nbsp;'.number_format($amount,2).'</td>
            <td>&nbsp;'.$bank.'</td>
            <td align="center">&nbsp;'.$branch.'</td>
            <td align="center">&nbsp;'.$swiftcode.'</td>
            <td align="center">&nbsp;'.$account_no.'</td>
    </tr>
    </tbody>';
    
}

  $html .="</table>";
  
$pdf->SetXY(20, $pdf->GetY()-3);
$total_amount = "<p><b>Total Amount: &nbsp;&nbsp;&nbsp;</b>".number_format($amount_takehome ,2)." Tsh</p>";
$pdf->writeHTMLCell(0, 12, '', '', $total_amount, 0, 1, 0, true, '', true);
 
  
 //HTML2
 
$signatory = '
<table width="100%" >
<thead>
  <tr align="left">
    <th width="312"><b>SIGNATORIES</b></th>
    <th width="312"><b></b></th>
    <th width="312"><b></b></th>
  </tr>
 </thead>';
  $signatory .='
      <tr nobr="true">
            <td width="320" align="left"><br><br>Signatory 1...............................................................</td>
            <td width="320"><br><br>Signature..............................................</td>
            <td width="295"><br><br>Date..............................................</td>
    </tr>';
      
  /*$signatory .='
      <tr nobr="true">
            <td width="312" align="left"><br><br>Signatory 2...............................................</td>
            <td width="312"><br><br>Signature..............................................</td>
            <td width="312"><br><br>Date..............................................</td>
    </tr>';*/
      
  $signatory .='<tbody>
      <tr nobr="true">
            <td width="312" align="left"><br><br><br><br>Signatory 2...............................................................</td>
            <td width="312"><br><br><br><br>Signature..............................................</td>
            <td width="312"><br><br><br><br>Date..............................................</td>
    </tr>
    </tbody>';

  $signatory .="</table>";




// $txt = <<<EOD
// TCPDF Example 003

// Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
// EOD;

// // print a block of text using Write()
// $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);



 
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()-5, $html, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+10, $signatory, 0, 1, 0, true, '', true);
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
$pdf->Output('task_report-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 
