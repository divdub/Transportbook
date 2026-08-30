<?php 
include("../adminsession.php");

   $payment_id = $_POST['payment_id'];
	$sortamt = $_POST['sortamt'];
	$tds = $_POST['tds'];
	$tds_amt = $_POST['tds_amt'];
	$bilty_commision=$_POST['bilty_commision'];
	
   $rebidcharge=$_POST['rebidcharge'];
	$total_amt=$_POST['total_amt'];
	$tblname="payment";
   $bank_charge=$_POST['bank_charge']; 
   $gstper=$_POST['gstper']; 
   $gst_type=$_POST['gst_type'];
  $bill_type=$_POST['bill_type'];
  $ifsc_code=$_POST['ifsc_code'];
  $acc_no=$_POST['acc_no'];
   $panno=$_POST['panno'];                 
mysqli_query($connection,"UPDATE payment set sortamt='$sortamt',rebidcharge='$rebidcharge',tds='$tds',tds_amt='$tds_amt',bilty_commision='$bilty_commision',panno='$panno',bank_charge='$bank_charge',amt_paid_to='$total_amt',gstper='$gstper',gst_type='$gst_type',bill_type='$bill_type',user_id='$user_id',ifsc_code='$ifsc_code',acc_no='$acc_no',updated_date='$currentdate' WHERE payment_id='$payment_id'" );

                         
                          


                              
?>

