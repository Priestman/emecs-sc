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

$result = mysql_query("SELECT * FROM co_authors WHERE `id` = '$id'",$db); 
$myrow = mysql_fetch_array($result);//»звлекаем все данные пользовател¤ с данным id
$ids = $myrow['id'];

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
<div class="tab"> 
<b><center>Data of your co-author</b><br></center>
Full name: <?php echo $myrow['full_name']; ?> <br>
Title: <?php echo $myrow['title']; ?><br>
Country: <?php echo $myrow['country']; ?><br>
Organization: <?php echo $myrow['organization']; ?><br>
Academic degree: <?php echo $myrow['degree']; ?><br>
E-mail: <?php echo $myrow['emeil']; ?><br>
Sequence number: <?php echo $myrow['num_pp']; ?>

 </div>
<br>
<div class="box"> 
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
<h2>Edit data:</h2>
HERE;
//выше вывели меню


if ($myrow['login'] == $login) {
//≈сли страничка принадлежит вошедшему, то предлагаем изменить данные и выводим личные сообщения

print <<<HERE

<form action='update_soavtor.php' method='post'>
Title:<br>
<input name='title' type='text' size='50' >
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>
<br>

<form action='update_soavtor.php' method='post'>
Full name(Surname Name Middle name):<br>
<input name='full_name' type='text' size='50' >
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>
<br>

<form action='update_soavtor.php' method='post'>
Country:<br>
<input name='country' type='text' size='50'>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>
<br>

<form action='update_soavtor.php' method='post'>
Organization:<br>
<input name='organization' type='text' size='50'>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>
<br>

<form action='update_soavtor.php' method='post'>
Academic degree:<br>
<input name='degree' type='text' size='50'>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>
<br>

<form action='update_soavtor.php' method='post'>
E-mail:<br>
<input name='emeil' type='text' size='50'>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_soavtor.php' method='post'>
Number relative to the main author:<br>
<input name='num_pp' type='int' size='20'>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_soavtor.php' method='post'>
<input name='del' type='hidden' value='$ids'>
<input name='upd' type='hidden' value='$ids'>
<input type='submit' name='submit' value='Delete co-author'>
</form>

HERE;
///////////
///////////


////////////////

$tmp = mysql_query("SELECT * FROM messages WHERE poluchatel='$login' ORDER BY id DESC",$db); 
$messages = mysql_fetch_array($tmp);//извлекаем сообщени¤ пользовател¤, сортируем по идентификатору в обратном пор¤дке, т.е. самые новые сообщени¤ будут вверху

if (!empty($messages['id'])) {
do //выводим все сообщени¤ в цикле
  {
$author = $messages['author'];
$result4 = mysql_query("SELECT avatar,id FROM users WHERE login='$author'",$db); //извлекаем аватар автора
$myrow4 = mysql_fetch_array($result4);

if (!empty($myrow4['avatar'])) {//если такового нет, то выводим стандартный(может этого пользовател¤ уже давно удалили)
$avatar = $myrow4['avatar'];
}
else {$avatar = "avatars/net-avatara.jpg";}

  printf("
  <table>
  <tr>
  <td><a href='page.php?id=%s'><img alt='avatar' src='%s'></a></td>
  
  <td>Author: <a href='page.php?id=%s'>%s</a><br>
      Date: %s<br>
	  Message:<br>
	 %s<br>
	 <a href='drop_post.php?id=%s'>Delete</a>
  
  </td>  
  </tr>
  </table><br>
  ",$myrow4['id'],$avatar,$myrow4['id'],$author,$messages['date'],$messages['text'],$messages['id']);
  //выводим само сообщение
  }
  while($messages = mysql_fetch_array($tmp));

                    }
					else {
					//если сообщений не найдено
					echo "";
					}
					
}

else
{
//если страничка чужа¤, то выводим только некторые данные и форму дл¤ отправки личных сообщений

print <<<HERE
<img alt='аватар' src='$myrow[avatar]'><br>
<form action='post.php' method='post'>
<br>
<h2>Send Your message:</h2>
<textarea cols='43' rows='4' name='text'></textarea><br>
<input type='hidden' name='poluchatel' value='$myrow[login]'>
<input type='hidden' name='id' value='$myrow[id]'>
<input type='submit' name='submit' value='Send'>
</form>
HERE;
}


?>
</div>
</center>
</body>
</html>