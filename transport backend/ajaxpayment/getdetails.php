<?php 
   include("../adminsession.php");
     $dispatch_id = $_REQUEST['dispatch_id']; 

    $sql = mysqli_query($connection, "select * from dispatch_entry where dispatch_id=$dispatch_id ");

  	  $row = mysqli_fetch_array($sql);
  	 
      $truck_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id ='$row[vehicle_id]'");
$toplace = $cmn->getvalfield($connection,"m_place", "place_name", "place_id ='$row[destination_id]'");
 $fromplace = $cmn->getvalfield($connection,"m_place", "place_name", "place_id ='$row[from_id]'");

$ownername = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id ='$row[owner_id]'");

 $itemname = $cmn->getvalfield($connection, "m_item", "item_name", "item_id ='$row[item_id]'");

  $amt = $cmn->getvalfield($connection, "tpa_entry", "sum(amt)", "dispatch_id ='$row[dispatch_id]'");
  $rate = $cmn->getvalfield($connection, "tpa_entry", "sum(rate)", "dispatch_id ='$row[dispatch_id]'");
     $wt_mt =$row['wt_mt'];
     $ownrate =$row['own_rate'];
    $freightamt =$wt_mt * $ownrate;
     $balamt=$freightamt -$amt;
     $balrate=$ownrate -$rate;
     $paid_to=$row['paid_to'];
     $tparemark=$row['tparemark'];

echo	$truck_no."|".$fromplace."|".$toplace."|".$ownername."|".$itemname."|".$wt_mt."|".$ownrate."|".$freightamt."|".$balamt."|".$balrate."|".$paid_to."|".$tparemark;
 // $bilty_no;
   ?>