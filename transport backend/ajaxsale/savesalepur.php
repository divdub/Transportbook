<?php include("../adminsession.php");

 $customer_id = trim(addslashes($_REQUEST['customer_id']));
  $paymentdate = trim(addslashes($_REQUEST['paymentdate'])); 
 $paid_amt = trim(addslashes($_REQUEST['paid_amt']));
$disc = trim(addslashes($_REQUEST['disc']));
$pay_type = trim(addslashes($_REQUEST['pay_type']));
$narration = trim(addslashes($_REQUEST['narration']));
  $paymentid = trim(addslashes($_REQUEST['paymentid']));

 // $keyvalue = $paymentid;

	if($customer_id!='' && $paymentdate!='' && $paid_amt!='') {
	if($paymentid==0) {
		
	mysqli_query($connection,"insert into inv_payment set paymentdate='$paymentdate', customer_id='$customer_id',	
	paid_amt='$paid_amt',discamt='$disc',pay_type='$pay_type',narration='$narration',createdby='$loginid',createdate='$createdate',
	type='sale',ipaddress='$ipaddress',sessionid='$sessionid',compid='$compid', consignor_id='$consignorid', user_id='$user_id'");

$keyvalue = mysqli_insert_id($connection);

	
	
			
	}
	else
	{
	echo "UPDATE inv_payment set paymentdate='$paymentdate', customer_id='$customer_id', 
	paid_amt='$paid_amt', discamt='$disc',pay_type='$pay_type', narration='$narration',createdby='$loginid',lastupdated='$createdate',
	ipaddress='$ipaddress' where paymentid='$paymentid'";
	  
		mysqli_query($connection,"UPDATE inv_payment set paymentdate='$paymentdate', customer_id='$customer_id', 
	paid_amt='$paid_amt', discamt='$disc',pay_type='$pay_type', narration='$narration', consignor_id='$consignorid', createdby='$loginid',lastupdated='$createdate',
	ipaddress='$ipaddress' where paymentid='$paymentid'");

	}

}

?>



