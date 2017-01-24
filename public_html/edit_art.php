<?php
// вс¤ процедура работает на сесси¤х. »менно в ней хран¤тс¤ данные пользовател¤, пока он находитс¤ на сайте. ќчень важно запустить их в самом начале странички!!!
session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
if (isset($_GET['id'])) {$id =$_GET['id']; } //id "хоз¤ина" странички
else
{ exit("You sewed a page without an argument!");} //если не указали id, то выдаем ошибку
if (!preg_match("|^[\d]+$|", $id)) {
exit("<p>Invalid request format! Please check the URL</p>");//если id не число, то выдаем ошибку
}

if (isset($_COOKIE['auto']) and isset($_COOKIE['key']))
{//если есть необходимые переменные
	if ($_COOKIE['auto'] == 'yes') { // если пользователь желает входить автоматически, то запускаем сессии
		  
		  $_SESSION['key']=$_COOKIE['key'];//сессия с логином
	}
}


$result = mysql_query("SELECT * FROM `reports` WHERE `id` = '$id'",$db); 
$myrow = mysql_fetch_array($result);//»звлекаем все данные пользовател¤ с данным id
$ids = $myrow['id'];
$login = $myrow['key'];

$titles = $myrow['title'];
$titles = mysql_real_escape_string($titles);
$result2 = mysql_query("SELECT * FROM co_authors WHERE `title`='$titles' AND `key`='$login' ORDER BY num_pp",$db); 
$myrow2 = mysql_fetch_array($result2);

$result3 = mysql_query("SELECT full_name FROM reg_users WHERE `key`='$login'",$db); 
$myrow3 = mysql_fetch_array($result3);
?>
<html>
<head>
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />

<script>
function limitText(limitField, limitCount, limitNum) { if (limitField.value.length > limitNum) { limitField.value = limitField.value.substring(0, limitNum); } else { limitCount.value = limitNum - limitField.value.length; } }
</script>

<title><?php echo $myrow['key']; ?></title>
</head>
<body>
<h2>User: "<?php echo $myrow['key']; ?>"</h2>
<a href='http://emecs-sc2016.com/'>Back to home emecs-sc2016.com</a>
 <br>
<div class="tab"> 
<b>
<p style="font-size: 28px; margin:0px;">	
Title: <?php echo htmlspecialchars ($myrow['title']); ?> </p>
<p style="color: green; font-size: 28px;">
Paper: <?php if ($myrow['paper'] != NULL) {printf("Uploaded");} else {printf("Not uploaded");} ?> 
</p>
Section: <?php echo $myrow['section']; ?><br>
Form of presentation: <?php echo $myrow['form']; ?><br>
Abstract: <?php echo htmlspecialchars($myrow['annotation']); ?><br>
Main author: <?php echo htmlspecialchars($myrow3['full_name']); ?><br>
Co-authors: <?php
do
{
//выводим их в цикле
printf($myrow2['full_name']);printf(', ');

}
while($myrow2 = mysql_fetch_array($result2));

?>
</div>


<br>
<div class="box">
<?php
print <<<HERE
<header id="header">
<nav id="nav">
<ul>
<li><a href='info.php?id=$_SESSION[id]'>Information</a></li>
<li><a href='all.php'>Registered participants</a></li>
<li><a href='index.php'>Abstract and paper submission</a></li>
<li><a href='vib_soavt.php'>Coauthors list</a></li>
<li><a href='visasup.php'>Visa information</a></li>
<li><a href='all_users.php'>Visa support list</a></li>
<li><a href='totalfee.php'>Total registration fee</a></li>
<li><a href='exit.php'>Exit</a></li>
<li><a href='form/support.php'>Tech support</a></li>
</ul>
</nav>
</header>

HERE;
//выше вывели меню


