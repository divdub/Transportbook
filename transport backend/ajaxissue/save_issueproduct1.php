<?php
include("../adminsession.php");
  $iteminv_id= $_REQUEST['iteminv_id'];
// echo $itemid;
 $unitname= $_REQUEST['unitname'];

$category= $_REQUEST['issue_cate'];
 $qty= addslashes($_REQUEST['qty']);
$issuedetailid=trim(addslashes($_REQUEST['issuedetailid'])); 
$issueid = trim(addslashes($_REQUEST['issueid']));
$is_rep = trim(addslashes($_REQUEST['is_rep']));  
$returnitem_id = trim(addslashes($_REQUEST['returnitem_id'])); 
$vehicle_id = trim(addslashes($_REQUEST['vehicle_id']));  
$iteminv_category_id = trim(addslashes($_REQUEST['iteminv_category_id'])); 
$remark1 = trim(addslashes($_REQUEST['remark1']));  
// $itemid = $cmn->getvalfield($connection, "purchasentry_detail", "itemid", "purdetail_id='$purdetail_id'");
	
if($returnitem_id!='' && $is_rep=='Repaired' ){

	echo "update issueentrydetail set is_used='1' WHERE returnitem_id = '$purdetail_id' &&  is_rep='Repaired'";
	
	$sql_update1="update issueentrydetail set  is_used='1' WHERE returnitem_id = '$purdetail_id' &&  is_rep='Repaired'";
	mysqli_query($connection,$sql_update1);

}

	if($issuedetailid==0)
	{
	   
	    
		$sqlcheckdup = mysqli_query($connection, "SELECT * FROM issueentrydetail");
		// $check = mysqli_num_rows($sqlcheckdup);
		// if ($check > 0) {
		// echo "3";
		// $dup = "<div class='alert alert-danger'>
		// 	<strong>Error!</strong> Error : Duplicate Record.
		// 	</div>";
		// } else {
//    echo "insert into issueentrydetail set iteminv_category_id = '$iteminv_category_id',iteminv_id = '$iteminv_id',  unitname = '$unitname', vehicle_id = '$vehicle_id',qty = '$qty', issueid = '$issueid',
//         returnitem_id='$returnitem_id',remark1='$remark1',is_rep='$is_rep', ipaddress='$ipaddress',createdby='$userid',createdate='$createdate',compid='$compid',sessionid='$sessionid'";
		 $sql_insert="insert into issueentrydetail set iteminv_category_id = '$iteminv_category_id',iteminv_id = '$iteminv_id', category='$category', unitname = '$unitname', vehicle_id = '$vehicle_id',qty = '$qty', issueid = '$issueid',
        returnitem_id='$returnitem_id',remark1='$remark1',is_rep='$is_rep', ipaddress='$ipaddress',createdby='$userid',createdate='$createdate',compid='$compid',sessionid='$sessionid',user_id='$user_id'";
 
		mysqli_query($connection,$sql_insert);



	$action=1;
	$process = "insert";
	echo "1";
	}
	else
	{
		$sql_insert="update issueentrydetail set itemid = '$itemid',iteminv_category_id = '$iteminv_category_id',purdetail_id = '$purdetail_id', unitname = '$unitname', vehicle_id = '$vehicle_id',qty = '$qty', issueid = '$issueid',
        returnitem_id='$returnitem_id',remark1='$remark1',is_rep='$is_rep', ipaddress='$ipaddress',createdby='$userid',createdate='$createdate' WHERE issuedetailid = '$issuedetailid'";
 
		mysqli_query($connection,$sql_insert);

		$action=2;
		$process = "update";
	}	

//}

?>