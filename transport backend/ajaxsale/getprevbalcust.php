<?php 
error_reporting(0);
include("../adminsession.php");
 $customer_id = trim(addslashes($_REQUEST['customer_id']));
$paymentdate = $cmn->dateformatusa(trim(addslashes($_REQUEST['paymentdate']))); 

if($customer_id !='') {
	$purpayents = $cmn->getvalfield($connection,"inv_payment","sum(paid_amt)","customer_id='$customer_id' and type='sale' && compid='$compid' && sessionid='$sessionid'");
		$discamtt = $cmn->getvalfield($connection,"inv_payment","sum(discamt)","customer_id='$customer_id' and type='sale' && compid='$compid' && sessionid='$sessionid'");
	$sql = mysqli_query($connection,"select * from inv_saleentry where  customer_id='$customer_id' && compid='$compid' && sessionid='$sessionid'"); 
		while($row=mysqli_fetch_assoc($sql))
		{
  $saleid=$row['saleid'];
  $tot_pur = $cmn->getvalfield($connection,"inv_saleentrydetail","sum(grandtotal)","saleid='$saleid'");
$totpur+=$tot_pur;

		 }
$balamt =$opningamt+ $totpur-$purpayents-$discamtt;

echo $balamt;
}

?>