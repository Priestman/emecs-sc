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
$result1 = mysql_query("SELECT * FROM reg_users WHERE `key` = '$login'",$db);
$myrow1 = mysql_fetch_array($result1);
$from_title = $myrow1['title'];

$result4 = mysql_query("SELECT * FROM visa WHERE `key` = '$login'",$db);
$myrow4 = mysql_fetch_array($result4);

$result = mysql_query("SELECT * FROM users WHERE login = '$login'",$db);
$myrow = mysql_fetch_array($result);
$my_key = $myrow['login'];
?>
<html>
<head>
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />

<title><?php echo $myrow['login']; ?></title>
</head>
<body>

<h2>User: "<?php echo $myrow['login']; ?>"</h2>
<a href='http://emecs-sc2016.com/'>Back to emecs-sc2016.com</a>

<header id="header">
<nav id="nav">
<?php
print <<<HERE
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
HERE;
//выше вывели меню
?>
 </nav>
 </header>
<h3><b>Your data: </b></h3><br>
<div class="tab">

Login: <?php echo $my_key; ?><br>
Full name: <?php echo $myrow1['full_name']; ?><br>
Passport number: <?php echo $myrow4['passport_id']; ?><br>
Expiry date: <?php echo $myrow4['valid']; ?><br>
City where you will apply for visa (Embassy/Consulate of the Russian Federation): <?php echo $myrow4['located']; ?><br>
Postal address where the original invitation must be sent: <?php echo $myrow4['zip_addr']; ?><br>
I am: <?php echo $myrow1['letter']; ?><br>

</div>
<br>
<div class="box">
<?php

//≈сли страничка принадлежит вошедшему, то предлагаем изменить данные и выводим личные сообщения

print <<<HERE
 
<form action='update_visa.php' method='post' enctype='multipart/form-data'>
Scan-copy of the passport. (If everything is correct, you will see a small copy):<br>
<img alt='скан' src='$myrow[avatar]'><br>
The image format must be jpg, gif or png.<br>
<input type="FILE" name="fupload"><br><br>
<input type='submit' name='submit' value='Change!'>

<br> 

<form action='update_visa.php' method='post'>
Passport number:<br>
<input name='passport_id' type='text' size='50' >
<input type='submit' name='submit' value='Change!'>
</form>
<br>

<form action='update_visa.php' method='post'>
Expiry date:<br>
<input name='valid' type='date' >
<input type='submit' name='submit' value='Change!'>
</form>
<br>

<form action='update_visa.php' method='post'>
City where you will apply for visa (Embassy/Consulate of the Russian Federation):<br>
<input name='located' type='text' size='50' >
<input type='submit' name='submit' value='Change!'>
</form>
<br>

<form action='update_visa.php' method='post'>
Postal address where the original invitation must be sent:<br>
<input name='zip_addr' type='text' size='50' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_anketa.php' method='post'>
<p><b>Sending the original visa invitation letter:</b><Br><br>
   <input type="radio" name="letter" value="VIR" >Send me<Br>
   <input type="radio" name="letter" value="join" >I'll join another user<Br>
  </p> 
<input type='submit' name='submit' value='Change!'><br><br>
</form>

HERE;
///////////
///////////<h2>Private messages:</h2>

?> 
</div>

</center>
</body>
</html>
