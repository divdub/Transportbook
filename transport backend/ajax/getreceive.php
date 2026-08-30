<?php 
   include("../adminsession.php");
     $dispatch_id = $_REQUEST['dispatch_id']; 
// echo "select * from dispatch_entry where dispatch_id=$dispatch_id";
    $sql = mysqli_query($connection, "select * from dispatch_entry where dispatch_id=$dispatch_id");

  	  $row = mysqli_fetch_array($sql);
  	  $consignor_name1 = $cmn->getvalfield($connection,"m_consignor", "consignor_name", "consignor_id ='$row[consignor_id]'");
	  $consignee_name1 = $cmn->getvalfield($connection, "m_consignee", "consignee_name","consignee_id ='$row[consignee_id]'");
      $vehicle_no1 = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id ='$row[vehicle_id]'");
      $place_name1 = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$row[destination_id]'");

$owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id =$row[owner_id]");

    $bilty_no =$row['bilty_no'];
     $bilty_date =$row['bilty_date'];
     $wt_mt =$row['wt_mt'];
     $qty =$row['qty'];
    
     

echo	$bilty_no."|".$bilty_date."|".$consignor_name1."|".$consignee_name1."|".$place_name1."|".$wt_mt."|".$qty."|".$vehicle_no1."|".$owner_name;
 // $bilty_no;
   ?>