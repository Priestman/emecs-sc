<?php
session_start();//��������� ������
include ("bd.php");//������������ � ����

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//���� ���������� ����� � ������ � �������, �� ���������, ������������� �� ���
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //������ ������������ �������. 
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//���������, ��������������� �� ��������
exit("Entrance to this page is allowed only for registered users!"); }
$id2 = $_SESSION['id']; //�������� ������������� ����� ��������


if (isset($_GET['id'])) { $id = $_GET['id'];}//�������� ����� GET ������ ������������� ���������, ������� ����� �������

$result = mysql_query("SELECT poluchatel FROM messages WHERE id='$id'",$db); 
$myrow = mysql_fetch_array($result); //����� ��������, ���� ��������� ����������
//���� ����� GET ������ ������������ ����� ������ ����� ������������� � ��� ��������� ������� ���������, ������� ���������� �� ���.

if ($login == $myrow['poluchatel']) {//���� ��������� ���������� ������� ������������, �� ��������� ��� �������

$result = mysql_query ("DELETE FROM messages WHERE id = '$id' LIMIT 1");//������� ���������
if ($result == 'true') {//���� ������� - �������������� �� ��������� ������������
echo "<html><head><meta http-equiv='Refresh' content='5; URL=page.php?id=".$id2."'></head><body>Your message deleted! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$id2."'>click here</a></body></html>";
}
else {//���� �� �������, �� ��������������, �� ������ ��������� � �������
echo "<html><head><meta http-equiv='Refresh' content='5; URL=page.php?id=".$id2."'></head><body>Error! Your message is not removed. You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$id2."'>click here.</a></body></html>"; }

}
else {exit("You are trying to delete a message sent to you is not!");} //���� ��������� ���������� �� ����� ������������. ������, �� ��������� ������� ���, ����� � �������� ������ �����-�� ������ �������������
?>