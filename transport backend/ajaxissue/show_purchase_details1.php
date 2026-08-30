<?php error_reporting(0);
include("../adminsession.php");
 $iteminv_id = $_REQUEST['iteminv_id'];
 $issue_cate = $_REQUEST['issue_cate'];
 $unitinv_id = $cmn->getvalfield($connection,"m_iteminv","unitinv_id","iteminv_id='$iteminv_id'"); 
 $item_cat_id = $cmn->getvalfield($connection,"m_iteminv","iteminv_category_id","iteminv_id='$iteminv_id'");
 $unit_name = $cmn->getvalfield($connection,"m_unitinv","unit_name","unitinv_id='$unitinv_id'");

 $issuedetailid = $cmn->getvalfield($connection,"issueentrydetail","issuedetailid","iteminv_id='$iteminv_id'");

  $qty = $cmn->getvalfield($connection, "purchasentry_detail", "sum(qty)", "iteminv_id='$iteminv_id' && purchaseid!='0' && compid='$compid' && sessionid='$sessionid'");
  $saleqty = $cmn->getvalfield($connection, "inv_saleentrydetail", "sum(qty)", "iteminv_id='$iteminv_id' && saleid!='0' && comp_id='$compid' && sessionid='$sessionid'");
  $materialinqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$iteminv_id' && category='New Item' && compid='$compid' && sessionid='$sessionid'");
    $materialinqty1 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$iteminv_id' && is_rep='Repaired' && compid='$compid' && sessionid='$sessionid'");
 
 $qty1 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$iteminv_id' && category='Repaired' && compid='$compid' && sessionid='$sessionid'");
  
  $materialinqty2 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$iteminv_id' && is_rep='Exchange' && compid='$compid' && sessionid='$sessionid'");
 
 $qty2 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","iteminv_id='$iteminv_id' && category='Exchange' && compid='$compid' && sessionid='$sessionid'"); 

 if($saleqty==''){$saleqty='0';}
if($materialinqty==''){$materialinqty='0';}
 if($issue_cate=='New Item'){
    //  echo $saleqty;
 $stock = $qty- $materialinqty - $saleqty;

}

 if($issue_cate=='Repaired'){
 $stock = $materialinqty1 -$qty1;

}

 if($issue_cate=='Exchange'){
    //  echo $materialinqty2;
 $stock = $materialinqty2 -$qty2 ;

}




 
 

 echo  $unit_name ."|".$stock."|".$item_cat_id;

?>