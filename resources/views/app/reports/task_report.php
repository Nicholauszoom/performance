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
//foreach($info as $key){
    $name = $title;
     
//}
// define style for border
$style = array('width' => 0.25, 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->SetDrawColor(127, 255, 127);
$pdf->SetFillColor(0, 255, 0);

$pdf->SetXY(0, 15);
$headertable =<<<"EOD"
<p align="center"><b>CORPORATE INFORMATION TECHNOLOGY SOLUTIONS (CITS)</b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);


$pdf->SetXY(117, 18);
$path=FCPATH.'uploads/img/cits.jpg';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 30, 25, '', '', 'T', false, 300, '', false, false, '', false, false, false);

$totalStrategyProgress = number_format($strategyProgress, 2);
$pdf->SetXY(100, 37);
$headertable = "
<p align='center'><h3>STRATEGY PROGRESS REPORT</h3></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);

$pdf->SetXY(20, 55);
$headertable = "
<p><b>TRACK TO COMPLETION (TASK)<br>STRATEGY NAME: &nbsp;&nbsp;&nbsp;&nbsp;</b>".strtoupper($name)."<br><b>PROGRESS: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>".$totalStrategyProgress."%<br></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);
 
 

 
// Set some content to print
// $pdf->SetXY(15, 85);
$html = '
<table border="1px">
<thead>
  <tr align="center">
    <th width="37"><b>S/N</b></th>
    <th width="355"><b>Task Name</b></th>
    <th width="105"><b>Accountable Executive</b></th>
    <th width="105"><b>Responsible Person</b></th>
    <th width="65"><b>Duration</b></th>
    <th width="85"><b>Start</b></th>
    <th width="85"><b>End</b></th>
    <th width="100"><b>RAG Status</b></th>
  </tr>
 </thead>';

  foreach($taskList as $row){
    $sno = $row->SNo;
    $output_name = $row->outputTitle;
    $taskTitle = $row->title;
    $executive = $row->executive;
    
    if($row->isAssigned == 0){ $name = "Not Assigned"; } else { $name = $row->name; }
    $startd=date_create($row->start);
    $endd=date_create($row->end);
    $diff=date_diff($startd, $endd);
    $DURATION = $diff->format("%a Days");
    
    $startDate = date('d-m-Y', strtotime($row->start));
    $finishDate = date('d-m-Y', strtotime($row->end));
    
      $todayDate=date_create(date('Y-m-d'));
      $endd=date_create($row->end);
        
      $diffToday=date_diff($endd,$todayDate);
      $overDue = $diffToday->format("%R%a Days");
      
    //   $totalTaskProgress = $row->sumProgress;
    //   $taskCount = $row->countTask;
      $progress = $row->progress;
      
      if($overDue>=0){
          if($progress==100)  { $outputProgress = "Completed"; $color = "#00CC00";} else { $outputProgress = "Overdue ".number_format($progress,1)."%"; $color = "#FF0000"; }
          
      } else { 
          if($progress==0)   {$outputProgress = "Not Started"; $color = "#FFA500";}
          else if($progress>0 && $progress<100) {$outputProgress  = "On Progress ".number_format($progress,1)."%";  $color = "#ADD8E6";}
          else if($progress==100)  {$outputProgress = "Completed"; $color = "#00CC00";}
      }
      
      
  $html .='<tbody>
      <tr nobr="true">
            <td width="37" align="center">'.$sno.'</td>
            <td width="355">&nbsp;'.$taskTitle.'<br><b>Outcome Reference:</b>'.$output_name.'</td>
            <td width="105">&nbsp;'.$name.'</td>
            <td width="105">&nbsp;'.$executive.'</td>
            <td width="65">&nbsp;'.$DURATION.'</td>
            <td width="85" align="center">&nbsp;'.$startDate.'</td>
            <td width="85" align="center">&nbsp;'.$finishDate.'</td>
            <td width="100" bgcolor="'.$color.'" color="#000000" align="center">&nbsp;<b>'.$outputProgress.'</b></td>
    </tr>
    </tbody>';
    
}

  $html .="</table><br>
  
  <table border='1px'>
  
      <tr nobr='true'>
      <td colspan='4'><br><br><b>Responsible Person</b><br><br>Name............................................... <br><br>Signature......................................
      </td>
      <td></td>
      <td colspan='4'><br><br><br><br>Date: .....................................</td>
      </tr>
      
      <tr nobr='true'>
      <td colspan='4'><br><br><b>Accountable Executive</b><br><br>Name............................................... <br><br>Signature......................................
      </td>
      <td></td>
      <td colspan='4'><br><br><br><br>Date: .....................................</td>
      </tr>
      
</table>";




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
$pdf->Output('task_report-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 
