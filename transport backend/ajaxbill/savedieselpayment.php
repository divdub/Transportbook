<?php 
include("../adminsession.php");

   $dbillid = $_POST['dbillid'];
	$rcv_amt = $_POST['rcv_amt'];
	$rcv_date=$_POST['rcv_date'];
	$bill_remark=$_POST['bill_remark'];
		$pay_mode=$_POST['pay_mode'];
			$pump_id=$_POST['pump_id'];
	$tblname="diesel_pay";
// 	$pump_id=$_POST['pay_mode'];
	// $tot=$netamt- $received_amt;
// 	echo $pump_id;
// echo "'dbillid'=>$dbillid,'rcv_amt'=>$rcv_amt,'rcv_date'=>$rcv_date,'bill_remark'=>$bill_remark,'pay_mode'=>$pay_mode,'pump_id'=>$pump_id,'sessionid'=>$session_id,'consignorid'=>$consignorid,'createdate'=>$currentdate";
$form_data = array('dbillid'=>$dbillid,'rcv_amt'=>$rcv_amt,'rcv_date'=>$rcv_date,'bill_remark'=>$bill_remark,'pay_mode'=>$pay_mode,'pump_id'=>$pump_id,'sessionid'=>$session_id,'consignorid'=>$consignorid,'createdate'=>$currentdate,'user_id' => $user_id);
	dbRowInsert($connection,$tblname, $form_data);
	$amt_paid_to=0;
 $amt_paid_to = $cmn->getvalfield($connection,"dispatch_entry","sum(diesel_adv_amt)","dbillid='$dbillid'"); 	 
 $discountamt = $cmn->getvalfield($connection,"dieselbill","discountamt","dbillid='$dbillid'"); 	
		 $receive_amt = $cmn->getvalfield($connection,"diesel_pay","sum(rcv_amt)","dbillid='$dbillid'"); 
		$bal1=$amt_paid_to - $receive_amt - $discountamt;
 $bal=round($bal1);
 if($bal== 0 || $bal < 0 || $bal == 1 ){
 		mysqli_query($connection,"UPDATE dieselbill set is_pay = '1' WHERE dbillid='$dbillid'");
 }
 

	// mysqli_query($connection,"UPDATE dispatch_entry  set is_pay = '1' WHERE invoiceid='$invoiceid'");

	// }
?>
