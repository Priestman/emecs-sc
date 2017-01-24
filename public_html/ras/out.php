<?

$pass = $_POST['pass'];
$subject = 'INFORMATION'; // тема рассылки
$fromemail = 'liiss.ru@gmail.com'; // ваш адрес (для ответов)
$file = 'maillist.txt'; // список адресов подписчиков
$file = file($file);
$password = 'qwerty'; // ваш пароль для рассылки

if ($pass == $password) // если пароль ввели правильный
// то выводим форму с полями для ввода:
// адрес отправителя, текст письма, тело письма
// кнопку для отправления
// после нажатия на кнопку, передаем данные скрипту send.php
{
echo "<font size=\"-1\"><hr><form method=\"POST\" action=\"send.php\">";
echo "Aдрес отправителя<br><input type=\"text\" name=\"fromemail\" value=\"$fromemail\" size=\"25\"><br>";
echo "Тема письма<br><input type=\"text\" name=\"subject\" value=\"$subject\" size=\"50\">";
echo "<br>Текст письма:<br><textarea name=\"body\" rows=\"8\" cols=\"50\"></textarea>";
echo "<br><input type=\"submit\" value=\"Отправить сообщение\"></form></font>";
print "<i>В базе <b>". sizeof($file) ."</b> адресов</i><br><hr>";
for ($i = 0; $i < sizeof ($file); $i++) print $file[$i]. "<br>";
}
// если пароль неверный - просим ввести еще раз
else echo "<form method=\"POST\" action=\"ras.php\"><input type=\"password\" name=\"pass\" value=\"\"><input type=\"submit\" value=\"Управление\"></form>";

?>