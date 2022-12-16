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
$pdf->SetTitle('Strategy Report');
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
$pdf->AddPage('P','A4');


// EMPLOYER INFO
//foreach($info as $key){
    $name = $title;
     
//}



$pdf->SetXY(0, 10);
$headertable = <<<"EOD"
<p align="center"><b>CORPORATE INFORMATION TECHNOLOGY SOLUTIONS (CITS)</b></p>
EOD;
// $headertable = " p align='center'><h4>MKOMBOZI COMMERCIAL BANK(MKCB)</h4></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);


$pdf->SetXY(87, $pdf->getY()-7);
$path=public_path().'/img/img/cits.jpg';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 30, 23, '', '', 'T', false, 300, '', false, false, '', false, false, false);

$progress = number_format($strategyProgress, 2);
$pdf->SetXY(0, $pdf->getY()+24);
$headertable =  <<<"EOD"
<p align="center"><b>STRATEGY PROGRESS REPORT</b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);

$pdf->SetXY(20, $pdf->getY());
$headertable = "
<p><b>STRATEGY NAME: &nbsp;&nbsp;&nbsp;&nbsp;</b>".ucwords($name)."<br><br><b>PROGRESS: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>".$progress."%</p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);


$pdf->SetXY(20, $pdf->getY());
$headertable1 = "
<p>TRACK TO COMPLETION</p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable1, 0, 1, 0, true, '', true);
  
 
// Set some content to print
// $pdf->SetXY(15, 85);  
$html_table1 = 
' <table border="1px">
                      <thead>
                        <tr align="center">
                          <th></th>
                          <th><b>Outcomes</b></th>
                          <th><b>Outputs</b></th>
                          <th><b>Tasks</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr align="center">
                          <th><b>Not Started</b></th>
                          <td>'.$notStartedOutcome.'</td>
                          <td>'.$notStartedOutput.'</td>
                          <td>'.$notStartedTask.'</td>
                        </tr>
                        <tr align="center">
                          <th ><b>In Progress</b></th>
                          <td>'.$progressOutcome.'</td>
                          <td>'.$progressOutput.'</td>
                          <td>'.$progressTask.'</td>
                        </tr>
                        <tr align="center">
                          <th><b>Completed</b></th>
                          <td>'.$completedOutcome.'</td>
                          <td>'.$completedOutput.'</td>
                          <td>'.$completedTask.'</td>
                        </tr>
                        <tr align="center">
                          <th ><b>Total</b></th>
                          <td>'.$totalOutcome.'</td>
                          <td>'.$totalOutput.'</td>
                          <td>'.$totalTask.'</td>
                        </tr>
                      </tbody>
                    </table>'; 
                    
$sumOutcome = $completedOutcome+$outcomeOnTrack+$outcomeOffTrack+$overdueOutcome;
$sumOutput = $completedOutput+$outputOnTrack+$outputOffTrack+$overdueOutput;
$sumTask = $completedTask+$taskOnTrack+$taskOffTrack+$overdueTask;

if($sumOutcome==0)$sumOutcome=1;
if($sumOutput==0)$sumOutput=1;
if($sumTask==0)$sumTask=1;

$html_table2 = 
' <table border="1px">
                      <thead>
                        <tr align="center">
                          <th></th>
                          <th><b>Outcomes</b></th>
                          <th><b>Outputs</b></th>
                          <th><b>Tasks</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr align="center">
                          <th><b>Completed</b></th>
                          <td>'.$completedOutcome.'( '.number_format($completedOutcome*100/$sumOutcome, 1).'% )</td>
                          <td>'.$completedOutput.'( '.number_format($completedOutput*100/$sumOutput, 1).'% )</td>
                          <td>'.$completedTask.'( '.number_format($completedTask*100/$sumTask, 1).'% )</td>
                        </tr>
                        <tr align="center">
                          <th ><b>On Track</b></th>
                          <td>'.$outcomeOnTrack.'( '.number_format($outcomeOnTrack*100/$sumOutcome, 1).'% )</td>
                          <td>'.$outputOnTrack.'( '.number_format($outputOnTrack*100/$sumOutput, 1).'% )</td>
                          <td>'.$taskOnTrack.'( '.number_format($taskOnTrack*100/$sumTask, 1).'% )</td>
                        </tr>
                        <tr align="center">
                          <th><b>Delayed</b></th>
                          <td>'.$outcomeOffTrack.'( '.number_format($outcomeOffTrack*100/$sumOutcome, 1).'% )</td>
                          <td>'.$outputOffTrack.'( '.number_format($outputOffTrack*100/$sumOutput, 1).'% )</td>
                          <td>'.$taskOffTrack.'( '.number_format($taskOffTrack*100/$sumTask, 1).'% )</td>
                        </tr>
                        <tr align="center">
                          <th ><b>Overdue</b></th>
                          <td>'.$overdueOutcome.'( '.number_format($overdueOutcome*100/$sumOutcome, 1).'% )</td>
                          <td>'.$overdueOutput.'( '.number_format($overdueOutput*100/$sumOutput, 1).'% )</td>
                          <td>'.$overdueTask.'( '.number_format($overdueTask*100/$sumTask, 1).'% )</td>
                        </tr>
                      </tbody>
                    </table>';
                    

// $txt = <<<EOD
// TCPDF Example 003

// Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
// EOD;

// // print a block of text using Write()
// $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);



 
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', $pdf->getY()-5, $html_table1, 0, 1, 0, true, '', true);
// ---------------------------------------------------------


$pdf->SetXY(20, $pdf->getY()+8);
$headertable2 = "
<p>TRACK TO TARGET ESTIMATE</p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable2, 0, 1, 0, true, '', true);


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', $pdf->getY()-6, $html_table2, 0, 1, 0, true, '', true);
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
$pdf->Output('strategy_track_to_completion-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 
