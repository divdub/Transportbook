<?php 
// error_reporting(0);
include("../adminsession.php");
 $tpcat_id = $_REQUEST['tpcat_id']; 
?>
  <option value="">Select</option>
  <?php 
if($tpcat_id==1){
	 $sql = mysqli_query($connection, "select * from payment where category_id=1 && is_paid=0 && consignorid=$consignorid && comp_id=$comp_id && status=0 && session_id=$session_id GROUP BY voucher_id"  );

  	  while($row = mysqli_fetch_array($sql)) { 
  	   $agent_name=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id='$row[catname]'");
  	  ?>
  	  	<option value="<?php echo $row['voucher_id']; ?>"><?php echo $row['voucher_id']; ?> / <?php echo $agent_name; ?></option>
  <?php	  }
}
if($tpcat_id==2){
	 $sql = mysqli_query($connection, "select * from payment where category_id=2 && is_paid=0 && consignorid=$consignorid && comp_id=$comp_id && status=0 && session_id=$session_id GROUP BY voucher_id");

  	  while($row = mysqli_fetch_array($sql)) { 
  	   $consignee_name = $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id ='$row[catname]'");  
  	  ?>
  	  	<option value="<?php echo $row['voucher_id']; ?>"><?php echo $row['voucher_id']; ?> / <?php echo $consignee_name; ?></option>
  <?php	  }
}
if($tpcat_id==4){
//   echo  "select * from payment where category_id=4 && is_paid=0 && consignorid=$consignorid GROUP BY 'voucher_id' && consignorid";
	 $sql = mysqli_query($connection, "select * from payment where category_id=4 && is_paid=0 && consignorid=$consignorid && comp_id=$comp_id && status=0 && session_id=$session_id GROUP BY voucher_id");

  	  while($row = mysqli_fetch_array($sql)) {
  	  $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[catname]");
 ?>
  	  	<option value="<?php echo $row['voucher_id']; ?>"><?php echo $row['voucher_id']; ?> / <?php echo $owner_name; ?></option>
  <?php	  }
}

?>