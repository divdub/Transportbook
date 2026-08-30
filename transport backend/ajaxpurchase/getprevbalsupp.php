<?php 
error_reporting(0);
include("../adminsession.php");
$supplier_id = trim(addslashes($_REQUEST['supplier_id']));
$paymentdate = trim(addslashes($_REQUEST['paymentdate'])); 

if($supplier_id!='') {

	    $purpayents = $cmn->getvalfield($connection,"inv_payment","sum(paid_amt)","supplier_id='$supplier_id' and type='purchase' && compid='$comp_id' && consignor_id='$consignorid' && sessionid='$session_id'");
		$discamtt = $cmn->getvalfield($connection,"inv_payment","sum(discamt)","supplier_id='$supplier_id' and type='purchase' && consignor_id='$consignorid' && compid='$comp_id' && sessionid='$session_id'");

		$sql = mysqli_query($connection,"select * from purchaseentry where  supplier_id='$supplier_id' && consignor_id='$consignorid' && compid='$comp_id' && sessionid='$session_id'"); 
		while($row=mysqli_fetch_assoc($sql))
		{
  $purchase_id=$row['purchaseid'];
  $tot_pur = $cmn->getvalfield($connection,"purchasentry_detail","sum(nettotal)","purchaseid='$purchase_id'");
$totpur+=$tot_pur;

		 }
$balamt =$opningamt+ $totpur-$purpayents-$discamtt;
echo $balamt;
}

?>