<?php

if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //������� ��������� ������������� ����� � ���������� $login, ���� �� ������, �� ���������� ����������
if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
//������� ��������� ������������� ������ � ���������� $password, ���� �� ������, �� ���������� ����������
if (isset($_POST['code'])) { $code = $_POST['code']; if ($code == '') { unset($code);} } //������� ��������� ������������� �������� ��� � ���������� $code, ���� �� ������, �� ���������� ����������

if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } //������� ��������� ������������� e-mail, ���� �� ������, �� ���������� ����������


if (empty($login) or empty($password)or empty($code) or empty($email)) //���� ������������ �� ���� ����� ��� ������, �� ������ ������ � ������������� ������
{
exit ("You do not have entered all the information, go back and fill in all fields!"); //������������� ���������� ���������

}


function generate_code() //��������� �������, ������������ ���
{
                
    $hours = date("H"); // ���       
    $minuts = substr(date("H"), 0 , 1);// ������ 
    $mouns = date("m");    // �����             
    $year_day = date("z"); // ���� � ����

    $str = $hours . $minuts . $mouns . $year_day; //������� ������
    $str = md5(md5($str)); //������ ������� � md5
	$str = strrev($str);// ������ ������
	$str = substr($str, 3, 6); // ��������� 6 ��������, ������� � 3
	// ��� ������� �� ����� ��������� ������ ��������, ��� ���, ���� ��������� ������, ����� ������ �������� ��� ��� ������������, �� � ������ �� ����� ������.
	

    $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
    srand ((float)microtime()*1000000);
    shuffle ($array_mix);
	//��������� ������������, ����, ����� �� �����!!!
    return implode("", $array_mix);
}

function chec_code($code) //��������� ���
{
    $code = trim($code);//������� �������

    $array_mix = preg_split ('//', generate_code(), -1, PREG_SPLIT_NO_EMPTY);
    $m_code = preg_split ('//', $code, -1, PREG_SPLIT_NO_EMPTY);

    $result = array_intersect ($array_mix, $m_code);
if (strlen(generate_code())!=strlen($code))
{
    return FALSE;
}
if (sizeof($result) == sizeof($array_mix))
{
    return TRUE;
}
else
{
    return FALSE;
}
}

// ����� ��������� ���������, ������� �� ������������ ������ ���, �� ������ ������, � ���������� ������
if (!chec_code($_POST['code']))
{
exit ("You have entered the wrong code in the image."); //������������� ���������� ���������
}


//���� ����� � ������ �������,�� ������������ ��, ����� ���� � ������� �� ��������, ���� �� ��� ���� ����� ������
$login = stripslashes($login);
$login = htmlspecialchars($login);

$password = stripslashes($password);
$password = htmlspecialchars($password);

//������� ������ �������
$login = trim($login);
$password = trim($password);


// ���������� �����********************************************

//��������� �������� �� ����� ������ � ������
if (strlen($login) < 3 or strlen($login) > 15) {

exit ("Login must be at least 3 characters and no more than 15."); //������������� ���������� ���������

}
if (strlen($password) < 3 or strlen($password) > 15) {

exit ("The password must be at least 3 characters and no more than 15."); //������������� ���������� ���������

}

if (empty($_FILES['fupload']['name']))
{
//���� ���������� �� ���������� (������������ �� �������� �����������),�� ����������� ��� ������� �������������� �������� � �������� "��� �������"
$avatar = "avatars/net-avatara.jpg"; //������ ���������� net-avatara.jpg ��� ����� � ����������
}

else 
{
//����� - ��������� ����������� ������������
$path_to_90_directory = 'avatars/';//�����, ���� ����� ����������� ��������� �������� � �� ������ �����

	
if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//�������� ������� ��������� �����������
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
unlink ($delfull);//������� �������� ������������ �����������, �� ��� ������ �� �����. ������� ���� - �������� ���������.
}
else 
         {
		 //� ������ �������������� �������, ������ ��������������� ���������
         
exit ("Picture must be formatted <strong>JPG, GIF or PNG</strong>"); //������������� ���������� ���������

	     }
//����� �������� �������� � ���������� ���������� $avatar ������ ����������� ���
}

$password = md5($password);//������� ������

$password = strrev($password);// ��� ���������� ������� ������

$password = $password."b3p6f";
//����� �������� ��������� ����� �������� �� �����, ��������, ������ "b3p6f". ���� ���� ������ ����� ���������� ������� ������� � ���� �� ������� ���� �� md5,�� ���� ������ �������� �� ������. �� ������� ������� ������ �������, ����� � ������ ������ ��� � ��������.

