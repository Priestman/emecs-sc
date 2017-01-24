<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 



 if ($_POST) //Условие будет выполнено, если произведен POST-запрос к скрипту.
    { 
	
	$ids = $_POST['ids'];
	
	$sql = mysql_query("SELECT * FROM users WHERE `id` = '$ids'",$db);
	$myrow = mysql_fetch_array($sql);
	$login = $myrow['login'];
	
	$full_name = $_POST['full_name'];
	$full_name   = mysql_real_escape_string($full_name);
	
	$country = $_POST['country'];
	$country   = mysql_real_escape_string($country);
	
	$birth = $_POST['birth'];
	
	$degree = $_POST['degree'];
	$degree   = mysql_real_escape_string($degree);
	
	$gild = $_POST['gild'];
	$gild   = mysql_real_escape_string($gild);
	
	$address = $_POST['address'];
	$address   = mysql_real_escape_string($address);
	
	$position = $_POST['position'];
	$position   = mysql_real_escape_string($position);
	
	$work_tel = $_POST['work_tel'];
	$work_tel   = mysql_real_escape_string($work_tel);
	
	$mob_tel = $_POST['mob_tel'];
	$mob_tel   = mysql_real_escape_string($mob_tel);
	
	$need_visa = $_POST['need_visa'];
	
	
if (empty($full_name))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'Full name'"); //останавливаем выполнение сценариев
} 
if (empty($country))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'Country'"); //останавливаем выполнение сценариев
} 
if (empty($birth))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'Date of birth'"); //останавливаем выполнение сценариев
} 
if (empty($degree))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'Academic degree'"); //останавливаем выполнение сценариев
} 
if (empty($gild))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'Organization'"); //останавливаем выполнение сценариев
} 
if (empty($address))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'Address'"); //останавливаем выполнение сценариев
} 
if (empty($position))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'Position'"); //останавливаем выполнение сценариев
} 
if (empty($work_tel))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'Work phone'"); //останавливаем выполнение сценариев
} 


		
$sql1 = mysql_query ("INSERT INTO `reg_users` (`key`,`full_name`,`country`,`birth`,`degree`,`gild`,`address`,`position`,`work_tel`,`mob_tel`,`need_visa`) VALUES ('$login','$full_name','$country','$birth','$degree','$gild','$address','$position','$work_tel','$mob_tel','$need_visa')", $db);

		
		if ($sql1=='TRUE')

	//Выводим сообщение об успешной регистрации.	
		{
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=info.php?id=".$_SESSION['id']."'></head><body>Ok! </body></html>"; }


	}

?>