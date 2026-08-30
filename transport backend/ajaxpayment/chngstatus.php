<?php
include("../adminsession.php");
$voucher_id = $_POST['voucher_id'];
	$status = $_POST['status'];
	$stremark = $_POST['stremark'];
	mysqli_query($connection,"UPDATE payment set stremark='$stremark',status='$status',updated_date='$currentdate' WHERE voucher_id='$voucher_id' && consignorid=$consignorid" );

?>