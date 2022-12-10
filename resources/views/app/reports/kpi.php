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
$pdf->SetTitle('KPI-'.date('d/m/Y'));
$pdf->SetSubject('KPI');
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


// This method has several options, check the source code documentation for more information.
// $pdf->AddPage();
$pdf->AddPage('L', 'A4');
// $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');


  ////$CI_Model = get_instance();
  //$CI_Model->load->model('flexperformance_model');
  $employeeID = $empID;
  
  $duration = $CI_Model->reports_model->taskDuration($employeeID);
  $averagePerformance = $CI_Model->reports_model->averageTaskPerformance($employeeID);
  $averageQuantityBehaviourPerformance = $CI_Model->reports_model->averageQuantityBehaviour($employeeID);
  if($averagePerformance=='') $averagePerformance = 0;
  foreach($duration as $durationRow){
		$started = $durationRow->started;
		$updated = $durationRow->updated;
  }
  foreach($averageQuantityBehaviourPerformance as $qbratio){
    $average_behaviour = $qbratio->average_behaviour;
    $average_quantity = $qbratio->average_quantity;
  }
  
  $rating = "Very Strong";
  
  foreach($empInfo as $employee){
// 		$empID = $employee->id;
		$leader = $employee->leader;
		$name = $employee->empName;
		$department = $employee->department;
  }
  

if($averagePerformance>=0 && $averagePerformance<60) {
    $rating = "Improvement Needed";
    }elseif($averagePerformance>=60 && $averagePerformance<75){
        $rating = "Good";
    }elseif($averagePerformance>=75 && $averagePerformance<85){
        $rating = "Strong";
    }elseif($averagePerformance>=85 && $averagePerformance<95){
        $rating = "Very Strong";
    }elseif($averagePerformance>=95){
        $rating = "Outstanding";
    }


$pdf->SetXY(0, 18);
$header1 = <<<"EOD"
<p align="center"><b>CORPORATE INFORMATION TECHNOLOGY SOLUTIONS (CITS)</b><br>EMPLOYEE KEY PERFORMANCE INDICATOR (KPI) PLAN</p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $header1, 0, 1, 0, true, '', true);




$pdf->SetFont('times', '', 10, '', true);


$employee_info = '
<table width = "100%" border="1px">';

$employee_info .='<tr style="background-color:#000080; color:#FFFFFF;" > 
				<th colspan="2">Employee Basic Details</th>
		</tr>';

