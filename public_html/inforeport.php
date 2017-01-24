<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сесси¤х, то провер¤ем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //если данные пользовател¤ не верны
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//ѕровер¤ем, зарегистрирован ли вошедший
exit("Entrance to this page is allowed only for registered users!"); }
?>
<html>
<head>
<title>Register report</title>
</head>
<body>
<h2>Register report</h2>


<?php
//выводим меню
print <<<HERE
|<a href='page.php?id=$_SESSION[id]'>Information</a>|<a href='all.php'>Registrated participants</a>|<a href='index.php'>Article</a>|<a href='reports.php'>Add coauthors</a>|<a href='visasup.php'>Visa</a>|<a href='all_users.php'>Visa support list</a>|<a href='exit.php'>Exit</a><br><br>
HERE;

//извлекаем идентификатор пользователей

$result = mysql_query("SELECT id, full_name, gild FROM reg_users ORDER BY full_name",$db);
$myrow = mysql_fetch_array($result);
do
{
//выводим их в цикле
printf($myrow['full_name']); printf(', from ');
printf($myrow['gild']);printf(';');
}
while($myrow = mysql_fetch_array($result));

/* "<a href='page.php?id=%s'>%s</a><br>",$myrow['id'], */

?>
</body>
</html>