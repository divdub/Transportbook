<?php
include("../adminsession.php");
$id = addslashes($_REQUEST['id']);
$tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);

if($id!="" && $tblname!="")
{
    $iteminv_id=  $cmn->getvalfield($connection, "$tblname", "iteminv_id", "$tblpkey='$id'");
     $iteminv_category_id =  $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id='$iteminv_id'");
     if($iteminv_category_id=='5'){ 
         
     mysqli_query($connection, "update purchaseorderserial set sale='0',saledetail_id='0' where saledetail_id='$id'");
         
     }
     
   
	$sql_del="delete from $tblname where $tblpkey='$id'";
	$res = mysqli_query($connection,$sql_del)or die(mysqli_error()."Delete failed");
	
}
?>