<?php
// âñÿ ïðîöåäóðà ðàáîòàåò íà ñåññèÿõ. Èìåííî â íåé õðàíÿòñÿ äàííûå ïîëüçîâàòåëÿ, ïîêà îí íàõîäèòñÿ íà ñàéòå. Î÷åíü âàæíî çàïóñòèòü èõ â ñàìîì íà÷àëå ñòðàíè÷êè!!!
session_start();

include ("bd.php");// ôàéë bd.php äîëæåí áûòü â òîé æå ïàïêå, ÷òî è âñå îñòàëüíûå, åñëè ýòî íå òàê, òî ïðîñòî èçìåíèòå ïóòü 

if (isset($_COOKIE['auto']) and isset($_COOKIE['login']) and isset($_COOKIE['password']))
{//åñëè åñòü íåîáõîäèìûå ïåðåìåííûå
	if ($_COOKIE['auto'] == 'yes') { // åñëè ïîëüçîâàòåëü æåëàåò âõîäèòü àâòîìàòè÷åñêè, òî çàïóñêàåì ñåññèè
		  $_SESSION['password']=strrev(md5($_COOKIE['password']))."b3p6f"; //â êóêàõ ïàðîëü áûë íå çàøèôðîâàííûé, à â ñåññèÿõ îáû÷íî õðàíèì çàøèôðîâàííûé
		  $_SESSION['login']=$_COOKIE['login'];//ñåññèÿ ñ ëîãèíîì
		  $_SESSION['id']=$_COOKIE['id'];//èäåíòèôèêàòîð ïîëüçîâàòåëÿ
		}	
	}

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//åñëè ñóùåñòâåò ëîãèí è ïàðîëü â ñåññèÿõ, òî ïðîâåðÿåì èõ è èçâëåêàåì àâàòàð
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$result = mysql_query("SELECT id,avatar FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow = mysql_fetch_array($result);

$result3 = mysql_query("SELECT full_name,country FROM reg_users WHERE `key` = '$login'",$db);
$myrow3 = mysql_fetch_array($result3); 


//èçâëåêàåì íóæíûå äàííûå î ïîëüçîâàòåëå
}

$result4 = mysql_query("SELECT * FROM reports WHERE `key` = '$login'",$db);
$myrow4 = mysql_fetch_array($result4);

$result5 = mysql_query("SELECT * FROM reg_users WHERE `key` = '$login'",$db);
$myrow5 = mysql_fetch_array($result5);
$full_name=$myrow3['full_name'];

?>
<html>
<head>
<center>
<meta charset="utf-8">
<script src="assets/js/ie/html5shiv.js"></script>

<script>
function limitText(limitField, limitCount, limitNum) { if (limitField.value.length > limitNum) { limitField.value = limitField.value.substring(0, limitNum); } else { limitCount.value = limitNum - limitField.value.length; } }
</script>


<title>Abstract and paper submission</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>

<h2>Personal account</h2>
<a href='http://emecs-sc2016.com/'>Back to emecs-sc2016.com</a>
<div class="boxtotal">
<?php

/// testreg form START

if (!isset($myrow['avatar']) or $myrow['avatar']=='') {
//ïðîâåðÿåì, íå èçâëå÷åíû ëè äàííûå ïîëüçîâàòåëÿ èç áàçû. Åñëè íåò, òî îí íå âîøåë, ëèáî ïàðîëü â ñåññèè íåâåðíûé. Âûâîäèì îêíî äëÿ âõîäà. Íî ìû íå áóäåì åãî âûâîäèòü äëÿ âîøåäøèõ, èì îíî óæå íå íóæíî.

/// testreg form START

print <<<HERE


<form action="testreg.php" method="post">
<!-- testreg.php - ýòî àäðåñ îáðàáîò÷èêà. Òî åñòü, ïîñëå íàæàòèÿ íà êíîïêó "Âîéòè", äàííûå èç ïîëåé îòïðàâÿòñÿ íà ñòðàíè÷êó testreg.php ìåòîäîì "post"  -->
    <label>Your login:</label>
    <input name="login" type="text" size="15" maxlength="15"
HERE;

if (isset($_COOKIE['login'])) //åñòü ëè ïåðåìåííàÿ ñ ëîãèíîì â COOKIE. Äîëæíà áûòü, åñëè ïîëüçîâàòåëü ïðè ïðåäûäóùåì âõîäå íàæàë íà ÷åêáîêñ "Çàïîìíèòü ìåíÿ"
{
//åñëè äà, òî âñòàâëÿåì â ôîðìó åå çíà÷åíèå. Ïðè ýòîì ïîëüçîâàòåëþ îòîáðàæàåòñÿ, ÷òî åãî ëîãèí óæå âïèñàí â íóæíóþ ãðàôó
echo ' value="'.$_COOKIE['login'].'">';
}


print <<<HERE
  </p>
<!-- Â òåêñòîâîå ïîëå (name="login" type="text") ïîëüçîâàòåëü ââîäèò ñâîé ëîãèí -->  
  <p>
    <label>Your password:<br></label>
    <input name="password" type="password" size="15" maxlength="15"
HERE;

	
if (isset($_COOKIE['password']))//åñòü ëè ïåðåìåííàÿ ñ ïàðîëåì â â COOKIE. Äîëæíà áûòü, åñëè ïîëüçîâàòåëü ïðè ïðåäûäóùåì âõîäå íàæàë íà ÷åêáîêñ "Çàïîìíèòü ìåíÿ"
{
//åñëè äà, òî âñòàâëÿåì â ôîðìó åå çíà÷åíèå. Ïðè ýòîì ïîëüçîâàòåëþ îòîáðàæàåòñÿ, ÷òî åãî ïàðîëü óæå âïèñàí â íóæíóþ ãðàôó
echo ' value="'.$_COOKIE['password'].'">';
}

print <<<HERE
  </p>
<!-- Â ïîëå äëÿ ïàðîëåé (name="password" type="password") ïîëüçîâàòåëü ââîäèò ñâîé ïàðîëü -->  
  <p>
    <input name="save" type="checkbox" value='1'> Remember me.
  </p>
  <p>
    <input name="autovhod" type="checkbox" value='1'> Automatic input.
  </p>

<p>
<input type="submit" name="submit" value="Sign in">
<!-- Êíîïî÷êà (type="submit") îòïðàâëÿåò äàííûå íà ñòðàíè÷êó testreg.php  --> 
<br>
<!-- ññûëêà íà ðåãèñòðàöèþ, âåäü êàê-òî æå äîëæíû ãîñòè òóäà ïîïàäàòü  --> 
<a href="reg.php">Registration</a> 

<br>
<!-- ññûëêà íà âîññòàíîâëåíèå ïàðîëÿ  --> 
<a href="send_pass.php">Forgot your password?</a> 

</p>
</form>
<br>
You are logged in as guest<br>
<a href="form/support.php">TECHNICAL SUPPORT</a>
HERE;
}
///testreg form END

