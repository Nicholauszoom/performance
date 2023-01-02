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
global $docAuthor;
$docAuthor = $author;  

class MYPDF extends TCPDF {
 

  //Page header
  public function Header() {    
    global $docAuthor;
    // Logo
    // $image_file = K_PATH_IMAGES.'logo_example.jpg';
    // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
    // Title
    $this->Cell(50, 0, ' Printed By '.$docAuthor.' at '.date('d-m-Y H:i:s'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
  }

  // Page footer
  public function Footer() {
    global $docAuthor;
    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('helvetica', 'I', 10);
    // Page number
    $this->Cell(0, 15, 'PAGE '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    $this->SetY(-5);
    $this->SetFont('helvetica', 'I', 8);
    $this->Cell(70, 0, ' Printed By '.$docAuthor.' at '.date('d-m-Y H:i:s'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
  }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


 
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Miraji Issa');
$pdf->SetTitle('Strategy Report_Task');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

 
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);


// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001',  PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

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

// define style for border
$style = array('width' => 0.25, 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->SetDrawColor(127, 255, 127);
$pdf->SetFillColor(0, 255, 0);

$pdf->SetXY(0, 10);
$headertable =<<<"EOD"
<p align="center"><b>CORPORATE INFORMATION TECHNOLOGY SOLUTIONS (CITS)</b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);


$pdf->SetXY(124, $pdf->GetY()-7);
$path=public_path().'/img/img/cits.jpg';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 30, 23, '', '', 'T', false, 300, '', false, false, '', false, false, false);

$totalStrategyProgress = number_format($strategy_progress, 2);
$reportName = strtoupper($report_name);
$pdf->SetXY(0, $pdf->GetY()+24);
$header =  <<<"EOD"
<p align="center"><b>STRATEGY REPORT ( With Approved Submissions)</b></p>
EOD;
$subheader =  <<<"EOD"
<p align="center"><b>$reportName</b></p>
EOD;

$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 10, 0, $pdf->GetY()-5, $subheader, 0, 1, 0, true, '', true);

$pdf->SetXY(20, $pdf->GetY());
$headertable = "
<p><b>STRATEGY DETAILS: </b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);

foreach ($strategy_info as $row) {
  $tasks = $row->countTask;
  $outcomes = $row->countOutcome;
  $outputs = $row->countOutput;
  $strategyName  = $row->title;
  $description = $row->description;
  $strategyStart = date('d-m-Y', strtotime($row->start));
  $strategyEnd = date('d-m-Y', strtotime($row->end));
  if ($row->title==1) $type = "STRATEGY";  else $type = "PROJECT";
}
 
 $strategy_details = 
' <table border="1px">
                      <thead>
                        <tr align="center">
                          <th width="37"><b>#</b></th>
                          <th width="200"><b>Attribute</b></th>
                          <th width="700"><b>Value</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr align="left">
                          <th width="37" align="center">1</th>
                          <th width="200"><b> Strategy Name:</b></th>
                          <td width="700"> '.$strategyName.'</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 2</td>
                          <th width="200"><b> Type:</b></th>
                          <td width="700"> '.$type.'</td>
                        </tr>';
  $strategy_details .=  '<tr align="left">
                          <td width="37" align="center"> 2</td>
                          <th width="200"><b> Progress:</b></th>
                          <td width="700"> '.$totalStrategyProgress.'%</td>
                        </tr>';
  $strategy_details .=  '<tr align="left">
                          <td width="37" align="center"> 3</td>
                          <th width="200"><b> Number of Outcomes:</b></th>
                          <td width="700"> '.$outcomes.'</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 4</td>
                          <th width="200"><b> Number of Outputs:</b></th>
                          <td width="700"> '.$outputs.'</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 5</td>
                          <th width="200"><b> Number of Tasks:</b></th>
                          <td width="700"> '.$tasks.'</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 6</td>
                          <th width="200"><b> Date Started:</b></th>
                          <td width="700"> '.$strategyStart.'</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 7</td>
                          <th width="200"><b> Date Completed:</b></th>
                          <td width="700"> '.$strategyEnd.'</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 8</td>
                          <th width="200"><b> Strategy Description:</b></th>
                          <td width="700"> '.$description.'</td>
                        </tr>
                      </tbody>
                    </table>'; 


$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()-4, $strategy_details, 0, 1, 0, true, '', true);
 

 
// Set some content to print
// $pdf->SetXY(15, 85);
$pdf->SetXY(20, $pdf->GetY()+8);
$headertable = "
<p><b>OUTCOMES: </b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);
// OUTCOMES
$html = '
<table border="1px">
<thead>
  <tr align="center">
    <th width="37"><b>S/N</b></th>
    <th width="405"><b>Outcome Name.</b></th>
    <th width="128"><b>Resource Cost</b></th>
    <th width="128"><b>Target</b></th>
    <th width="128"><b>Result</b></th>
    <th width="111"><b>Achievements %</b></th>
  </tr></thead> <tbody>';

  foreach($outcomeList as $key){
      
      $sno = $key->SNo;
      $id = $key->id;
      $strategy_ref = $key->strategy_ref;
      $outcome_name = $key->title;
       if($key->isAssigned == 0){  $accountable = "NOT ASSIGNED"; } else { $accountable = $key->executive; }
      $startd=date_create($key->start);
      $endd=date_create($key->end);
      $diff=date_diff($startd, $endd);
      $DURATION = $diff->format("%a Days");

      $target = $key->initial_quantity;
      $results = $key->submitted_quantity;
      $resource_cost = $key->resource_cost;

      if ($results<=0){ $achievements =0;} else{
        $achievements = ($results/$target)*100;
      }
      
      /*$totalTaskProgress = $key->sumProgress;
      $taskCount = $key->countOutput;
      if($taskCount==0) $progress = 0; else $progress = number_format(($totalTaskProgress/$taskCount),1);
      
      $todayDate=date_create(date('Y-m-d'));
      $endd=date_create($key->end);
        
      $diffToday=date_diff($endd,$todayDate);
      $overDue = $diffToday->format("%R%a Days");
      
      $fromDate = date('d-m-Y', strtotime($key->start));
      $toDate = date('d-m-Y', strtotime($key->end));
      
      if($overDue>=0){
          if($progress==100)  { $outcomeProgress = "Completed"; $color = "#00CC00";} else { $outcomeProgress = "Overdue ".$progress.'%'; $color = "#FF0000"; }
          
      } else { 
          if($progress==0)   {$outcomeProgress = "Not Started"; $color = "#FFA500";}
          else if($progress>0 && $progress<100) {$outcomeProgress  = "On Progress ".$progress.'%';  $color = "#ADD8E6";}
          else if($progress==100)  {$outcomeProgress = "Completed"; $color = "#00CC00";}
      }*/
      
      
  

  $html .='<tr nobr ="true">
  
    <td width="37" align="center">'.$sno.'</td>
    <td width="405">&nbsp;<b>'.$strategy_ref.'.'.$id.'</b>&nbsp;'.$outcome_name.'</td>
    <td width="128">&nbsp;'.number_format($resource_cost,2).'</td>
    <td width="128">&nbsp;'.number_format($target,2).'</td>
    <td width="128">&nbsp;'.number_format($results,2) .'</td>
    <td width="111"  align="center">&nbsp;<b>'.number_format($achievements, 1).'%</b></td>
  </tr>';
    
}

