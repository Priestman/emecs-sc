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
$pdf->SetMargins(15, 2, 15);

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
$pdf->SetFont('times', ' ', 19);

$file = 'author.txt';
$author = file($file);

$file2 = 'paper.txt';
$paper = file($file2);

$file3 = 'type.txt';
$type = file($file3);	

$j = 0;	

for ($i = 0; $i < sizeof ($author); $i++)
{
    
	while ($i < sizeof ($paper))

	{
		while ($j < sizeof ($type))

	{

    

$pdf->AddPage('L', 'A4');

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = 'images/var2_red.jpg';
$pdf->Image($img_file, 0, 0, 290, 210, '', '', '', false, 400, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



$pdf->SetY(86); 

$html = <<<EOM

<div align="center">
<i><b>$author[$i]</b></i>
</div>

EOM;
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->SetY(155); 

$html = <<<EOL
<div align="center">
<i>$paper[$i]</i>
</div>

EOL;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(120, 140); 

$html = <<<EOD

<i>$type[$j]</i>


EOD;
$pdf->writeHTML($html, true, false, true, false, '');

$j++;
$i++;

}
}
}


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('papers.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>