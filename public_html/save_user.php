<?php

if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (isset($_POST['code'])) { $code = $_POST['code']; if ($code == '') { unset($code);} } //заносим введенный пользователем защитный код в переменную $code, если он пустой, то уничтожаем переменную

if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } //заносим введенный пользователем e-mail, если он пустой, то уничтожаем переменную


if (empty($login) or empty($password)or empty($code) or empty($email)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{
exit ("You do not have entered all the information, go back and fill in all fields!"); //останавливаем выполнение сценариев

}


function generate_code() //запускаем функцию, генерирующую код
{
                
    $hours = date("H"); // час       
    $minuts = substr(date("H"), 0 , 1);// минута 
    $mouns = date("m");    // месяц             
    $year_day = date("z"); // день в году

    $str = $hours . $minuts . $mouns . $year_day; //создаем строку
    $str = md5(md5($str)); //дважды шифруем в md5
	$str = strrev($str);// реверс строки
	$str = substr($str, 3, 6); // извлекаем 6 символов, начиная с 3
	// Вам конечно же можно постваить другие значения, так как, если взломщики узнают, каким именно способом это все генерируется, то в защите не будет смысла.
	

    $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
    srand ((float)microtime()*1000000);
    shuffle ($array_mix);
	//Тщательно перемешиваем, соль, сахар по вкусу!!!
    return implode("", $array_mix);
}

function chec_code($code) //проверяем код
{
    $code = trim($code);//удаляем пробелы

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

// после сравнения проверяем, пускать ли пользователя дальше или, он сделал ошибку, и остановить скрипт
if (!chec_code($_POST['code']))
{
exit ("You have entered the wrong code in the image."); //останавливаем выполнение сценариев
}


//если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
$login = stripslashes($login);
$login = htmlspecialchars($login);

$password = stripslashes($password);
$password = htmlspecialchars($password);

//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);


// дописываем новое********************************************

//добавляем проверку на длину логина и пароля
if (strlen($login) < 3 or strlen($login) > 15) {

exit ("Login must be at least 3 characters and no more than 15."); //останавливаем выполнение сценариев

}
if (strlen($password) < 3 or strlen($password) > 15) {

exit ("The password must be at least 3 characters and no more than 15."); //останавливаем выполнение сценариев

}

if (empty($_FILES['fupload']['name']))
{
//если переменной не существует (пользователь не отправил изображение),то присваиваем ему заранее приготовленную картинку с надписью "нет аватара"
$avatar = "avatars/net-avatara.jpg"; //можете нарисовать net-avatara.jpg или взять в исходниках
}

else 
{
//иначе - загружаем изображение пользователя
$path_to_90_directory = 'avatars/';//папка, куда будет загружаться начальная картинка и ее сжатая копия

	
if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//проверка формата исходного изображения
	 {	
	 	 	
		$filename = $_FILES['fupload']['name'];
		$source = $_FILES['fupload']['tmp_name'];	
		$target = $path_to_90_directory . $filename;
		move_uploaded_file($source, $target);//загрузка оригинала в папку $path_to_90_directory

	if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
	$im = imagecreatefromgif($path_to_90_directory.$filename) ; //если оригинал был в формате gif, то создаем изображение в этом же формате. Необходимо для последующего сжатия
	}
	if(preg_match('/[.](PNG)|(png)$/', $filename)) {
	$im = imagecreatefrompng($path_to_90_directory.$filename) ;//если оригинал был в формате png, то создаем изображение в этом же формате. Необходимо для последующего сжатия
	}
	
	if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
		$im = imagecreatefromjpeg($path_to_90_directory.$filename); //если оригинал был в формате jpg, то создаем изображение в этом же формате. Необходимо для последующего сжатия
	}
	
//СОЗДАНИЕ КВАДРАТНОГО ИЗОБРАЖЕНИЯ И ЕГО ПОСЛЕДУЮЩЕЕ СЖАТИЕ ВЗЯТО С САЙТА www.codenet.ru

// Создание квадрата 90x90
// dest - результирующее изображение 
// w - ширина изображения 
// ratio - коэффициент пропорциональности 

$w = 90;  // квадратная 90x90. Можно поставить и другой размер.

// создаём исходное изображение на основе 
// исходного файла и определяем его размеры 
$w_src = imagesx($im); //вычисляем ширину
$h_src = imagesy($im); //вычисляем высоту изображения

         // создаём пустую квадратную картинку 
         // важно именно truecolor!, иначе будем иметь 8-битный результат 
         $dest = imagecreatetruecolor($w,$w); 

         // вырезаем квадратную серединку по x, если фото горизонтальное 
         if ($w_src>$h_src) 
         imagecopyresampled($dest, $im, 0, 0,
                          round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                          0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 

         // вырезаем квадратную верхушку по y, 
         // если фото вертикальное (хотя можно тоже серединку) 
         if ($w_src<$h_src) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,
                          min($w_src,$h_src), min($w_src,$h_src)); 

         // квадратная картинка масштабируется без вырезок 
         if ($w_src==$h_src) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 
		 

$date=time(); //вычисляем время в настоящий момент.
imagejpeg($dest, $path_to_90_directory.$date.".jpg");//сохраняем изображение формата jpg в нужную папку, именем будет текущее время. Сделано, чтобы у аватаров не было одинаковых имен.

//почему именно jpg? Он занимает очень мало места + уничтожается анимирование gif изображения, которое отвлекает пользователя. Не очень приятно читать его комментарий, когда краем глаза замечаешь какое-то движение.

$avatar = $path_to_90_directory.$date.".jpg";//заносим в переменную путь до аватара.

$delfull = $path_to_90_directory.$filename; 
unlink ($delfull);//удаляем оригинал загруженного изображения, он нам больше не нужен. Задачей было - получить миниатюру.
}
else 
         {
		 //в случае несоответствия формата, выдаем соответствующее сообщение
         
exit ("Picture must be formatted <strong>JPG, GIF or PNG</strong>"); //останавливаем выполнение сценариев

	     }
//конец процесса загрузки и присвоения переменной $avatar адреса загруженной авы
}

