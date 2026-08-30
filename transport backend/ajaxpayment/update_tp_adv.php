<?php 
include("../adminsession.php");
   $dispatch_id = $_REQUEST['dispatch_id'];
   mysqli_query($connection,"update tpa_entry  set dispatch_id='$dispatch_id' where $dispatch_id='0'");
   

	?>
