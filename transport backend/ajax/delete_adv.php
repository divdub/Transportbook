<?php 
include("../adminsession.php");

   $dispatch_id = $_REQUEST['dispatch_id'];
 // echo  "UPDATE dispatch_entry set pump_id = '',diesel_rate='',diesel_ltr='',cash_adv='',cash_adv_date='',other_cash_adv='',other_cash_adv_date='',consignor_cash_adv='',consignor_cash_adv_date='',diesel_adv_amt='',consignee_cash_adv='',consignee_cash_adv_date='',is_advance='',updated_date='$currentdate' WHERE dispatch_id='$dispatch_id' ";

	mysqli_query($connection,"UPDATE dispatch_entry set pump_id = '',diesel_rate='',diesel_ltr='',cash_adv='',cash_adv_date='',other_cash_adv='',other_cash_adv_date='',consignor_cash_adv='',consignor_cash_adv_date='',diesel_adv_amt='',consignee_cash_adv='',consignee_cash_adv_date='',is_advance='',updated_date='$currentdate' WHERE dispatch_id='$dispatch_id'" );
	
	
?>