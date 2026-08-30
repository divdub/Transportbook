<?php 
 include("../adminsession.php");
 $id = $_REQUEST['id'];


echo $countval= $cmn->getvalfield($connection,"other_deduct","sum(damt)","invoiceid='0' && session_id='$session_id' && consignorid= '$consignorid'");

?>
