<?php include("../adminsession.php");
$paymentdate = trim(addslashes($_REQUEST['paymentdate'])); 

mysqli_query($connection,"update inv_payment set iscomp=1 where type='purchase' && iscomp=0 && compid='$comp_id' && sessionid='$session_id' && consignor_id='$consignorid'");	

?>



