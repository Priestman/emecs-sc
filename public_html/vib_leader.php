<?php
// �� ��������� �������� �� ������. ������ � ��� ������ ������ �����������, ���� �� �������� �� �����. ����� ����� ��������� �� � ����� ������ ���������!!!
session_start();

include ("bd.php");// ���� bd.php ������ ���� � ��� �� �����, ��� � ��� ���������, ���� ��� �� ���, �� ������ �������� ���� 
if (isset($_GET['id'])) {$id =$_GET['id']; } //id "������" ���������
else
{ exit("You sewed a page without an argument!");} //���� �� ������� id, �� ������ ������
if (!preg_match("|^[\d]+$|", $id)) {
exit("<p>Invalid request format! Please check the URL</p>");//���� id �� �����, �� ������ ������
}

if (isset($_COOKIE['auto']) and isset($_COOKIE['key']))
{//���� ���� ����������� ����������
	if ($_COOKIE['auto'] == 'yes') { // ���� ������������ ������ ������� �������������, �� ��������� ������
		  
		  $_SESSION['key']=$_COOKIE['key'];//������ � �������
	}
}
$login = $_SESSION['key'];	

$result = mysql_query("SELECT * FROM reg_users WHERE `id` = '$id' AND letter = 'VIR'",$db); 
$myrow = mysql_fetch_array($result);//��������� ��� ������ ����������� � ������ id

$ids = $myrow['id'];
$keys = $myrow['key'];

$result1 = mysql_query("SELECT * FROM visa WHERE `key` = '$keys'",$db); 
$myrow1 = mysql_fetch_array($result1);//��������� ��� ������ ����������� � ������ id



?>
<html>
<head>
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<title><?php echo $myrow['key']; ?></title>
</head>
<body>
<h2>User: "<?php echo $myrow['key']; ?>"</h2>
<a href='http://emecs-sc2016.com/'>Back to home emecs-sc2016.com</a>
 <div class="outline">
<p>
<div class="tab"> 

Full name: <?php echo $myrow['full_name']; ?> <br>
Country: <?php echo $myrow['country']; ?><br>
Organisation: <?php echo $myrow['gild']; ?><br>
Position: <?php echo $myrow['position']; ?><br>
Address (organisation): <?php echo $myrow['address']; ?><br>
Work phone: <?php echo $myrow['work_tel']; ?><br>
Address: <?php echo $myrow1['zip_addr']; ?>
 </p>
</div>
</div> 
<br>

<?php
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
HERE;
//���� ������ ����


if ($myrow['login'] == $login) {
//?��� ��������� ����������� ���������, �� ���������� �������� ������ � ������� ������ ���������

print <<<HERE

<form action='update_anketa.php' method='post'>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Join!'>
</form> 


HERE;
					
}




?>
</center>
</body>
</html>