<?php
include("../adminsession.php");
$dispatch_id = $_POST['dispatch_id'];

$sql = mysqli_query($connection,
"SELECT amount,type 
FROM dispatch_deduction 
WHERE dispatch_id='$dispatch_id'");

$add = 0;
$subtract = 0;
$finaltotal=0;
$add=$cmn->getvalfield($connection,"dispatch_deduction","sum(amount)","dispatch_id=$dispatch_id && type='add'");
$subtract=$cmn->getvalfield($connection,"dispatch_deduction","sum(amount)","dispatch_id=$dispatch_id && type='subtract'");
if($add==0){
   $finaltotal= $subtract;
} elseif($subtract >= $add) {
     $finaltotal=$subtract - $add;  
}else { 
  $finaltotal=$add - $subtract;  
}

$sql_insert="update dispatch_entry set deduct = '$finaltotal' WHERE dispatch_id = '$dispatch_id'";
 
		mysqli_query($connection,$sql_insert);
echo "success";
?>