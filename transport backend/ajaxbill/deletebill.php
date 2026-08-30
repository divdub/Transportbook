<?php
include("../adminsession.php");
$id = addslashes($_REQUEST['id']);
$tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);

if($id!="" && $tblname!="")
{	

	mysqli_query($connection,"update dispatch_entry set is_bill=0,dbillid=0 where dbillid='$id'");

		
	$sql_del="delete from $tblname where $tblpkey='$id'";	
	$res = mysqli_query($connection,$sql_del)or die(mysqli_error()."Delete failed");
	
}
?>