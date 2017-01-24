<?

$odr = "\n\n\n Для отказа от подписки воспользуйтесь ссылкой\n";
$homepage = "http://emecs-sc2016.com/ras/ras.php";

error_reporting(0);
$subject = $HTTP_POST_VARS['subject'];
$body = $HTTP_POST_VARS['body'];
$subject = stripslashes($subject);
$body = stripslashes($body);

$file = "maillist.txt";
$maillist = file($file);

print "В базе". sizeof($maillist) ." адресов<br>";
for ($i = 0; $i < sizeof ($maillist); $i++)
{
#echo($maillist[$i]."<br>");
mail($maillist[$i], $subject,
$body ."$odr $homepag?delmail=$maillist[$i]",
"From: $fromemail");
}
echo "Готово!";

?>