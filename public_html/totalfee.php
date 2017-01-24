<?php
// âñ¤ ïðîöåäóðà ðàáîòàåò íà ñåññè¤õ. »ìåííî â íåé õðàí¤òñ¤ äàííûå ïîëüçîâàòåë¤, ïîêà îí íàõîäèòñ¤ íà ñàéòå. ÷åíü âàæíî çàïóñòèòü èõ â ñàìîì íà÷àëå ñòðàíè÷êè!!!
session_start();

include ("bd.php");// ôàéë bd.php äîëæåí áûòü â òîé æå ïàïêå, ÷òî è âñå îñòàëüíûå, åñëè ýòî íå òàê, òî ïðîñòî èçìåíèòå ïóòü 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//åñëè ñóùåñòâóåò ëîãèí è ïàðîëü â ñåññè¤õ, òî ïðîâåð¤åì, äåéñòâèòåëüíû ëè îíè
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT * FROM `users` WHERE `login`='$login' AND `password`='$password' AND `activation`='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //åñëè äàííûå ïîëüçîâàòåë¤ íå âåðíû
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//¾ðîâåð¤åì, çàðåãèñòðèðîâàí ëè âîøåäøèé
exit("Entrance to this page is allowed only for registered users!"); }
?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/jquery.easydropdown.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/css/easydropdown.css"/>
<center>
<title>Total registration fee</title>

<style>


.modalDialog {
  position: fixed;
  font-family: Arial, Helvetica, sans-serif;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0,0,0,0.8);
  z-index: 99999;
  -webkit-transition: opacity 400ms ease-in;
  -moz-transition: opacity 400ms ease-in;
  transition: opacity 400ms ease-in;
  display: none;
  pointer-events: none;
  overflow: auto;
}

.modalDialog:target {
  display: block;
  pointer-events: auto;
}

