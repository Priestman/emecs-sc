<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (isset($_POST['upd']))//Если существует 
      {
$upd = $_POST['upd'];
$result5 = mysql_query("UPDATE co_authors SET upd='$upd' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>";	}
	  }

if (isset($_POST['title']))//Если существует 
      {
$title = $_POST['title'];
$title   = mysql_real_escape_string($title);
$result = mysql_query("SELECT upd,id FROM co_authors WHERE id = upd",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE co_authors SET title='$title' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE co_authors SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>";		}
	  }

if (isset($_POST['full_name']))//Если существует 
      {
$full_name = $_POST['full_name'];
$full_name   = mysql_real_escape_string($full_name);
$result = mysql_query("SELECT upd,id FROM co_authors WHERE id = upd",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE co_authors SET full_name='$full_name' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE co_authors SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>";		}
	  }

if (isset($_POST['country']))//Если существует 
      {
$country = $_POST['country'];
$country   = mysql_real_escape_string($country);
$result = mysql_query("SELECT upd,id FROM co_authors WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE co_authors SET country='$country' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE co_authors SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>";		}
	  }

if (isset($_POST['organization']))//Если существует 
      {
$organization = $_POST['organization'];
$organization   = mysql_real_escape_string($organization);
$result = mysql_query("SELECT upd,id FROM co_authors WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE co_authors SET organization='$organization' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE co_authors SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>";		}
	  }

if (isset($_POST['degree']))//Если существует 
      {
$degree = $_POST['degree'];
$degree   = mysql_real_escape_string($degree);
$result = mysql_query("SELECT upd,id FROM co_authors WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE co_authors SET degree='$degree' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE co_authors SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>";		}
	  }
	  

if (isset($_POST['emeil']))//Если существует 
      {
$emeil = $_POST['emeil'];
$emeil   = mysql_real_escape_string($emeil);
$result = mysql_query("SELECT upd,id FROM co_authors WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE co_authors SET emeil='$emeil' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE co_authors SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>";		}
	  }	  
	  
	  if (isset($_POST['num_pp']))//Если существует 
      {
$num_pp = $_POST['num_pp'];
$result = mysql_query("SELECT upd,id FROM co_authors WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("UPDATE co_authors SET num_pp='$num_pp' WHERE id='$upd'",$db);
$result6 = mysql_query("UPDATE co_authors SET upd='0' WHERE id='$upd'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>";		}
	  }	 
	  
if (isset($_POST['del']))//Если существует 
      {
$del = $_POST['del']; 		  
$result = mysql_query("SELECT upd,id FROM co_authors WHERE `id` = `upd`",$db); 
$myrow = mysql_fetch_array($result);
$upd = $myrow['upd'];
$id = $myrow['id'];
$result5 = mysql_query("DELETE FROM `co_authors` WHERE `id`='$upd' or `id`='$del'",$db);
if ($result5=='TRUE') {
	echo "<html><head><meta http-equiv='Refresh' content='0.1; URL=vib_soavt.php'></head><body>Ok! </body></html>"; }
	  } 

	  
?>