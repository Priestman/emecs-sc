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

<div class="box">

<?php
print <<<HERE
<form action='assets/db_to_excel_reports.php' method='post' align = "center">
From reports<br>
<input type='submit' name='submit' value='Yes'>
</form>

<form action='assets/db_to_excel_regusers.php' method='post' align = "center">
From reg_users<br>
<input type='submit' name='submit' value='Yes'>
</form>

<form action='assets/db_to_excel_coauthors.php' method='post' align = "center">
From co-authors<br>
<input type='submit' name='submit' value='Yes'>
</form>

<form action='assets/db_to_excel_users.php' method='post' align = "center">
From users<br>
<input type='submit' name='submit' value='Yes'>
</form>

<form action='assets/db_to_excel_visa.php' method='post' align = "center">
Visa<br>
<input type='submit' name='submit' value='Yes'>
</form>

HERE;
	
$result = mysql_query("SELECT * FROM reports WHERE assepted = '0' AND annotation != '' ORDER BY id",$db); //извлекаем логин и идентификатор пользователей
$myrow = mysql_fetch_array($result);

do
{
$annotation = htmlspecialchars($myrow['annotation'],ENT_QUOTES);

printf("<b> Пользователь: ");printf("<a href='all_abs_inf.php?id=%s'>%s</a> ",$myrow['id'],$myrow['key']);printf("</b> <br>");

printf("Заголовок тезиса: "); printf($myrow['title']); printf(", <br> Секция: "); printf($myrow['section']);printf("<br> Форма: "); printf($myrow['form']); printf("<br> Тезис: ");printf($annotation);printf(" <br>");
printf("Отправлено 3G: ");printf($myrow['ackn']);printf("<br>");printf("<br>");
}
while($myrow = mysql_fetch_array($result));



// $result = mysql_query("SELECT *  FROM users WHERE fullscan IS NOT NULL ORDER BY id",$db); //извлекаем логин и идентификатор пользователей
// $myrow = mysql_fetch_array($result);

// do
// {

// printf($myrow['login']); printf(":  "); printf($myrow['fullscan']); 
// printf("<br>");
// }
// while($myrow = mysql_fetch_array($result));

?>

</div>

</body>
</html>