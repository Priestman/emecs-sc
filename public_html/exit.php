<?php
session_start();
if (empty($_SESSION['login']) or empty($_SESSION['password'])) 
{
//���� �� ���������� ������ � ������� � �������, ������ �� ���� ���� ����� ���������� ������������. ��� ��� �� �����. ������ ��������� �� ������, ������������� ������
exit ("Access to this page is allowed only to registered users. If you are registered, please login using your login and password.<br><a href='index.php'>Home page</a>");
}

unset($_SESSION['password']);
unset($_SESSION['login']); 
unset($_SESSION['id']);// ���������� ���������� � �������

setcookie("auto", "", time()+9999999);//������� �������������� ����
exit("<html><head><meta http-equiv='Refresh' content='0; URL=index.php'>Home page</head></html>");
// ���������� ������������ �� ������� ��������.
?>