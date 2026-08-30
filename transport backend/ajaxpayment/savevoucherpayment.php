<?php 
include("../adminsession.php");

   $category = $_POST['tpcat_id'];
	$voucher_no = $_POST['voucher_no'];
	$receive_date = $_POST['receive_date'];
	$voucher_name=$_POST['voucher_name'];
	$receive_amt = $_POST['receive_amt'];
	$remark=$_POST['remark'];
	$pay_mode=$_POST['pay_mode'];
	$utrno=$_POST['utrno'];
	$bankid=$_POST['bankid'];
	$catname=$_POST['catname'];
	$rec_no= $cmn->getcode($connection,"payment_receive","rec_no","consignorid=$consignorid && session_id='$session_id'");
	$tblname="payment_receive";

$form_data = array('category'=>$category,'bankid'=>$bankid,'utrno'=>$utrno,'catname'=>$catname,'voucher_no'=>$voucher_no,'receive_date'=>$receive_date,'voucher_name'=>$voucher_name,'receive_amt'=>$receive_amt,'remark'=>$remark,'rec_no'=>$rec_no,'pay_mode'=>$pay_mode,'comp_id'=>$comp_id,'session_id'=>$session_id,'consignorid'=>$consignorid,'created_date'=>$currentdate,'user_id' => $user_id);
	dbRowInsert($connection,$tblname, $form_data);

	 $amt_paid_to=$cmn->getvalfield($connection,"payment","sum(amt_paid_to)","voucher_id='$voucher_no' && consignorid=$consignorid && session_id='$session_id'");
	 	$receive_amt=$cmn->getvalfield($connection,"payment_receive","sum(receive_amt)","voucher_no='$voucher_no' && consignorid=$consignorid && session_id='$session_id'");
$bal1=$amt_paid_to - $receive_amt;
 $bal=round($bal1);
 if($bal== 0 || $bal < 0 || $bal == 1 ){
 		mysqli_query($connection,"UPDATE payment set is_paid = 1 ,updated_date='$currentdate' WHERE voucher_id='$voucher_no' && consignorid=$consignorid && session_id='$session_id'" );
 }

	 $sql = mysqli_query($connection,"Select * from payment  where consignorid=$consignorid && voucher_id='$voucher_no' && session_id='$session_id'");
                                          	  while($row= mysqli_fetch_array($sql)) {
											// echo	"UPDATE dispatch_entry set is_complete = 1 ,updated_date='$currentdate' WHERE dispatch_id='$row[dispatch_id]' && consignor_id='$consignorid'";
	mysqli_query($connection,"UPDATE dispatch_entry set is_complete = 1 ,updated_date='$currentdate' WHERE dispatch_id='$row[dispatch_id]' && consignor_id='$consignorid'" );
}
?>