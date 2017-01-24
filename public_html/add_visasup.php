<?php
session_start();

include ("bd.php");
$login = $_SESSION['login'];
$password = $_SESSION['password'];

$result = mysql_query("SELECT * FROM `reg_users` WHERE `key` = '$login'",$db);
$myrow = mysql_fetch_array($result);

$result2 = mysql_query("SELECT * FROM `visa` WHERE `key` = '$login'",$db);
$myrow2 = mysql_fetch_array($result2);

$key = $login;
$full_name_key = $myrow['full_name'];

if ($_POST) //Условие будет выполнено, если произведен POST-запрос к скрипту.
{ 

	$full_name_usr = $_POST['full_name_usr'];
	$full_name_usr = mysql_real_escape_string($full_name_usr);

	$passport_id = $_POST['passport_id'];
	$passport_id = mysql_real_escape_string($passport_id);

	$valid_to = $_POST['valid_to'];

	$located = $_POST['located'];
	$located = mysql_real_escape_string($located);

	$zip_addr = $_POST['zip_addr'];
	$zip_addr = mysql_real_escape_string($zip_addr); 

	$visasup = $_POST['visasup'];


	if (empty($full_name_usr))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field Full name"); //останавливаем выполнение сценариев
} 
	if (empty($passport_id))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field Passport Id"); //останавливаем выполнение сценариев
} 
	if (empty($valid_to))
{
exit ("I'm sorry, but you must fill in all fields. You have not filled the field Expiry Date"); //останавливаем выполнение сценариев
}

if (empty($located))
{
	$located = $myrow2['located'];
	$located = htmlspecialchars($located);
}

if (empty($zip_addr))
{
	$zip_addr = $myrow2['zip_addr'];
	$zip_addr = htmlspecialchars($zip_addr);
}

$path_to_90_directory = 'scans/accomp/';//папка, куда будет загружаться начальная картинка и ее сжатая копия

	
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

$w = 500;  // квадратная 90x90. Можно поставить и другой размер.

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

$scan = $path_to_90_directory.$date.".jpg";//заносим в переменную путь до аватара.

$full_scan = $path_to_90_directory.$filename;

///unlink ($delfull);//удаляем оригинал загруженного изображения, он нам больше не нужен. Задачей было - получить миниатюру.

}
else 
        {
		//в случае несоответствия формата, выдаем соответствующее сообщение
        exit ("Picture must be formatted <strong>JPG,GIF or PNG</strong>");
		}

$sql1 = mysql_query("INSERT INTO `add_visasup` (`key`,`full_name_key`,`full_name_usr`,`valid_to`,`passport_id`, `located`, `zip_addr`,`scan`,`full_scan`,`visasup`) VALUES ('$key','$full_name_key','$full_name_usr','$valid_to','$passport_id','$located', '$zip_addr', '$scan','$full_scan','$visasup')",$db) or die (mysql_error());

if ($sql1 == TRUE)
{
	echo "<html><head><meta http-equiv='Refresh' content='0; URL=totalfee.php#openModal2'></head><body>Data changed!</body></html> ";
}

}

?>