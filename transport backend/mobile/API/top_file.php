<?php
include "config.php";

function getvalfield($connection,$table,$field,$where)
{
 	$sql = mysqli_query($connection,"select $field from $table where $where");
	
	$sql = "select $field from $table where $where";

	$getvalue = mysqli_query($connection,$sql);
	$getval = mysqli_fetch_row($getvalue);
	if ($getval === null) {
        return null; // or handle the case when no data is found, e.g., return a default value
    }
	return $getval[0];
}

function dateformatindia($date)
{
	if($date == "0000-00-00" || $date =="")
	{
	return "";
	}
	else
	{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	return $day . "-" . $month . "-" . $year;
	}
	
}

	





	



$data = array();
$data1 = array();
$data2 = array();
$data3 = array();
$data4 = array();
$data01 = array();
$data02 = array();
$success = false;

$created_at = date('Y-m-d H:i:s');

$tag = ""; //1-login,2-home,3-entry
$return_id = 0;

$type = "";

$msg = "";

$token = "";

$user = "";
$status="";

$version_code = "1.0";

$fbtoken = "";

$userid = "";

$create_date = date('Y-m-d');
$create_datetime = date('Y-m-d');

if (isset($_REQUEST['token'])) $token = $_REQUEST['token'];

if (isset($_REQUEST['fbtoken'])) $fbtoken = $_REQUEST['fbtoken'];

if (isset($_REQUEST['userid'])) $userid = $_REQUEST['userid'];

?>