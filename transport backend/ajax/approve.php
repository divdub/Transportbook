<?php
include("../adminsession.php");

$dispatch_id = $_REQUEST['dispatch_id'];
$voucher_id = $_REQUEST['voucher_id'];
$voucher    = $_REQUEST['voucher'];

// echo "update dispatch_entry set is_approve=1,approved_by='$user_id' where dispatch_id='$dispatch_id'";die;
if($voucher=='voucher'){
    // echo "update payment set is_approve=1,approved_by='$user_id' where voucher_id='$voucher_id'";die;
mysqli_query($connection,"update payment set is_approve=1,approved_by='$user_id' where voucher_id='$voucher_id' && consignorid=$consignorid && session_id=$session_id");
}else{
mysqli_query($connection,"update dispatch_entry set is_approve=1,approved_by='$user_id' where dispatch_id='$dispatch_id'");
}


echo "Done";
?>