//��� ���� ���������� ��������� ����� ���� password � ����. ������������� ������ ����� ��������� ������� �������� �������.


// �������� �����********************************************

// ����� ���� ��� �� ������ ����� ������,�� ���������� �������� ��������� � ������ � ����. 

// ������������ � ����
include ("bd.php");// ���� bd.php ������ ���� � ��� �� �����, ��� � ��� ���������, ���� ��� �� ���, �� ������ �������� ���� 

// �������� �� ������������� ������������ � ����� �� �������
$result = mysql_query("SELECT id FROM users WHERE login='$login'",$db);
$myrow = mysql_fetch_array($result);
if (!empty($myrow['id'])) {

exit ("Sorry, you entered login is already registered. Please enter a different username."); //������������� ���������� ���������

}

// ���� ������ ���, �� ��������� ������
$result2 = mysql_query ("INSERT INTO users (login,password,avatar,email,date) VALUES('$login','$password','$avatar','$email',NOW())");

// ���������, ���� �� ������
if ($result2=='TRUE')
{
	
$my_str='hotmail';	
$my_str2='outlook';	
$my_str3='gov';

$pos1 = strpos($email, $my_str);
$pos2 = strpos($email, $my_str2);
$pos3 = strpos($email, $my_str3);

	if ($pos1==TRUE) {
		$result4 = mysql_query ("INSERT INTO `ind_rass` (`key`,`email`) VALUES ('$login','$email')",$db);
		$result5 = mysql_query("UPDATE users SET activation=1 WHERE login='$login'",$db);
		if ($result5=='TRUE') {
		 exit ("Your account has been successfully activated. <a href='index.php'>Back to log in page</a>."); }
					}
					
	if ($pos3==TRUE) {
		$result4 = mysql_query ("INSERT INTO `ind_rass` (`key`,`email`) VALUES ('$login','$email')",$db);
		$result5 = mysql_query("UPDATE users SET activation=1 WHERE login='$login'",$db);
		if ($result5=='TRUE') {
		 exit ("Your account has been successfully activated. <a href='index.php'>Back to log in page</a>."); }
					}				

	  
	if ($pos2==TRUE) {
		$result4 = mysql_query ("INSERT INTO `ind_rass` (`key`,`email`) VALUES ('$login','$email')",$db);
		$result5 = mysql_query("UPDATE users SET activation=1 WHERE login='$login'",$db);
		if ($result5=='TRUE') {
		exit ("Your account has been successfully activated. <a href='index.php'>Back to log in page</a>."); }
								}

$result3 = mysql_query ("SELECT id FROM users WHERE login='$login'",$db);//��������� ������������� ������������. ��������� ��� � ��� � ����� ���������� ��� ���������, ���� ���� ���������� ��������������� ���� �� �����.
$myrow3 = mysql_fetch_array($result3);
$activation = md5($myrow3['id']).md5($login);//��� ��������� ��������. ��������� ����� ������� md5 ������������� � �����. ����� ��������� ������������ ���� �� ������ ��������� ������� ����� �������� ������.

$to  = ''.$email.''; // �������� �������� �� �������
$subject = 'Registration';//���� ���������
$message = '
<html>
<head>
  <title>Registration on the website emecs-sc2016.com</title>
</head>
<body>
  <p>Welcome!</p>
 <p> 
  <table>
    <tr>
      <td>Your login: '.$login.'</td>
    </tr>
    <tr>
      <td>Click this link to activate your account: http://emecs-sc2016.com//activation.php?login='.$login.'&code='.$activation.'</td>
    </tr>
    <tr>
      <td>Sinserelly yours,</td>
    </tr>
	<tr>
      <td>Web-admin emecs-sc2016.com</td>
    </tr>
  </table> 
  </p>
</body>
</html>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: EMECS11 SeaCoasts XXVI <foxy@rshu.ru>' . "\r\n";
/* $headers .= 'Bcc: liiss.ru@gmail.com' . "\r\n";
$headers .= 'Cc: '.$email.'' . "\r\n";   */


if (mail($to, $subject, $message, $headers)) { 
    echo "Messege accepted for delivery. Click on the link in the email to confirm your registration. (if mail did not come, check the spam folder. In some cases, beyond our control, the letter could go within the hour.). If you have not received a confirmation e-mail, use the <a href='/form/support.php'>technical support form</a> with the subject \"Confirm my profile\". <a href='index.php'>Back to log in page</a>"; 
} 

else { 
    echo "Some error happen... <a href='/form/support.php'>technical support form</a>"; 
} //���������� ��������� 
}


else {
exit ("Error! You are not registred."); //������������� ���������� ���������

     }
?>