<?php
session_start();
 $consignorid=$_GET['consignor_id'];

	   $_SESSION['consignor_id'] = $consignorid;
	echo "<script>location='dashboard.php'</script>";
		
?>