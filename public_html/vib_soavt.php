<?php
// �� ��������� �������� �� ������. ������ � ��� ������ ������ �����������, ���� �� �������� �� �����. ����� ����� ��������� �� � ����� ������ ���������!!!
session_start();

include ("bd.php");// ���� bd.php ������ ���� � ��� �� �����, ��� � ��� ���������, ���� ��� �� ���, �� ������ �������� ���� 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//���� ���������� ����� � ������ � ������, �� ��������, ������������� �� ���
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //���� ������ ����������� �� �����
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//��������, ��������������� �� ��������
exit("Entrance to this page is allowed only for registered users!"); }
?>
<html>
<head>
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<title>Coauthors list</title>
</head>
<body>
<h2>Coauthors list</h2>

<?php
//������� ����
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
<h2>Coauthors list</h2>
HERE;

$result = mysql_query("SELECT id,full_name,title FROM co_authors WHERE `key` = '$login'",$db); //��������� ����� � ������������� �������������
$myrow = mysql_fetch_array($result);

do
{
//������� �� � �����
printf("<a href='edit_soavt.php?id=%s'>%s</a>",$myrow['id'],$myrow['full_name'],$myrow['key']);printf("; ");
printf("<br>");
}
while($myrow = mysql_fetch_array($result));

?>
</center>
</body>
</html>