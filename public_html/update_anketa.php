<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
$login = $_SESSION['login'];
$password = $_SESSION['password'];


$result3 = mysql_query("SELECT * FROM reg_users WHERE `key` = '$login'",$db);
$myrow3 = mysql_fetch_array($result3);

$id = $myrow3['id'];
$old_fullname = $myrow3['full_name'];
$old_fullname   = mysql_real_escape_string($old_fullname);

$old_country = $myrow3['country'];
$old_country   = mysql_real_escape_string($old_country);

$old_birth = $myrow3['birth'];

$old_degree = $myrow3['degree'];
$old_degree   = mysql_real_escape_string($old_degree);

$old_gild = $myrow3['gild'];
$old_gild   = mysql_real_escape_string($old_gild);

$old_address = $myrow3['address'];
$old_address   = mysql_real_escape_string($old_address);

$old_position = $myrow3['position'];
$old_position   = mysql_real_escape_string($old_position);

$old_work_tel = $myrow3['work_tel'];
$old_work_tel   = mysql_real_escape_string($old_work_tel);

$old_mob_tel = $myrow3['mob_tel'];
$old_mob_tel   = mysql_real_escape_string($old_mob_tel);

$old_scan = $myrow3['scan'];
$old_need_visa = $myrow3['need_visa'];
$old_letters = $myrow3['letter'];
$old_forwarding = $myrow3['forwarding'];
$oldfio_rus = $myrow3['fio_rus'];
$oldorg_rus = $myrow3['org_rus'];



if (isset($_POST['full_name']))//Если существует 
      {
$full_name = $_POST['full_name'];
$full_name   = mysql_real_escape_string($full_name);
$result5 = mysql_query("UPDATE reg_users SET full_name='$full_name' WHERE full_name='$old_fullname' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Your name changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['country']))//Если существует 
      {
$country = $_POST['country'];
$country   = mysql_real_escape_string($country);
$result5 = mysql_query("UPDATE reg_users SET country='$country' WHERE country='$old_country' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Your country changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['birth']))//Если существует 
      {
$birth = $_POST['birth'];
$result5 = mysql_query("UPDATE reg_users SET birth='$birth' WHERE birth='$old_birth' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Your birth changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['degree']))//Если существует 
      {
$degree = $_POST['degree'];
$degree   = mysql_real_escape_string($degree);
$result5 = mysql_query("UPDATE reg_users SET degree='$degree' WHERE degree='$old_degree' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Your degree changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['gild']))//Если существует 
      {
$gild = $_POST['gild'];
$gild   = mysql_real_escape_string($gild);
$result5 = mysql_query("UPDATE reg_users SET gild='$gild' WHERE gild='$old_gild' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Your organization changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['address']))//Если существует 
      {
$address = $_POST['address'];
$address   = mysql_real_escape_string($address);
$result5 = mysql_query("UPDATE reg_users SET address='$address' WHERE address='$old_address' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>The full address changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }
	  
if (isset($_POST['position']))//Если существует 
      {
$position = $_POST['position'];
$position   = mysql_real_escape_string($position);
$result5 = mysql_query("UPDATE reg_users SET position='$position' WHERE position='$old_position' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Position changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['mob_tel']))//Если существует 
      {
$mob_tel = $_POST['mob_tel'];
$mob_tel   = mysql_real_escape_string($mob_tel);
$result5 = mysql_query("UPDATE reg_users SET mob_tel='$mob_tel' WHERE mob_tel='$old_mob_tel' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Mobile phone changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['work_tel']))//Если существует 
      {
$work_tel = $_POST['work_tel'];
$work_tel   = mysql_real_escape_string($work_tel);
$result5 = mysql_query("UPDATE reg_users SET work_tel='$work_tel' WHERE work_tel='$old_work_tel' AND id='$id'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Work phone changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  }

if (isset($_POST['need_visa']))//Если существует 
{   
$need_visa = $_POST['need_visa'];
$result5 = mysql_query("UPDATE reg_users SET need_visa='$need_visa' WHERE need_visa='$old_need_visa' AND id='$id'",$db);
 	  
    if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=totalfee.php?id=".$_SESSION['id']."'></head><body>Data changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  
}
	  
if (isset($_POST['letter']))//Если существует 
{   
$letter = $_POST['letter'];
$result6 = mysql_query("UPDATE reg_users SET letter='$letter' WHERE id='$id'",$db); 	 	  
    if ($result6=='TRUE') {
		$result7 = mysql_query("UPDATE reg_users SET forwarding='50' WHERE id='$id' AND letter='VIR'",$db);
		$result9 = mysql_query("UPDATE reg_users SET forwarding='0' WHERE id='$id' AND letter='join'",$db); 		
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=visasup.php'></head><body>Data changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>"; }
	  
} 
	
 if (isset($_POST['upd']))//Если существует 
      {
$upd = $_POST['upd'];
$result = mysql_query("SELECT * FROM reg_users WHERE id='$upd'",$db);
$myrow = mysql_fetch_array($result);
$name = $myrow['full_name'];
$key = $myrow['key'];

$result1 = mysql_query("SELECT * FROM users WHERE login='$key'",$db);
$myrow1 = mysql_fetch_array($result1);
$email = $myrow1['email'];


$result2 = mysql_query("UPDATE reg_users SET leader_name='$name' WHERE id='$id'",$db);
$result8 = mysql_query("UPDATE reg_users SET upd='$upd' WHERE id='$id'",$db); 
if ($result2=='TRUE') {
	
	$subject = "You have chosen as a 'VIR' ";//тема сообщения
	$message = "Dear ".$name."!\nInform that ".$old_fullname." is joined you for sending visa invitation. His original invitation letter sent to your address, with the original of your invitation.\n 
	Administration http://emecs-sc2016.com";//содержание сообщение
	mail($email, $subject, $message, "Content-type:text/plain;charset=windows-1251rn");//отправляем сообщение 

	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=visasup.php'></head><body>Ok! </body></html>";	
	}
	  } 
	
?>