<?php
include("../adminsession.php");

$pump_id = $_REQUEST['id'];

$next_adv_no = $cmn->getvalfield( $connection, "diesel_advpayment","MAX(CAST(SUBSTRING(adv_no, 4) AS UNSIGNED))", "pump_id='$pump_id' && consignorid='$consignorid' && sessionid='$session_id'");

if ($next_adv_no == '' || $next_adv_no == 0) {
    $sno = 1;
} else {
    $sno = $next_adv_no + 1;
}

echo 'ADV' . str_pad($sno, 2, '0', STR_PAD_LEFT);
?>