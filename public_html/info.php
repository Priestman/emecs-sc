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
$id = $_SESSION['id'];
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
<center>
<meta charset="utf-8">
<script src="assets/js/ie/html5shiv.js"></script>

<script>
function limitText(limitField, limitCount, limitNum) { if (limitField.value.length > limitNum) { limitField.value = limitField.value.substring(0, limitNum); } else { limitCount.value = limitNum - limitField.value.length; } }
</script>

<link rel="stylesheet" href="style.css" />

<title><?php echo $myrow['login']; ?></title>
</head>
<body>

<h2>User: "<?php echo $myrow['login']; ?>"</h2>
<a href='http://emecs-sc2016.com/'>Back to emecs-sc2016.com</a>

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
HERE;
//выше вывели меню
?>

<h3><b>Your data: </b></h3><br>

<div class="tab">

1. Full name:<em> <?php echo htmlspecialchars($myrow3['full_name']); ?> <br></em>
2. Country:<em> <?php echo htmlspecialchars($myrow3['country']); ?><br></em>
3. Date of Birth:<em> <?php echo $myrow3['birth']; ?><br></em>
4. Academic degree:<em> <?php echo htmlspecialchars($myrow3['degree']); ?><br></em>
5. Organization (full name and abbreviation):<em></b> <?php echo htmlspecialchars($myrow3['gild']); ?><br></em>
6. Full address of the organization with index:<em></b> <?php echo htmlspecialchars ($myrow3['address']); ?><br></em>
7. Position:<em> <?php echo htmlspecialchars($myrow3['position']); ?><br></em>
8. Work and mobile phone numbers:<em> <?php echo htmlspecialchars($myrow3['work_tel']); ?>, <?php echo htmlspecialchars($myrow3['mob_tel']); ?></em>

</div>
<br>
<div class="box">
<?php
if ($myrow3['full_name']==NULL)
{
//если нет полного имени, то выводим следующее

print <<<HERE

<h4>Insert personal information: <br>
Please fill in the form ONLY in English! <br><br>

<form action='ins_info.php' method='post'>
<input name='ids' type='hidden' value='$id'>

Full name: <br><strong>$myrow3[full_name]</strong><br>
<input name='full_name' type='text' size='50' placeholder='Surname, Given names' >

<br>

Country: <strong>$myrow3[country]</strong><br>
<input name='country' type='text' size='50' >

<br>

Date of birth: <strong>$myrow3[birth]</strong><br>
If you are using Internet Explorer, then enter: yyyy-mm-dd<br>
<input name='birth' type='date' >

<br><br>

Academic degree: <strong>$myrow3[degree]</strong><br>
<input name='degree' type='text' size='50'>

<br>

Organization (full name and abbreviation): <br><strong>$myrow3[gild]</strong><br>
<input name='gild' type='text' size='50' placeholder='For example: Russian State Hydrometeorological University (RSHU)' >

<br>

Full address of the organization with index: <br><strong>$myrow3[address]</strong><br>
<input name='address' type='text' size='50' placeholder='For example: 195196, Russia, St.Petersburg, Metallistov pr., 3' >

<br>

Position: <strong>$myrow3[position]</strong><br>
<input name='position' type='text' size='50' >

<br>

Mobile phone: <strong>$myrow3[mob_tel]</strong><br>
<input name='mob_tel' type='text' size='50' >

<br>

Work phone: <strong>$myrow3[work_tel]</strong><br>
<input name='work_tel' type='text' size='50' >
<br>


<p><b>Do you need a visa support?</b><Br><br>
   <input type="radio" name="need_visa" value="10" >Yes<Br>
   <input type="radio" name="need_visa" value="0" >No<Br>
  </p>
  
<input type='submit' name='submit' value='Save'><br><br>
</form>
<h2><a href='visasup.php'>Click here to fill in visa information.</a></h2>
<br>

<h4><a href='page.php?id=$_SESSION[id]'>To change your personal information, click here.</a><br><br>

HERE;

///////////
///////////<h2>Private messages:</h2>
?>
</div>

<?php
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
					echo " ";
					}
					
}

else
{
//иначе выводим ссылку на изменение информации

print <<<HERE
<h4><a href='page.php?id=$_SESSION[id]'>To change your personal information, click here.</a></h4><br>
HERE;
}


?>
</center>
</body>
</html>
