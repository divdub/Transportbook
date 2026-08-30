<?php error_reporting(0);
include("../adminsession.php");
$iteminv_id = $_REQUEST['iteminv_id'];



 $purqty = $cmn->getvalfield($connection,"purchasentry_detail","sum(qty)","iteminv_id='$iteminv_id' && compid='$compid' && sessionid='$sessionid'");
//$saleqty = $cmn->getvalfield($connection,"saleentry_detail","sum(qty)","iteminv_id='$iteminv_id' && comp_id='$compid' && sessionid='$sessionid'");
  //$materialinqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$iteminv_id' && category='New Item' && compid='$compid' && sessionid='$sessionid'");
$tyre = $cmn->getvalfield($connection,"purchaseorderserial","count(pos_id)","iteminv_id='$iteminv_id' && is_issue='1' && compid='$compid' && session_id='$sessionid'");
//   echo $saleqty;
  $stock=$purqty - $saleqty -$materialinqty -$tyre;
 echo $stock;

?>
 