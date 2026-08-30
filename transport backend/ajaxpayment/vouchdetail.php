<?php 
error_reporting(0);
   include("../adminsession.php");
     $voucher_no = $_REQUEST['voucher_no']; 
     $category_id=$_REQUEST['tpcat_id'];
//   echo   "select * from payment where voucher_id ='$voucher_no' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id";
    $sql = mysqli_query($connection, "select * from payment where voucher_id ='$voucher_no' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");

      $row = mysqli_fetch_array($sql);
     
   $category_id =$row['category_id'];
   $catname =$row['catname'];
    $dispatch_id =$row['dispatch_id'];
    $payee_name =$row['payee_name'];
 $payee_name =$row['payee_name'];
  $accountno =$row['acc_no'];
   $Ifsccode =$row['ifsc_code'];
    $Panno =$row['panno'];
// $dispatch_id= $cmn->getvalfield($connection, "payment", "dispatch_id", "category_id ='$row[category_id]'");
if($category_id==1){
    
    $agent_id= $cmn->getvalfield($connection, "dispatch_entry", "agent_id", "dispatch_id ='$dispatch_id'");
    $voucher_name= $cmn->getvalfield($connection, "m_agent", "agent_name", "agent_id ='$agent_id'");
}
if($category_id==2){
    $consignee_id= $cmn->getvalfield($connection, "dispatch_entry", "consignee_id", "dispatch_id ='$dispatch_id'");
    $voucher_name= $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id ='$consignee_id'");
}
if($category_id==4){
$owner_id=$cmn->getvalfield($connection,"dispatch_entry","owner_id","dispatch_id ='$dispatch_id'");
$voucher_name= $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id ='$owner_id'");
}
$amt_paid_to=$cmn->getvalfield($connection,"payment","sum(amt_paid_to)","voucher_id ='$voucher_no' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id ");

$receive_amt=$cmn->getvalfield($connection,"payment_receive","sum(receive_amt)","voucher_no ='$voucher_no' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id ");
$balance_amt=$amt_paid_to - $receive_amt;
$rec_no=$cmn->getvalfield($connection,"payment_receive","count(pay_receive_id)","voucher_no ='$voucher_no'  && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id") +1;

echo  $voucher_name."|".$amt_paid_to."|".$balance_amt."|".$rec_no."|".$catname ."|".$payee_name."|".$accountno."|".$Ifsccode."|".$Panno;
   ?>