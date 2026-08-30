<?php 
include("../adminsession.php");

   $current_date=date('Y-m-d');
   $iteminv_id=$_REQUEST['iteminv_id'];
   $unitinv_id=$_REQUEST['unitinv_id'];
   $gst=$_REQUEST['gst'];
   $qty=$_REQUEST['qty'];
   $rate=$_REQUEST['rate'];
   $purdetail_id=$_REQUEST['purdetail_id'];  
   $purchaseid = $_REQUEST['purchaseid'];
   $total_amt=$_REQUEST['total_amt'];
   $nettotal=$_REQUEST['nettotal'];
    $serial_no=$_REQUEST['serial_no'];
  
       $iteminv_category_id = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id='$iteminv_id'");
      $itemcateid =  $cmn->getvalfield($connection, "m_iteminv_category", "category_name", "iteminv_category_id='$iteminv_category_id'");
       
   if($qty!='')
   
{
   
	if($purdetail_id==''){

// echo "INSERT into purchasentry_detail set purchaseid='$purchaseid',serial_no='$serial_no',compid='$comp_id', gst='$gst',iteminv_id='$iteminv_id', unitinv_id='$unitinv_id',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$session_id', consignor_id='$consignorid', createdate='$createdate',ipaddress='$ipaddress','user_id' = $user_id";
   	mysqli_query($connection,"INSERT into purchasentry_detail set purchaseid='$purchaseid',serial_no='$serial_no',compid='$comp_id', gst='$gst',iteminv_id='$iteminv_id', unitinv_id='$unitinv_id',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$session_id', consignor_id='$consignorid', createdate='$createdate',ipaddress='$ipaddress',user_id = $user_id");

      $action=1;
   $process = "insert";
}
else
{

   mysqli_query($connection,"update  purchasentry_detail set purchaseid='$purchaseid',serial_no='$serial_no', gst='$gst',iteminv_id='$iteminv_id',compid='$comp_id', unitinv_id='$unitinv_id',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$session_id',  consignor_id='$consignorid', lastupdated='$createdate',ipaddress='$ipaddress' WHERE purdetail_id = '$purdetail_id'");


   $action=2;
   $process = "update";
}	
}


?>