else
{
	


//ïðè óäà÷íîì âõîäå ïîëüçîâàòåëþ âûäàåòñÿ âñå, ÷òî ðàñïîëîæåíî íèæå ìåæäó çâåçäî÷êàìè.
//************************************************************************************

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
</ul>
</nav>
</header>
<h2>Abstract and paper submission</h2>
HERE;

if ($full_name == NULL) {
//?ñëè ñòðàíè÷êà ïðèíàäëåæèò âîøåäøåìó, òî ïðåäëàãàåì èçìåíèòü äàííûå è âûâîäèì ëè÷íûå ñîîáùåíèÿ

print <<<HERE

You did not fill in the section "information". <br>
Please go back and fill in. Then you will be able to upload your abstract.

HERE;
///////////

					
}
else{

print <<<HERE
<label>
<a href="files/Conference_rules.pdf" target="blanck">Conference paper rules</a></label>
<label>
<a href="update_article.php" target="blanck">Added papers</a><br>
<br></label>
<label><b>You can upload your full papers only after your abstracts have been reviewed by the Conference Scientific Committee (you will receive the notification by e-mail).</lable><br>
<i>Follow <a href="update_article.php">this link</a> to edit abstracts and upload full papers.</i></b><br>
HERE;



print <<<HERE
<!-- Ìåæäó îïåðàòîðîì  "print <<<HERE" âûâîäèòñÿ html êîä ñ íóæíûìè ïåðåìåííûìè èç php -->
<!--<b>You are logged in as $_SESSION[login]<br><br></b>-->
<!-- âûøå ññûëêà íà âûõîä èç àêêàóíòà -->


<!-- Ôîðìà ðåãèñòðàöèè äîêëàäîâ -->

<a href='reports.php'>To add coauthors, click here</a><br>


<form action="update_reports.php" align = "left" method="post" enctype="multipart/form-data">
Enter the title of the article:
<input name="title" type="text" size="40" onKeyPress="if (this.value.empty = true) { this.style.border = '1px solid #000000' }"; style="border: 1px solid red;" > 

<br>
<br>
Choose section:<br><br>

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

<br>

<br>
Desired form of presentation: 
<input name="form" type="radio" value="oral">Oral    
<input name="form" type="radio" value="poster">Poster<br> 


Enter abstract (max 1500 characters including spaces)<br>
<p><textarea name="annotation" class="require_ws en_char no_special_chars confirm-2" cols="80" rows="20" onKeyDown="limitText(this,this.form.count,1500);"
 onKeyUp="limitText(this,this.form.count,1500);" placeholder="Please, in English!"></textarea>
 <br> 
 <input readonly type="text" name="count" size="3" value="1500"> 
</p>


<input name="coast" type="hidden" value="75">	  
<input name="submit" type="submit" value="Submit">

</form>
<br>
<a href='reports.php'>To add coauthors, click here</a><br>

HERE;
}
}
?>

<!--<a href='http://emecs-sc2016.com/reports.php'>To add co-authtors, click here</a><br><br>
<a href='update_article.php'>View and edit the entries you added, click here.</a><br><br> -->


<!-- Èìåííî  òóò ôîðìû è ïðî÷åå... -->

</div>
</center>
</body>
</html>