foreach($total_outcome as $key){
    $total_resource_cost = $key->total_resource_cost;
    $total_target = $key->total_target;
    $total_results = $key->total_results;
    if($total_results<=0){ $total_achievements = 0;} else{
      $total_achievements = ($total_results/$total_target)*100;
    }

$html .= '<tr>
          <td colspan ="2" width="442" style="background-color:#FFFF00;"><b>TOTAL</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_resource_cost,2).'</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_target,2).'</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_results,2).'</b></td>
          <td width="111"  align="right"><b>'.number_format($total_achievements,2).'%</b></td>
          </tr>';
      }

  $html .="</tbody></table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()-5, $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// END OUTCOMES

// OUTPUTS

  $tableHeading  = '
  <table width="100%" >
    <thead>
      <tr align="left">
        <th width="312"><b></b></th>
    </tr>
    </thead>';

  $tableHeading .='<tbody>
      <tr nobr="true">
        <td width="312" align="left"><b>OUTPUTS</b></td>
      </tr>
    </tbody>
  </table>';

$html = '
<table border="1px">
<thead>
  <tr align="center">
    <th width="37"><b>S/N</b></th>
    <th width="405"><b>Output Name</b></th>
    <th width="128"><b>Resource Cost</b></th>
    <th width="128"><b>Target</b></th>
    <th width="128"><b>Result</b></th>
    <th width="111"><b>Achievements %</b></th>
  </tr>
 </thead><tbody>';

  foreach($outputList as $rowOutput){
    $sno = $rowOutput->SNo;
    $id = $rowOutput->id;
    $outcome_ref = $rowOutput->outcome_ref;
    $strategy_ref = $rowOutput->strategy_ref;
    $outputTitle = $rowOutput->title;
    
    if($rowOutput->isAssigned == 0){ $name = "Not Assigned"; } else { $name = $rowOutput->executive; }
    $startd=date_create($rowOutput->start);
    $endd=date_create($rowOutput->end);
    $diff=date_diff($startd, $endd);
    $DURATION = $diff->format("%a Days");
    
    $startDate = date('d-m-Y', strtotime($rowOutput->start));
    $finishDate = date('d-m-Y', strtotime($rowOutput->end));
    
      $todayDate=date_create(date('Y-m-d'));
      $endd=date_create($rowOutput->end);
        
      $diffToday=date_diff($endd,$todayDate);
      $overDue = $diffToday->format("%R%a Days");
      $target = $rowOutput->initial_quantity;
      $results = $rowOutput->submitted_quantity;
      $resource_cost = $rowOutput->resource_cost;

      if ($results<=0){ $achievements =0;} else{
        $achievements = ($results/$target)*100;
      }
      
     /* $totalTaskProgress = $rowOutput->sumProgress;
      $taskCount = $rowOutput->countTask;
      if($taskCount==0) $progress = 0; else $progress = ($totalTaskProgress/$taskCount);
      
      if($overDue>=0){
          if($progress==100)  { $outputProgress = "Completed"; $color = "#00CC00";} else { $outputProgress = "Overdue ".number_format($progress,1)."%"; $color = "#FF0000"; }
          
      } else { 
          if($progress==0)   {$outputProgress = "Not Started"; $color = "#FFA500";}
          else if($progress>0 && $progress<100) {$outputProgress  = "On Progress ".number_format($progress,1)."%";  $color = "#ADD8E6";}
          else if($progress==100)  {$outputProgress = "Completed"; $color = "#00CC00";}
      }*/
      
      
  $html .='
      <tr nobr="true">
            <td width="37" align="center">'.$sno.'</td>
            <td width="405">&nbsp;<b>'.$strategy_ref.'.'.$outcome_ref.'.'.$id.'</b>&nbsp;'.$outputTitle.'</td>
            <td width="128" align="right">&nbsp;'.number_format($resource_cost,2).'</td>
            <td width="128" align="right">&nbsp;'.number_format($target,2).'</td>
            <td width="128" align="right">&nbsp;'.number_format($results,2) .'</td>
            <td width="111" align="right">&nbsp;<b>'.number_format($achievements, 1).'%</b></td>
    </tr>';
    
}

