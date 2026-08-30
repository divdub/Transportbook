<?php
include("../adminsession.php");
$destination_id = $_REQUEST['destination_id'];
// echo "select * from dispatch_entry where dispatch_id=$dispatch_id";
$sql = mysqli_query($connection, "select * from rate_setting where 	place_id=$destination_id && consignorid=$consignorid");

$row = mysqli_fetch_array($sql);


$rate = $row['rate'];



echo  $rate; 
// $bilty_no;
