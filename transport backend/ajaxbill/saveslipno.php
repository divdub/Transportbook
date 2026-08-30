<?php 
include("../adminsession.php");

   $slipno = $_POST['slipno'];
	$dispatch_id = $_POST['dispatch_id'];
	
	
// 	$tblname="diesel_pay";
// 	// $tot=$netamt- $received_amt;

// $form_data = array('dbillid'=>$dbillid,'rcv_amt'=>$rcv_amt,'rcv_date'=>$rcv_date,'bill_remark'=>$bill_remark,'sessionid'=>$session_id,'consignorid'=>$consignorid,'createdate'=>$currentdate);
// 	dbRowInsert($connection,$tblname, $form_data);
	
// 	// echo "UPDATE invoicebilty set is_pay = '1' WHERE invoiceid='$invoiceid'";
// 	// if($tot==0){

	// mysqli_query($connection,"UPDATE dieselbill set is_pay = '1' WHERE dbillid='$dbillid'");
	mysqli_query($connection,"UPDATE dispatch_entry  set slip_no = '$slipno' WHERE dispatch_id='$dispatch_id'");

	// }
?>
