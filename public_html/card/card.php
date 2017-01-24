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
$pdf->SetMargins(10, 10, 10);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

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
$pdf->SetFont('times', '', 22);

$file = 'name.txt';
$name = file($file);

$file2 = 'org.txt';
$country = file($file2);




for ($i = 0; $i < sizeof ($name); $i++)
{
    
	while ($i < sizeof ($country))

{
	

$pdf->AddPage('L', 'CARD_UPD');

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = 'images/business_card.jpg';
$pdf->Image($img_file, 0, 0, 100, 72, '', '', '', false, 400, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

$pdf->SetXY(10, 30); 

$html = <<<EOD

<style type="text/css">
 .block { 
 	font-size: 20px;
   }
</style>

<div align="center">
$name[$i]<br>
<i class="block">$country[$i]</i>
</div>

EOD;

//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->writeHTML($html, true, false, true, false, '');
$i++;
}

}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('cards.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>