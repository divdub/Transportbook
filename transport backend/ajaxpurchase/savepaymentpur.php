<?php include("../adminsession.php");

 $supplier_id = trim(addslashes($_REQUEST['supplier_id']));
  $paymentdate = trim(addslashes($_REQUEST['paymentdate'])); 
 $paid_amt = trim(addslashes($_REQUEST['paid_amt']));
$disc = trim(addslashes($_REQUEST['disc']));
$pay_type = trim(addslashes($_REQUEST['pay_type']));
$narration = trim(addslashes($_REQUEST['narration']));
 $paymentid = trim(addslashes($_REQUEST['paymentid']));

 // $keyvalue = $paymentid;

	if($supplier_id  !='' && $paymentdate !='' && $paid_amt !='') {
	if($paymentid==0) {
	mysqli_query($connection,"insert into inv_payment set paymentdate='$paymentdate', supplier_id ='$supplier_id',	
	paid_amt='$paid_amt',discamt='$disc',pay_type='$pay_type',narration='$narration',createdby='$loginid', consignor_id='$consignorid' ,compid='$comp_id',createdate='$createdate',
	type='purchase',ipaddress='$ipaddress',sessionid='$session_id',user_id='$user_id'");

$keyvalue = mysqli_insert_id($connection);


	}
	else
	{
 	
		mysqli_query($connection,"UPDATE inv_payment set paymentdate='$paymentdate', supplier_id ='$supplier_id', 
	paid_amt='$paid_amt', discamt='$disc',pay_type='$pay_type', narration='$narration', consignor_id='$consignorid' , createdby='$loginid',lastupdated='$createdate',
	ipaddress='$ipaddress' where paymentid='$paymentid'");


	}

}

?>



