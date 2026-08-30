<?php
include("adminsession.php");
 $billid = $_REQUEST['billid'];
 $mobile = $_REQUEST['mobile'];
 $bill_name = $_REQUEST['bill_name'];
 $owner_id = $_REQUEST['owner_id'];
 $type=$_REQUEST['type'];
 $upval=$_REQUEST['upval'];

 $photopath =  'whatsapp/'.$billid.'.pdf';
 if($type=='owner'){
  if($upval==1){
    // echo "UPDATE m_vehicle_owner  set mobileno1 = $mobile WHERE owner_id='$owner_id'";
    mysqli_query($connection,"UPDATE m_vehicle_owner  set mobileno1 = $mobile WHERE owner_id='$owner_id'");
  }
 }
  if($type=='pump'){
  if($upval==1){
    // echo "UPDATE m_vehicle_owner  set mobileno1 = $mobile WHERE owner_id='$owner_id'";
    mysqli_query($connection,"UPDATE m_petrol_pump  set mobile_no = $mobile WHERE pump_id='$owner_id'");
  }
 }
 if($type=='agent'){
  if($upval==1){
    // echo "UPDATE m_vehicle_owner  set mobileno1 = $mobile WHERE owner_id='$owner_id'";
    mysqli_query($connection,"UPDATE m_agent  set mobileno1 = $mobile WHERE agent_id='$owner_id'");
  }
 }
 if($type=='consignee'){
  if($upval==1){
    // echo "UPDATE m_vehicle_owner  set mobileno1 = $mobile WHERE owner_id='$owner_id'";
    mysqli_query($connection,"UPDATE m_consignee  set mobile_no = $mobile WHERE consignee_id='$owner_id'");
  }
 }
// echo $photopath;
$photodata = file_get_contents($photopath);
$bsimg =  base64_encode($photodata);
$bsimg=urlencode("data:application/pdf;base64,". $bsimg); 			
$url="http://api.iconicsolution.co.in/wapp/api/send?";

$data="apikey=0ac19e01e8804aa3a08d7231c6dea1b9&mobile=$mobile&pdf=$bsimg&pdfname=$bill_name.pdf";
// $data="apikey=fc86f138d94c456ea7fae49bcfddee87&mobile=$mobile&pdf=$bsimg&pdfname=$bill_name.pdf";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
var_dump($result);


    if(is_file($photopath))  {

      unlink($photopath);  
    }


?>