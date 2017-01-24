<?php

session_start();

include ("bd.php");
if (isset($_GET['pas'])) {$pas =$_GET['pas']; } 
else
{
$pas = $_POST['pas'];
}

?>

<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<center>
<title>Admin's page</title>
</head>
<body>
<h2>Admin's page</h2>
<div class="box" align="left">


<form action=admins.php method=POST>
Для входа введите пароль:
<input type='password' name='pas' size='10'>
<input type='submit'>
</form>


<?PHP 

 if ($pas == 'qwerVCxzASD')
   {
     
$result1 = mysql_query("SELECT key FROM reg_users",$db);
$myrow1 = mysql_fetch_array($result);
	 
$result = mysql_query("SELECT id,full_name,gild,country FROM reg_users ORDER BY full_name",$db); //извлекаем логин и идентификатор пользователей
$myrow = mysql_fetch_array($result);

do
{
//выводим их в цикле
printf("<a href='allinfo.php?id=%s'>%s</a> ",$myrow['id'],$myrow['full_name']); printf($myrow['country']); printf(", "); printf($myrow['gild']); printf(" <br>");
}
while($myrow = mysql_fetch_array($result));

   }
   else
   {
     echo "Access denied";
   } 

?>
</div>
</center>
</body>
</html>