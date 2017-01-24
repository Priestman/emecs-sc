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

$result = mysql_query("SELECT * FROM reg_users WHERE `id` = '$id'",$db); 
$myrow = mysql_fetch_array($result);//»звлекаем все данные пользовател¤ с данным id

$user_key = $myrow['key'];

$result1 = mysql_query("SELECT title,ackn,paper,assepted,form,section FROM reports WHERE `key` = '$user_key' ORDER BY id",$db); 
$myrow1 = mysql_fetch_array($result1);//»звлекаем все данные пользовател¤ с данным id

$mystring = $myrow1['ackn'];
$findme   = 'ok';
$pos = strpos($mystring, $findme);

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
<a href='admins.php?pas=qwerVCxzASD'>Выбрать другого юзера</a>
 <div class="outline">
<p>
<div class="tab">

 
<b>User:</b> <?php echo $myrow['key']; ?><br>
<b>Full name: </b><?php echo $myrow['full_name']; ?> <br>
<b>Country:</b> <?php echo $myrow['country']; ?><br>
<b>Organisation:</b> <?php echo $myrow['gild']; ?><br>
<b>Degree:</b> <?php echo $myrow['degree']; ?><br>
<b>Position:</b> <?php echo $myrow['position']; ?><br>
<b>Address:</b> <?php echo $myrow['address']; ?><br>
<b>Work phone:</b> <?php echo $myrow['work_tel']; ?><br>
<b>Mobile phone:</b> <?php echo $myrow['mob_tel']; ?><br><br>
<b>ABSTRACTS:</b><br>
<b>Форма:</b> <?php echo $myrow1['form']; ?><br>
<b>Секция:</b> <?php echo $myrow1['section']; ?><br>
<b>Подавал тезисы?</b> <?php if ($myrow1['ackn'] === 'ok') {printf("Да");} else {printf("Нет");} ?><br>
<b>Приняты?</b> <?php if ($myrow1['assepted'] != 0) {printf("Да");} else {printf("Нет");} ?><br>
<b>Подавал статью?</b> <?php if ($myrow1['paper'] != NULL) {printf("Да");} else {printf("Нет");} ?><br>
<b>Заголовки:</b><br>
<?php
do
{
//выводим их в цикле
printf($myrow1['title']);printf("; ");
printf("<br>");
}
while($myrow1 = mysql_fetch_array($result1));

?><br>
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


/* if ($myrow['login'] == $login) {
//?сли страничка принадлежит вошедшему, то предлагаем изменить данные и выводим личные сообщения

print <<<HERE

<form action='update_anketa.php' method='post'>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Join!'>
</form> 


HERE;
					
} */




?>
</center>
</body>
</html>