<?php 
	$host = "127.0.0.1";
	$user = "root";
	$db_name = "tpPhp";
	$psw = "";
	$db = mysql_connect($host,$user,$psw) or die("impossible de se connecter à la bdd");
	$connexion = mysql_select_db($db_name,$db)or die("impossible de selectionner cette bdd");
 ?>