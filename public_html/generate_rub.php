<?php
//============================================================+
// File name   : generate_rub.php
// Begin       : 2015-13-12
// Last Update : 2015-13-12
//
// Description : invoice for TCPDF class
//               Default Header and Footer
//
// Author: Popova Alice
//
// (c) Copyright:
//               Alice Popova
//               RSHU ELC
//               www.rshu.ru
//               foxy@rshu.ru
//============================================================+


// Include the main TCPDF library (search for installation path).
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //Если не действительны, то закрываем доступ
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Entrance to this page is allowed only for registered users!"); }

$result = mysql_query("SELECT * FROM reg_users WHERE `key`='$login'",$db);
$myrow = mysql_fetch_array($result);

$key = $_SESSION['login'];
$full_name = $myrow['full_name'];
$gild = $myrow['gild'];
$leader_name = $myrow['leader_name'];
$forwarding = $myrow['forwarding'];
$need_visa = $myrow['need_visa'];
$accomp = $myrow['accomp'];
$accomp_all = $accomp*10500;

$now_date = date("d F, Y ");
$date_today = date("m.d.y");

/*Скрипт получения данных из тоталфи*/

// $query=mysql_query("SELECT `key`, COUNT(`key`) AS cnt FROM `reports` GROUP BY `key`",$db);

// while ($row = mysql_fetch_array($query)){
	
// 	if ($row['key']==$_SESSION['login']) {
		
//    "<tr style='background-color:#".($i?"ddedff":"f2f8ff")."'>
//     <td>".$row['cnt']."</td> 
	
//    </tr>"; 
//    $stat = $row['cnt'];
//    $stat1 = $stat-1;
// 	}
// }
$query = mysql_query("SELECT COUNT(1) FROM `reports` WHERE `key`='$key'",$db);
$stat1 = mysql_fetch_array($query);

$stat1 =  $stat1[0]; 
$stat = $stat1 - 1;

if ($stat < 0) {$stat = 0;}

$sum = 75;


$sum = 75*75;
$full_sum = $sum*$stat1-(75*75);
if ($full_sum < 0) 
{
	$full_sum=0;
}
else {
$full_sum = $sum*$stat1-(75*75);}
	
$additional = $stat;
$inv_letter = $forwarding;	
$total_amount = $full_sum;

$visa_service = ($need_visa*1.1)+($forwarding*1.1);
if ($visa_service > 0) {$ok = 1;} 
	

$easybird = 24500;

function calculate_age($birthday) {
  $birthday_timestamp = strtotime($birthday);
  $age = date('Y') - date('Y', $birthday_timestamp);
  if (date('md', $birthday_timestamp) > date('md')) {
    $age--;
  }
  return $age;
}

$vozrast = calculate_age($myrow['birth']);

$sDate1 = "2016-08-22";
$sDate2 = $myrow['birth'];

$day = (strtotime($sDate1) - strtotime($sDate2))/3600/24;

if ($day < '7305') {$reg_easy=0;}

else {

if ($day < '10958') 
{
 $easybird = $easybird-10500;
 $reg_easy = $easybird;
 }
else 
{
	$reg_easy = $easybird;
}
}

$full = $full_sum+$easybird;

$full = $full + $accomp_all;


/*Скрипт получения данных из тоталфи*/

/*Формирование ПДФ*/
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Popova Alice');
$pdf->SetTitle('TCPDF invoice');
$pdf->SetSubject('invoice EUR'); 
$pdf->SetKeywords('TCPDF, PDF, invoice, eur, rshu');

// set default header data
/* $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' EUR', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128)); */

$pdf->setPrintHeader(false); 
$pdf->setPrintFooter(false); 


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
/* $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); */

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
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$pdf->Image('images/tcpdf_logo.jpg', 15, 15, 45, 50, 'JPG', 'http://www.emecs-sc2016.com', '', true, 150, '', false, false, 0, false, false, false);

// Set some content to print

$pdf->SetXY(15, 20); 

$html = <<<EOD

<style>
.hed {
    color: #00008B; /* Цвет символа */
    font-size: 150%; /* Размер шрифта */
	margin-left: 70%;
   }
