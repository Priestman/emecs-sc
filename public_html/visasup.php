<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сесси¤х, то провер¤ем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result3 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow3 = mysql_fetch_array($result3); 
if (empty($myrow3['id']))
   {
   //если данные пользовател¤ не верны
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//ѕровер¤ем, зарегистрирован ли вошедший
exit("Entrance to this page is allowed only for registered users!"); }

$result1 = mysql_query("SELECT * FROM `reg_users` WHERE `key` = '$login'",$db);
$myrow1 = mysql_fetch_array($result1);
$from_title = $myrow1['title'];

$result2 = mysql_query("SELECT * FROM `visa` WHERE `key` = '$login'",$db);
$myrow2 = mysql_fetch_array($result2);

$result = mysql_query("SELECT * FROM `users` WHERE `login` = '$login'",$db);
$myrow = mysql_fetch_array($result);
$my_key = $myrow['login'];

?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/help.js"></script>

<center>
<title>Visa support</title>
</head>
<body>
<br><br>
<h2>Visa support</h2>
<a href='infovisa.html'>Description of visa service</a>
<br><br>
</center>

<div class="tab">
Login: <?php echo $my_key; ?><br>
Full name: <?php echo $myrow1['full_name']; ?><br>
Passport number: <?php echo $myrow2['passport_id']; ?><br>
Expiry date: <?php echo $myrow2['valid']; ?><br>
City where you will apply for visa (Embassy/Consulate of the Russian Federation): <?php echo $myrow2['located']; ?><br>
Postal address where the original invitation must be sent: <?php echo $myrow2['zip_addr']; ?><br>
I am: <?php echo $myrow1['letter']; ?><br>
<?php 
if ($myrow1['letter']=='join')
{
print <<<HERE
Visa invitation recipient: '$myrow1[leader_name]'
HERE;
}
?>
</div>
<br>
<center>

<?php
//выводим меню
print <<<HERE
<header id="header">
<nav id="nav">
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
 </nav>
 </header>
HERE;
?>
<div class="box">
<?php

if (empty($myrow2['key']))
{
print <<<HERE
 
<form action='insert_visa.php' method='post'>

Passport number:<br>
<input name='passport_id' type='text' size='50' >

<br>

Expiry date<br>
If you are using Internet Explorer, then enter: yyyy-mm-dd <br>
<input name='valid' type='date' >

<br><br>

City where you will apply for visa (Embassy/Consulate of the Russian Federation):<br>
<input name='located' type='text' size='50' >

<br>

Postal address where the original invitation must be sent:<br>
<input name='zip_addr' type='text' size='50' placeholder='If it is necessary or you are a "visa invitation recipient (VIR)", otherwise write "not needed"'>

<br>

<input type='submit' name='submit' value='Save'>

</form>

HERE;
?>
<?php
}
else if (!empty($myrow2['key']) and empty($myrow['fullscan']))
{
print <<<HERE

<form action='update_user.php' method='post' enctype='multipart/form-data'>
Scan-copy of the passport. (If everything is correct, you will see a small copy):<br>
<img alt='скан' src='$myrow[avatar]'><br>
The image format must be jpg, gif or png.<br><br>
<input type="FILE" name="fupload"><br><br>
<input type='submit' name='submit' value='Save'>
</form>
HERE;

?>

<?php
}
else if(!empty($myrow2['key'])and !empty($myrow['fullscan']) and ($myrow1['letter']==null) )
{
print <<<HERE
<form action='update_anketa.php' method='post'>
<p><b>Sending the original visa invitation letter:</b><Br><br>
   <input type="radio" name="letter" value="VIR" id="tbnum4">Send me (VIR)<Br>
   <input type="radio" name="letter" value="join" id="tbnum5">I'll join another user<Br>
  </p> 
<input type='submit' name='submit' value='Save'><br><br>
</form> 
<p align="left">To obtain a Russian visa you must submit the documents, including the original invitation letter, to the Embassy or Consulate of the Russian Federation, which you indicated in the registration form. This original invitation letter we send you by an insured express mail, which costs 50 euros.<br>
However, if the Russian visa make out number people from one organization (or one city/country), we can send ONE mail to ONE address with NUMBER of invitations.<br>
In this case, you must do the following procedure:<br>
- ONE person <b>("visa invitation recipient (VIR)")</b> indicates in point <b>"Sending the original visa invitation letter" as "Send me"</b>, that he needs the original invitation letter by the insured express mailand is willing to pay 50 euros; <br>
- his name appears in the Member list section marked VIR of mail visa invitation”;<br>
- the participant after filling out the page with the visa information, indicate in point <b>"Sending the original visa invitation letter" as “I'll join another user”</b> and choose the <b>"VIR" name</b> from the list in the <b>Visa support list</b> section;<br>
- payment for sending the original visa invitation letter will be 0 euro, and the original invitation letter to him will come in same mail that for "VIR".<br>
<b>Please note that the division of the payment for sending the original visa invitation letter (50 Euro) for number of people is IMPOSSIBLE!</b></p>

HERE;

?>
<?php
}
else
{
print <<<HERE
<h4><a href='visasup_change.php?id=$_SESSION[id]'>To change your personal information, click here.</a></h4><br>
HERE;
}
?>
</div>
</center>
</body>
</html>
