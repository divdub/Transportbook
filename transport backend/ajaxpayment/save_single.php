<?php 
include("../adminsession.php");

   $dispatch_id = $_POST['dispatch_id'];
	$sortamt = $_POST['sortamt'];
	$tds = $_POST['tds'];
	$tds_amt = $_POST['tds_amt'];
	$bilty_commision=$_POST['bilty_commision'];
	$paid_to = $_POST['paid_to'];
	$commision=$_POST['commision'];
	$freight_rate=$_POST['freight_rate'];
	$freight_amt=$_POST['freight_amt'];
	$payment_date=$_POST['payment_date'];
	$remark=$_POST['remark'];
	$tpcat_id=$_POST['tpcat_id'];
		$total=$_POST['total'];
		$name=$_POST['name'];
		   $diesel_adv_amt =$_POST['diesel_adv_amt'];
   $cash_adv =$_POST['cash_adv']; 
   $other_cash_adv = $_POST['other_cash_adv'];
   $consignor_cash_adv =$_POST['consignor_cash_adv'];
   $consignee_cash_adv =$_POST['consignee_cash_adv']; 
		$payee_name=$_POST['payee_name'];
		$gstper=$_POST['gstper'];
		$gst_type=$_POST['gst_type'];
		$bill_type=$_POST['bill_type'];
			$acc_no=$_POST['acc_no'];
		$ifsc_code=$_POST['ifsc_code'];
	$tblname="payment";
    if($tpcat_id=='1'){
  // $no=$cmn->getcode($connection,"payment","max(voucher_no)","paid_to='Agent'");
  $voucher_no= $cmn->getcode($connection,"payment","voucher_no","category_id='1' && consignorid=$consignorid");
   // $last_id = $cmn->getvalfield($connection, "payment", "max(voucher_no)", "category_id='1'") +1;
  $voucher_id ='AG-'.$voucher_no;
  }
 if($tpcat_id=='2'){
  $voucher_no=$cmn->getcode($connection,"payment","voucher_no","category_id='2' && consignorid=$consignorid");
   // $last_id = $cmn->getvalfield($connection, "payment", "max(voucher_no)", "category_id='2'") +1;
  $voucher_id ='CO-'.$voucher_no;
   }
     if($tpcat_id=='4'){
  $voucher_no=$cmn->getcode($connection,"payment","voucher_no","category_id='4' && consignorid=$consignorid");
   // $last_id = $cmn->getvalfield($connection, "payment", "max(voucher_no)", "category_id='4'") +1;
  $voucher_id ='TO-'.$voucher_no;
  }

$form_data = array('sortamt'=>$sortamt,'dispatch_id'=>$dispatch_id,'tds'=>$tds,'tds_amt'=>$tds_amt,'bilty_commision'=>$bilty_commision,'paid_to'=>$paid_to,'commision'=>$commision,'voucher_no'=>$voucher_no,'voucher_id'=>$voucher_id,'freight_amt'=>$freight_amt,'freight_rate'=>$freight_rate,'category_id'=>$tpcat_id,'catname'=>$name,'payee_name'=>$payee_name,'voucher_date'=>$payment_date,'diesel_adv_amt'=>$diesel_adv_amt,'cash_adv'=>$cash_adv,'other_cash_adv'=>$other_cash_adv,'consignor_cash_adv'=>$consignor_cash_adv,'bill_type'=>$bill_type,'gst_type'=>$gst_type,'gstper'=>$gstper,'consignee_cash_adv'=>$consignee_cash_adv,'remark'=>$remark, 'amt_paid_to'=>$total,'comp_id'=>$comp_id,'session_id'=>$session_id,'consignorid'=>$consignorid,'acc_no'=>$acc_no,'ifsc_code'=>$ifsc_code,'created_date'=>$currentdate,'user_id' => $user_id);
	dbRowInsert($connection,$tblname, $form_data);

	 $checkbox=$cmn->getvalfield($connection,"dispatch_entry","checkbox","dispatch_id='$dispatch_id'");
 if($checkbox==0){
 		mysqli_query($connection,"UPDATE dispatch_entry set is_create = 1 ,is_voucher= 1 ,updated_date='$currentdate' WHERE dispatch_id='$dispatch_id'" );
 }
if($checkbox==1){

	mysqli_query($connection,"UPDATE tpa_entry set is_create = 1  WHERE dispatch_id='$dispatch_id' && tpcat_id='$tpcat_id'" );
$amt = $cmn->getvalfield($connection,"tpa_entry","sum(amt)","dispatch_id = '$dispatch_id'");
$wt_mt = $cmn->getvalfield($connection,"dispatch_entry","wt_mt","dispatch_id = '$dispatch_id'");
$own_rate = $cmn->getvalfield($connection,"dispatch_entry","own_rate","dispatch_id = '$dispatch_id'");
                          $freight_amt= $wt_mt * $own_rate;
                          if($freight_amt== $amt){
                          	 $iscreate=$cmn->getvalfield($connection,"tpa_entry","count(tpa_id)","dispatch_id='$dispatch_id' && is_create=0");
                              if($iscreate==0){
mysqli_query($connection,"UPDATE dispatch_entry set is_voucher= 1 ,updated_date='$currentdate' WHERE dispatch_id='$dispatch_id'" );

                              }
                          }
}	
	
?>