if ($myrow['login'] == $login) {
//≈сли страничка принадлежит вошедшему, то предлагаем изменить данные и выводим личные сообщения

print <<<HERE

<form action='update_art.php' method='post' align = "left">
Title:<br>
<input name='title' type='text' size='50' >
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_art.php' method='post' align = "left">
Enter section:<br>

<input name="section" type="radio" value="Coastal systems and their dynamics (from coast to water and from water to coast">Coastal systems and their dynamics (from coast to water and from water to coast<br> 
<input name="section" type="radio" value="Coastal erosion and dynamical processes in the nearshore zone">Coastal erosion and dynamical processes in the nearshore zone <br> 
<input name="section" type="radio" value="GIS & marine spatial planning">GIS & marine spatial planning <br>
<input name="section" type="radio" value="Climate change in the changing world. Coastal adaptation to climate change">Climate change in the changing world. Coastal adaptation to climate change <br> 
<input name="section" type="radio" value="Construction and exploitation of hydraulic engineering structures and dredging in the coastal areas">Construction and exploitation of hydraulic engineering structures and dredging in the coastal areas <br>  
<input name="section" type="radio" value="Study and monitoring of coastal and marine ecosystems">Study and monitoring of coastal and marine ecosystems <br>  
<input name="section" type="radio" value="Approaches to and issues of processes in the coastal areas modelling and monitoring">Approaches to and issues of processes in the coastal areas modelling and monitoring <br>   
<input name="section" type="radio" value="Interactions between coastal zone and the open sea: impact on the ecosystems">Interactions between coastal zone and the open sea: impact on the ecosystems <br>   
<input name="section" type="radio" value="Ecological sensitivity of coastal areas: anthropogenic loads and natural disasters">Ecological sensitivity of coastal areas: anthropogenic loads and natural disasters <br>   
<input name="section" type="radio" value="ICZM case study and new experience">ICZM case study and new experience <br>   
<input name="section" type="radio" value="Sustainable use and development of coastal resources: effective management and approaches">Sustainable use and development of coastal resources: effective management and approaches <br>  	
<input name="section" type="radio" value="Legal and political issues of enclosed coastal seas management">Legal and political issues of enclosed coastal seas management <br>
<input name="section" type="radio" value="Human resource and indigenous dimension of enclosed coastal seas management">Human resource and indigenous dimension of enclosed coastal seas management <br>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_art.php' method='post' align = "left">
The desired form of presentation:
<input name="form" type="radio" value="oral">Oral
<input name="form" type="radio" value="poster">Poster<br> <br>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_art.php' method='post' align = "left">
<p> Enter abstract (max 1650 characters, including spaces)<br></p>
<p><textarea name="annotation" cols="80" rows="20" title="annotation" onKeyDown="limitText(this,this.form.count,1500);"
 onKeyUp="limitText(this,this.form.count,1650);" ></textarea></p>
<input readonly type="text" name="count" size="3" value="1650"><br>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>


<form action='update_art.php' method='post' align="left" align = "left">
<input name='del' type='hidden' value='$ids'>
<input name='upd' type='hidden' value='$ids'>
<input type='submit' name='submit' value='Delete this paper'>
</form>

<a href='vib_soavt.php'>If yor want to change sequence number of authors, click here</a><br>

HERE;
///////////

					
}

else
{
//если страничка чужа¤, то выводим только некторые данные и форму дл¤ отправки личных сообщений

if ($myrow['assepted'] != 0) {
	
print <<<HERE
<h2>Upload paper</h2>
<form action="update_art.php" align = "center" method="post" enctype="multipart/form-data">	
<label>Your paper in .doc (.docx) format, size should not exceed <b>32 Mb.</b><br>
<a href="files/Conference_rules.pdf" target="blanck">Conference paper rules</a><br>
<a href="files/template_paper.doc">Download sample for filling (.doc)</a><br><br></label>
<input type="FILE" name="fupload"><br><br>
<input name='upd' type='hidden' value='$ids' >
<input name="submit" type="submit" value="Submit">
</form>

HERE;
	
}

print <<<HERE

<h3>Edit article</h3>

<form action='update_art.php' method='post' align = "left">
Title:<br>
<input name='title' type='text' size='50' >
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_art.php' method='post' align = "left">
Enter section:<br>

<input name="section" type="radio" value="Coastal systems and their dynamics (from coast to water and from water to coast">Coastal systems and their dynamics (from coast to water and from water to coast<br> 
<input name="section" type="radio" value="Coastal erosion and dynamical processes in the nearshore zone">Coastal erosion and dynamical processes in the nearshore zone <br> 
<input name="section" type="radio" value="GIS & marine spatial planning">GIS & marine spatial planning <br>
<input name="section" type="radio" value="Climate change in the changing world. Coastal adaptation to climate change">Climate change in the changing world. Coastal adaptation to climate change <br> 
<input name="section" type="radio" value="Construction and exploitation of hydraulic engineering structures and dredging in the coastal areas">Construction and exploitation of hydraulic engineering structures and dredging in the coastal areas <br>  
<input name="section" type="radio" value="Study and monitoring of coastal and marine ecosystems">Study and monitoring of coastal and marine ecosystems <br>  
<input name="section" type="radio" value="Approaches to and issues of processes in the coastal areas modelling and monitoring">Approaches to and issues of processes in the coastal areas modelling and monitoring <br>   
<input name="section" type="radio" value="Interactions between coastal zone and the open sea: impact on the ecosystems">Interactions between coastal zone and the open sea: impact on the ecosystems <br>   
<input name="section" type="radio" value="Ecological sensitivity of coastal areas: anthropogenic loads and natural disasters">Ecological sensitivity of coastal areas: anthropogenic loads and natural disasters <br>   
<input name="section" type="radio" value="ICZM case study and new experience">ICZM case study and new experience <br>   
<input name="section" type="radio" value="Sustainable use and development of coastal resources: effective management and approaches">Sustainable use and development of coastal resources: effective management and approaches <br>  	
<input name="section" type="radio" value="Legal and political issues of enclosed coastal seas management">Legal and political issues of enclosed coastal seas management <br>
<input name="section" type="radio" value="Human resource and indigenous dimension of enclosed coastal seas management">Human resource and indigenous dimension of enclosed coastal seas management <br>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_art.php' method='post' align = "left">
The desired form of presentation:
<input name="form" type="radio" value="oral">Oral
<input name="form" type="radio" value="poster">Poster<br> <br>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>

<form action='update_art.php' method='post' align = "left">
Enter abstract (max 1500 characters, including spaces)<br>
<p><textarea name="annotation" cols="80" rows="20" title="annotation" onKeyDown="limitText(this,this.form.count,1500);"
 onKeyUp="limitText(this,this.form.count,1500);" ></textarea></p>
<input readonly type="text" name="count" size="3" value="1500"><br>
<input name='upd' type='hidden' value='$ids' >
<input type='submit' name='submit' value='Change!'>
</form>


<form action='update_art.php' method='post' align="left" align = "left">
<input name='del' type='hidden' value='$ids'>
<input name='upd' type='hidden' value='$ids'>
<input type='submit' name='submit' value='Delete this paper'>
</form>

<a href='vib_soavt.php'>If yor want to change sequence number of authors, click here</a><br>

HERE;


/* print <<<HERE
<img alt='аватар' src='$myrow[avatar]'><br>
<form action='post.php' method='post'>
<br>
<h2>Send Your message:</h2>
<textarea cols='43' rows='4' name='text'></textarea><br>
<input type='hidden' name='poluchatel' value='$myrow[login]'>
<input type='hidden' name='id' value='$myrow[id]'>
<input type='submit' name='submit' value='Send'>
</form>
HERE;
 */
}

?>
</div>
</center>
</body>
</html>