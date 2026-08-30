<?php error_reporting(0);
include("../adminsession.php");
$iteminv_id = $_REQUEST['iteminv_id'];



  $hsncode = $cmn->getvalfield($connection,"m_iteminv","hsn_code","iteminv_id='$iteminv_id'");
 $itemcatid = $cmn->getvalfield($connection,"m_iteminv","iteminv_category_id","iteminv_id='$iteminv_id'");
 echo $hsncode ."|" .$itemcatid;

 ?>