foreach($total_output as $key){
    $total_resource_cost = $key->total_resource_cost;
    $total_target = $key->total_target;
    $total_results = $key->total_results;
    if($total_results<=0){ $total_achievements = 0;} else{
      $total_achievements = ($total_results/$total_target)*100;
    }

$html .= '<tr>
          <td colspan ="2" width="442" style="background-color:#FFFF00;"><b>TOTAL</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_resource_cost,2).'</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_target,2).'</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_results,2).'</b></td>
          <td width="111" align="right"><b>'.number_format($total_achievements,2).'%</b></td>
          </tr>';
      }

  $html .="</tbody></table>";

 
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+5, $tableHeading, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+2, $html, 0, 1, 0, true, '', true);

// END OUTPUTS

//TASKS

  $tableHeading  = '
  <table width="100%" >
    <thead>
      <tr align="left">
        <th width="312"></th>
    </tr>
    </thead>';

  $tableHeading .='<tbody>
      <tr nobr="true">
        <td width="312" align="left"><b>TASKS</b></td>
      </tr>
    </tbody>
  </table>';


$html = '
<table border="1px">
<thead>
  <tr align="center">
    <th width="37"><b>S/N</b></th>
    <th width="405"><b>Task Name</b></th>
    <th width="128"><b>Resource Cost</b></th>
    <th width="128"><b>Target</b></th>
    <th width="128"><b>Result</b></th>
    <th width="111"><b>Achievements %</b></th>
  </tr>
 </thead><tbody>';

  foreach($taskList as $row){
    $sno = $row->SNo;
    $id = $rowOutput->id;
    $outcome_ref = $row->outcome_ref;
    $strategy_ref = $row->strategy_ref;
    $output_ref = $row->output_ref;
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
      $target = $row->initial_quantity;
      $results = $row->submitted_quantity;
      $resource_cost = $row->resource_cost;

      if ($results<=0){ $achievements =0;} else{
        $achievements = ($results/$target)*100;
      }
      

      /*$progress = $row->progress;
      
      if($overDue>=0){
          if($progress==100)  { $outputProgress = "Completed"; $color = "#00CC00";} else { $outputProgress = "Overdue ".number_format($progress,1)."%"; $color = "#FF0000"; }
          
      } else { 
          if($progress==0)   {$outputProgress = "Not Started"; $color = "#FFA500";}
          else if($progress>0 && $progress<100) {$outputProgress  = "On Progress ".number_format($progress,1)."%";  $color = "#ADD8E6";}
          else if($progress==100)  {$outputProgress = "Completed"; $color = "#00CC00";}
      }*/
      
      
  $html .='
      <tr nobr="true">
            <td width="37" align="center">'.$sno.'</td>
            <td width="405">&nbsp;<b>'.$strategy_ref.'.'.$outcome_ref.'.'.$output_ref.'.'.$id.'</b>&nbsp;'.$taskTitle.'</td>
            <td width="128" align="right">&nbsp;'.number_format($resource_cost,2).'</td>
            <td width="128" align="right">&nbsp;'.number_format($target,2).'</td>
            <td width="128" align="right">&nbsp;'.number_format($results,2) .'</td>
            <td width="111" align="right">&nbsp;<b>'.number_format($achievements, 1).'%</b></td>
    </tr>';    
}

