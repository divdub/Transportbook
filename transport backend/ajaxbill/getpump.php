<?php 
include("../adminsession.php");

   $pump_id = $_REQUEST['pump_id'];
    $dpayid = $_REQUEST['dpayid'];
   
  ?> <option value"">Select</option>
<?php		 $sql = mysqli_query($connection, "Select * from  dieselbill where consignorid=$consignorid && is_pay='0' && sessionid=$session_id && pump_id=$pump_id order by dbillid");
										while ($row = mysqli_fetch_array($sql)) { ?>
				<option value="<?php echo $row['dbillid']; ?>"><?php echo $row['dbillno']; ?></option>
																	<?php } ?>
																	



