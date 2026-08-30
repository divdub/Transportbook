<?php 
include("../adminsession.php");
    $condid = $_REQUEST['condid'];
      $condtype = $_REQUEST['condtype'];
    
   ?>
   
   <option value="">Select</option>	

   <?php
 
   if($condtype=='consignor'){
  echo 	"select * from trip_entry where consignor_id='$condid'";
														$sql = mysqli_query($connection, "select * from trip_entry where consignor_id='$condid' && sessionconsignor_id=$consignorid && session_id=$session_id");
														
   }else{
echo   	"select * from trip_entry where consignee_id='$condid'";
	   $sql = mysqli_query($connection, "select * from trip_entry where consignee_id='$condid' && sessionconsignor_id=$consignorid && session_id=$session_id");
   }
												
														while ($row = mysqli_fetch_array($sql)) {
														    //   $netamt = $cmn->getvalfield($connection, "trip_entry","net_amount", "trip_no='$row[trip_no]'");
										
											          // $recamt = $cmn->getvalfield($connection, "payment_recive", "sum(recived_amt)", "trip_no='$row[trip_no]'");
											                 
										            //     	 $balamt= $netamt - $recamt;
											               
														?>
														
															
												<option value="<?php echo $row['trip_id'];?>"><?php echo $row['trip_no'];?></option>
												<?php } ?>