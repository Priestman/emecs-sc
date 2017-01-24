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

if (isset($_COOKIE['auto']) and isset($_COOKIE['key']))
{//если есть необходимые переменные
	if ($_COOKIE['auto'] == 'yes') { // если пользователь желает входить автоматически, то запускаем сессии
		  
		  $_SESSION['key']=$_COOKIE['key'];//сессия с логином
	}
}
$login = $_SESSION['key'];	

$result = mysql_query("SELECT * FROM reg_users WHERE `id` = '$id' AND letter = 'VIR'",$db); 
$myrow = mysql_fetch_array($result);//»звлекаем все данные пользовател¤ с данным id

$ids = $myrow['id'];
$keys = $myrow['key'];

$result1 = mysql_query("SELECT * FROM visa WHERE `key` = '$keys'",$db); 
$myrow1 = mysql_fetch_array($result1);//»звлекаем все данные пользовател¤ с данным id



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
<a href='http://emecs-sc2016.com/'>Back to home emecs-sc2016.com</a>
 <div class="outline">
<p>
<div class="tab"> 

Full name: <?php echo $myrow['full_name']; ?> <br>
Country: <?php echo $myrow['country']; ?><br>
Organisation: <?php echo $myrow['gild']; ?><br>
Position: <?php echo $myrow['position']; ?><br>
Address (organisation): <?php echo $myrow['address']; ?><br>
Work phone: <?php echo $myrow['work_tel']; ?><br>
Address: <?php echo $myrow1['zip_addr']; ?>
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


if ($myrow['login'] == $login) {
//?сли страничка принадлежит вошедшему, то предлагаем изменить данные и выводим личные сообщения

print <<<HERE

<form action='update_anketa.php' method='post'>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Join!'>
</form> 


HERE;
					
}




?>
</center>
</body>
</html>