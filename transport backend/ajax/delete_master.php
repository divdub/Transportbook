<?php
include("../dbinfo.php");
$tablename = $_REQUEST['tablename'];
$tableid = $_REQUEST['tableid'];
$id = $_REQUEST['id'];

echo "delete from $tablename where $tableid=$id";
mysqli_query($connection,"delete from $tablename where $tableid=$id");
?>


