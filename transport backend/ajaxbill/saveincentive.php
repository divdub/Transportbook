<?php
include("../adminsession.php");

 $gst_amt = $_POST['gst_amt1'];
 
 $incgst = $_POST['incgst'];
$tds_amt = $_POST['tds_amt'];
$ref_no = $_POST['ref_no'];
$received_amt = $_POST['received_amt'];

$receive_date = $_POST['receive_date'];
$remark = $_POST['remark'];
$type = $_POST['type'];
$tblname = "manualinv";

if($type== 'Deduct'){
     $form_data = array('gst_amt' => $gst_amt, 'tds_amt' => $tds_amt, 'ref_no' => $ref_no, 'deduct' => $received_amt, 'receive_date' => $receive_date, 'remark' => $remark, 'gst' =>$incgst,'type'=>$type,'for_ledger'=>$type, 'session_id' => $session_id, 'consignorid' => $consignorid, 'user_id' => $user_id,'created_date' => $currentdate);
dbRowInsert($connection, $tblname, $form_data); 
}else{
  $form_data = array('gst_amt' => $gst_amt, 'tds_amt' => $tds_amt, 'ref_no' => $ref_no, 'received_amt' => $received_amt, 'receive_date' => $receive_date, 'remark' => $remark, 'gst' =>$incgst,'type'=>$type,'for_ledger'=>$type, 'session_id' => $session_id, 'consignorid' => $consignorid, 'user_id' => $user_id,'created_date' => $currentdate);
dbRowInsert($connection, $tblname, $form_data);  
}

?>