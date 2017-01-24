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
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />

<title>Registered participants</title>
</head>
<body>
<h2>Registered participants</h2>

<?php
print <<<HERE
<header id="header">
<nav id="nav">
<ul>
<li><a href='info.php?id=$_SESSION[id]'>Information</a></li>
<li><a href='all.php'>Registered participants</a></li>
<li><a href='index.php'>Abstract and paper submission</a></li>
<li><a href='vib_soavt.php'>Coauthors list</a></li>
<li><a href='visasup.php'>Visa information</a></li>
<li><a href='all_users.php'>Visa support list</a></li>
<li><a href='totalfee.php'>Total registration fee</a></li>
<li><a href='exit.php'>Exit</a></li>
</ul>
</nav>
</header>
<center><h2>Registered participants</h2></center>
HERE;
//выше вывели меню
?>

<div class="Boxtotal">

<?php
$result = mysql_query("SELECT id,full_name,gild,country FROM reg_users ORDER BY full_name",$db); //извлекаем логин и идентификатор пользователей
$myrow = mysql_fetch_array($result);

do
{
//выводим их в цикле
/* printf("<a href='vib_leader.php?id=%s'>%s</a> ",$myrow['id'],$myrow['full_name']); printf($myrow['country']); printf(" "); printf($myrow['gild']); printf(" <br>"); */

printf("<b>");printf($myrow['full_name']);printf("</b>");printf(", "); printf($myrow['country']); printf(", "); printf($myrow['gild']); printf("; <br>");
}
while($myrow = mysql_fetch_array($result));


?>
</div>

</body>
</html>