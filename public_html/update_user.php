<?php
session_start();
include ("bd.php");// ���� bd.php ������ ���� � ��� �� �����, ��� � ��� ���������, ���� ��� �� ���, �� ������ �������� ���� 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//���� ���������� ����� � ������ � �������, �� ���������, ������������� �� ���
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //���� �� �������������, �� ��������� ������
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//���������, ��������������� �� ��������
exit("Entrance to this page is allowed only for registered users!"); }

$old_login = $_SESSION['login']; //������ ����� ��� �����������
$id = $_SESSION['id'];//������������� ������������ ���� �����
$ava = "avatars/net-avatara.jpg";//����������� ����������� ����� ������

////////////////////////
////////��������� ������
////////////////////////

if (isset($_POST['login']))//���� ���������� �����
      {
$login = $_POST['login'];
$login = stripslashes($login); $login = htmlspecialchars($login); $login = trim($login);//������� ��� ������
if ($login == '') { exit("You have not entered login");} //���� ����� ������, �� ������������� ��������

if (strlen($login) < 3 or strlen($login) > 15) {//��������� �����
exit ("Login must be at least 3 characters and no more than 15."); //������������� ���������� ���������
}

// �������� �� ������������� ������������ � ����� �� �������
$result = mysql_query("SELECT id FROM users WHERE login='$login'",$db);
$myrow = mysql_fetch_array($result);
if (!empty($myrow['id'])) {
exit ("Sorry, you entered login is already registered. Please enter a different username."); //������������� ���������� ���������
}

$result4 = mysql_query("UPDATE users SET login='$login' WHERE login='$old_login'",$db);//��������� � ���� ����� ������������
if ($result4=='TRUE') {//���� ��������� �����, �� ��������� ��� ���������, ������� ���������� ���
mysql_query("UPDATE messages SET author='$login' WHERE author='$old_login'",$db);
$_SESSION['login'] = $login;//��������� ����� � ������
if (isset($_COOKIE['login'])) {
setcookie("login", $login, time()+9999999);//��������� ����� � �����
}

echo "<html><head><meta http-equiv='Refresh' content='5; URL=page.php?id=".$_SESSION['id']."'></head><body>Your login changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>";}//���������� ������������ �����

      } 

//////////////////////////////////////
////////������.���������� �����������
//////////////////////////////////////	  

						
/* if (isset($_POST["full_name"])) {
    //��������� ������, ���������� �� � ������
    $sql = mysql_query("INSERT INTO `reg_users` (`key`,`full_name`, `country`, `birth`, `degree`, `gild`, `address`, `position`, `work_tel`, `mob_tel`) 
                        VALUES ('$login','".$_POST['full_name']."','".$_POST['country']."','".$_POST['birth']."','".$_POST['degree']."','".$_POST['gild']."','".$_POST['address']."','".$_POST['position']."','".$_POST['work_tel']."','".$_POST['mob_tel']."')");						
					
    //���� ������� ������ �������
    if ($sql) {
        echo "<html><head><meta http-equiv='Refresh' content='5; URL=page.php?id=".$_SESSION['id']."'></head><body>Data successfully added! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>";
    } else {
        echo "<p>An error has occurred.</p>";
    }
} */
	  
/* 
if (isset($_POST["passport_id"])) {
		
		
		$sql2 = mysql_query("INSERT INTO `visa` (`key`, `passport_id`, `valid`, `located`, `zip_addr`) 
							VALUES ('$login','".$_POST['passport_id']."','".$_POST['valid']."','".$_POST['located']."','".$_POST['zip_addr']."')"); 
			
			
			if ($sql2) {
        echo "<html><head><meta http-equiv='Refresh' content='5; URL=page.php?id=".$_SESSION['id']."'></head><body>Data successfully added! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>";
    } else {
        echo "<p>An error has occurred.</p>";
    }				
							
		
	} */
	
//////////////////////////////////////
////////������. ��������� ������
//////////////////////////////////////		



