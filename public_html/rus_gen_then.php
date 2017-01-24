<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$id = $_SESSION['id'];

$result3 = mysql_query("SELECT * FROM reg_users WHERE `key` = '$login'",$db);
$myrow3 = mysql_fetch_array($result3);


if (isset($_POST['fio_rus']))//Если существует 
      {
$fio_rus = $_POST['fio_rus'];
$org_rus = $_POST['org_rus'];
$result = mysql_query("UPDATE reg_users SET fio_rus='$fio_rus' WHERE id='$id'",$db);
$result1 = mysql_query("UPDATE reg_users SET org_rus='$org_rus' WHERE id='$id'",$db);

if ($result=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=rus_generate.php?id=".$_SESSION['id']."'></head><body>Your name changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
else {
	echo "<html><head><meta http-equiv='Refresh' content='5; URL=rus_generate.php?id=".$_SESSION['id']."'></head><body>Ошибка БД</body></html>";}
	  }
	  
?>