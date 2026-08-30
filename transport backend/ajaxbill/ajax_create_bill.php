<?php include("../adminsession.php");

// print_r($_REQUEST); die;
$dbillid = trim(addslashes($_REQUEST['dbillid']));
$hideid = trim(addslashes($_POST['hideid']));
$dbillno = trim(addslashes($_POST['dbillno']));
$pump_id = trim(addslashes($_POST['pump_id']));
$discountamt = trim(addslashes($_POST['discountamt']));
$dbilldate = $cmn->dateformatusa(trim(addslashes($_POST['dbilldate'])));
$ids = explode(',', $hideid); 
// echo "insert into dieselbill set dbillno='$dbillno',pump_id='$pump_id',discountamt='$discountamt',dbilldate='$dbilldate',createdate='$createdate',sessionid='$session_id',consignorid='$consignorid',user_id='$user_id'";
if($dbillid==0) {

			mysqli_query($connection,"insert into dieselbill set dbillno='$dbillno',pump_id='$pump_id',discountamt='$discountamt',dbilldate='$dbilldate',createdate='$createdate',sessionid='$session_id',consignorid='$consignorid',user_id='$user_id'");
			$lastid = mysqli_insert_id($connection);
}
else
{
	mysqli_query($connection,"update dieselbill set dbillno='$dbillno',dbilldate='$dbilldate',discountamt='$discountamt',lastupdated='$createdate',sessionid='$session_id',consignorid='$consignorid' 
	where dbillid='$dbillid'");
			$lastid = $dbillid;
		// echo	"update dispatch_entry set dbillid='0',is_bill='0' where invoiceid='$lastid'";
			mysqli_query($connection,"update dispatch_entry set dbillid='0',is_bill='0' where dbillid='$lastid'");
}
foreach($ids as $id) {
		// echo $id; 
	// echo	"update dispatch_entry set dbillid='$lastid',is_bill='1' where dispatch_id='$id'";
		mysqli_query($connection,"update dispatch_entry set dbillid='$lastid',is_bill='1' where dispatch_id='$id'");

}


// echo $lastid;
?>