////////////����/////////
/* if (isset($_POST['upload']))
      {
$uploaddir = 'scans/';
// ��� �����, � ������� ����� ����������� ��������
$apend=date('YmdHis').rand(100,1000).'.jpg'; 
// ��� ���, ������� ����� ���������� ����������� 
$uploadfile = "$uploaddir$apend"; 
//� ���������� $uploadfile ����� ������� ����� � ��� �����������

// � ������ ������ ����� ������ - ��������� ����������� �� ����������� (� ����� ����������� ���?)
// � �������� �� ����������� �� ����. � ����� ������ �� 512 ��
if(($_FILES['userfile']['type'] == 'image/gif' || $_FILES['userfile']['type'] == 'image/jpeg' || $_FILES['userfile']['type'] == 'image/png') && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size']<=512000)) 
{ 
// ��������� ������������ ��� ������������ �����. ������ �� 512 �� 
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
   { 
   //����� ���� ������� �������� ����������� 
   $size = getimagesize($uploadfile); 
   // � ������� ���� ������� �� ����� �������� ������ �������� ����������� 
     if ($size[0] < 501 && $size[1]<1501) 
     { 
 
$sql4 = mysql_query("INSERT INTO `docs` (`key`,`scan`) VALUES ('$login','$uploadfile')");
 
     // ���� ������ ����������� �� ����� 500 �������� �� ������ � �� ����� 1500 ��  ������ 
     echo "File upload. The path to the file: <b>http:/emecs-sc2016.com/".$uploadfile."</b>"; 
     } else {
     echo "Upload images exceeds the permissible limits (the width of not more than - 500; height of not more than 1500)"; 
     unlink($uploadfile); 
     // �������� ����� 
     } 
   } else {
   echo "The file is not loaded, vernitec and try again";
   } 
} else { 
echo "File size should not exceed 512KB";
} 
	  } */
	  
////////////////////////////
////////////////////////////

	  

	  
////////////////////////
////////��������� ������
////////////////////////

