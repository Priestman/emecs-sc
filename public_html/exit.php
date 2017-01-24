<?php
session_start();
if (empty($_SESSION['login']) or empty($_SESSION['password'])) 
{
//если не существует сессии с логином и паролем, значит на этот файл попал невошедший пользователь. Ему тут не место. Выдаем сообщение об ошибке, останавливаем скрипт
exit ("Access to this page is allowed only to registered users. If you are registered, please login using your login and password.<br><a href='index.php'>Home page</a>");
}

unset($_SESSION['password']);
unset($_SESSION['login']); 
unset($_SESSION['id']);// уничтожаем переменные в сессиях

setcookie("auto", "", time()+9999999);//очищаем автоматический вход
exit("<html><head><meta http-equiv='Refresh' content='0; URL=index.php'>Home page</head></html>");
// отправляем пользователя на главную страницу.
?>