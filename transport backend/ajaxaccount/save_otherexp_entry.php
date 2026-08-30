<?php 
include("../adminsession.php");

   $vehicle_id = $_POST['vehicle_id'];
	$driver_id = $_POST['driver_id'];
	$exp_date = $_POST['exp_date'];
	$otherid = $_POST['otherid'];

	$amount = $_POST['amount'];
	$bill_type = $_POST['bill_type'];
	$payment_mode = $_POST['payment_mode'];
    $narration = $_POST['narration'];
    $other_exp_id  = $_POST['other_exp_id'];

	$tblname="other_expense_entry";
	$tblpkey="other_exp_id ";  
	if($other_exp_id   == '')
	{

// echo		"'vehicle_id'=>$vehicle_id,'driver_id'=>$driver_id,'exp_date'=>$exp_date,'otherid'=>$otherid,'amount'=>$amount,'bill_type'=>$bill_type,'payment_mode'=>$payment_mode,'narration'=>$narration,'comp_id'=>$comp_id,'session_id'=>$session_id,'created_date'=>$currentdate";
	$form_data = array('vehicle_id'=>$vehicle_id,'driver_id'=>$driver_id,'exp_date'=>$exp_date,'type'=>'EXPENSE','otherid'=>$otherid,'amount'=>$amount,'bill_type'=>$bill_type,'payment_mode'=>$payment_mode,'narration'=>$narration,'comp_id'=>$comp_id,'session_id'=>$session_id,'consignorid'=>$consignorid,'created_date'=>$currentdate,'user_id' => $user_id);
	dbRowInsert($connection,$tblname, $form_data);
	} else {
   $form_data = array('vehicle_id'=>$vehicle_id,'driver_id'=>$driver_id,'exp_date'=>$exp_date,'otherid'=>$otherid,'amount'=>$amount,'bill_type'=>$bill_type,'payment_mode'=>$payment_mode,'narration'=>$narration,'comp_id'=>$comp_id,'consignorid'=>$consignorid,'session_id'=>$session_id,'updated_date'=>$currentdate,'user_id' => $user_id);
dbRowUpdate($connection,$tblname, $form_data, "$tblpkey='$other_exp_id'");

	}
?>