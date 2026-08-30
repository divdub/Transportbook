<?php 
   include("../adminsession.php");
// include("../function/bill_function.php");
      $minvid = $_REQUEST['minvid']; 
     
	$sql = mysqli_query($connection, "Select * from  manualinv where minvid=$minvid order by minvid");
										while ($row = mysqli_fetch_array($sql)) { 
										    
										    $gst=$row['gst'];
										     $gst_amt=$row['gst_amt'];
										}
										      
										  	
										  
echo $gst."|".$gst_amt;	
									  
										  
									  
?>
						