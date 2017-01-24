<?php
session_start();
include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE login='$login' AND password='$password'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //Если не действительны, то закрываем доступ
    exit("Entrance to this page is allowed only for registered users!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Entrance to this page is allowed only for registered users!"); }

$old_login = $_SESSION['login']; //Старый логин нам пригодиться
$id = $_SESSION['id'];//идентификатор пользователя тоже нужен
$ava = "avatars/net-avatara.jpg";//стандартное изображение будет кстати

////////////////////////
////////ИЗМЕНЕНИЕ ЛОГИНА
////////////////////////

if (isset($_POST['login']))//Если существует логин
      {
$login = $_POST['login'];
$login = stripslashes($login); $login = htmlspecialchars($login); $login = trim($login);//удаляем все лишнее
if ($login == '') { exit("You have not entered login");} //Если логин пустой, то останавливаем сценарий

if (strlen($login) < 3 or strlen($login) > 15) {//проверяем длину
exit ("Login must be at least 3 characters and no more than 15."); //останавливаем выполнение сценариев
}

// проверка на существование пользователя с таким же логином
$result = mysql_query("SELECT id FROM users WHERE login='$login'",$db);
$myrow = mysql_fetch_array($result);
if (!empty($myrow['id'])) {
exit ("Sorry, you entered login is already registered. Please enter a different username."); //останавливаем выполнение сценариев
}

$result4 = mysql_query("UPDATE users SET login='$login' WHERE login='$old_login'",$db);//обновляем в базе логин пользователя
if ($result4=='TRUE') {//если выполнено верно, то обновляем все сообщения, которые отправлены ему
mysql_query("UPDATE messages SET author='$login' WHERE author='$old_login'",$db);
$_SESSION['login'] = $login;//Обновляем логин в сессии
if (isset($_COOKIE['login'])) {
setcookie("login", $login, time()+9999999);//Обновляем логин в куках
}

echo "<html><head><meta http-equiv='Refresh' content='5; URL=page.php?id=".$_SESSION['id']."'></head><body>Your login changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>";}//отправляем пользователя назад

      } 

