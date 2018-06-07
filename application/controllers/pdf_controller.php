<?php
/**
* 
*/
class pdf_controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('pdf');
$pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	}

	public function index()
	{
		//­=====================­====================­===================+
		// File name : example_021.php
		// Begin : 2008-03-04
		// Last Update : 2013-05-14
		//
		// Description : Example 021 for TCPDF class
		// WriteHTML text flow
		//
		// Author: Convenio Sena - Universidad Simón Bolívar
		//
		// (c) Copyright:
		// Convenio Sena - Universidad Simón Bolívar
		// Tecnick.com LTD
		// www.tecnick.com
		// info@tecnick.com
		//­=====================­====================­===================+

		/**
		* Creates an example PDF TEST document using TCPDF
		* @package com.tecnick.tcpdf
		* @abstract TCPDF - Example: WriteHTML text flow.
		* @author Convenio Sena - Universidad Simón Bolívar
		* @since 2008-03-04
		*/

		// Include the main TCPDF library (search for installation path).
		$this->load->library('pdf');

		// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Convenio Sena - Universidad Simón Bolívar');
$pdf->SetTitle('REPORTES 001');
$pdf->SetSubject('Resportes de Inasistencias');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128)); $pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN)); $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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

//­ -----------------------­--------------------­--------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information. $pdf->AddPage();
// add a page
$pdf->AddPage();

// create some HTML content
$html = 'hola';

// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

// reset pointer to the last page
$pdf->lastPage();

//­ -----------------------­--------------------­--------------

//Close and output PDF document
$pdf->Output('example_021.pdf', 'I');

//­=====================­====================­===================+
// END OF FILE
//­=====================­====================­===================+

	}
}
