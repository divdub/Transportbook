<?php 
include("../adminsession.php");
   $current_date=date('Y-m-d');
  
   
   $iteminv_id=$_REQUEST['iteminv_id'];

   $unitinv_id=$_REQUEST['unitinv_id'];
   $gst=$_REQUEST['gst'];
   $qty=$_REQUEST['qty'];
   $rate=$_REQUEST['rate'];
   $disc=$_REQUEST['disc'];
   $saledetail_id=$_REQUEST['saledetail_id'];  
   $total_amt=$_REQUEST['total_amt'];
   $nettotal=$_REQUEST['nettotal'];
   $serial_no=$_REQUEST['serial_no'];
   $grandtotal=$_REQUEST['grandtotal'];
   $hiddenid=$_REQUEST['hiddenid'];
   $iteminv_category_id = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id='$iteminv_id'");
   $itemcateid =  $cmn->getvalfield($connection, "m_iteminv_category", "category_name", "iteminv_category_id='$iteminv_category_id'");
    $ids = explode(',', $hiddenid); 
   
   if($qty !='')
   
{
	if($saledetail_id==''){

   
   	mysqli_query($connection,"INSERT into inv_saleentrydetail set saleid='$saleid',pos_id='$hiddenid', gst='$gst',iteminv_id='$iteminv_id', comp_id='$compid',unitinv_id='$unitinv_id',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate', consignor_id='$consignorid', ipaddress='$ipaddress',disc='$disc',grandtotal='$grandtotal',user_id='$user_id'");
           $lastid = mysqli_insert_id($connection);
      $action=1;
   $process = "insert";
}
else
{
//echo "update  inv_saleentrydetail set  gst='$gst',iteminv_id='$iteminv_id', comp_id='$compid', unitinv_id='$unitinv_id',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress',disc='$disc',grandtotal='$grandtotal' WHERE saledetail_id = '$saledetail_id'";
   mysqli_query($connection,"update  inv_saleentrydetail set gst='$gst',iteminv_id='$iteminv_id', comp_id='$compid', unitinv_id='$unitinv_id',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid', consignor_id='$consignorid', createdate='$createdate',ipaddress='$ipaddress',disc='$disc',grandtotal='$grandtotal' WHERE saledetail_id = '$saledetail_id'");
$lastid=$saledetail_id;
	mysqli_query($connection,"update purchaseorderserial set sale='0',saledetail_id='0' where saledetail_id='$saledetail_id'");
   $action=2;
   $process = "update";
}
if($hiddenid!=''){
foreach($ids as $id) {
		// echo $id; 
	// echo	"update dispatch_entry set dbillid='$lastid',is_bill='1' where dispatch_id='$id'";
		mysqli_query($connection,"update purchaseorderserial set sale='1',saledetail_id='$lastid' where pos_id='$id'");

}
}

}


?>