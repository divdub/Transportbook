<?php 
include("../adminsession.php");

   $vehicle_id = $_POST['vehicle_id'];
	$driver_id = $_POST['driver_id'];
	$mdate = $_POST['mdate'];
	$head_id = $_POST['head_id'];
	$mechanic_id=$_POST['mechanic_id'];
	$amount = $_POST['amount'];
	$payment_type = $_POST['payment_type'];
	$payment_mode = $_POST['payment_mode'];
    $remark = $_POST['remark'];
    $main_id = $_POST['main_id'];
	$pay_type = $_POST['pay_type'];
	$bill_id = $_POST['bill_id'];

	$tblname="maintenance_entry";
	$tblpkey="main_id";  
	if($main_id  == '')
	{
	$form_data = array('vehicle_id'=>$vehicle_id,'driver_id'=>$driver_id, 'service_id'=>$bill_id, 'pay_type'=>$pay_type, 'mdate'=>$mdate,'head_id'=>$head_id,'mechanic_id'=>$mechanic_id,'amount'=>$amount,'payment_type'=>$payment_type,'payment_mode'=>$payment_mode,'remark'=>$remark,'comp_id'=>$comp_id,'session_id'=>$session_id,'consignorid'=>$consignorid,'created_date'=>$currentdate,'user_id' => $user_id);
	dbRowInsert($connection,$tblname, $form_data);
	} else {
   $form_data = array('vehicle_id'=>$vehicle_id,'driver_id'=>$driver_id, 'service_id'=>$bill_id, 'pay_type'=>$pay_type, 'mdate'=>$mdate,'head_id'=>$head_id,'mechanic_id'=>$mechanic_id,'amount'=>$amount,'payment_type'=>$payment_type,'payment_mode'=>$payment_mode,'remark'=>$remark,'comp_id'=>$comp_id,'session_id'=>$session_id,'consignorid'=>$consignorid,'updated_date'=>$currentdate);
dbRowUpdate($connection,$tblname, $form_data, "$tblpkey='$main_id'");

	}
?>