<?php 
include("../adminsession.php");
   $current_date=date('Y-m-d');
   $head_id=$_REQUEST['head_id'];
   $mechanic_id=$_REQUEST['mechanic_id'];
   $amount=$_REQUEST['amount'];
   $meater_readingnext=$_REQUEST['meater_readingnext'];
   $service_datenext=$_REQUEST['service_datenext'];  
   echo $service_id=$_REQUEST['service_id']; 
   $servicedetailid = $_REQUEST['servicedetailid'];

   
   

	if($servicedetailid==''){

//echo "INSERT into service_detail set service_id='$service_id',head_id='$head_id',compid='$compid',amount='$amount',meater_readingnext='$meater_readingnext', service_datenext='$service_datenext',meachineid='$meachineid',sessionid='$sessionid', sessionid='$sessionid', createdate='$createdate'";
   	mysqli_query($connection,"INSERT into service_detail set service_id='$service_id',head_id='$head_id',amount='$amount',meater_readingnext='$meater_readingnext', service_datenext='$service_datenext',mechanic_id='$mechanic_id',createdate='$createdate', consignorid='$consignorid', comp_id='$comp_id',session_id='$session_id'");

      $action=1;
   $process = "insert";
}
else
{
echo "update  service_detail set service_id='$service_id',head_id='$head_id',amount='$amount',meater_readingnext='$meater_readingnext',service_datenext='$service_datenext', mechanic_id='$mechanic_id',lastupdated='$createdate' WHERE servicedetailid = '$servicedetailid'";
   mysqli_query($connection,"update  service_detail set service_id='$service_id',head_id='$head_id',amount='$amount', consignorid='$consignorid' ,meater_readingnext='$meater_readingnext',service_datenext='$service_datenext', mechanic_id='$mechanic_id',lastupdated='$createdate' WHERE servicedetailid = '$servicedetailid'");


//    $action=2;
//    $process = "update";
}	



?>