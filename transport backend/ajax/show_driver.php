<?php 
error_reporting(0);
include("../adminsession.php");
 $driver_id = $_REQUEST['driver_id']; 

$mobile_no1 = $cmn->getvalfield($connection,"m_driver","mobile_no","driver_id='$driver_id'");

echo $mobile_no1;

?>