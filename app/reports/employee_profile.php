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
$pdf->SetTitle('Employee Profile');
$pdf->SetSubject('Cipay');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data

// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001',
//  PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

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
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('P', 'A4');


foreach ($employee_info as $row) {
    $id = $row->emp_id;
    $emp_name = $row->fname . ' ' . $row->mname . ' ' . $row->lname;
    $gender = $row->gender;
    $birthdate = $row->birthdate;
    $nationality = $row->nationality;
    $email = $row->email;
    $department = $row->department;
    $position = $row->position;
    $branch = $row->branch;
    $line_manager = $row->line_manager;
    $contract = $row->contract;
    $salary = $row->salary;
    $pension = $row->pension;
    $pension_number = $row->pension_number;
    $account_no = $row->account_no;
    $mobile = $row->mobile;
}


$pdf->SetXY(85, 5);

$path = public_path().'/img/logo/logo.png';
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($path, '', '', 30, 25, '', '', 'T', false, 300, '', false, false, '', false, false, false);


$pdf->SetXY(86, $pdf->GetY() + 25); //(+3)
$header = "
<p align='center'><b>Employee Profile</b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);

// SET THE FONT FAMILY
$pdf->SetFont('courier', '', 10, '', true);
// SET THE STYLE FOR DOTTED LINES
$style4 = array('B' => array('width' => 0, 'cap' => 'square', 'join' => 'miter', 'dash' => 3));

$pdf->SetXY(15, $pdf->GetY() - 6); //(+3)
$header = "
<p><b></b></p>";
$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);
$pdf->Rect(16, $pdf->GetY() - 7, 175, 0, '', $style4);  //Dotted LIne


// Employee Info
$pdf->SetXY(0, $pdf->GetY() - 10);
$subtitle1 = "
<p><br>PERSONAL DETAILS:";


$employee_info = '
<table width = "100%">
    <tr align="left">
        <td width="200" align "left"><b>Name:</b></td>
        <td width="300" align "left">' . $emp_name . '</td>
    </tr>
    <tr align="left">
        <td width="200" align "left"><b>Gender:</b></td>
        <td width="300" align "left">' . $gender . '</td>
    </tr>
    <tr align="left">
        <td width="200" align "left"><b>Email:</b></td>
        <td width="300" align "left">' . $email . '</td>
    </tr>
    <tr align="left">
        <td width="200" align "left"><b>Mobile:</b></td>
        <td width="300" align "left">' . $mobile . ' </td>
    </tr>
    <tr align="left">
        <td width="200" align "left"><b>Date of Birth:</b></td>
        <td width="300" align "left">' . $birthdate . '</td>
    </tr>
    <tr align="left">
        <td width="200" align "left"><b>Nationality:</b></td>
        <td width="300" align "left">' . $nationality . '</td>
    </tr>
</table>';
$pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $subtitle1, 0, 1, 0, true, '', true);

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 3, $employee_info, 0, 1, 0, true, '', true);
$pdf->Rect(16, $pdf->GetY() + 2, 175, 0, '', $style4);  //Dotted LIne


//START EARNINGS AND PAYMENTS
$pdf->SetXY(15, $pdf->GetY());
$out = "<p><br>OFFICIAL DETAILS:";
$allowance = '
<table width = "100%">
    <tr align="left">
            <th width="200"><b>Employee ID:</b></th>
            <th width="300">' . $id . '</th>
        </tr>
    <tr align="left">
        <th width="200"><b>Contract:</b></th>
        <th width="300">' . $branch . '</th>
    </tr>
    <tr align="left">
        <th width="200"><b>Basic Salary:</b></th>
        <th width="300">' . number_format($salary, 2) . '</th>
    </tr>
    <tr align="left">
        <th width="200"><b>Account Number:</b></th>
        <th width="300">' . $account_no . '</th>
    </tr>
    <tr align="left">
        <th width="200"><b>Pension:</b></th>
        <th width="300">' . $pension . '</th>
    </tr>
    <tr align="left">
        <th width="200"><b>Pension Number:</b></th>
        <th width="300">' . $pension_number . '</th>
    </tr>
    <tr align="left">
        <th width="200"><b>Department:</b></th>
        <th width="300">' . $department . '</th>
    </tr>
    <tr align="left">
        <th width="200"><b>Position:</b></th>
        <th width="300">' . $position . '</th>
    </tr>
    <tr align="left">
        <th width="200"><b>Branch Office:</b></th>
        <th width="300">' . $branch . '</th>
    </tr>
    <tr align="left">
        <th width="200"><b>Line Manager:</b></th>
        <th width="300">' . $line_manager . '</th>
    </tr>';
$allowance .= '</table>';

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY(), $out, 0, 1, 0, true, '', true);

$pdf->writeHTMLCell(0, 12, '', $pdf->GetY() - 4, $allowance, 0, 1, 0, true, '', true);

$pdf->SetXY(15, $pdf->GetY() + 3);

//END EARNINGS AND PAYMENTS


// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('employee_profile-' . date('d/m/Y') . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

