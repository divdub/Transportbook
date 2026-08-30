<?php
ini_set('memory_limit', '512M'); 
date_default_timezone_set("Asia/Kolkata");
if($_SERVER["SERVER_NAME"]=="localhost" || $_SERVER["SERVER_NAME"]=="ghanshyam"  || $_SERVER["SERVER_NAME"]=="trinityhome")
{
	$host_name="localhost";
	$db_name="guru"; 
	$db_user="root";
	$db_pwd="";
}
else
{
    
    
                 $host_name="localhost";
			     $db_name="chaarqvc_guruassociates";
			     $db_user="chaarqvc_guruassociates";
			     $db_pwd="]7xSacsHLe]P";
	
}
$connection = mysqli_connect("$host_name","$db_user","$db_pwd",$db_name);


?>