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
$pdf->SetTitle('Arrears');
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
// $pdf->SetFont('times', '', 12, '', true);
$pdf->SetFont('courier', '', 12, '', true);
 
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L','A4');


// EMPLOYER INFO
foreach ($info as $row) {
      $logo = $row->logo;
      $companyname = $row->cname;
}

// define style for border
$style = array('width' => 0.25, 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->SetDrawColor(127, 255, 127);
$pdf->SetFillColor(0, 255, 0);

$pdf->SetXY(137, 10);
$path=FCPATH.'uploads/logo/logo.png';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '',  35, 30, '', '', 'T', false, 300, '', false, false, '', false, false, false);

$pdf->SetXY(113,  $pdf->GetY()+25);
$headertable = <<<EOD
  <p align='center'><h3>SALARY ARREARS REPORT OVER TIME</h3></p>
EOD;

$sum_arrears = $sum_paid= $sum_outstanding = $sum_last_paid = 0;

$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);
// $date = date('F, Y', strtotime($payroll_month));


$pdf->SetXY(20, $pdf->GetY());
if($dateStart==$dateFinish){


$summary = '
  <table width = "100%">
      <tr align="left">
          <th width="180"><b>Payroll Month:</b></th>
          <th width="200">'.date('F-Y', strtotime($dateStart)).'</th>
      </tr>
  </table>';

} else {
  if($dateFinish>$dateStart){
    $summary = '
    <table width = "100%">
        <tr align="left">
            <th width="180"><b>From Date:</b></th>
            <th width="200">'.date('F-Y', strtotime($dateStart)).'</th>
        </tr>
        <tr align="left">
            <td align "left"><b>To Date:</b></td>
            <td align "left">'.date('F-Y', strtotime($dateFinish)).'</td>
        </tr>
    </table>';
  }else{
    $summary = '
    <table width = "100%">
        <tr align="left">
            <th width="180"><b>From Date:</b></th>
            <th width="200">'.date('F-Y', strtotime($dateFinish)).'</th>
        </tr>
        <tr align="left">
            <td align "left"><b>To Date:</b></td>
            <td align "left">'.date('F-Y', strtotime($dateStart)).'</td>
        </tr>
    </table>';

  }
}
$pdf->writeHTMLCell(0, 12, '', '', $summary, 0, 1, 0, true, '', true);

$pdf->SetXY(20, $pdf->GetY()+5);
$html = '
<table border="1px">
<thead>
  <tr style="background-color:#14141f;color:#FFFFFF;" align="center">
    <th width="37"><b>S/N</b></th>
    <th width="90"><b>Employee ID</b></th>
    <th width="200"><b>Name</b></th>
    <th width="118"><b>Amount</b></th>
    <th width="118"><b>Paid</b></th>
    <th width="118"><b>Outstanding</b></th>
    <th width="118"><b>Last Payment</b></th>
    <th width="135"><b>Date Last<br>Payment</b></th>
  </tr>
 </thead>';

  foreach($arrears as $row){
    // $sno = $row->SNo;
    $empID =  $row->empID;
    $name =$row->empName;
    $amount = $row->amount;
    $paid = $row->paid;
    $outstanding = ($row->amount-$row->paid);
    $last_paid = $row->amount_last_paid;
    $last_paid_date = date('d-M-Y', strtotime($row->last_paid_date));
    if  ($row->SNo % 2 == 0) { $background = "#d3d3d3;"; } else { $background = "#FFFFFF;"; }
    $sum_arrears = $sum_arrears + $amount;
    $sum_paid = $sum_paid + $paid;
    $sum_last_paid = $sum_last_paid + $last_paid;
    $sum_outstanding = $sum_outstanding + $outstanding;

  $html .='<tbody>
      <tr nobr="true" style="background-color:'.$background.'">
            <td width="37" align="center">'.$row->SNo.'</td>
            <td width="90">&nbsp;'.$empID.'</td>
            <td width="200">&nbsp;'.$name.'</td>
            <td width="118" align="right">&nbsp;'.number_format($amount,2).'</td>
            <td width="118" align="right">&nbsp;'.number_format($paid,2).'</td>
            <td width="118" align="right">&nbsp;'.number_format($outstanding,2).'</td>
            <td width="118" align="right">&nbsp;'.number_format($last_paid,2).'</td>
            <td width="135"  align="center">'.$last_paid_date.'</td>
    </tr>
    </tbody>';
    
}

  $html .= '<tr colspan="6">
            <td width="327" align="center">TOTAL</td>
            <td width="118" align="right">&nbsp;'.number_format($sum_arrears,2).'</td>
            <td width="118" align="right">&nbsp;'.number_format($sum_paid,2).'</td>
            <td width="118" align="right">&nbsp;'.number_format($sum_outstanding,2).'</td>
            <td width="118" align="right">&nbsp;'.number_format($sum_last_paid,2).'</td>
            <td width="135"  align="center"></td>
    </tr>';

  $html .="</table>";
  
 //HTML2
 
$signatory = '
<table width="100%" >
<thead>
  <tr align="left">
    <th width="312"><b>SIGNATORY</b></th>
    <th width="312"><b></b></th>
    <th width="312"><b></b></th>
  </tr>
 </thead>';
  $signatory .='
      <tr nobr="true">
            <td width="320" align="left"><br><br>Signatory 1.................</td>
            <td width="320"><br><br>Signature..............</td>
            <td width="295"><br><br>Date.............</td>
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
 
