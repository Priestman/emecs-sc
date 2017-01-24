<?php
if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //çàíîñèì ââåäåííûé ïîëüçîâàòåëåì ëîãèí â ïåðåìåííóþ $login, åñëè îí ïóñòîé, òî óíè÷òîæàåì ïåðåìåííóþ

if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } //çàíîñèì ââåäåííûé ïîëüçîâàòåëåì e-mail, åñëè îí ïóñòîé, òî óíè÷òîæàåì ïåðåìåííóþ

if (isset($login) and isset($email)) {//åñëè ñóùåñòâóþò íåîáõîäèìûå ïåðåìåííûå  
	
	include ("bd.php");// ôàéë bd.php äîëæåí áûòü â òîé æå ïàïêå, ÷òî è âñå îñòàëüíûå, åñëè ýòî íå òàê, òî ïðîñòî èçìåíèòå ïóòü 
	
	$result = mysql_query("SELECT id FROM users WHERE login='$login' AND email='$email' AND activation='1'",$db);//òàêîé ëè ó ïîëüçîâàòåëÿ å-ìåéë
	$myrow = mysql_fetch_array($result);
	if (empty($myrow['id']) or $myrow['id']=='') {
		//åñëè àêòèâèðîâàííîãî ïîëüçîâàòåëÿ ñ òàêèì ëîãèíîì è å-mail àäðåñîì íåò
		exit ("No user with this e-mail address is not found in any CIA base :) <a href='index.php'>Home page</a>");
		}
	//åñëè ïîëüçîâàòåëü ñ òàêèì ëîãèíîì è å-ìåéëîì íàéäåí, òî íåîáõîäèìî ñãåíåðèðîâàòü äëÿ íåãî ñëó÷àéíûé ïàðîëü, îáíîâèòü åãî â áàçå è îòïðàâèòü íà å-ìåéë
	$datenow = date('YmdHis');//èçâëåêàåì äàòó 
	$new_password = md5($datenow);// øèôðóåì äàòó
	$new_password = substr($new_password, 2, 6);	//èçâëåêàåì èç øèôðà 6 ñèìâîëîâ íà÷èíàÿ ñî âòîðîãî. Ýòî è áóäåò íàø ñëó÷àéíûé ïàðîëü. Äàëåå çàïèøåì åãî â áàçó, çàøèôðîâàâ òî÷íî òàê æå, êàê è îáû÷íî.
	
$new_password_sh = strrev(md5($new_password))."b3p6f";//çàøèôðîâàëè
mysql_query("UPDATE users SET password='$new_password_sh' WHERE login='$login'",$db);// îáíîâèëè â áàçå
	//ôîðìèðóåì ñîîáùåíèå
	
	$message = "Hello, ".$login."! We generated password for you. Upon entering, we advise you to change it:\n".$new_password;//òåêñò ñîîáùåíèÿ
	mail($email, "Password recovery", $message, "Content-type:text/plain;charset=windows-1251rn");//îòïðàâëÿåì ñîîáùåíèå
	
	echo "<html><head><meta http-equiv='Refresh' content='5; URL=index.php'></head><body>In your e-mail was sent a letter with a password. You will be moved after 5 seconds. If you do not want to wait, <a href='index.php'>click here.</a></body></html>";//ïåðåíàïðàâëÿåì ïîëüçîâàòåëÿ
	}


else {//åñëè äàííûå åùå íå ââåäåíû
echo '
<html>
<head>
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<title>Forgot your password?</title>
</head>
<body>
<div class="box">
<h2>Forgot your password?</h2>
<form action="#" method="post">
Enter your login:<br> <input type="text" name="login"><br><br>
Enter your E-mail:<br><input type="text" name="email"><br><br>
<input type="submit" name="submit" value="Send">
</form>
</div>
</body>
</html>';
}

?>