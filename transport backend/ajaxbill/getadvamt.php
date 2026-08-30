<?php
include("../adminsession.php");

$advid = $_REQUEST['advid'];

$sql = mysqli_query($connection, "Select * from  diesel_advpayment where consignorid=$consignorid  && sessionid=$session_id && dadvpayid=$advid order by dadvpayid");
$row = mysqli_fetch_array($sql);
$adv_amt = $row['adv_amt'];

$paid_amt = $cmn->getvalfield($connection, "diesel_pay", "sum(rcv_amt)", "advid='$advid' ");
$adv_bal_amt = $adv_amt - $paid_amt;
?> 
<?php echo $adv_bal_amt; 
?>