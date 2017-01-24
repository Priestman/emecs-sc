<?php
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке
$login = $_SESSION['login'];
$password = $_SESSION['password'];

$result = mysql_query("SELECT * FROM reg_users WHERE `key` = '$login'",$db);
$myrow = mysql_fetch_array($result);

$name = $myrow['full_name'];

$result2 = mysql_query("SELECT * FROM reports WHERE `key` = '$login'",$db);
$myrow2 = mysql_fetch_array($result2);

$user_id = $myrow2['co_authors'];
$from_title = $myrow2['title'];

	
if (isset($_POST['full_name'])) 
      {
		  
$op = $_POST['reports'];
$res = mysql_query ("SELECT * FROM reports where id=".$op);		  
$row = mysql_fetch_array($res);

$title = $row['title'];
$title   = mysql_real_escape_string($title);

$full_name = $_POST['full_name'];
$full_name   = mysql_real_escape_string($full_name);
$country = $_POST['country'];
$country   = mysql_real_escape_string($country);
$organization = $_POST['organization'];
$organization   = mysql_real_escape_string($organization);
$degree = $_POST['degree'];
$degree   = mysql_real_escape_string($degree);
$emeil = $_POST['emeil'];
$emeil   = mysql_real_escape_string($emeil);
$num_pp = $_POST['num_pp'];
$num_pp   = mysql_real_escape_string($num_pp);

$subject = "To add you as a co-author";//тема сообщения
$message = "Dear ".$full_name."!\n
Inform that you are indicated as co-author on the article ".$title.", main author is ".$name." \n
Administration http://emecs-sc2016.com";//содержание сообщение
mail($emeil, $subject, $message, "Content-type:text/plain;charset=windows-1251rn");//отправляем сообщение 

$result3 = mysql_query("INSERT INTO `co_authors` (`key`,`title`,`full_name`,`country`,`organization`,`degree`,`emeil`,`num_pp`) VALUES ('$login','$title','$full_name','$country','$organization','$degree','$emeil','$num_pp')");
if ($result3=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>"; }
	  }



?>