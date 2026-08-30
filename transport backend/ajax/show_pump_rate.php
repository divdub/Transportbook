<?php 
include("../adminsession.php");
 $pump_id = $_REQUEST['pump_id']; 

$dispatch_id = $cmn->getvalfield($connection,"dispatch_entry","max(dispatch_id )","pump_id='$pump_id'");
if($dispatch_id!=''){
$diesel_rate = $cmn->getvalfield($connection,"dispatch_entry","diesel_rate","dispatch_id='$dispatch_id'");
echo $diesel_rate;
}

?>