.modalDialog > div {
  width: 670px;
  position: relative;
  margin: 10% auto;
  padding: 5px 20px 13px 20px;
  border-radius: 10px;
  background: #fff;
  background: -moz-linear-gradient(#fff, #999);
  background: -webkit-linear-gradient(#fff, #999);
  background: -o-linear-gradient(#fff, #999);
}

.close {
  background: #606061;
  color: #FFFFFF;
  line-height: 25px;
  position: absolute;
  right: -12px;
  text-align: center;
  top: -10px;
  width: 24px;
  text-decoration: none;
  font-weight: bold;
  -webkit-border-radius: 12px;
  -moz-border-radius: 12px;
  border-radius: 12px;
  -moz-box-shadow: 1px 1px 3px #000;
  -webkit-box-shadow: 1px 1px 3px #000;
  box-shadow: 1px 1px 3px #000;
}

.close:hover { background: #00d9ff; }



.modalDialog2 {
  position: fixed;
  font-family: Arial, Helvetica, sans-serif;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0,0,0,0.8);
  z-index: 99999;
  -webkit-transition: opacity 400ms ease-in;
  -moz-transition: opacity 400ms ease-in;
  transition: opacity 400ms ease-in;
  display: none;
  pointer-events: none;
  overflow: auto;
}

.modalDialog2:target {
  display: block;
  pointer-events: auto;
}

.modalDialog2 > div {
  width: 500px;
  position: relative;
  margin: 10% auto;
  padding: 5px 20px 13px 20px;
  border-radius: 10px;
  background: #fff;
  background: -moz-linear-gradient(#fff, #999);
  background: -webkit-linear-gradient(#fff, #999);
  background: -o-linear-gradient(#fff, #999);
}

.close {
  background: #606061;
  color: #FFFFFF;
  line-height: 25px;
  position: absolute;
  right: -12px;
  text-align: center;
  top: -10px;
  width: 24px;
  text-decoration: none;
  font-weight: bold;
  -webkit-border-radius: 12px;
  -moz-border-radius: 12px;
  border-radius: 12px;
  -moz-box-shadow: 1px 1px 3px #000;
  -webkit-box-shadow: 1px 1px 3px #000;
  box-shadow: 1px 1px 3px #000;
}

.close:hover { background: #00d9ff; }

</style>
</head>
<body>
<h2>Total registration fee</h2>

<header id="header">
<nav id="nav">
<?php
//âûâîäèì ìåíþ
print <<<HERE
<ul>
<li><a href='info.php?id=$_SESSION[id]'>Information</a></li>
<li><a href='all.php'>Registered participants</a></li>
<li><a href='index.php'>Abstract and paper submission</a></li>
<li><a href='vib_soavt.php'>Coauthors list</a></li>
<li><a href='visasup.php'>Visa information</a></li>
<li><a href='all_users.php'>Visa support list</a></li>
<li><a href='totalfee.php'>Total registration fee</a></li>
<li><a href='exit.php'>Exit</a></li>
</ul>
HERE;
?>
 </nav>
 </header>

<?php
print <<<HERE
You are logged in as $_SESSION[login]<br><br>
HERE;
?>
</center>
<div class="boxtotal">
<?php
$result = mysql_query("SELECT * FROM `reg_users` WHERE `key`='$login'",$db);
$myrow = mysql_fetch_array($result);

$result3 = mysql_query("SELECT `full_name_usr` FROM `add_visasup` WHERE `key`='$login'",$db);
$myrow3 = mysql_fetch_array($result3);




$key = $_SESSION['login'];
$need_visa = $myrow['need_visa'];
$birth = $myrow['birth'];
$letter = $myrow['letter'];
$forwarding = $myrow['forwarding'];
$leader_name = $myrow['leader_name'];
$accomp = $myrow['accomp'];
$full_name_usr = $myrow3['full_name_usr'];

?>

<?php



if ($myrow2['det'] == '1') {echo "<b><center> Scan-copy of payment confirmation uploaded. </b></center><br>";}

if (isset($myrow['birth'])) {

if (($myrow['birth']) != '0000-00-00') {

// $query = mysql_query("SELECT `key`, COUNT(`key`) AS `cnt` FROM `reports` GROUP BY `key`",$db);
 
 
// /* echo "<caption style='font-size:13px; background:#FFFFCC;'>Your addition article: </caption>"; */
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

$sum = 75;
$full_sum = $sum*$stat1-75;
if ($full_sum < 0) 
{
	$full_sum=0;
}
else { 
$full_sum = $sum*$stat1-75;}

if ($stat < 0) {$stat = 0;}
printf("Your article: ");printf($stat1);printf("<br>");
printf("Your additional article: ");printf($stat);printf("<br>");
printf("Total amount: ");printf($full_sum); printf("<br>");
printf("Payment for sending the original visa invitation letter: ");printf($forwarding);printf("<br>");
printf("Visa service of International Department of RSHU: ");printf($need_visa);printf("<br>");

if ($need_visa == 10) {
print <<<HERE
<br>
<form action='update_anketa.php' method='POST'>
  <input name='need_visa' type='checkbox' value = '25'>If you need payment of service migration and taxes, check this box and click apply (25 EUR)<br>
  <input type = 'submit' value = 'Apply'>
</form>

HERE;
}


$easybird = 350;

/* printf("'Early bird' registration fee for you(payment before March 15, 2016) is:");printf("<br>"); */

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



/* $sDate3 = date("Y-m-d");
$sDate4 = $myrow['birth'];

echo (strtotime($sDate1) - strtotime($sDate2))/3600/24;
printf("<br>");
echo (strtotime($sDate3) - strtotime($sDate4))/3600/24; */

$day = (strtotime($sDate1) - strtotime($sDate2))/3600/24;

if ($day < '7305') {printf("Your registration fee: 0 ");}

else {

if ($day < '10958') 
{
 $easybird = $easybird-150;
 printf("Your registration fee: ");printf($easybird);
 }
else 
{
printf("Your registration fee: ");printf($easybird);
}
}

printf("<br>");printf("<br>");
$full = $full_sum+$forwarding+$need_visa+$easybird;
printf("In total: ");printf($full);printf(" EUR");


print <<<HERE
<br><br>
<form action='accomp.php' method='post'>
Add accompanying participants: <br>
(Specify the number of accompanying participants)<br>
<input name='accomp' type='int' >
<input type='submit' name='submit' value='Save'>
</form>

HERE;
$accopm_all = 150*$accomp;
$full = $full + 150*$accomp;
printf("Accompanying participants: ");printf($accomp);printf("<br>");
printf("<b>In total with accompanying participants: ");printf($full);printf(" EUR");printf("</b>");
printf("<br>");
printf("Visa information for accompanying participants: ");

do
{

$full_name_usr = $myrow3['full_name_usr'];
$full_name_usr = htmlspecialchars($full_name_usr);
//выводим их в цикле
printf("<b>");
printf($full_name_usr); printf("; ");
}
while($myrow3 = mysql_fetch_array($result3));

printf("</b>");


if ($accomp != 0) {
print <<<HERE
<br>
<a href="#openModal">If necessary, fill in the visa information about their.</a>
<div id="openModal" class="modalDialog">
      <div>
        <a href="#close" title="Close" class="close">X</a>

        <h4>Visa information for accompanying participants</h4>
        <h5 style='color: red;'>Attention! Carefully check the data. Data can be edited only when referring to the Program Committee or technical support.</h5>
          <form action='add_visasup.php' method='post' enctype='multipart/form-data'>

          Full name(Surname, Given names): <br>
          <input name='full_name_usr' type='text' ><br>

          Passport number: <br>
          <input name='passport_id' type='text' ><br>

          Expiry date: (yyyy-mm-dd)<br>
          <input name='valid_to' type='date' ><br><br>

          City where you will apply for visa: <br>
          (If needed, fill in this field. Otherwise, leave this field blank. By default will copy the data for the main participant)<br>
          <input name='located' type='text' ><br>

          Postal address where the original invitation must be sent:<br>
          (If needed, fill in this field. Otherwise, leave this field blank. By default will copy the data for the main participant)<br>
          <input name='zip_addr' type='text' ><br>

          Scan-copy of the passport.  <br>
          The image format must be jpg, gif or png.<br>
          <input type="FILE" name="fupload"><br><br>

          <input type="checkbox" name="visasup" value='25'>If you need payment of service migration and taxes, check this box.

          <br><br>


          <input type='submit' name='submit' value='Save'>
          </form>
      </div>
</div>

<div id="openModal2" class="modalDialog2">
      <div>
        <a href="#close" title="Close" class="close">X</a>

        <h4 style='color:green;'>Data successfully added!</h4>
        <h5><a href='totalfee.php#openModal'>Add more</a> <br></h5>
          </form>
      </div>
</div>

HERE;
}

print <<<HERE
<br><br>
<b>Sample receipt of payment in RUB you can download <a href="files/org_vznos_cpb.doc">here (format .doc)</a></b><br><br>
<form action="generate_inv.php" metod="post">
   <input type="submit" name="invoice" value="Show and download/print the invoice EUR">
</form>

<form action="generate_usd.php" metod="post">
   <input type="submit" name="invoice" value="Show and download/print the invoice USD">
</form>

<form action="generate_rub.php" metod="post">
   <input type="submit" name="invoice" value="Show and download/print the invoice RUB">
</form>

<b>If necessary:</b><br>
<font color="green" face="sans-serif">
Beneficiary's name: Alexey Krylov, Vice-Rector;<br>
Address: 195196, Russia, Saint-Petersburg, Malookhtinsky prospect 98;<br>
Telephone number: +7 (812) 372-50-92; <br>
</font>
Rates are available <a href="http://emecs-sc2016.com/aboutreg.html" target="_blank">here. </a>

HERE;

}
else {printf ("Incorrect date of birth. Go back to the 'Information' section and edit the date of birth.");}
}
else {printf ("Incorrect date of birth. Go back to the 'Information' section and edit the date of birth.");}


if ($myrow2['det'] == '0')
{
	
print <<<HERE
<br><br>
<b>All bank account information for transfer of the registration fee is on the <a href='http://emecs-sc2016.com/aboutreg.html'>Registration page</a> of the Conference web-site.<br>
Please, upload here the scan-copy/photo of the payment receipt.</b>
HERE;
	
print <<<HERE
<br><br>
<center>
<form action='finisheds.php' method='post' enctype='multipart/form-data'>
Scan-copy/photo of payment receipt (.jpeg or .png):<br>
<br>
<input type="FILE" name="fupload"><br><br>
<input type='submit' name='submit' value='Upload'>
</form>

<form action='finishpdf.php' method='post' enctype='multipart/form-data'>
Scan-copy of payment receipt (.pdf, max 3 MB):<br>
<br>
<input type="FILE" name="fupload"><br><br>
<input type='submit' name='submit' value='Upload'>
</form>
</center>
HERE;
}


?>
</div>

</body>
</html>
