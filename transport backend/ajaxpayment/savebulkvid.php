<?php 
include("../adminsession.php");


	$voucher_date=$_POST['voucher_date'];
	$remark=$_POST['remark'];
	$cat_id=$_POST['cat_id'];
	$payee_name=$_POST['payee_name'];
  
	$tblname="payment";
 //     if($cat_id=='1'){
 //  // $no=$cmn->getcode($connection,"payment","max(voucher_no)","paid_to='Agent'");
 //  $voucher_no= $cmn->getcode($connection,"payment","voucher_no","category_id='1'");
 //  }
 // if($cat_id=='2'){
 //  $voucher_no=$cmn->getcode($connection,"payment","voucher_no","category_id='2'");
 //   }
 //     if($cat_id=='4'){
 //  $voucher_no=$cmn->getcode($connection,"payment","voucher_no","category_id='4'");
 //  } 
  if($cat_id=='1'){
  // $no=$cmn->getcode($connection,"payment","max(voucher_no)","paid_to='Agent'");
  $voucher_no= $cmn->getcode($connection,"payment","voucher_no","category_id='1' && consignorid=$consignorid && session_id='$session_id'");
   // $last_id = $cmn->getvalfield($connection, "payment", "max(voucher_no)", "category_id='1'") +1;
  $voucher_id ='AG-'.$voucher_no;
  }
 if($cat_id=='2'){
  $voucher_no=$cmn->getcode($connection,"payment","voucher_no","category_id='2' && consignorid=$consignorid && session_id='$session_id'");
   // $last_id = $cmn->getvalfield($connection, "payment", "max(voucher_no)", "category_id='2'") +1;
  $voucher_id ='CO-'.$voucher_no;
   }
     if($cat_id=='4'){
  $voucher_no=$cmn->getcode($connection,"payment","voucher_no","category_id='4' && consignorid=$consignorid && session_id='$session_id'");
   // $last_id = $cmn->getvalfield($connection, "payment", "max(voucher_no)", "category_id='4'") +1;
  $voucher_id ='TO-'.$voucher_no;
  }
	mysqli_query($connection,"UPDATE payment set voucher_date = '$voucher_date', voucher_no='$voucher_no', voucher_id='$voucher_id', remark='$remark', payee_name='$payee_name', updated_date='$currentdate' WHERE voucher_no='0' && consignorid='$consignorid' && comp_id='$comp_id' && session_id='$session_id'");
	
?>