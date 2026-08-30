<?php 
include("../adminsession.php");

$dispatch_id = $_POST['dispatch_id'];
$deduction_id = $_POST['deduction_id'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$remark = $_POST['remark'];
$type = $_POST['type'];


$tblname = "dispatch_deduction";

$sql = "INSERT INTO dispatch_deduction
(dispatch_id,deduction_id,amount,date,remark,type,session_id,consignorid,createdate)
VALUES
('$dispatch_id','$deduction_id','$amount','$date','$remark','$type','$session_id','$consignorid','$currentdate')";

if(mysqli_query($connection,$sql)){
 echo "success";
}else{
 echo mysqli_error($connection);
}

?>
