<?php 
   include("../adminsession.php");
// include("../function/bill_function.php");
      $invoiceid = $_REQUEST['invoiceid']; 
     
	
										      
										  		$amount1 = $cmn->getinvoiceamount1($connection,$invoiceid);
                                      $wt_mt = $cmn->getvalfield($connection,"dispatch_entry","sum(wt_mt)","invoiceid='$invoiceid'"); 	 
// $invdate=$row['invdate'];
$invdate = $cmn->getvalfield($connection,"invoicebilty","invdate","invoiceid='$invoiceid'"); 	
$gstval = $cmn->getvalfield($connection,"invoicebilty","gst","invoiceid='$invoiceid'"); 	
				$gst=$amount1 * ($gstval/100);		
			$amount=$amount1 + $gst;
										  
echo $invdate."|".$wt_mt."|".$amount."|".$amount1."|".$gstval."|".$gst;	
									  
										  
									  
?>
						