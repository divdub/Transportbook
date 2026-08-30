<?php 
error_reporting(0);
include("../adminsession.php");
 $vehicle_id = $_REQUEST['vehicle_id']; 

$owner_id = $cmn->getvalfield($connection,"m_vehicle","owner_id","vehicle_id='$vehicle_id'");
$agent_id = $cmn->getvalfield($connection,"m_vehicle","agent_id","vehicle_id='$vehicle_id'");
 $owner_name1 = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$owner_id'");
 $agent_name1 = $cmn->getvalfield($connection,"m_agent","agent_name","agent_id='$agent_id'");

echo $owner_name1;

?>