<?php

session_start();// вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в самом начале странички!!!
		  
if (isset($_POST['username'])) { $login = $_POST['username']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную

if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{
exit ("You do not have entered all the information, go back and fill in all fields!"); //останавливаем выполнение сценариев
}
//если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
$login = stripslashes($login);
$login = htmlspecialchars($login);

$password = stripslashes($password);
$password = htmlspecialchars($password);

//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);

include ("bd.php");

$ip=getenv("HTTP_X_FORWARDED_FOR");
if (empty($ip) || $ip=='unknown') { $ip=getenv("REMOTE_ADDR"); }

mysql_query ("DELETE FROM `oshibka` WHERE UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 900");//удаляем ip-адреса ошибавшихся при входе пользователей через 15 минут.

$result = mysql_query("SELECT `col` FROM `oshibka` WHERE `ip`='$ip'",$db);// извлекаем из базы колличество неудачных попыток входа за последние 15 минут у пользователя с данным ip
$myrow = mysql_fetch_array($result);

if ($myrow['col'] > 2) {
exit ("You typed your username or password is incorrect 3 times. Wait 15 minutes before the next attempt."); //останавливаем выполнение сценариев


}

$password = md5($password);//шифруем пароль
$password = strrev($password);// добавим реверс
$password = $password."ythnfo6jm";

$result = mysql_query("SELECT * FROM `adm_access` WHERE `key`='$login' AND `password`='$password'",$db);

$myrow = mysql_fetch_array($result);
if (empty($myrow['id']))
{
//если пользователя с введенным логином и паролем не существует,то записываем ip пользователя и с датой ошибки

$select = mysql_query ("SELECT `ip` FROM `oshibka` WHERE `ip`='$ip'");
$tmp = mysql_fetch_row ($select);
if ($ip == $tmp[0]) {
//проверяем, есть ли пользователь в таблице "oshibka"
$result52 = mysql_query("SELECT `col` FROM `oshibka` WHERE `ip`='$ip'",$db);
$myrow52 = mysql_fetch_array($result52);

$col = $myrow52[0] + 1;//Если есть,то приплюсовываем количесво 
mysql_query ("UPDATE `oshibka` SET `col`=$col,`date`=NOW() WHERE `ip`='$ip'");
}

else {
//если за последние 15 минут ошибок не было, то вставляем новую запись в таблицу "oshibka"
mysql_query ("INSERT INTO `oshibka` (`ip`,`date`,`col`) VALUES ('$ip',NOW(),'1')");
}

exit ("Sorry, you entered an incorrect username or password."); //останавливаем выполнение сценариев

}
  else {

          //если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
        $_SESSION['password']=$myrow['password']; 
        $_SESSION['login']=$myrow['key']; 
        $_SESSION['id']=$myrow['id'];
        
        if (isset($_POST['Field'])){
//сохраняем в куках его браузера
setcookie("login", $_POST["username"], time()+9999999);
setcookie("password", $_POST["password"], time()+9999999);
setcookie("id", $myrow['id'], time()+9999999);
}
echo "<html><head><script>
<!--
 location='http://emecs-sc2016.com/admin_panel/index.html';
//-->
</script></head></html>";
}

        
?>

