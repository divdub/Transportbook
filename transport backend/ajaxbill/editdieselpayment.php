<?php 
include("../adminsession.php");

  
	$rcv_amt = $_POST['rcv_amt'];
	$rcv_date=$_POST['rcv_date'];
	$bill_remark=$_POST['bill_remark'];
		$pay_mode=$_POST['pay_mode'];
		$dpayid=$_POST['dpayid'];
	$tblname="diesel_pay";
	$Edbillid =$_POST['Edbillid'];
	
	// $tot=$netamt- $received_amt;
// 	echo $pump_id;
// echo "'dbillid'=>$dbillid,'rcv_amt'=>$rcv_amt,'rcv_date'=>$rcv_date,'bill_remark'=>$bill_remark,'pay_mode'=>$pay_mode,'pump_id'=>$pump_id,'sessionid'=>$session_id,'consignorid'=>$consignorid,'createdate'=>$currentdate";
// $form_data = array('dbillid'=>$dbillid,'rcv_amt'=>$rcv_amt,'rcv_date'=>$rcv_date,'bill_remark'=>$bill_remark,'pay_mode'=>$pay_mode,'pump_id'=>$pump_id,'sessionid'=>$session_id,'consignorid'=>$consignorid,'createdate'=>$currentdate);
// 	dbRowInsert($connection,$tblname, $form_data);
	
	// echo "UPDATE invoicebilty set is_pay = '1' WHERE invoiceid='$invoiceid'";
	// if($tot==0){

	mysqli_query($connection,"UPDATE $tblname set rcv_amt = '$rcv_amt',bill_remark='$bill_remark',pay_mode='$pay_mode',rcv_date='$rcv_date' WHERE dpayid='$dpayid'");
	// mysqli_query($connection,"UPDATE dispatch_entry  set is_pay = '1' WHERE invoiceid='$invoiceid'");

	// }
	
	$amt_paid_to=0;
    $amt_paid_to = $cmn->getvalfield($connection,"dispatch_entry","sum(diesel_adv_amt)","dbillid='$Edbillid'"); 	 
	$receive_amt = $cmn->getvalfield($connection,"diesel_pay","sum(rcv_amt)","dbillid='$Edbillid'"); 
	$bal1=$amt_paid_to - $receive_amt;
 $bal=round($bal1);
 
 if($bal== 0 || $bal < 0 || $bal == 1 ){
 		mysqli_query($connection,"UPDATE dieselbill set is_pay = '1' WHERE dbillid='$Edbillid'");
 }else{
     mysqli_query($connection,"UPDATE dieselbill set is_pay = '0' WHERE dbillid='$Edbillid'");
 }
 
?>
