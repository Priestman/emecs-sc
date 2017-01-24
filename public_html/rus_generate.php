<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
if (isset($_GET['id'])) {$id =$_GET['id']; } //id "хоз¤ина" странички
else
{ exit("You sewed a page without an argument!");} //если не указали id, то выдаем ошибку
if (!preg_match("|^[\d]+$|", $id)) {
exit("<p>Invalid request format! Please check the URL</p>");//если id не число, то выдаем ошибку
}

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сесси¤х, то провер¤ем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //≈сли не действительны (может мы удалили этого пользовател¤ из базы за плохое поведение)
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//ѕровер¤ем, зарегистрирован ли вошедший
exit("Entrance to this page is allowed only for registered users!"); }
$result = mysql_query("SELECT * FROM users WHERE id='$id'",$db); 
$myrow = mysql_fetch_array($result);//»звлекаем все данные пользовател¤ с данным id

if (empty($myrow['login'])) { exit("User does not exist! Maybe it was deleted.");} //если такого не существует
$result3 = mysql_query("SELECT * FROM reg_users WHERE `key` = '$login'",$db);
$myrow3 = mysql_fetch_array($result3);
$result4 = mysql_query("SELECT * FROM visa WHERE `key` = '$login'",$db);
$myrow4 = mysql_fetch_array($result4); 
?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<center>
<title>Total registration fee</title>
</head>
<body>
<h2>Total registration fee</h2>

<header id="header">
<nav id="nav">
<?php
//выводим меню
print <<<HERE
<ul>
<li><a href='info.php?id=$_SESSION[id]'>Information</a></li>
<li><a href='all.php'>Registered participants</a></li>
<li><a href='index.php'>Abstract and paper submission</a></li>
<li><a href='reports.php'>Add coauthors</a></li>
<li><a href='visasup.php'>Visa information</a></li>
<li><a href='all_users.php'>Visa support list</a></li>
<li><a href='totalfee.php'>Total registration fee</a></li>
<li><a href='exit.php'>Exit</a></li>
</ul>
HERE;
?>
 </nav>
 </header>

<?php
print <<<HERE
You are logged in as $_SESSION[login]<br><br>
HERE;
?>
</center>
<div class="box">
<?php
$result = mysql_query("SELECT * FROM reg_users WHERE `key`='$login'",$db);
$myrow = mysql_fetch_array($result);

$results = mysql_query("SELECT * FROM users WHERE `key`='$login'",$db);
$row2 = mysql_fetch_array($results);

$key = $_SESSION['login'];
$need_visa = $myrow['need_visa'];
$birth = $myrow['birth'];
$letter = $myrow['letter'];
$forwarding = $myrow['forwarding'];
$leader_name = $myrow['leader_name'];

?>

<?php

print <<<HERE
Для того, чтобы сгенерировать ваш счет на русском языке, заполните форму ниже:<br><br>

<form action='rus_gen_then.php' metod='post'>
ФИО (на русском):
   <input name='fio_rus' type='text' size='50'><br>

Организация (полное наименование, на русском):
   <input name='org_rus' type='text' size='50'><br>   
   <input type='submit' name='submit' value='upload'>
</form>

HERE;

?>
</div>

</body>
</html>
