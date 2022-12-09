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
 $CI_Model = get_instance();
  $CI_Model->load->model('performance_model');


 
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
$header =<<<"EOD"
<p align="center"><b>CORPORATE INFORMATION TECHNOLOGY SOLUTIONS (CITS)</b></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);


$pdf->SetXY(124, $pdf->GetY()-7);
$path=FCPATH.'uploads/img/cits.jpg';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 30, 23, '', '', 'T', false, 300, '', false, false, '', false, false, false);

// $totalStrategyProgress = number_format($strategy_progress, 2);
$reportName = strtoupper("PRODUCTIVITY AND PERFORMANCE");
$pdf->SetXY(0, $pdf->GetY()+24);
/*$header =  <<<"EOD"
<p align="center"><b>STRATEGY REPORT</b></p>
EOD;*/
$header =  <<<"EOD"
<p align="center"><b>$reportName</b></p>
EOD;

// $pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 10, 0, '', $header, 0, 1, 0, true, '', true);

$header = "
<p><b>PERIOD: </b> From ".date('F, Y', strtotime($date_from))." To ".date('F, Y', strtotime($date_to))."</p>";
$pdf->writeHTMLCell(0, 12, '', $pdf->GetY()+2, $header, 0, 1, 0, true, '', true);

$pdf->SetXY(20, $pdf->GetY());
$category=5;


/*START ORGANIZATION LEVEL PRODUCTIVITY*/

if(!empty($org_prod) && $organizationReport==1){
$header = "
<p><b>ORGANIZATION LEVEL PRODUCTIVITY: </b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);

foreach ($org_prod as $row) {
  $employment_cost = number_format($row->employment_cost,2);
  $taskCounts = $row->task_counts;
  $allDays = $row->payroll_days;
  $all_employment_cost = $row->employment_cost;
  $empCount = $row->headcounts;

  $daily_cost = $all_employment_cost/$allDays;
  $total_input_cost = $row->duration * $daily_cost;
  $total_output_cost = $row->time_cost;
  $productivity =  $total_output_cost-$total_input_cost;

  $org_prod =  number_format($productivity,2);

  $orgProd_wf_ratio = number_format(($productivity/$row->headcounts),2);
  $org_avgScore = number_format(($row->score/$row->headcounts),1);

  $avgScore = number_format(($row->score/$row->headcounts),1);
  $category_rating = $CI_Model->performance_model->category_rating($avgScore);
  foreach ($category_rating as $value) {
    $category = $value->id;
    $org_rating = $value->title;
  }
}

if ($category==1) $color = "#00CC00";
if ($category==2) $color = "#00CC00";
if ($category==3) $color = "#ADD8E6";
if ($category==4) $color = "#FFA500";
if ($category==5) $color = "#FF0000"; 
 
 $organization_level = 
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
                          <th width="200"><b> Employees Count:</b></th>
                          <td width="700"> '.$empCount.'</td>
                        </tr>
                        <tr align="left">
                          <th width="37" align="center">2</th>
                          <th width="200"><b> Employment Cost:</b></th>
                          <td width="700" align="right"> '.number_format($employment_cost,2).'/= Tsh</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 3</td>
                          <th width="200"><b> Number of Tasks:</b></th>
                          <td width="700"> '.$taskCounts.'</td>
                        </tr>';
  $organization_level .=  '<tr align="left">
                          <td width="37" align="center"> 4</td>
                          <th width="200"><b> Productivity:</b></th>
                          <td width="700" align="right"> '.number_format($org_prod,2).'/= Tsh</td>
                        </tr>';
  $organization_level .=  '<tr align="left">
                          <td width="37" align="center"> 5</td>
                          <th width="200"><b> Productivity  to Workforce Ratio:</b></th>
                          <td width="700" align="right"> '.number_format($orgProd_wf_ratio,2).'/= Tsh</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 6</td>
                          <th width="200"><b> Average Score:</b></th>
                          <td width="700"> '.$org_avgScore.'</td>
                        </tr>
                        <tr align="left">
                          <td width="37" align="center"> 7</td>
                          <th width="200"><b> Performance Rating:</b></th>
                          <td bgcolor="'.$color.'" color="#000000" width="700"> '.$org_rating.'</td>
                        </tr>
                      </tbody>
                    </table>'; 


$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()-4, $organization_level, 0, 1, 0, true, '', true);
}
/*END ORGANIZATION LEVEL*/

/*DEPARTMENT LEVEL*/
if($departmentReport==1){
$pdf->SetXY(20, $pdf->GetY()+8);
$headertable = "
<p><b>DEPARTMENT LEVEL PRODUCTIVITY: </b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);

