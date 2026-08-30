<?php
include("../adminsession.php");

$id = $_POST['id'];
$dispatch_id = $_POST['dispatch_id'];
mysqli_query($connection,"DELETE FROM dispatch_deduction WHERE id='$id'");

$sql = mysqli_query($connection,
"SELECT amount,type 
FROM dispatch_deduction 
WHERE dispatch_id='$dispatch_id'");

$total = 0;

while($row = mysqli_fetch_assoc($sql)){

    if(strtolower($row['type'])=="add"){
        $total += $row['amount'];
    }
    else{
        $total -= $row['amount'];
    }
}
$sql_insert="update dispatch_entry set deduct = '$total' WHERE dispatch_id = '$dispatch_id'";
 
		mysqli_query($connection,$sql_insert);
echo "success";
?>