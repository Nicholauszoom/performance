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
$pdf->SetTitle('NHIF Report');
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
foreach($info as $key){
    $name = $key->cname;
    // $tin = $key->tin;
    // $postal_address = $key->postal_address;
    // $postal_city = $key->postal_city;
    // $phone_no1 = $key->phone_no1;
    // $phone_no2 = $key->phone_no2;
    // $phone_no3 = $key->phone_no3;
    // $fax_no = $key->fax_no;
    // $email = $key->email;
    // $plot_no = $key->plot_no;
    // $block_no = $key->block_no;
    // $branch = $key->branch;
    // $street = $key->street;
    // $heslbcode = $key->heslb_code_no;
     
}




// foreach ($total as $row) {
//    $total_salary=$row->TOTAL_SALARY;
//    $total_amount1=$row->TOTAL_AMOUNT1;
//    $total_amount2=$row->TOTAL_AMOUNT2;
//    $overall_contribution=$row->OVERALL_CONTRIBUTION;
//   }



$pdf->SetXY(100, 10);
$headertable = "
<p align='center'><h1>NHIF EMPLOYEES CONTRIBUTION</h1></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);

$pdf->SetXY(30, 35);
$headertable = "
<p><b>CONTRIBUTION FOR THE MONTH OF:<br><br>Name of Employer: &nbsp;&nbsp;&nbsp;&nbsp;</b>".strtoupper($name)."<br></p>";
$pdf->writeHTMLCell(0, 12, '', '', $headertable, 0, 1, 0, true, '', true);
 

 
// Set some content to print
// $pdf->SetXY(15, 85);
$html = '
<table border="1px">
  <tr align="center">
    <th width="37"><b>S/N</b></th>
    <th width="130"><b>Membership No.</b></th>
    <th width="130"><b>PF Number</b></th>
    <th width="100"><b>Check No.</b></th>
    <th><b>First Name</b></th>
    <th><b>Middle Name</b></th>
    <th><b>Last Name</b></th>
    <th><b>Basic Salary</b></th>
    <th width="150"><b>Amount Contributed</b></th>
  </tr>';

  foreach($nhif as $key){
              $membership_no = $key->nhif_membership_no;
              $pension_no = "N/A";
              $check_no = "N/A";
              $fname = $key->fname;
              $mname = $key->mname;
              $lname = $key->lname;
              $salary = $key->salary;
              $amount_contribution = ($key->medical_employee+$key->medical_employer);
  

  $html .='<tr>
    <td align="center">'.$key->SNo.'</td>
    <td>&nbsp;'.$membership_no.'</td>
    <td >&nbsp;'.$pension_no.'</td>
    <td>&nbsp;'.$check_no.'</td>
    <td>&nbsp;'.$fname.'</td>
    <td>&nbsp;'.$mname.'</td>
    <td>&nbsp;'.$lname.'</td>
    <td align="right">&nbsp;'.number_format($salary,2).'</td>
    <td align="right">&nbsp;'.number_format($amount_contribution,2).'</td>
  </tr>';
}
// money_format('%i', $number)
 

  // setlocale(LC_MONETARY, 'en_US');

  $html .="</table><br><table border='1px'><tr>
  <td colspan='4'><br><br><b>Confirmation</b><br><br>Employer's Signature............................................... 
  </td>
  <td></td>
  <td colspan='4'><br><br><br><br>Date: .....................................</td>
  </tr>
</table>";





// MYSQL DATA
// $html = '<table align="center" border="1px">';
// $html .= '<tr> <th ><b>ID</b></th>
//        <th ><b>Name</b></th>
//          <th ><b>Relationship</b></th>
//          <th ><b>Excessp</b></th>
//          </tr>';

//  foreach($taxable->result() as $key){
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
$pdf->Output('nhif-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+
 