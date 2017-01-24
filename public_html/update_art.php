<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (isset($_POST['upd']))//Если существует 
      {
$upd = $_POST['upd'];
$result5 = mysql_query("UPDATE reports SET upd='$upd' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Ok! </body></html>"; }
	  }

if (isset($_POST['title']))//Если существует 
      {
$title = $_POST['title'];
$title   = mysql_real_escape_string($title);
$result = mysql_query("SELECT upd,id FROM reports WHERE id = upd",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE reports SET title='$title' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE reports SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Ok! </body></html>"; }
	  }

if (isset($_POST['section']))//Если существует 
      {
$section = $_POST['section'];
$result = mysql_query("SELECT upd,id FROM reports WHERE id = upd",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE reports SET section='$section' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE reports SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Ok! </body></html>"; }
	  }

if (isset($_POST['form']))//Если существует 
      {
$form = $_POST['form'];
$result = mysql_query("SELECT upd,id FROM reports WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE reports SET form='$form' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE reports SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Ok! </body></html>"; }
	  }

if (isset($_POST['annotation']))//Если существует 
      {
$annotation = $_POST['annotation'];
$annotation   = mysql_real_escape_string($annotation);
$result = mysql_query("SELECT upd,id FROM reports WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE reports SET annotation='$annotation' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE reports SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Ok! </body></html>"; }
	  }

if (isset($_POST['article']))//Если существует 
      {
$article = $_POST['article'];
$result = mysql_query("SELECT upd,id FROM reports WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE reports SET article='$article' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE reports SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Ok! </body></html>"; }
	  }
	  

if (isset($_POST['co_authors']))//Если существует 
      {
$co_authors = $_POST['co_authors'];
$result = mysql_query("SELECT upd,id FROM reports WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE reports SET co_authors='$co_authors' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE reports SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Ok! </body></html>"; }
	  } 
	  
if (isset($_POST['del']))//Если существует 
      {
		  $upd = $_POST['upd'];
$result5 = mysql_query("UPDATE reports SET upd='$upd' WHERE id='$upd'",$db);
$del = $_POST['del']; 		  
$result = mysql_query("SELECT upd,id FROM reports WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("DELETE FROM `reports` WHERE `id`='$upd' or `id`='$del'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=update_article.php'></head><body>Ok! </body></html>"; }
	  } 

if (isset($_FILES['fupload']['name']))//Если существует 
      {
		  
		 /*papers*/
		 
$result7 = mysql_query("SELECT `paper` FROM `reports` WHERE `id` = `upd`",$db);//извлекаем текущий аватар
$myrow7 = mysql_fetch_array($result7);
		
		$old_filename = $myrow7['paper'];
		unlink ($old_filename);
		
		

$path_to_90_directory = 'papers/';//папка, куда будет загружаться начальная картинка и ее сжатая копия
if(preg_match('/[.](DOC)|(doc)|(DOCX)|(docx)$/',$_FILES['fupload']['name']))//проверка исходного формата 
{	
	 	 	
 		$filename = $_FILES['fupload']['name'];
		$source = $_FILES['fupload']['tmp_name'];
		
		$target = $path_to_90_directory . $filename;
		move_uploaded_file($source, $target);//загрузка оригинала в папку $path_to_90_directory

		/* imagejpeg($dest, $path_to_90_directory.$login.".pdf");//сохраняем в нужную папку, именем будет текущее время. Сделано, чтобы у аватаров не было одинаковых имен. */
		
		$paper = $path_to_90_directory.$filename;//заносим в переменную путь до аватара.
		
}
else 
        {
		//в случае несоответствия формата, выдаем соответствующее сообщение
        exit ("Must be formatted <strong>.doc (.docx)</strong>");
		}
		
/*papers*/
		  
		 $upd = $_POST['upd'];
$result5 = mysql_query("UPDATE `reports` SET `upd`='$upd' WHERE id='$upd'",$db); 	  
$result = mysql_query("SELECT `upd`,`id` FROM `reports` WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE `reports` SET `paper`='$paper' WHERE `id`='$upd'",$db);
$result6 = mysql_query("UPDATE `reports` SET `upd`='0' WHERE `id`='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='3; URL=update_article.php'></head><body>Successfully!</body></html>"; }
	  } 	 	  

?>