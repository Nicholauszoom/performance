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
$pdf->SetTitle('P9-'.date('d/m/Y'));
$pdf->SetSubject('PAYE');
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

// TIN NUMBER

foreach($info as $key){
		$name = $key->cname;
		$tin = $key->tin;
		$postal_address = $key->postal_address;
		$postal_city = $key->postal_city;
		$phone_no1 = $key->phone_no1;
		$phone_no2 = $key->phone_no2;
		$phone_no3 = $key->phone_no3;
		$fax_no = $key->fax_no;
		$email = $key->email;
		$plot_no = $key->plot_no;
		$block_no = $key->block_no;
		$branch = $key->branch;
		$street = $key->street;
		 
}


// This method has several options, check the source code documentation for more information.
// $pdf->AddPage();
$pdf->AddPage('L', 'A4');
// $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');


$pdf->SetXY(0, 18);
$header1 = <<<"EOD"
<p align="center">HESLB LOAN REPAYMENT SCHEDULE<br>(To be submitted duly completed with every payment to HESLB)</p>
EOD;
$pdf->writeHTMLCell(0, 12, '', '', $header1, 0, 1, 0, true, '', true);


// EMPLOYER
foreach($info as $key){
		$name = $key->cname;
		$tin = $key->tin;
		$postal_address = $key->postal_address;
		$postal_city = $key->postal_city;
		$phone_no1 = $key->phone_no1;
		$phone_no2 = $key->phone_no2;
		$phone_no3 = $key->phone_no3;
		$fax_no = $key->fax_no;
		$email = $key->email;
		$plot_no = $key->plot_no;
		$block_no = $key->block_no;
		$branch = $key->branch;
		$street = $key->street;
		$heslbcode = $key->heslb_code_no;
		 
}
$payrollmonth = date('F, Y', strtotime($payrolldate));




$pdf->SetFont('times', '', 10, '', true);
$pdf->SetXY(40, 34);
$header = "<p><b>NAME OF EMPLOYER:&nbsp;&nbsp;</b>  ".strtoupper($name)."<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>POSTAL ADDRESS:&nbsp;&nbsp;&nbsp;</b>".$postal_address."<br><br><br>";

$pdf->writeHTMLCell(0, 12, '', '', $header, 0, 1, 0, true, '', true);



$pdf->SetXY(55, 54);
$htm = "<p><b>TELEPHONE:&nbsp;&nbsp;&nbsp;</b>".$phone_no1."<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>EMAIL:&nbsp;&nbsp;&nbsp;</b>".$email."</p>";
$pdf->writeHTMLCell(0, 12, '', '', $htm, 0, 1, 0, true, '', true);


$pdf->SetXY(190, 34);
$header2 = "<p><b>EMPLOYER HESLB CODE NO:&nbsp;&nbsp;</b>&nbsp;&nbsp;&nbsp;".$heslbcode."<br><br><br><br>
			<b>PAYROLL MONTH:&nbsp;&nbsp;</b>".$payrollmonth;
$pdf->writeHTMLCell(0, 12, '', '', $header2, 0, 1, 0, true, '', true);


 
$pdf->SetFont('times', '', 12, '', true);
// Set some content to print
$pdf->SetXY(38, 30);

$html = '<table align="center" border="1px">';

$html .='<tr> 
				<th colspan="5"><br><br><br><br><br><br><br><br></th>
		</tr>';

$html .='<tr>
				<th width = "40px" >S/NO</th>
				<th>INDEX NUMBER</th>
				<th >PF/CHECK NO</th>
				<th width = "200px">NAME OF LOANEE</th>
				<th width = "160px">AMOUNT DEDUCTED</th>
				<th >OUTSNDING BALANCE</th>
		</tr>';


// MYSQL DATA


	foreach($heslb as $key){
		$index = $key->form_four_index_no;
		$pf = "N/A";
		$name = $key->name;
		$amountdeducted= $key->paid;
		$out = $key->remained;

$html .= '<tr>
          <td width= "40px">'.$key->SNo.'</td>
          <td >'.$index.'</td>
          <td >'.$pf.'</td>
          <td width = "200px">'.$name.'</td>
          <td width = "160px" align="right">'.number_format($amountdeducted,2).'</td>
          <td align="right">'.number_format($out,2).'</td>
       </tr>';
}



foreach($total as $key){
		$sum1 = $key->total_paid;
		$sum2 = $key->total_remained;
	}
$html .= "<tr>
		  <td></td>
          <td >TOTAL DEDUCTIONS</td>
          <td></td>
          <td></td>
          <td align='right'>".number_format($sum1,2)."</td>
          <td align='right'>".number_format($sum2,2)."</td>
          </tr>";
      


$html .= '</table>
			<table border="1px">
			<tr>
			<td><br><br><br>Paid by Cheque Number................................................................
			Dated:...........................................
			Paid in by:................................................<br><br>
			HESLB Receipt No. Issued: ..........................................................
			Date of Receipt.................................
			Receipted By.......................................</td>
			</tr>
			</table>';
// MYSQL DATA
 
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 
// ---------------------------------------------------------
 
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('heslb-'.date('d/m/Y').'.pdf', 'I');
 
//============================================================+
// END OF FILE
//============================================================+