<?php 
error_reporting(0);
   include("../adminsession.php");
     $payee_name = $_REQUEST['payee_name']; 
    
//   echo   "select * from payment where voucher_id ='$voucher_no' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id";
    $sql = mysqli_query($connection, "select * from paid_to where payee_name ='$payee_name'");

      $row = mysqli_fetch_array($sql);
     
   $account_no =$row['account_no'];
   $ifsc_code =$row['ifsc_code'];
    $pan_no =$row['pan_no'];
// $dispatch_id= $cmn->getvalfield($connection, "payment", "dispatch_id", "category_id ='$row[category_id]'");
// echo $account_no;


echo  $account_no."|".$ifsc_code."|".$pan_no ;
   ?>