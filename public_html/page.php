<?php
// вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
if (isset($_GET['id'])) {$id =$_GET['id']; } //id "хозяина" странички
else
{ exit("You sewed a page without an argument!");} //если не указали id, то выдаем ошибку
if (!preg_match("|^[\d]+$|", $id)) {
exit("<p>Invalid request format! Please check the URL</p>");//если id не число, то выдаем ошибку
}

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //Если не действительны (может мы удалили этого пользователя из базы за плохое поведение)
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Entrance to this page is allowed only for registered users!"); }
$result = mysql_query("SELECT * FROM users WHERE id='$id'",$db); 
$myrow = mysql_fetch_array($result);//Извлекаем все данные пользователя с данным id

if (empty($myrow['login'])) { exit("User does not exist! Maybe it was deleted.");} //если такого не существует
$result3 = mysql_query("SELECT * FROM reg_users WHERE `key` = '$login'",$db);
$myrow3 = mysql_fetch_array($result3);
$result4 = mysql_query("SELECT * FROM visa WHERE `key` = '$login'",$db);
$myrow4 = mysql_fetch_array($result4);  
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

1. Full name:<em> <?php echo $myrow3['full_name']; ?> <br></em>
2. Country:<em> <?php echo $myrow3['country']; ?><br></em>
3. Date of Birth:<em> <?php echo $myrow3['birth']; ?><br></em>
4. Academic degree:<em> <?php echo $myrow3['degree']; ?><br></em>
5. Organization (full name and abbreviation):<em></b> <?php echo $myrow3['gild']; ?><br></em>
6. Full address of the organization with index:<em></b> <?php echo $myrow3['address']; ?><br></em>
7. Position:<em> <?php echo $myrow3['position']; ?><br></em>
8. Work and mobile phone numbers:<em> <?php echo $myrow3['work_tel']; ?>, <?php echo $myrow3['mob_tel']; ?></em>

</div>
<br>
<div class="box">
<?php
if ($myrow['login'] == $login) {
//Если страничка принадлежит вошедшему, то предлагаем изменить данные и выводим личные сообщениЯ

print <<<HERE

<h4>Insert personal information:<br><br>

<form action='update_user.php' method='post'>
Change password:<br>
<input name='password' type='password'>
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
Full name(Surname, Given names): <br><strong>$myrow3[full_name]</strong><br>
<input name='full_name' type='text' placeholder='Surname, Given names' size='50'>
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
Country: <strong>$myrow3[country]</strong><br>
<input name='country' type='text' size='50'>
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
Date of birth: <strong>$myrow3[birth]</strong><br>
If you do not see the calendar, enter in the format yyyy-mm-dd.<br>
<input name='birth' type='date' >
<input type='submit' name='submit' value='Save'><br>
</form>
<br>

<form action='update_anketa.php' method='post'>
Academic degree: <strong>$myrow3[degree]</strong><br>
<input name='degree' type='text' size='50'>
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
Organization (full name and abbreviation): <br><strong>$myrow3[gild]</strong><br>
<input name='gild' type='text' size='50'>
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
Full address of the organization with index: <br><strong>$myrow3[address]</strong><br>
<input name='address' type='text' size='50' >
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
Position: <strong>$myrow3[position]</strong><br>
<input name='position' type='text' size='50' >
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
Mobile phone: <strong>$myrow3[mob_tel]</strong><br>
<input name='mob_tel' type='text' size='50' >
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
Work phone: <strong>$myrow3[work_tel]</strong><br>
<input name='work_tel' type='text' size='50' >
<input type='submit' name='submit' value='Save'>
</form>
<br>

<form action='update_anketa.php' method='post'>
<p><b>Do you need a visa support?</b><Br><br>
   <input type="radio" name="need_visa" value="10" >Yes<Br>
   <input type="radio" name="need_visa" value="0" >No<Br>
  </p>
<input type='submit' name='submit' value='Save'><br><br>
</form>
<h2><a href='visasup.php'>Click here to fill in visa information.</a></h2>
<br>

HERE;
///////////
///////////<h2>Private messages:</h2>
?>
</div>

<?php
////////////////

$tmp = mysql_query("SELECT * FROM messages WHERE poluchatel='$login' ORDER BY id DESC",$db); 
$messages = mysql_fetch_array($tmp);//извлекаем сообщения пользователя, сортируем по идентификатору в обратном порядке, т.е. самые новые сообщения будут вверху

if (!empty($messages['id'])) {
do //выводим все сообщения в цикле
  {
$author = $messages['author'];
$result4 = mysql_query("SELECT avatar,id FROM users WHERE login='$author'",$db); //извлекаем аватар автора
$myrow4 = mysql_fetch_array($result4);

if (!empty($myrow4['avatar'])) {//если такового нет, то выводим стандартный(может этого пользователя уже давно удалили)
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
					echo " ";
					}
					
}

else
{
//если страничка чужая, то выводим только некторые данные и форму для отправки личных сообщений

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
</center>
</body>
</html>
