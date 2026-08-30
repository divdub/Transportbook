<?php include("../adminsession.php");

// print_r($_REQUEST); die;
$invoiceid = trim(addslashes($_REQUEST['invoiceid']));
$hiddenid = trim(addslashes($_POST['hiddenid']));
$invno = trim(addslashes($_POST['invoiceno']));
$itemtype = trim(addslashes($_POST['itemtype']));
$billtype = trim(addslashes($_POST['billtype']));
$planttype = trim(addslashes($_POST['planttype']));
$gst = trim(addslashes($_POST['gst']));
$sno = trim(addslashes($_POST['sno']));
$gsttype=$_POST['gsttype'];
$cserial=$_POST['cserial'];
$pserial=$_POST['pserial'];
$serial = trim(addslashes($_POST['serial']));
$invdate = $cmn->dateformatusa(trim(addslashes($_POST['invdate'])));
if($serial==''){
	$serial=0;
}
$ids = explode(',', $hiddenid); 

if($invoiceid==0) {

			mysqli_query($connection,"insert into invoicebilty set invno='$invno',cserial='$cserial',pserial='$pserial', planttype='$planttype', serial='$serial',invdate='$invdate',itemtype='$itemtype',sno='$sno',billtype='$billtype',gst='$gst',gsttype='$gsttype',createdate='$createdate',sessionid='$session_id',consignorid='$consignorid',user_id='$user_id'");
			$lastid = mysqli_insert_id($connection);
			echo $lastid;
}
else
{
    echo "update invoicebilty set invno='$invno',invdate='$invdate',itemtype='$itemtype',lastupdated='$createdate',sessionid='$session_id',consignorid='$consignorid' 
	where invoiceid='$invoiceid'";
	mysqli_query($connection,"update invoicebilty set invno='$invno',invdate='$invdate', planttype='$planttype', itemtype='$itemtype',gst='$gst',gsttype='$gsttype',lastupdated='$createdate',sessionid='$session_id',consignorid='$consignorid' 
	where invoiceid='$invoiceid'");
			$lastid = $invoiceid;
// 		echo	"update dispatch_entry set invoiceid='0',is_invoice='0' where invoiceid='$lastid'";
			mysqli_query($connection,"update dispatch_entry set invoiceid='0',is_invoice='0' where invoiceid='$lastid'");
}
foreach($ids as $id) {
		echo $id; 
	echo "update dispatch_entry set invoiceid='$lastid',is_invoice='1' where dispatch_id='$id'";
		mysqli_query($connection,"update dispatch_entry set invoiceid='$lastid',is_invoice='1' where dispatch_id='$id'");

}


echo $lastid;
?>