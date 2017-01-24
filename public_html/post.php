<?php
session_start(); //запускаем сессию. Обязательно в начале страницы
include ("bd.php"); // соединяемся с базой, укажите свой путь, если у вас уже есть соединение

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //если логин или пароль не действителен
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Entrance to this page is allowed only for registered users!"); }

if (isset($_POST['id'])) { $id = $_POST['id'];}//получаем идентификатор страницы получателя
if (isset($_POST['text'])) { $text = $_POST['text'];}//получаем текст сообщения
if (isset($_POST['poluchatel'])) { $poluchatel = $_POST['poluchatel'];}//логин получателя
$author = $_SESSION['login'];//логин автора
$date = date("Y-m-d");//дата добавления

if (empty($author) or empty($text) or empty($poluchatel) or empty($date)) {//есть ли все необходимые данные? Если нет, то останавливаем
exit ("You do not have entered all the information, go back and fill in all fields");}

$text = stripslashes($text);//удаляем обратные слеши
$text = htmlspecialchars($text);//преобразование спецсимволов в их HTML эквиваленты


$result2 = mysql_query("INSERT INTO messages (author, poluchatel, date, text) VALUES ('$author','$poluchatel','$date','$text')",$db);//заносим в базу сообщение

echo "<html><head><meta http-equiv='Refresh' content='5; URL=page.php?id=".$id."'></head><body>Your message has been sent! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$id."'>click here.</a></body></html>";//перенаправляем пользователя
?>