//////////////////////////////////////
////////АНКЕТА.Завершение регистрации
//////////////////////////////////////	  

						
/* if (isset($_POST["full_name"])) {
    //Вставляем данные, подставляя их в запрос
    $sql = mysql_query("INSERT INTO `reg_users` (`key`,`full_name`, `country`, `birth`, `degree`, `gild`, `address`, `position`, `work_tel`, `mob_tel`) 
                        VALUES ('$login','".$_POST['full_name']."','".$_POST['country']."','".$_POST['birth']."','".$_POST['degree']."','".$_POST['gild']."','".$_POST['address']."','".$_POST['position']."','".$_POST['work_tel']."','".$_POST['mob_tel']."')");						
					
    //Если вставка прошла успешно
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
////////АНКЕТА. Изменение данных
//////////////////////////////////////		



////////////СКАН/////////
/* if (isset($_POST['upload']))
      {
$uploaddir = 'scans/';
// это папка, в которую будет загружаться картинка
$apend=date('YmdHis').rand(100,1000).'.jpg'; 
// это имя, которое будет присвоенно изображению 
$uploadfile = "$uploaddir$apend"; 
//в переменную $uploadfile будет входить папка и имя изображения

// В данной строке самое важное - проверяем загружается ли изображение (а может вредоносный код?)
// И проходит ли изображение по весу. В нашем случае до 512 Кб
if(($_FILES['userfile']['type'] == 'image/gif' || $_FILES['userfile']['type'] == 'image/jpeg' || $_FILES['userfile']['type'] == 'image/png') && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size']<=512000)) 
{ 
// Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб 
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
   { 
   //Здесь идет процесс загрузки изображения 
   $size = getimagesize($uploadfile); 
   // с помощью этой функции мы можем получить размер пикселей изображения 
     if ($size[0] < 501 && $size[1]<1501) 
     { 
 
$sql4 = mysql_query("INSERT INTO `docs` (`key`,`scan`) VALUES ('$login','$uploadfile')");
 
     // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте 
     echo "File upload. The path to the file: <b>http:/emecs-sc2016.com/".$uploadfile."</b>"; 
     } else {
     echo "Upload images exceeds the permissible limits (the width of not more than - 500; height of not more than 1500)"; 
     unlink($uploadfile); 
     // удаление файла 
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
////////ИЗМЕНЕНИЕ ПАРОЛЯ
////////////////////////

else if (isset($_POST['password']))//Если существует пароль
      {
$password = $_POST['password'];
$password = stripslashes($password);$password = htmlspecialchars($password);$password = trim($password);//удаляем все лишнее
if ($password == '') { exit("You are not logged in");} //если пароль не введен, то выдаем ошибку

if (strlen($password) < 3 or strlen($password) > 15) {//проверка на количество символов
exit ("The password must be at least 3 characters and no more than 15."); //останавливаем выполнение сценариев
}

$password = md5($password);//шифруем пароль
$password = strrev($password);// для надежности добавим реверс
$password = $password."b3p6f";

//При этом необходимо увеличить длину поля password в базе. Зашифрованный пароль может получится гораздо большего размера.


$result4 = mysql_query("UPDATE users SET password='$password' WHERE login='$old_login'",$db);//обновляем пароль
if ($result4=='TRUE') {//если верно, то обновляем его в сессии
$_SESSION['password'] = $password;

if (isset($_COOKIE['password'])) {
setcookie("password",$_POST['password'], time()+9999999);//Обновляем пароль в куках, если они есть
}


echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=page.php?id=".$_SESSION['id']."'></head><body>Your password has been changed! You will be moved after 5 seconds. If you do not want to wait, <a href='page.php?id=".$_SESSION['id']."'>click here</a></body></html>";}//отправляем обратно на его страницу

      } 




////////////////////////
////////ИЗМЕНЕНИЕ АВАТАРЫ
////////////////////////

else if (isset($_FILES['fupload']['name'])) //отправлялась ли переменная
      {

if (empty($_FILES['fupload']['name']))
{
//если переменная пустая (пользователь не отправил изображение),то присваиваем ему заранее приготовленную картинку с надписью "нет аватара"
$avatar = "avatars/net-avatara.jpg"; //можете нарисовать net-avatara.jpg или взять в исходниках
$result7 = mysql_query("SELECT avatar FROM users WHERE login='$old_login'",$db);//извлекаем текущий аватар
$myrow7 = mysql_fetch_array($result7);
if ($myrow7['avatar'] == $ava) {//если аватар был стандартный, то не удаляем его, ведь у на одна картинка на всех.
$ava = 1;
}
else {unlink ($myrow7['avatar']);}//если аватар был свой, то удаляем его, затем поставим стандарт
}

else 
{
//иначе - загружаем изображение пользователя для обновления
$path_to_90_directory = 'avatars/';//папка, куда будет загружаться начальная картинка и ее сжатая копия

	
if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//проверка формата исходного изображения
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

///unlink ($delfull);//удаляем оригинал загруженного изображения, он нам больше не нужен. Задачей было - получить миниатюру.

$result7 = mysql_query("SELECT avatar FROM users WHERE login='$old_login'",$db);//извлекаем текущий аватар пользователя
$myrow7 = mysql_fetch_array($result7);

if ($myrow7['avatar'] == $ava) {//если он стандартный, то не удаляем его, ведь у нас одна картинка на всех.
$ava = 1;
}
else {unlink ($myrow7['avatar']);}//если аватар был свой, то удаляем его


}
else 
        {
		//в случае несоответствия формата, выдаем соответствующее сообщение
        exit ("Picture must be formatted <strong>JPG,GIF or PNG</strong>");
		}

}


$result4 = mysql_query("UPDATE users SET avatar='$avatar' WHERE login='$old_login'",$db);//обновляем аватар в базе
$result5 = mysql_query("UPDATE users SET fullscan='$delfull' WHERE login='$old_login'",$db);
if ($result4=='TRUE') {//если верно, то отправляем на личную страничку
echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=visasup.php'></head><body>Saccesfully! </body></html>";}

      } 
?>