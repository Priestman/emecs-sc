<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
if (isset($_GET['id'])) {$id =$_GET['id']; } //id "хозяина" странички
else
{ exit("You sewed a page without an argument!");} //если не указали id, то выдаем ошибку
if (!preg_match("|^[\d]+$|", $id)) {
exit("<p>Invalid request format! Please check the URL</p>");//если id не число, то выдаем ошибку
}

if (isset($_COOKIE['auto']) and isset($_COOKIE['key']))
{//если есть необходимые переменные
	if ($_COOKIE['auto'] == 'yes') { // если пользователь желает входить автоматически, то запускаем сессии
		  
		  $_SESSION['key']=$_COOKIE['key'];//сессия с логином
	}
}
$login = $_SESSION['key'];
$id = $_GET['id'];

$result = mysql_query("SELECT * FROM `reports` WHERE `id` = '$id'",$db); 
$myrow = mysql_fetch_array($result);//»звлекаем все данные пользовател¤ с данным id

$user_key = $myrow['key'];

$result1 = mysql_query("SELECT `full_name` FROM `reg_users` WHERE `key` = '$user_key'",$db); 
$myrow1 = mysql_fetch_array($result1);//»звлекаем все данные пользовател¤ с данным id

$result2 = mysql_query("SELECT `email` FROM `users` WHERE `login` = '$user_key'",$db); 
$myrow2 = mysql_fetch_array($result2);//»звлекаем все данные пользовател¤ с данным id

?>
<html>
<head>
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<title><?php echo $myrow['key']; ?></title>
</head>
<body>
<h2>User: "<?php echo $myrow['key']; ?>"</h2>
<a href='http://emecs-sc2016.com/'>Back to home emecs-sc2016.com</a><br>
<a href='all_abs.php'>back</a>
 <div class="outline">
<p>
<div class="tab">

 
<b>User:</b> <?php echo $user_key; ?><br>
<b>Full name: </b><?php echo $myrow1['full_name']; ?> <br>
<b>E-mail:</b> <?php echo $myrow2['email']; ?><br>
<b>Принято к рассмотрению?</b> <?php echo $myrow['ackn']; ?><br>
<b>Разрешена загрузка полного текста?</b> <?php echo $myrow['assepted']; ?><br>
<b>Тезис: </b><?php echo $myrow['annotation']; ?> <br>
<b>ID: </b><?php echo $id; ?> <br>


 </p>
</div>
</div> 
<br>

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
<li><a href='form/support.php'>Tech support</a></li>
</ul>
 </nav>
 </header>
HERE;
//выше вывели меню

print <<<HERE
<form action='all_abs_upd.php' method='post' align = "center">
Передать на проверку?<br>
<input name='ackn' type='hidden' value='ok'>
<input name='id' type='hidden' value='$id'>
<input type='submit' name='submit' value='Yes'>
</form>
<form action='all_abs_upd.php' method='post' align = "center">
Принять и разрешить загрузить статью?<br>
<input name='assepted' type='hidden' value='1'>
<input name='id' type='hidden' value='$id'>
<input type='submit' name='submit' value='Yes'>
</form>


HERE;



?>
</center>
</body>
</html>