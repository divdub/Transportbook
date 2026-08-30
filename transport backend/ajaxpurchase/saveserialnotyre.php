<?php 
error_reporting(0);
include("../adminsession.php");
$qty = trim(addslashes($_REQUEST['qty']));
 $purchaseid =$_REQUEST['purchaseid'];
$iteminv_id = trim(addslashes($_REQUEST['iteminv_id']));
  $purdetail_id = trim(addslashes($_REQUEST['purdetail_id']));
  $pos_id = $_REQUEST['pos_id'];
  $serial_no = trim(addslashes($_REQUEST['serial_no']));
  $i = trim(addslashes($_REQUEST['i']));

   $loop= $cmn->getvalfield($connection,"purchaseorderserial","count(pos_id)","iteminv_id='$iteminv_id'  && loop_i=$i and purchaseid='0' && compid='$comp_id' && session_id='$session_id' && consignor_id='$consignorid'");
$totserial= $cmn->getvalfield($connection,"purchaseorderserial","count(pos_id)","iteminv_id='$iteminv_id' and serial_no='$serial_no'  and purchaseid='0' && compid='$comp_id' && session_id='$session_id' && consignor_id='$consignorid'");

$countval= $cmn->getvalfield($connection,"purchaseorderserial","count(pos_id)","iteminv_id='$iteminv_id' and purchaseid='0' && compid='$comp_id' && session_id='$session_id' && consignor_id='$consignorid'");
if($countval==$qty){
  $totqty=$qty;
} else {
  $totqty=$countval+1;
}

if($purdetail_id==0){
  if($totserial=='0'){
  if($loop=='0'){
     
  mysqli_query($connection,"insert into purchaseorderserial set serial_no='$serial_no',purdetail_id='$purdetail_id',compid='$comp_id',consignor_id='$consignorid',session_id='$session_id',purchaseid='$purchaseid',iteminv_id='$iteminv_id',loop_i='$i'");
echo $totqty;
  } else {
    mysqli_query($connection,"update purchaseorderserial set serial_no='$serial_no',purdetail_id='$purdetail_id',purchaseid='$purchaseid',compid='$comp_id',session_id='$session_id',iteminv_id='$iteminv_id' where  iteminv_id='$iteminv_id' and loop_i='$i'and purchaseid='$purchaseid' && compid='$comp_id' && session_id='$session_id' && consignor_id='$consignorid'");
    echo $totqty;
  

  }
} else {
    echo "duplicate";
  }
}else{
  if($totserial=='0'){
	if($loop=='0'){
	   
  mysqli_query($connection,"insert into purchaseorderserial set serial_no='$serial_no',purdetail_id='$purdetail_id',compid='$comp_id',consignor_id='$consignorid',session_id='$session_id',purchaseid='$purchaseid',iteminv_id='$iteminv_id',loop_i='$i'");
echo $totqty;
  } else {
    mysqli_query($connection,"update purchaseorderserial set serial_no='$serial_no',purdetail_id='$purdetail_id',purchaseid='$purchaseid',iteminv_id='$iteminv_id' where  iteminv_id='$iteminv_id' and loop_i='$i'and purchaseid='$purchaseid' && compid='$comp_id' && session_id='$session_id' && consignor_id='$consignorid'");
    echo $totqty;
  }
} else {
  echo "duplicate";
}
}


?>
