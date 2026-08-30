<?php 
include("../adminsession.php");
   $dispatch_id = $_POST['dispatch_id'];
	$pump_id = $_POST['pump_id'];
	$adblue_id = $_POST['adblue_id'];
	$adblueqty = $_POST['adblueqty'];
	$rate = $_POST['rate'];
	$diesel_rate = $_POST['diesel_rate'];
	$diesel_ltr = $_POST['diesel_ltr'];
	$diesel_adv_amt=$_POST['diesel_adv_amt'];
	$cash_adv = $_POST['cash_adv'];
	$cash_adv_date = $_POST['cash_adv_date'];
	$other_cash_adv = $_POST['other_cash_adv'];
    $other_cash_adv_date = $_POST['other_cash_adv_date'];
	$consignor_cash_adv = $_POST['consignor_cash_adv'];
	$consignor_cash_adv_date = $_POST['consignor_cash_adv_date'];
	$consignee_cash_adv = $_POST['consignee_cash_adv'];
	$consignee_cash_adv_date = $_POST['consignee_cash_adv_date'];
	$adv_remark=$_POST['adv_remark'];
	$pay_type=$_POST['pay_type'];
	$deduct=$_POST['deduct'];
	$tblname="dispatch_entry";

	$form_data = array('pump_id'=>$pump_id,'diesel_rate'=>$diesel_rate, 'pay_type'=>$pay_type, 'deduct'=>$deduct, 'adblue_id'=>$adblue_id,'adblueqty'=>$adblueqty,'rate'=>$rate,'diesel_ltr'=>$diesel_ltr,'cash_adv'=>$cash_adv,'cash_adv_date'=>$cash_adv_date,'other_cash_adv'=>$other_cash_adv,'other_cash_adv_date'=>$other_cash_adv_date,'consignor_cash_adv'=>$consignor_cash_adv,'consignor_cash_adv_date'=>$consignor_cash_adv_date,'diesel_adv_amt'=>$diesel_adv_amt,'consignee_cash_adv'=>$consignee_cash_adv,'consignee_cash_adv_date'=>$consignee_cash_adv_date,'is_advance'=>'1','adv_remark'=>$adv_remark,'updated_date'=>$currentdate,'addvuser_id'=>$user_id);
	dbRowUpdate($connection,$tblname, $form_data, "dispatch_id='$dispatch_id'");
	
	if($diesel_adv_amt !=''){
     $query = "SELECT MAX(demand_no) AS max_demand FROM dispatch_entry";
     $result = mysqli_query($connection, $query);
     $row = mysqli_fetch_assoc($result);

    // Increment and pad with zeros to make it 4 digits
    $next_demand_no = isset($row['max_demand']) ? (int)$row['max_demand'] + 1 : 1;
    $next_demand_no_padded = str_pad($next_demand_no, 4, '0', STR_PAD_LEFT);
    //  echo $next_demand_no_padded;
    $form_data = array('demand_no'=>$next_demand_no_padded);
	dbRowUpdate($connection,$tblname, $form_data, "dispatch_id='$dispatch_id'");
     }
	
?>