else if (isset($_POST['password']))//���� ���������� ������
      {
$password = $_POST['password'];
$password = stripslashes($password);$password = htmlspecialchars($password);$password = trim($password);//������� ��� ������
if ($password == '') { exit("You are not logged in");} //���� ������ �� ������, �� ������ ������

if (strlen($password) < 3 or strlen($password) > 15) {//�������� �� ���������� ��������
exit ("The password must be at least 3 characters and no more than 15."); //������������� ���������� ���������
}

$password = md5($password);//������� ������
$password = strrev($password);// ��� ���������� ������� ������
$password = $password."b3p6f";

//��� ���� ���������� ��������� ����� ���� password � ����. ������������� ������ ����� ��������� ������� �������� �������.


$result4 = mysql_query("UPDATE users SET password='$password' WHERE login='$old_login'",$db);//��������� ������
if ($result4=='TRUE') {//���� �����, �� ��������� ��� � ������
$_SESSION['password'] = $password;

if (isset($_COOKIE['password'])) {
setcookie("password",$_POST['password'], time()+9999999);//��������� ������ � �����, ���� ��� ����
}


echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Your password has been changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>";}//���������� ������� �� ��� ��������

      } 




////////////////////////
////////��������� �������
////////////////////////

else if (isset($_FILES['fupload']['name'])) //������������ �� ����������
      {

if (empty($_FILES['fupload']['name']))
{
//���� ���������� ������ (������������ �� �������� �����������),�� ����������� ��� ������� �������������� �������� � �������� "��� �������"
$avatar = "avatars/net-avatara.jpg"; //������ ���������� net-avatara.jpg ��� ����� � ����������
$result7 = mysql_query("SELECT avatar FROM users WHERE login='$old_login'",$db);//��������� ������� ������
$myrow7 = mysql_fetch_array($result7);
if ($myrow7['avatar'] == $ava) {//���� ������ ��� �����������, �� �� ������� ���, ���� � �� ���� �������� �� ����.
$ava = 1;
}
else {unlink ($myrow7['avatar']);}//���� ������ ��� ����, �� ������� ���, ����� �������� ��������
}

else 
{
//����� - ��������� ����������� ������������ ��� ����������
$path_to_90_directory = 'avatars/';//�����, ���� ����� ����������� ��������� �������� � �� ������ �����

	
if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//�������� ������� ��������� �����������
	 {	
	 	 	
 		$filename = $_FILES['fupload']['name'];
		$source = $_FILES['fupload']['tmp_name'];
		
		$target = $path_to_90_directory . $filename;
		move_uploaded_file($source, $target);//�������� ��������� � ����� $path_to_90_directory

	if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
	$im = imagecreatefromgif($path_to_90_directory.$filename) ; //���� �������� ��� � ������� gif, �� ������� ����������� � ���� �� �������. ���������� ��� ������������ ������
	}
	if(preg_match('/[.](PNG)|(png)$/', $filename)) {
	$im = imagecreatefrompng($path_to_90_directory.$filename) ;//���� �������� ��� � ������� png, �� ������� ����������� � ���� �� �������. ���������� ��� ������������ ������
	}
	
	if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
		$im = imagecreatefromjpeg($path_to_90_directory.$filename); //���� �������� ��� � ������� jpg, �� ������� ����������� � ���� �� �������. ���������� ��� ������������ ������
	}
	
//�������� ����������� ����������� � ��� ����������� ������ ����� � ����� www.codenet.ru

// �������� �������� 90x90
// dest - �������������� ����������� 
// w - ������ ����������� 
// ratio - ����������� ������������������ 

$w = 90;  // ���������� 90x90. ����� ��������� � ������ ������.

// ������ �������� ����������� �� ������ 
// ��������� ����� � ���������� ��� ������� 
$w_src = imagesx($im); //��������� ������
$h_src = imagesy($im); //��������� ������ �����������

         // ������ ������ ���������� �������� 
         // ����� ������ truecolor!, ����� ����� ����� 8-������ ��������� 
         $dest = imagecreatetruecolor($w,$w); 

         // �������� ���������� ��������� �� x, ���� ���� �������������� 
         if ($w_src>$h_src) 
         imagecopyresampled($dest, $im, 0, 0,
                          round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                          0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 

         // �������� ���������� �������� �� y, 
         // ���� ���� ������������ (���� ����� ���� ���������) 
         if ($w_src<$h_src) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,
                          min($w_src,$h_src), min($w_src,$h_src)); 

         // ���������� �������� �������������� ��� ������� 
         if ($w_src==$h_src) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);  
		 

$date=time(); //��������� ����� � ��������� ������.

imagejpeg($dest, $path_to_90_directory.$date.".jpg");//��������� ����������� ������� jpg � ������ �����, ������ ����� ������� �����. �������, ����� � �������� �� ���� ���������� ����.

//������ ������ jpg? �� �������� ����� ���� ����� + ������������ ������������ gif �����������, ������� ��������� ������������. �� ����� ������� ������ ��� �����������, ����� ����� ����� ��������� �����-�� ��������.

$avatar = $path_to_90_directory.$date.".jpg";//������� � ���������� ���� �� �������.

$delfull = $path_to_90_directory.$filename;

///unlink ($delfull);//������� �������� ������������ �����������, �� ��� ������ �� �����. ������� ���� - �������� ���������.

$result7 = mysql_query("SELECT avatar FROM users WHERE login='$old_login'",$db);//��������� ������� ������ ������������
$myrow7 = mysql_fetch_array($result7);

if ($myrow7['avatar'] == $ava) {//���� �� �����������, �� �� ������� ���, ���� � ��� ���� �������� �� ����.
$ava = 1;
}
else {unlink ($myrow7['avatar']);}//���� ������ ��� ����, �� ������� ���


}
else 
        {
		//� ������ �������������� �������, ������ ��������������� ���������
        exit ("Picture must be formatted <strong>JPG,GIF or PNG</strong>");
		}

}


$result4 = mysql_query("UPDATE users SET avatar='$avatar' WHERE login='$old_login'",$db);//��������� ������ � ����
$result5 = mysql_query("UPDATE users SET fullscan='$delfull' WHERE login='$old_login'",$db);
if ($result4=='TRUE') {//���� �����, �� ���������� �� ������ ���������
echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=visasup.php'></head><body>Saccesfully! </body></html>";}

      } 
?>