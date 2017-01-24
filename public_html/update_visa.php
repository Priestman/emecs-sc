<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
$login = $_SESSION['login'];
$password = $_SESSION['password'];

$result = mysql_query("SELECT * FROM `visa` WHERE `key` = '$login'",$db);
$myrow = mysql_fetch_array($result);

$id = $myrow['id'];
$old_passport_id = $myrow['passport_id'];
$old_valid = $myrow['valid'];
$old_located = $myrow['located'];
$old_zip_addr = $myrow['zip_addr'];
$old_letter = $myrow['letter'];



if (isset($_POST['passport_id']))//Если существует 
      {
$passport_id = $_POST['passport_id'];
$result1 = mysql_query("UPDATE `visa` SET `passport_id`='$passport_id' WHERE `key`='$login'",$db);
if ($result1=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0; URL=visasup.php'></head><body>ok<a href='visasup_change.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }
	  else {echo "something happened";}
	  
if (isset($_POST['valid']))//Если существует 
      {
$valid = $_POST['valid'];
$result1 = mysql_query("UPDATE `visa` SET `valid`='$valid' WHERE `key`='$login'",$db);
if ($result1=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=visasup.php'></head><body>Your name changed! You will be moved after 5 seconds. If you do not want to wait, <a href='visasup.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }
	  
if (isset($_POST['located']))//Если существует 
      {
$located = $_POST['located'];
$result1 = mysql_query("UPDATE `visa` SET `located`='$located' WHERE `key`='$login'",$db);
if ($result1=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=visasup.php'></head><body>Your name changed! You will be moved after 5 seconds. If you do not want to wait, <a href='visasup.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['zip_addr']))//Если существует 
      {
$zip_addr = $_POST['zip_addr'];
$result1 = mysql_query("UPDATE `visa` SET `zip_addr`='$zip_addr' WHERE `key`='$login'",$db);
if ($result1=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=visasup.php'></head><body>Your name changed! You will be moved after 5 seconds. If you do not want to wait, <a href='visasup.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }
?>