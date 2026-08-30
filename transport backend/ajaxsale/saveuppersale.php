<?php 
error_reporting(0);
include("../adminsession.php");
//echo "update inv_payment set iscomp=1 where type='sale' && iscomp=0 && sessionid='$sessionid' && compid='$compid'";
mysqli_query($connection,"update inv_payment set iscomp=1 where type='sale' && iscomp=0 && sessionid='$sessionid' && compid='$compid'");
?>