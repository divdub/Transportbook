<?php 
include("../adminsession.php");

   $other_id = $_POST['other_id'];
	$sap_doc_no = $_POST['sap_doc_no'];
	$inv_ref_no = $_POST['inv_ref_no'];
	$ddate=$_POST['ddate'];
		$dremark = $_POST['dremark'];
			$damt = $_POST['damt'];
	$tblname="other_deduct";
$form_data = array('other_id'=>$other_id,'sap_doc_no'=>$sap_doc_no,'inv_ref_no'=>$inv_ref_no,'ddate'=>$ddate,'dremark'=>$dremark,'damt'=>$damt,'session_id'=>$session_id,'consignorid'=>$consignorid,'createdate'=>$currentdate);
	dbRowInsert($connection,$tblname, $form_data);
	
?>
