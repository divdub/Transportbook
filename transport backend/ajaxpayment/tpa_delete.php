<?php
// error_reporting(0);
include("../adminsession.php");

$tablename = $_REQUEST['tablename'];
$tableid = $_REQUEST['tableid'];
$id = $_REQUEST['id'];
$wt_mt=$_REQUEST['wt_mt'];
	$tpaown_rate=$_REQUEST['tpaown_rate'];
$dispatch_id = $_REQUEST['dispatch_id'];
if($dispatch_id==''){
    $dispatch_id='0';
}
// echo "delete from $tablename where $tableid=$id";
mysqli_query($connection,"delete from $tablename where $tableid=$id");
	 $amt = $cmn->getvalfield($connection, "tpa_entry", "sum(amt)", "dispatch_id ='$dispatch_id'");
  $rate = $cmn->getvalfield($connection, "tpa_entry", "sum(rate)", "dispatch_id ='$dispatch_id'");
  if($dispatch_id==0){
    $freightamt =$wt_mt * $tpaown_rate;
    $balamt=$freightamt -$amt;
    $balrate=$tpaown_rate -$rate;
  } else{
    $wtmt = $cmn->getvalfield($connection, "dispatch_entry", "wt_mt", "dispatch_id ='$dispatch_id'");
    $own_rate = $cmn->getvalfield($connection, "dispatch_entry", "own_rate", "dispatch_id ='$dispatch_id'");
     $freightamt =$wtmt * $own_rate;
     $balamt=$freightamt -$amt;
     $balrate=$own_rate -$rate;
   
  }
 
 
    
     echo	$balamt."|".$balrate;
?>


