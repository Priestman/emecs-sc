<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

$login = $_SESSION['login'];
$password = $_SESSION['password'];

$result = mysql_query("SELECT * FROM users WHERE login = '$login'",$db);
$myrow = mysql_fetch_array($result);
$my_key = $myrow['login'];

/* $result1 = mysql_query("SELECT * FROM reg_users WHERE login = '$login'",$db);
$myrow1 = mysql_fetch_array($result1);
$letter = $myrow1['letter']; */

 if ($_POST) //Условие будет выполнено, если произведен POST-запрос к скрипту.
    { 
	
	$passport_id = $_POST['passport_id'];
	$valid = $_POST['valid'];
	$located = $_POST['located'];
	$zip_addr = $_POST['zip_addr']; 
	
	if (empty($passport_id))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field Passport number"); //останавливаем выполнение сценариев
} 
if (empty($valid))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field Expiry date"); //останавливаем выполнение сценариев
} 
if (empty($located))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field City where you will apply for visa"); //останавливаем выполнение сценариев
} 
if (empty($zip_addr))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field Postal address"); //останавливаем выполнение сценариев
} 


		
$sql1 = mysql_query ("INSERT INTO `visa` (`key`,`passport_id`,`valid`,`located`,`zip_addr`) VALUES ('$my_key','$passport_id','$valid','$located','$zip_addr')", $db);

		
		if ($sql1=='TRUE')

	//Выводим сообщение об успешной регистрации.	
		{
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=visasup.php?id=".$_SESSION['id']."'></head><body>Ok! </body></html>"; }


	}

?>