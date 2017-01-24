<?php
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
$login = $_SESSION['login'];
$password = $_SESSION['password'];

$result = mysql_query("SELECT * FROM users WHERE `login` = '$login'",$db);
$myrow = mysql_fetch_array($result);
$email = $myrow['email'];

$result2 = mysql_query("SELECT * FROM reg_users WHERE `key` = '$login'",$db);
$myrow2 = mysql_fetch_array($result2);
$full_name = $myrow2['full_name'];

if (isset($_POST['annotation']))//Если существует 
      {
$title = $_POST['title'];
$title = mysql_real_escape_string($title);

$section = $_POST['section'];
$form = $_POST['form'];
$annotation = $_POST['annotation'];
$annotation   = mysql_real_escape_string($annotation);

$coast = $_POST['coast'];

if (empty($title))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'title', or maybe you used invalid characters"); //останавливаем выполнение сценариев
} 
if (empty($section))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'section', or maybe you used invalid characters"); //останавливаем выполнение сценариев
} 
if (empty($form))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'form', or maybe you used invalid characters"); //останавливаем выполнение сценариев
} 
if (empty($annotation))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field 'abstract', or maybe you used invalid characters "); //останавливаем выполнение сценариев
}

$result5 = mysql_query("INSERT INTO `reports` (`key`,`title`,`section`,`form`,`annotation`,`coast`) VALUES ('$login','$title','$section','$form','$annotation','$coast')",$db);
if ($result5=='TRUE') {


$subject = "Your abstract";//тема сообщения
$message = "Dear ".$full_name."!\n
Your abstract was successfully added and accepted for consideration during next 10 days. \n 
Title: ".$title.", section: ".$section.", form: ".$form." \n
We will inform you about when you will be able to add your paper. \n
Administration http://emecs-sc2016.com";//содержание сообщение
mail($email, $subject, $message, "Content-type:text/plain;charset=windows-1251rn");//отправляем сообщение 	
	
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Data changed!</body></html> ";}
	else {echo "<html><head><meta http-equiv='Refresh' content='5; URL=update_article.php'></head><body>Somewhere there was an error.</body></html>";}
	  }
	  


  
 
?>