$password = md5($password);//шифруем пароль

$password = strrev($password);// для надежности добавим реверс

$password = $password."b3p6f";
//можно добавить несколько своих символов по вкусу, например, вписав "b3p6f". Если этот пароль будут взламывать метадом подбора у себя на сервере этой же md5,то явно ничего хорошего не выйдет. Но советую ставить другие символы, можно в начале строки или в середине.

//При этом необходимо увеличить длину поля password в базе. Зашифрованный пароль может получится гораздо большего размера.


// дописали новое********************************************

// Далее идет все из первой части статьи,но необходимо дописать изменение в запрос к базе. 

// подключаемся к базе
include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

// проверка на существование пользователя с таким же логином
$result = mysql_query("SELECT id FROM users WHERE login='$login'",$db);
$myrow = mysql_fetch_array($result);
if (!empty($myrow['id'])) {

exit ("Sorry, you entered login is already registered. Please enter a different username."); //останавливаем выполнение сценариев

}

// если такого нет, то сохраняем данные
$result2 = mysql_query ("INSERT INTO users (login,password,avatar,email,date) VALUES('$login','$password','$avatar','$email',NOW())");

// Проверяем, есть ли ошибки
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

$result3 = mysql_query ("SELECT id FROM users WHERE login='$login'",$db);//извлекаем идентификатор пользователя. Благодаря ему у нас и будет уникальный код активации, ведь двух одинаковых идентификаторов быть не может.
$myrow3 = mysql_fetch_array($result3);
$activation = md5($myrow3['id']).md5($login);//код активации аккаунта. Зашифруем через функцию md5 идентификатор и логин. Такое сочетание пользователь вряд ли сможет подобрать вручную через адресную строку.

$to  = ''.$email.''; // обратите внимание на запятую
$subject = 'Registration';//тема сообщения
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
} //отправляем сообщение 
}


else {
exit ("Error! You are not registred."); //останавливаем выполнение сценариев

     }
?>