foreach($total_task as $key){
    $total_resource_cost = $key->total_resource_cost;
    $total_target = $key->total_target;
    $total_results = $key->total_results;
    if($total_results<=0){ $total_achievements = 0;} else{
      $total_achievements = ($total_results/$total_target)*100;
    }

$html .= '<tr>
          <td colspan ="2" width="442" style="background-color:#FFFF00;"><b>TOTAL</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_resource_cost,2).'</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_target,2).'</b></td>
          <td width="128" align="right"><b>&nbsp;'.number_format($total_results,2).'</b></td>
          <td width="111" align="right"><b>'.number_format($total_achievements,2).'%</b></td>
          </tr>';
      }

  $html .="</tbody></table>";

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
      
  $signatory .='<tbody>
      <tr nobr="true">
            <td width="312" align="left"><br><br><br><br>Signatory 2...............................................................</td>
            <td width="312"><br><br><br><br>Signature..............................................</td>
            <td width="312"><br><br><br><br>Date..............................................</td>
      </tr>
    </tbody>
  </table>';


// $txt = <<<EOD
// TCPDF Example 003

// Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
// EOD;

// // print a block of text using Write()
// $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);



 
// Print text using writeHTMLCell()  $pdf->SetXY(86, $pdf->GetY()+25);
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+5, $tableHeading, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+3, $html, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+5, $signatory, 0, 1, 0, true, '', true);
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
 