$employee_info .='<tr align="left">
        <th width="300"><b>Name: &nbsp;&nbsp; '.$name.'</b></th>
        <th width="300"><b>Employee ID: &nbsp;&nbsp;'.$employeeID.'</b></th>
        <th width="340"><b>Department:&nbsp;&nbsp;'.$department.'</b></th>
    </tr>
    <tr align="left">
        <th width="300"><b>Team Leader`s Name:</b></th>
        <th width="300"><b>Date Started:&nbsp;&nbsp;'.date('d/m/Y', strtotime($started)).'</b></th>
        <th width="340"><b>Date Updated:&nbsp;&nbsp;'.date('d/m/Y', strtotime($updated)).'</b></th>
    </tr>
</table>';
// $pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle1, 0, 1, 0, true, '', true);


 
$pdf->SetFont('times', '', 12, '', true);
// Set some content to print
// $pdf->SetXY(38, 30);

$html = '<table  width = "100%" border="1px">';

/*$html .='<tr> 
				<th colspan="7" style="background-color:#000080; color:#FFFFFF;">Strategy 18</th>
		</tr>';*/

$html .='<thead><tr align="center">
				<th width="496" style="background-color:#000080; color:#FFFFFF;" align="left">Specific priorities / objectives for the year</th>
				<th width="90" rowspan="2" >Target</th>
				<th width="60" rowspan="2" >Target Unit Measure</th>
				<th width="40" rowspan="2">Start Date</th>
				<th width="40" rowspan="2">End Date</th>
				<th width="80" rowspan="2">Completion Date</th>
				<th width="80" rowspan="2">Status</th>
				<th width="54" rowspan="2">Progress</th>
		</tr>
		<tr align="center">
				<th  > </th>
		</tr></thead>';
		
		// STRATEGIES
foreach($strategies as $row){
		$id = $row->id;
		$name = $row->name;
		
// <b>SO'.$id.': '.$name.'</b></td>		
$html .='<tr> 
				<td colspan="8" >';
				$html .= '<table  width = "100%" border="1px"> ';

                $html .='<tr align="left">
                				<td colspan="8"><b>SO'.$id.': '.$name.'</b></td>
                		</tr>';
				


                $tasks = $CI_Model->reports_model->strategicTasks($id, $employeeID);
                foreach($tasks as $key){
                    $taskID = $key->id;
                    $strategyID = $id;
                    $taskname = $key->title;
                    $outputID = $key->output_ref;
                    $outcomeID =  $key->outcome_ref;
                    $target = $key->initial_quantity;
                    $target_type =  $key->quantity_type;
                    $status =  $key->status;
                    $progress =  $key->progress;
                    if($target_type==1) {$type ="Tsh";} elseif($target_type==2) {$type = "Number";}
                    
                    $start = $key->start;
                    $finish = $key->end;
                    
                    if($status==2) {
                        $submission_date =  date('d/m/Y', strtotime($key->date_completed));
                        $statusTag = "Completed"; 
                    } else{
                        $submission_date = ";
                        
                        if($finish > date('Y-m-d')){
                            if($progress==0){ $statusTag = "Not Started"; 
                            } elseif($progress>0){ $statusTag ="On Progress";}  

                        } elseif($finish <= date('Y-m-d')){
                            $statusTag ="OverDue";
                        }
                    }
                    

                    
                $html .= '<tbody>
                <tr nobr="true" align="center">
                      <td width="496" align="left" >'.$strategyID.'.'.$outcomeID.'.'.$outputID.'.'.$taskID.': '.$taskname.'</td>
                      <td width="90">'.number_format($target, 0).'</td>
                      <td width="60" >'.$type.'</td>
                      <td width="40">'.$start.'</td>
                      <td width="40" >'.$finish.'</td>
                      <td width="80">'.$submission_date.'</td>
                      <td width="80">'.$statusTag .'</td>
                      <td width="54">'.$progress.'%</td>
                   </tr>';
                }
                if(empty($adhocs)){
                    
                    $html .='<tr align="left">
                    				<td colspan="8"><b>No Adhoc Activities</b></td>
                    		</tr>';
                } else {
                $html .='<tr align="left">
                				<td colspan="8"><b>Adhoc Activities</b></td>
                		</tr>';
                }
                
                foreach($adhocs as $key){
                    $sno = $key->sNo;
                    $strategyID = $id;
                    $taskname = $key->title;
                    
                    $target = $key->initial_quantity;
                    $target_type =  $key->quantity_type;
                    $status =  $key->status;
                    $progress =  $key->progress;
                    if($target_type==1) {$type ="Tsh";} elseif($target_type==2) {$type = "Number";}
                    
                    $start = $key->start;
                    $finish = $key->end;
                    
                    if($status==2) {
                        $submission_date =  date('d/m/Y', strtotime($key->date_completed));
                        $statusTag = "Completed"; 
                    } else{
                        $submission_date = ";
                        
                        if($finish > date('Y-m-d')){
                            if($progress==0){ $statusTag = "Not Started"; 
                            } elseif($progress>0){ $statusTag ="On Progress";}  

                        } elseif($finish <= date('Y-m-d')){
                            $statusTag ="OverDue";
                        }
                    }
                    

                
                $html .= '<tbody>
                <tr nobr="true" align="center">
                      <td width="496" align="left" >'.$sno.': '.$taskname.'</td>
                      <td width="90">'.number_format($target, 0).'</td>
                      <td width="60" >'.$type.'</td>
                      <td width="40">'.date('d/m/Y', strtotime($start)).'</td>
                      <td width="40" >'.date('d/m/Y', strtotime($finish)).'</td>
                      <td width="80">'.$submission_date.'</td>
                      <td width="80">'.$statusTag .'</td>
                      <td width="54">'.$progress.'%</td>
                   <tbody></tr>';
                }
                $html .= '</table>';
				
$html .='</td></tr>';
		 
}



// }

$html .= '</table>
<table width = "100%" border="1px">
<tbody>';

$html .='<tr style="background-color:#000080; color:#FFFFFF;" > 
				<th colspan="1">Comments to support PM rating, training and career development</th>
		</tr>';

$html .='<tr  nobr="true"  align="left">
        <th width="470" rowspan="2"><b>Training and Career development Comments by Team Leader:</b><br><br></th>
        <th width="470"><b>&nbsp;&nbsp;Performance and Rating:&nbsp;&nbsp;&nbsp;</b>'.number_format($averagePerformance,2).'%&nbsp;('.number_format($average_quantity,2).':'.$average_behaviour.')&nbsp;&nbsp;'.$rating.'<br>
        <b>Generated On: </b>&nbsp;&nbsp; '.date('d/m/Y').' at '.date("h:i:sa").'</th>
    </tr>
    
    <tr  nobr="true"  align="left">
        <th width="470"><b>Sign for Year-end:</b><br>&nbsp;&nbsp;Employee Signature.................<br>&nbsp;&nbsp;Team Leader`s Signature.................<br></th>
    </tr>
    
    <tr  nobr="true" align="left">
        <th width="470"><b>Team Leader’s comments:</b><br><br><br></th>
        <th width="470"><b>Employee’s  comments:</b></th>
    </tr></tbody>
</table>';
// MYSQL DATA
 
// Print text using writeHTMLCell()

$pdf->writeHTMLCell(0, 12, '',$pdf->GetY()+2, $employee_info, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+4, $html, 0, 1, 0, true, '', true);
 
// ---------------------------------------------------------
 
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('employee KPI-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+