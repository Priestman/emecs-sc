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

$sql = mysql_query("SELECT * FROM `reg_users` WHERE `key`='$login'",$db);
$myrow3 = mysql_fetch_array($sql);
 
$name = $myrow3['full_name'];


?>
<html>
<head>
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<title>Papers</title>
</head>
<body>

    <h2>Your papers</h2>

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
<li><a href='form/support.php'>Tech support</a></li>
</ul>
</nav>
</header>
<h2>Your papers:</h2>
HERE;

$result = mysql_query("SELECT id,title FROM reports WHERE `key` = '$login'",$db); //��������� ����� � ������������� �������������
$myrow = mysql_fetch_array($result);

do
{
//������� �� � �����
printf("<a href='edit_art.php?id=%s'>%s</a><br>",$myrow['id'],$myrow['title']);
}
while($myrow = mysql_fetch_array($result));

?>
    
<br><br>
<h2>You are coauthor:</h2>

<?php
        
$sql2 = mysql_query("SELECT title FROM co_authors WHERE `full_name` = '$name'",$db);
$sqlrez = mysql_fetch_array($sql2);

do
{
/*printf($myrow2['title']);*/
// $title = $sqlrez['title'];
// $result4 = mysql_query("SELECT title FROM reports WHERE title = '$title'",$db);
// $myrow4 = mysql_fetch_array($result4);

printf($sqlrez['title']);

}
while($sqlrez = mysql_fetch_array($sql2));
?>
    
</center>
</body>
</html>