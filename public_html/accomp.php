<?php
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
$login = $_SESSION['login'];
$password = $_SESSION['password'];

$result = mysql_query("SELECT * FROM `reg_users` WHERE `key` = '$login'",$db);
$myrow = mysql_fetch_array($result);

$id = $myrow['id'];
$old_accomp = $myrow['accomp'];


if (isset($_POST['accomp']))//Если существует 
      {
$accomp = htmlspecialchars($_POST['accomp']);
$result1 = mysql_query("UPDATE `reg_users` SET `accomp`='$accomp' WHERE `id`='$id'",$db);
if ($result1=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0; URL=totalfee.php'></head><body>ok<a href='visasup_change.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }
	  else {echo "something happened";}

?>
