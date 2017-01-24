<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сесси¤х, то провер¤ем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result3 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow3 = mysql_fetch_array($result3); 
if (empty($myrow3['id']))
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
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<title>Add coauthors</title>

</head>
<body>
<h2>Add coauthors</h2>

<?php
//выводим меню
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
<h2>Add coauthors</h2>
HERE;

print <<<HERE
You are logged in as $_SESSION[login]<br>

<a href='vib_soavt.php'>View added coauthors</a><br><br>

<b>All fields are required</b><br><br>
<b>Please, add coauthors in the respective order one by one.</b> <br>
</center>

<div class="box">
HERE;
?>

<?php 

echo "<form action='update_co_authors.php' method='post'>
      <select name='reports'>
      <option value=''>Select title</option>";
          
$result =  mysql_query ("SELECT id,title FROM reports WHERE `key` = '$login'", $db) 
                or die ("<b>Query failed:</b> " . mysql_error());
 
while ($row = mysql_fetch_array($result)){
 
echo "<option value=' ".$row['id']." '>".$row['title']."</option>";
}
echo '</select><br>';

/* $trim = $row['title'];
echo "<input name='tit'  type='hidden' value='$trim' >";  */

echo ("Coauthor full name (Surname, Given names):");
echo '<input name="full_name"  type="text"  size="40" > <br>';

echo ("Country:");
echo '<input name="country"  type="text"  size="40" ><br>';

echo ("Organization (full name and abbreviation):");
echo '<input name="organization"  type="text"  size="40" ><br>';

echo ("Academic degree:");
echo '<input name="degree"  type="text"  size="40" ><br>';

echo ("E-mail:");
echo '<input name="emeil"  type="text"  size="40" ><br>';

echo ("Sequence number, if nedeed (for ex. 1, 2...):");
echo '<input name="num_pp"  type="text"  size="10" ><br>';

echo '<input name="submit" type="submit" value="Add co-author">';
echo '</form>'; 
?> 

<a href='vib_soavt.php' >View added coauthors</a>
<br><br>

</div> 
</body>
</html>
