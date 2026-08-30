<?php 
include("../adminsession.php");

   $minvid = $_POST['minvid'];
	$received_gstamt = $_POST['received_gstamt'];
	$receive_gstdate=$_POST['receive_gstdate'];
	$gstremark=$_POST['gstremark'];
	$incentiveamt=$_POST['incentiveamt'];
	$tblname="manualinv";
// 	ECHO "UPDATE manualinv set gst_pay = '1',received_gstamt='$received_gstamt',receive_gstdate='$receive_gstdate',gstremark='$gstremark',forledger='GST',gstuser_id= '$user_id'  WHERE minvid='$minvid'";
	mysqli_query($connection,"UPDATE manualinv set gst_pay = '1',incentiveamt='$incentiveamt',received_gstamt='$received_gstamt',receive_gstdate='$receive_gstdate',gstremark='$gstremark',forledger='GST',gstuser_id = '$user_id'  WHERE minvid='$minvid'");


?>
