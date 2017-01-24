<?php
include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
$result4 = mysql_query ("SELECT avatar FROM users WHERE activation='0' AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 3600");//извлекаем аватарки тех пользователей, которые в течении часа не активировали свой аккаунт. —ледовательно их надо удалить из базы, а так же и файлы их аватарок

if (mysql_num_rows($result4) > 0) {
$myrow4 = mysql_fetch_array($result4);	
do
{
//удал€ем аватары в цикле, если они не стандартные
if ($myrow4['avatar'] == "avatars/net-avatara.jpg") {$a = "Ќичего не делать";}
else {
	unlink ($myrow4['avatar']);//удал€ем файл
	}
}
while($myrow4 = mysql_fetch_array($result4));
}
mysql_query ("DELETE FROM users WHERE activation='0' AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 3600");//удал€ем пользователей из базы



if (isset($_GET['code'])) {$code =$_GET['code']; } //код подтверждени€
else
{ exit("You sewed a page without confirmation code!");} //если не указали code, то выдаем ошибку

if (isset($_GET['login'])) {$login=$_GET['login']; } //логин,который нужно активировать
else
{ exit("You sewed on the page without login!");} //если не указали логин, то выдаем ошибку

$result = mysql_query("SELECT id FROM users WHERE login='$login'",$db); //извлекаем идентификатор пользовател€ с данным логином
$myrow = mysql_fetch_array($result); 

$activation = md5($myrow['id']).md5($login);//создаем такой же код подтверждени€
if ($activation == $code) {//сравниваем полученный из url и сгенерированный код
	mysql_query("UPDATE users SET activation='1' WHERE login='$login'",$db);//если равны, то активируем пользовател€
	echo "Your e-mail is confirmed! Now you can enter the site under your login! <a href='index.php'>Home page</a>";
	}
else {echo "Error! Your E-mail has not been confirmed! <a href='index.php'>Home page</a>";
//если же полученный из url и сгенерированный код не равны, то выдаем ошибку
}

?>