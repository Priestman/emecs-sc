<?php

if (isset($_POST['key'])) { $key = $_POST['key']; if ($key == '') { unset($key);} } 
if (isset($_POST['firstname'])) { $firstname=$_POST['firstname']; if ($firstname =='') { unset($firstname);} }

if (isset($_POST['lastname'])) { $lastname = $_POST['lastname']; if ($lastname == '') { unset($lastname);} } 

if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } 

if (isset($_POST['password'])) { $password = $_POST['password']; if ($password == '') { unset($password);} }

if (isset($_POST['confirm_password'])) { $confirm_password = $_POST['confirm_password']; if ($confirm_password == '') { unset($confirm_password);} }

if (empty($key) or empty($firstname)or empty($lastname) or empty($email) or empty($password) or empty($confirm_password)) 
{
exit ("All fields are required"); //останавливаем выполнение сценариев

}

if ($password != $confirm_password) {exit ("Пароли не совпадают");}
else{
    
if (!preg_match("/^.*?@.*?\..*?$/", $email)) //проверка е-mail адреса регулярными выражениями на корректность
{exit ("Incorrectly entered e-mail!");} 
    
$key = stripslashes($key);
$key = htmlspecialchars($key);

$email = stripslashes($email);
$email = htmlspecialchars($email);

$firstname = stripslashes($firstname);
$firstname = htmlspecialchars($firstname);

$lastname = stripslashes($lastname);
$lastname = htmlspecialchars($lastname);

$password = stripslashes($password);
$password = htmlspecialchars($password);

//удаляем лишние пробелы
$key = trim($key);
$firstname = trim($firstname);
$lastname = trim($lastname);
$password = trim($password);
$email = trim($email);

$password = md5($password);//шифруем пароль
$password = strrev($password);// для надежности добавим реверс
$password = $password."ythnfo6jm";

include ("bd.php");

$result = mysql_query("SELECT `id` FROM `adm_access` WHERE `key`='$key'",$db);
$myrow = mysql_fetch_array($result);

if (!empty($myrow['id'])) {
exit ("Sorry, you entered login is already registered. Please enter a different username.");}

$result2 = mysql_query ("INSERT INTO `adm_access` (`key`,`pass`,`firstname`,`lastname`,`email`) VALUES ('$key','$password','$firstname','$lastname','$email')") or die(mysql_error());

if ($result2=='TRUE')
{
echo "<html><head><script>
<!--
 location='http://emecs-sc2016.com/admin_panel/login.html';
//-->
</script></head></html>";
}

}

?>

