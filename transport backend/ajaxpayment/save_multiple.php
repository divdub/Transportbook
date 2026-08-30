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
   $frt_debit=$_POST['frt_debit'];
	$catname=$_POST['catname'];
	$cat_id=$_POST['cat_id'];
	$total_amt=$_POST['total_amt'];
		$deduct=$_POST['deduct'];
	$tblname="payment";
   $diesel_adv_amt =$_POST['diesel_adv_amt'];
   $cash_adv =$_POST['cash_adv']; 
   $other_cash_adv = $_POST['other_cash_adv'];
   $consignor_cash_adv =$_POST['consignor_cash_adv'];
   $consignee_cash_adv =$_POST['consignee_cash_adv']; 
   $gstper=$_POST['gstper']; 
   $gst_type=$_POST['gst_type'];
   $panno=$_POST['panno'];
  $bill_type=$_POST['bill_type'];
  $ifsc_code=$_POST['ifsc_code'];
  $bank_charge=$_POST['bank_charge'];
  $rebidcharge=$_POST['rebidcharge'];
   $cmtrate=$_POST['cmtrate'];
  $acc_no=$_POST['acc_no'];
$checkbox=$cmn->getvalfield($connection,"dispatch_entry","checkbox","dispatch_id='$dispatch_id'");

//  echo "'sortamt'=>$sortamt,'dispatch_id'=>$dispatch_id,'tds'=>$tds,'tds_amt'=>$tds_amt,'bilty_commision'=>$bilty_commision,'paid_to'=>$paid_to,'commision'=>$commision,'voucher_no'=>'0','freight_amt'=>$freight_amt,'freight_rate'=>$freight_rate,'category_id'=>$cat_id,'catname'=>$catname,'amt_paid_to'=>$total_amt,'diesel_adv_amt'=>$diesel_adv_amt,'cash_adv'=>$cash_adv,'other_cash_adv'=>$other_cash_adv,'consignor_cash_adv'=>$consignor_cash_adv,'consignee_cash_adv'=>$consignee_cash_adv,'gstper'=>$gstper,'gst_type'=>$gst_type,'bill_type'=>$bill_type,'consignorid'=>$consignorid,

// 	'comp_id'=>$comp_id,'session_id'=>$session_id,'created_date'=>$currentdate";


 if($checkbox==0){
$iscreate = $cmn->getvalfield($connection,"dispatch_entry","is_create","dispatch_id = '$dispatch_id'");

 }
if($checkbox==1){

$iscreate = $cmn->getvalfield($connection,"tpa_entry","is_create","dispatch_id = '$dispatch_id' && tpcat_id='$cat_id'");
                              }
                              if($iscreate==0){
$form_data = array('sortamt'=>$sortamt,'deduct'=>$deduct,'dispatch_id'=>$dispatch_id,'cmtrate'=>$cmtrate,'frt_debit'=>$frt_debit,'rebidcharge'=>$rebidcharge,'panno'=>$panno,'bank_charge'=>$bank_charge,'tds'=>$tds,'tds_amt'=>$tds_amt,'bilty_commision'=>$bilty_commision,'paid_to'=>$paid_to,'commision'=>$commision,'voucher_no'=>'0','freight_amt'=>$freight_amt,'freight_rate'=>$freight_rate,'category_id'=>$cat_id,'catname'=>$catname,'amt_paid_to'=>$total_amt,'diesel_adv_amt'=>$diesel_adv_amt,'cash_adv'=>$cash_adv,'other_cash_adv'=>$other_cash_adv,'consignor_cash_adv'=>$consignor_cash_adv,'consignee_cash_adv'=>$consignee_cash_adv,'gstper'=>$gstper,'gst_type'=>$gst_type,'bill_type'=>$bill_type,'consignorid'=>$consignorid,'ifsc_code'=>$ifsc_code,'acc_no'=>$acc_no,

	'comp_id'=>$comp_id,'session_id'=>$session_id,'created_date'=>$currentdate,'user_id' => $user_id);
	dbRowInsert($connection,$tblname, $form_data);


 if($checkbox==0){
 		mysqli_query($connection,"UPDATE dispatch_entry set is_create = 1 ,is_voucher= 1 ,updated_date='$currentdate' WHERE dispatch_id='$dispatch_id'" );
 }
if($checkbox==1){

	mysqli_query($connection,"UPDATE tpa_entry set is_create = 1  WHERE dispatch_id='$dispatch_id' && tpcat_id='$cat_id'" );
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
                              }
?>

