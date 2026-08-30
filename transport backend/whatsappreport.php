<?php
include("adminsession.php");
//  $billid = $_REQUEST['billid'];
 $mobile = $_REQUEST['mobile'];
 $bill_name = $_REQUEST['bill_name'];
//  $owner_id = $_REQUEST['owner_id'];
//  $type=$_REQUEST['type'];
 $fromdate=$_REQUEST['fromdate'];

 $photopath =  'whatsapp/'.$fromdate.'.pdf';
 
// echo $photopath;die;
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