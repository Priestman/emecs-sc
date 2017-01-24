<?php
session_start();
include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //Если не действительны, то закрываем доступ
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Entrance to this page is allowed only for registered users!"); }

$old_login = $_SESSION['login']; //Старый логин нам пригодиться
$id = $_SESSION['id'];//идентификатор пользователя тоже нужен

if (isset($_FILES['fupload']['name'])) //отправлялась ли переменная
      {

$path_to_90_directory = 'totalfee/';//папка, куда будет загружаться начальная картинка и ее сжатая копия
if(preg_match('/[.](PDF)|(pdf)$/',$_FILES['fupload']['name']))//проверка исходного формата 
{	
	 	 	
 		$filename = $_FILES['fupload']['name'];
		$source = $_FILES['fupload']['tmp_name'];
		
		$target = $path_to_90_directory . $filename;
		move_uploaded_file($source, $target);//загрузка оригинала в папку $path_to_90_directory

		/* imagejpeg($dest, $path_to_90_directory.$login.".pdf");//сохраняем в нужную папку, именем будет текущее время. Сделано, чтобы у аватаров не было одинаковых имен. */
		
		$avatar = $path_to_90_directory.$filename;//заносим в переменную путь до аватара.
		$delfull = $path_to_90_directory.$filename;
		
}
else 
        {
		//в случае несоответствия формата, выдаем соответствующее сообщение
        exit ("Must be formatted <strong>.pdf</strong>");
		}
		
$result4 = mysql_query("UPDATE users SET finished='$avatar' WHERE login='$old_login'",$db);//обновляем аватар в базе
$result6 = mysql_query("UPDATE users SET det='1' WHERE login='$old_login'",$db);
if ($result4=='TRUE') {//если верно, то отправляем на личную страничку
echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=totalfee.php'></head><body>Saccesfully! </body></html>";}

      } 
	  
?>