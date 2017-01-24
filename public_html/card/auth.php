<?php
//============================================================+
// File name   : card.php
// Begin       : 2016-08-07
// 
//
// Description : card for TCPDF class
//               Default Header and Footer
//
// Author: Popova Alice
//
// (c) Copyright:
//               Alice Popova
//               RSHU
//               www.rshu.ru
//               foxy@rshu.ru
//============================================================+


// Include the main TCPDF library (search for installation path).

/*Формирование ПДФ*/
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 028');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(20, 2, 17);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 2);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}



// ---------------------------------------------------------



$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

// set font
$pdf->SetFont('times', '', 14);

$file = 'author.txt';
$author = file($file);

$file2 = 'paper.txt';
$paper = file($file2);
		
		$j = 1;
		while ($j <= sizeof ($author))
		{

for ($i = 0; $i < sizeof ($author); $i++)
{
    
	while ($i < sizeof ($paper))

	{

	
	

$pdf->AddPage('P', 'A4');

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = 'images/0001.jpg';
$pdf->Image($img_file, 0, 0, 210, 280, '', '', '', false, 400, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

$pdf->SetXY(108, 30.5); 

$html = <<<EOD

$j

EOD;

//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(108, 53); 

$html = <<<EOL

$j

EOL;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(80, 107); 

$html = <<<EOM

<i>$author[$i]</i>

EOM;
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->SetXY(25, 203); 

$html = <<<EOM

<i>$paper[$i]</i>

EOM;
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->AddPage('P', 'A4');
$img_file = 'images/0002.jpg';
$pdf->Image($img_file, 0, 0, 210, 280, '', '', '', false, 400, '', false, false, 0);

$pdf->AddPage('P', 'A4');
$img_file = 'images/0003.jpg';
$pdf->Image($img_file, 0, 0, 210, 280, '', '', '', false, 400, '', false, false, 0);

$pdf->AddPage('P', 'A4');
$img_file = 'images/0004.jpg';
$pdf->Image($img_file, 0, 0, 210, 280, '', '', '', false, 400, '', false, false, 0);

$pdf->SetXY(140, 215); 

$html = <<<EOM

<i>$author[$i]</i>

EOM;
$pdf->writeHTML($html, true, false, true, false, '');

$j++;
$i++;


}

}

}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('auth.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>