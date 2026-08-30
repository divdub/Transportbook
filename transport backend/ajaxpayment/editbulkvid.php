<?php 
include("../adminsession.php");


	$voucher_date=$_POST['voucher_date'];
	$remark=$_POST['remark'];
	$voucher_id=$_POST['voucher_id'];
	$payee_name=$_POST['payee_name'];
  
	$tblname="payment";
 
	mysqli_query($connection,"UPDATE payment set voucher_date = '$voucher_date', remark='$remark', payee_name='$payee_name', updated_date='$currentdate' WHERE voucher_id='$voucher_id' && consignorid=$consignorid" );
	echo  $voucher_id;
?>