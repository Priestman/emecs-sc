<?php
session_start(); //��������� ������. ����������� � ������ ��������
include ("bd.php"); // ����������� � �����, ������� ���� ����, ���� � ��� ��� ���� ����������

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//���� ���������� ����� � ������ � �������, �� ���������, ������������� �� ���
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //���� ����� ��� ������ �� ������������
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//���������, ��������������� �� ��������
exit("Entrance to this page is allowed only for registered users!"); }

if (isset($_POST['id'])) { $id = $_POST['id'];}//�������� ������������� �������� ����������
if (isset($_POST['text'])) { $text = $_POST['text'];}//�������� ����� ���������
if (isset($_POST['poluchatel'])) { $poluchatel = $_POST['poluchatel'];}//����� ����������
$author = $_SESSION['login'];//����� ������
$date = date("Y-m-d");//���� ����������

if (empty($author) or empty($text) or empty($poluchatel) or empty($date)) {//���� �� ��� ����������� ������? ���� ���, �� �������������
exit ("You do not have entered all the information, go back and fill in all fields");}

$text = stripslashes($text);//������� �������� �����
$text = htmlspecialchars($text);//�������������� ������������ � �� HTML �����������


$result2 = mysql_query("INSERT INTO messages (author, poluchatel, date, text) VALUES ('$author','$poluchatel','$date','$text')",$db);//������� � ���� ���������

echo "<html><head><meta http-equiv='Refresh' content='5; URL=page.php?id=".$id."'></head><body>Your message has been sent! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$id."'>click here.</a></body></html>";//�������������� ������������
?>