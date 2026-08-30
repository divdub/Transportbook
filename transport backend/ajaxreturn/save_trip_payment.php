<?php 
include("../adminsession.php");

   $billing_type = $_POST['billing_type'];
	$consignor_id = $_POST['consignor_id'];
	$consignee_id = $_POST['consignee_id'];
	 $trip_id = $_POST['trip_id'];

	$deduct_amt = $_POST['deduct_amt'];
	$rec_amt = $_POST['rec_amt'];
	$rec_date = $_POST['rec_date'];
    $payment_mode = $_POST['payment_mode'];
    $pay_remark   = $_POST['pay_remark'];
 $pay_id=$_POST['pay_id'];

	$tblname="trip_payment";
	$tblpkey="pay_id";  

if($pay_id == '')
	{
// echo		"'vehicle_id'=>$vehicle_id,'driver_id'=>$driver_id,'inc_date'=>$inc_date,'otherid'=>$otherid,'amount'=>$amount,'bill_type'=>$bill_type,'payment_mode'=>$payment_mode,'narration'=>$narration,'comp_id'=>$comp_id,'session_id'=>$session_id,'created_date'=>$currentdate";
	$form_data = array('billing_type'=>$billing_type,'consignor_id'=>$consignor_id,'consignee_id'=>$consignee_id,'trip_id'=>$trip_id,'deduct_amt'=>$deduct_amt,'rec_amt'=>$rec_amt,'rec_date'=>$rec_date,'payment_mode'=>$payment_mode,'pay_remark'=>$pay_remark,'comp_id'=>$comp_id,'session_id'=>$session_id,'sessionconsignor_id'=>$consignorid,'created_date'=>$currentdate);
	dbRowInsert($connection,$tblname, $form_data);
} else {
   $form_data = array('billing_type'=>$billing_type,'consignor_id'=>$consignor_id,'consignee_id'=>$consignee_id,'trip_id'=>$trip_id,'deduct_amt'=>$deduct_amt,'rec_amt'=>$rec_amt,'rec_date'=>$rec_date,'payment_mode'=>$payment_mode,'pay_remark'=>$pay_remark,'comp_id'=>$comp_id,'session_id'=>$session_id,'sessionconsignor_id'=>$consignorid,'updated_date'=>$currentdate);
dbRowUpdate($connection,$tblname, $form_data, "$tblpkey='$pay_id '");

	}
  
?>