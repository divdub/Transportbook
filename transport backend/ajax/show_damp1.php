<?php
include("../adminsession.php");

$dispatch_id = $_POST['dispatch_id'] ?? 0;

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

echo $total;
?>