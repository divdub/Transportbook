<?php 
error_reporting(0);
include("../adminsession.php");
 $cat_id = $_REQUEST['cat_id']; 
?>
  <option value="">Select</option>
  <?php 
if($cat_id==1){
	 $sql = mysqli_query($connection, "select * from m_agent");

  	  while($row = mysqli_fetch_array($sql)) { ?>
  	  	<option value="<?php echo $row['agent_id']; ?>"><?php echo $row['agent_name']; ?></option>
  <?php	  }
}
if($cat_id==2){
	 $sql = mysqli_query($connection, "select * from m_consignee");

  	  while($row = mysqli_fetch_array($sql)) { ?>
  	  	<option value="<?php echo $row['consignee_id']; ?>"><?php echo $row['consignee_name']; ?></option>
  <?php	  }
}
if($cat_id==4){
	 $sql = mysqli_query($connection, "select * from m_vehicle_owner");

  	  while($row = mysqli_fetch_array($sql)) { ?>
  	  	<option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
  <?php	  }
}

?>