<?php 
// error_reporting(0);
   include("../adminsession.php");
// include("../function/bill_function.php");
      $dbillid = $_REQUEST['dbillid']; 

	
										      
										  		$amount = $cmn->getinvoiceamount($connection,$invoiceid);
     $amt_paid_to = $cmn->getvalfield($connection,"dispatch_entry","sum(diesel_adv_amt)","dbillid='$dbillid'"); 	 
// $invdate=$row['invdate'];
$dbilldate = $cmn->getvalfield($connection,"dieselbill","dbilldate","dbillid='$dbillid'"); 	
$discountamt = $cmn->getvalfield($connection,"dieselbill","discountamt","dbillid='$dbillid'"); 	
$pump_id = $cmn->getvalfield($connection,"dispatch_entry","pump_id","dbillid='$dbillid'");
$pumpname= $cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id='$pump_id'");									  
$receive_amt = $cmn->getvalfield($connection,"diesel_pay","sum(rcv_amt)","dbillid='$dbillid'"); 
	$diesel_adv_amt=$amt_paid_to - $receive_amt - $discountamt;
	
echo $dbilldate."|".$pumpname."|".$diesel_adv_amt;	
									  
										  
									  
?>
						