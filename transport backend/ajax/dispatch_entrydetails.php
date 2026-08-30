<?php 
   include("../adminsession.php");
     $dispatch_id = $_REQUEST['dispatch_id']; 
// echo "select * from dispatch_entry where dispatch_id=$dispatch_id";
    $sql = mysqli_query($connection, "select * from dispatch_entry where dispatch_id=$dispatch_id");

  	  $row = mysqli_fetch_array($sql);
  	  $consignor_name1 = $cmn->getvalfield($connection,"m_consignor", "consignor_name", "consignor_id ='$row[consignor_id]'");
	  $consignee_name1 = $cmn->getvalfield($connection, "m_consignee", "consignee_name","consignee_id ='$row[consignee_id]'");
      $vehicle_no1 = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id ='$row[vehicle_id]'");

$owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id ='$row[owner_id]'");
$mobileno1 = $cmn->getvalfield($connection, "m_vehicle_owner", "mobileno1", "owner_id ='$row[owner_id]'");
    $bilty_no =$row['bilty_no'];
     $bilty_date =$row['bilty_date'];
     $order_no =$row['order_no'];
     $wt_mt =$row['wt_mt'];
     $own_rate=$row['own_rate'];
     $freight_amt=$wt_mt * $own_rate;

echo	$bilty_no."|".$bilty_date."|".$order_no."|".$consignor_name1."|".$consignee_name1."|".$wt_mt."|".$own_rate."|".$freight_amt."|".$vehicle_no1."|".$owner_name."|".$mobileno1;
 // $bilty_no;
   ?>