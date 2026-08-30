<?php
// error_reporting(0);
include("../adminsession.php");

$ppump_id = $_REQUEST['ppump_id'];
$adv_no = $_REQUEST['adv_no'];
$adv_date = $_REQUEST['adv_date'];
$adv_amt = $_REQUEST['adv_amt'];
$tblname = "diesel_advpayment";
$Eadvpayid = $_REQUEST['Eadvpayid'];
$apay_mode = $_REQUEST['apay_mode'];
$aremarks = $_REQUEST['aremarks'];
// echo $aremarks;

if($Eadvpayid !=''){
$form_data = array('pump_id' => $ppump_id, 'adv_no' => $adv_no, 'adv_date' => $adv_date, 'adv_amt' => $adv_amt, 'pay_mode' => $apay_mode, 'remark' => $aremarks ,'created_at'=>$currentdate,'comp_id'=>$comp_id,'sessionid'=>$session_id,'consignorid'=>$consignorid);
  dbRowUpdate($connection, $tblname, $form_data, "dadvpayid='$Eadvpayid'");
   
}else{

$form_data = array('pump_id' => $ppump_id, 'adv_no' => $adv_no, 'adv_date' => $adv_date, 'adv_amt' => $adv_amt, 'pay_mode' => $apay_mode, 'remark' => $aremarks ,'created_at'=>$currentdate,'comp_id'=>$comp_id,'sessionid'=>$session_id,'consignorid'=>$consignorid);
 echo dbRowInsert($connection, $tblname, $form_data); die;


}


