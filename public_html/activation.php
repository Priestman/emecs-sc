<?php
include ("bd.php");// ���� bd.php ������ ���� � ��� �� �����, ��� � ��� ���������, ���� ��� �� ���, �� ������ �������� ���� 
$result4 = mysql_query ("SELECT avatar FROM users WHERE activation='0' AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 3600");//��������� �������� ��� �������������, ������� � ������� ���� �� ������������ ���� �������. ������������� �� ���� ������� �� ����, � ��� �� � ����� �� ��������

if (mysql_num_rows($result4) > 0) {
$myrow4 = mysql_fetch_array($result4);	
do
{
//������� ������� � �����, ���� ��� �� �����������
if ($myrow4['avatar'] == "avatars/net-avatara.jpg") {$a = "������ �� ������";}
else {
	unlink ($myrow4['avatar']);//������� ����
	}
}
while($myrow4 = mysql_fetch_array($result4));
}
mysql_query ("DELETE FROM users WHERE activation='0' AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 3600");//������� ������������� �� ����



if (isset($_GET['code'])) {$code =$_GET['code']; } //��� �������������
else
{ exit("You sewed a page without confirmation code!");} //���� �� ������� code, �� ������ ������

if (isset($_GET['login'])) {$login=$_GET['login']; } //�����,������� ����� ������������
else
{ exit("You sewed on the page without login!");} //���� �� ������� �����, �� ������ ������

$result = mysql_query("SELECT id FROM users WHERE login='$login'",$db); //��������� ������������� ������������ � ������ �������
$myrow = mysql_fetch_array($result); 

$activation = md5($myrow['id']).md5($login);//������� ����� �� ��� �������������
if ($activation == $code) {//���������� ���������� �� url � ��������������� ���
	mysql_query("UPDATE users SET activation='1' WHERE login='$login'",$db);//���� �����, �� ���������� ������������
	echo "Your e-mail is confirmed! Now you can enter the site under your login! <a href='index.php'>Home page</a>";
	}
else {echo "Error! Your E-mail has not been confirmed! <a href='index.php'>Home page</a>";
//���� �� ���������� �� url � ��������������� ��� �� �����, �� ������ ������
}

?>