$html = '
<table border="1px">
<thead>
  <tr align="center">
    <th width="37"><b>S/N</b></th>
    <th width="190"><b>Department Name</b></th>
    <th width="60"><b>Head Counts</b></th>
    <th width="130" ><b>Employment Cost (Tsh)</b></th>
    <th width="80" ><b>Number of Tasks</b></th>
    <th width="110" ><b>Productivity (Tsh)</b></th>
    <th width="130"><b>Productivity to WorkForce Ratio (Tsh)</b></th>
    <th width="50"><b>Avg Score</b></th>
    <th width="150"><b>Avg Performance Rating</b></th>
  </tr></thead>';

  foreach ($dept_prod as $row) {

    $sno = $row->SNo;
    $department = $row->department;
    $employment_cost = number_format($row->employment_cost,2);
    $taskCounts = $row->task_counts;

    $allDays = $row->payroll_days;
    $all_employment_cost = $row->employment_cost;

    $daily_cost = $all_employment_cost/$allDays;
    $total_input_cost = $row->duration * $daily_cost;
    $total_output_cost = $row->time_cost;
    $productivity =  $total_output_cost-$total_input_cost;
    $headCounts = $row->headcounts;

    $dept_productivity = number_format($productivity,2);
    
    
    $dept_wf_ratio = number_format(($productivity/$row->headcounts),2);
    $dept_avgScore = number_format(($row->score/$row->headcounts),1);
    
    $avgScore = number_format(($row->score/$row->headcounts),1);
    $category_rating = $CI_Model->performance_model->category_rating($avgScore);
    foreach ($category_rating as $value) {
      $category = $value->id;
      $rating = $value->title;
    }

    if ($category==1) $color = "#00CC00";
    if ($category==2) $color = "#00CC00";
    if ($category==3) $color = "#ADD8E6";
    if ($category==4) $color = "#FFA500";
    if ($category==5) $color = "#FF0000"; 
      
      
  

  $html .='<tr nobr ="true">
  <tbody>
    <td width="37" align="center">'.$sno.'</td>
    <td width="190">&nbsp;'.$department.'</td>
    <td width="60">&nbsp;'.$headCounts.'</td>
    <td width="130" align="right">&nbsp;'.number_format($employment_cost,2).'</td>
    <td width="80" align="center">&nbsp;'.$taskCounts.'</td>
    <td width="110" align="center">&nbsp;'.number_format($dept_productivity,2).'</td>
    <td width="130" align="right">&nbsp;'.number_format($dept_wf_ratio,2).'</td>
    <td width="50" align="center">&nbsp;'.$dept_avgScore.'</td>
    <td width="150" align="center" bgcolor="'.$color.'" color="#000000">&nbsp;<b>'.$rating.'</b></td>
  </tr></tbody>';
}

  
  $html .="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()-5, $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
}
/*END DEPARTMENT LEVEL PRODUCTIVITY*/



/*INDIVIDUAL LEVEL*/
if($employeeReport==1){
$pdf->SetXY(20, $pdf->GetY()+8);
$headertable = "
<p><b>INDIVIDUAL LEVEL PRODUCTIVITY: </b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);

$html = '
<table border="1px">
<thead>
  <tr align="center">
    <th width="37"><b>S/N</b></th>
    <th width="170"><b>Name</b></th>
    <th width="230" ><b>Position</b></th>
    <th width="80" ><b>Number of Tasks</b></th>
    <th width="110" ><b>Employment Cost</b></th>
    <th width="110"><b>Productivity</b></th>
    <th width="50"><b>Avg Score</b></th>
    <th width="150"><b>Avg Performance Rating</b></th>
  </tr></thead>';

   foreach ($emp_prod as $row) {
      $sno = $row->SNo; 
      $empID = $row->empID; 
      $empName = $row->name; 
      $department =  $row->department;
      $position = $row->position;
      $taskCount = $row->number_of_tasks;
      $scores =  $row->scores;
      $avgScore = number_format($row->scores,1);
      $category_rating = $CI_Model->performance_model->category_rating($avgScore);
      foreach ($category_rating as $value) {
        $category = $value->id;
        $rating = $value->title;
      }

      $employment_cost = number_format($row->employment_cost,2);

       
      $allDays = $row->payroll_days;
      $all_employment_cost = $row->employment_cost;

      $daily_cost = $all_employment_cost/$allDays;
      $total_input_cost = $row->duration_time * $daily_cost;
      $total_output_cost = $row->monetary_value;
      $productivity =  $total_output_cost-$total_input_cost;

      $productivity =  number_format($productivity,2);

    if ($category==1) $color = "#00CC00";
    if ($category==2) $color = "#00CC00";
    if ($category==3) $color = "#ADD8E6";
    if ($category==4) $color = "#FFA500";
    if ($category==5) $color = "#FF0000"; 
      
      
  

  $html .='<tr nobr ="true">
  <tbody>
    <td width="37" align="center">'.$sno.'</td>
    <td width="170">&nbsp;'.$empName.'</td>
    <td width="230" >&nbsp;<b>Department: </b>'.$department.'<br><b>Position: </b>'.$position.'</td>
    <td width="80" align="center">&nbsp;'.$taskCount.'</td>
    <td width="110" align="right">&nbsp;'.number_format($employment_cost,2).'</td>
    <td width="110" align="right">&nbsp;'.number_format($productivity,2).'</td>
    <td width="50" align="center">&nbsp;'.$scores.'</td>
    <td width="150" align="center" bgcolor="'.$color.'" color="#000000">&nbsp;<b>'.$rating.'</b></td>
  </tr></tbody>';
}

  
  $html .="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', $pdf->GetY()-5, $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
}
/*END INDIVIDUAL LEVEL PRODUCTIVITY*/

 

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
// $pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+5, $tableHeading, 0, 1, 0, true, '', true);
// $pdf->writeHTMLCell(0, 0, '', $pdf->GetY()+3, $html, 0, 1, 0, true, '', true);
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
$pdf->Output('productivity_report-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 