.tohed{
	color: #104E8B; /* Цвет символа */
    font-size: 100%; /* Размер шрифта */
	margin-left: 70%;
}  
.zag{
	color: #000000; /* Цвет текста */
	font-size: 90%;
} 
p {
    color: #000000; /* Цвет текста */
	font-size: 70%;
   }
	table.text  {
    width:  100%; /* Ширина таблицы */
    border-spacing: 0; /* Расстояние между ячейками */
   }
   table.text td {
	font-size: 70%; 
    width: 50%; /* Ширина ячеек */
    vertical-align: top; /* Выравнивание по верхнему краю */
   }
   td.rightcol { /* Правая ячейка */ 
    text-align: right; /* Выравнивание по правому краю */
   }

   table.fee td {
   font-size: 90%; 
   text-align: center;
   }
   table.fee th {
   font-size: 90%;
   text-align: center; 
   }
   table.fee tr {
   font-size: 90%;
   text-align: left;
 }

</style>

<span class="hed", align="right"><b>EMECS11 – Sea Coasts XXVI<br>Join Conference</b></span><br><br><span class="tohed", align="right"><b>MANAGING RISKS TO COASTAL REGIONS<br>AND COMMUNITIES IN A CHANGING<br>WORLD</b></span><br><br>
<span class="zag", align="center">СЧЕТ ОПЛАТЫ РЕГИСТРАЦИОННОГО ВЗНОСА</span><br><br>
<table class="text">
   <tr>
    <td># EMECS-SC-276</td>
    <td class="rightcol">$now_date</td>
   </tr>
  </table>
<p align="left", face="Arial">Оплата в рублях</p>
<p align="left", face="Arial">Получатель: федеральное государственное бюджетное образовательное учреждение высшего профессионального образования "Российский государственный гидрометеорологический университет" (РГГМУ)<br>
Адрес: 195196 Санкт-Петербург, Малоохтинский пр., 98<br>
Телефон/Факс: 633-01-82<br>
Реквизиты:<br>
ИНН 7806012117 КПП 780601001 Получатель: УФК по г. Санкт-Петербургу (РГГМУ, л/с 20726X76900)<br>
<table border="0", align="left">
<tr><td>Р/с 40501810300002000001</td>
<td>БИК 044030001</td></tr>

<tr><td>ОГРН 1027804199653</td>
<td>ОКПО 02068568</td></tr>

<tr><td>ОКАТО 40278563000</td>
<td>ОКТМО 40350000000</td></tr>

<tr><td>ОКОГУ 1322500</td>
<td>ОКФС 12</td></tr>
</table>
ОКОПФ 75103<br>
Северо-Западное ГУ Банка России <br>
При перечислении безналичных денежных средств обязательно указывать код дохода: КБК 00000000000000000130
</p>
<p align="left">Назначение платежа: $full_name, оплата регистрационного взноса конференции EMECS-SC-2016.</p>
<p align="left">Счет выставлен: $gild </p><br>
<table class="fee" border="1">
    <tr>
    <th width="200">Название</th>
    <th>Стоимость</th>
    <th>Количество</th>
    <th width="100">Сумма</th>
   </tr>
   <tr><td width="200">Регистрационный взнос</td><td>$easybird</td><td>1</td><td width="100">$easybird</td></tr>
   <tr><td width="200">Дополнительные статьи</td><td >$sum</td><td>$stat</td><td width="100">$full_sum</td></tr>
   <tr><td width="200">Сопровождающие</td><td >10500</td><td>$accomp</td><td width="100">$accomp_all</td></tr>
   <tr><td width="200">ИТОГО</td><td></td><td></td><td>$full</td></tr>
  </table><br><br>
<table class="text">
<br><br>
   <tr>
    <td>Проректор РГГМУ</td>
    <td class="rightcol">Крылов А.Г.</td>
   </tr>
<br><br>
   <tr>
    <td>Главный бухгалтер</td>
    <td class="rightcol">Шумакова И.Б.</td>
   </tr>
  </table>
EOD;


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('invoiceRUB.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+