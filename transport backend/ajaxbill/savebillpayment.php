<?php 
include("../adminsession.php");

   $invoiceid = $_POST['invoiceid'];
	$tds_per = $_POST['tds_per'];
	$gst = $_POST['gst'];
	$tds_amt=$_POST['tds_amt'];
		$deduct = $_POST['deduct'];
			$deduct_remark = $_POST['deduct_remark'];
	$deduct_date = $_POST['deduct_date'];
	$received_amt = $_POST['received_amt'];
	$gst_amt = $_POST['gst_amt'];
	$receive_date=$_POST['receive_date'];
	$remark=$_POST['remark'];
	$netamt=$_POST['netamt'];
	$incentiveamt=$_POST['incentiveamt'];
	$tblname="manualinv";
	$tot=$netamt- $received_amt;

$form_data = array('invoiceid'=>$invoiceid,'tds_per'=>$tds_per,'gst'=>$gst,'deduct_date'=>$deduct_date,'deduct_remark'=>$deduct_remark,'tds_amt'=>$tds_amt,'incentiveamt'=>$incentiveamt,'deduct'=>$deduct,'received_amt'=>$received_amt,'gst_amt'=>$gst_amt,'receive_date'=>$receive_date,'remark'=>$remark,'session_id'=>$session_id,'consignorid'=>$consignorid,'created_date'=>$currentdate,'user_id' => $user_id);
	dbRowInsert($connection,$tblname, $form_data);
	
	// echo "UPDATE invoicebilty set is_pay = '1' WHERE invoiceid='$invoiceid'";
	// if($tot==0){

	mysqli_query($connection,"UPDATE invoicebilty set is_pay = '1' WHERE invoiceid='$invoiceid'");
	mysqli_query($connection,"UPDATE dispatch_entry  set is_pay = '1' WHERE invoiceid='$invoiceid'");
	mysqli_query($connection,"UPDATE other_deduct set invoiceid='$invoiceid' WHERE invoiceid='0' && session_id='$session_id' && consignorid= '$consignorid'");
	// }
?>
