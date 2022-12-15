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
$pdf->SetTitle('Project Time Report');
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



foreach ($info as $row) {
    $logo = $row->logo;
    $companyname = $row->cname;
}

$managed_by = null;
$start_date = null;
$end_date = null;
foreach ($project_info as $row) {
    $managed_by = $row->name;
    $start_date = $row->start_date;
    $end_date = $row->end_date;
}


// define style for border
$style = array('width' => 0.25, 'dash' => 0, 'color' => array(0, 0, 0));

$date = date('F, Y', strtotime(''));
$pdf->SetXY(127, 10);
$path=public_path().'/img/logo/logo.png';

$pdf->Image($path, '', '',  35, 30, '', '', 'T', false, 300, '', false, false, '', false, false, false);

$pdf->SetY($pdf->GetY()+25);
$headertable = <<<"EOD"
<p align="center"><h3>Project summary from $duration</h3></p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);

$date = date('F, Y', strtotime(''));

$pdf->SetXY(20, $pdf->GetY()+2);
$headertable = "<p><b>Managed By: &nbsp;&nbsp;&nbsp;</b>".$managed_by." <br>
<b>Start Date: &nbsp;&nbsp;&nbsp;</b>".$start_date."<br>
<b>End Date: &nbsp;&nbsp;&nbsp;</b>".$end_date."</p> <br>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);


$pdf->SetXY(20, $pdf->GetY()+(-10));

// REPORT HEADER

// Set some content to print
// $pdf->SetXY(15, 85);
$html = '
<table border="1px">
  <tr align="center">
    <th><b>Emp ID</b></th>
    <th><b>Name.</b></th>
    <th><b>Activity</b></th>
    <th><b>Task</b></th>
     <th><b>Time</b></th>
  </tr>';

$total_hour = 0;
$total_min = 0;
foreach($project_time as $key){
    $name = $key->name;
    $emp_id = $key->emp_id;
    $activity = $key->activity;
    $task_name = $key->task_name;
    try {
        $d1 = new DateTime($key->start_date);
        $d2 = new DateTime($key->end_date);
        $diff = $d2->diff($d1);
        $time = $diff->format('%h hour %i min ');
        $time_calculation = $diff->format('%h-%i');
        $total_hour += explode('-',$time_calculation)[0];
        $total_min += explode('-',$time_calculation)[1];
        if ($total_min >= 60){
            $total_hour += 1;
            $total_min = 0;
        }
    } catch (Exception $e) {
        $time = null;
        echo 'error';
    }


    $html .='<tr>
    <td>&nbsp;'.$emp_id.'</td>
    <td>&nbsp;'.$name.'</td>
    <td>&nbsp;'.$activity.'</td>
    <td>&nbsp;'.$task_name.'</td>
    <td align="right">&nbsp;'.$time.'</td>
    </tr>';
}
// money_format('%i', $number)


// setlocale(LC_MONETARY, 'en_US');

$html .="</table><br><br><table border='1px'><tr>
  <td colspan='4'><br><br><b></b><br><br> 
  </td>
  <td></td>
  <td colspan='4'><br><br><br><br></td>
  <td colspan='4'><br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  Total Time Spent</b></td>
  <td align='right' colspan='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$total_hour Hour $total_min Min</td>
  </tr>
</table>";





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
// // MYSQL DATA

// $html .= "<h1>This is a Heading</h1>
// <p>This is a paragraph.</p>

// </body>
// </html>";


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
$pdf->Output('project-time-'.date('d/m/Y').'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

