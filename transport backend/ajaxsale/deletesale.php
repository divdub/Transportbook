<?php
include("../adminsession.php");
$id = addslashes($_REQUEST['id']);
$tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);

if($id!="" && $tblname!="")
{


	$sql_del="delete from $tblname where $tblpkey='$id'";
	$sql_del2="delete from inv_saleentrydetail where saleid='$id'";
// 	$sql_del3="delete from payment where saleid='$id'";
	//$res=mysqli_query($connection,"Delete from $tblname where $tblpkey='$id'");
	$res = mysqli_query($connection,$sql_del)or die(mysqli_error()."Delete failed");
	$res = mysqli_query($connection,$sql_del1)or die(mysqli_error()."Delete failed");
	$res = mysqli_query($connection,$sql_del2)or die(mysqli_error()."Delete failed");
// 	$res = mysqli_query($connection,$sql_del3)or die(mysqli_error()."Delete failed");
}
?>