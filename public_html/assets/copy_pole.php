<?php

include ("/public_html/bd.php");

$result = mysql_query("INSERT INTO `visa` (`full_name`) SELECT `full_name` FROM `reg_users` WHERE `key` = `key`;") or die("Error MySQL:<br>" . mysql_error());

?>

