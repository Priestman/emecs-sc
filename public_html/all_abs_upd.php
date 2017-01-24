<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
$login = $_SESSION['login'];
$password = $_SESSION['password'];

if (isset($_POST['ackn']))//Если существует 
      {
$id = $_POST['id'];
$ackn = $_POST['ackn'];
$result5 = mysql_query("UPDATE `reports` SET `ackn`='$ackn' WHERE `id`='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0; URL=all_abs.php'></head><body>Ok</body></html>"; }
	  }

if (isset($_POST['assepted']))//Если существует 
      {
$id = $_POST['id'];		  
$assepted = $_POST['assepted'];
$result5 = mysql_query("UPDATE `reports` SET `assepted`='$assepted' WHERE `id`='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0; URL=all_abs.php'></head><body>Ok</body></html>"; }
	  }

	
?>