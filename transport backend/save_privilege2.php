<?php
include("adminsession.php");


$user_id = $_POST['user_id'];
$menu_id = $_POST['menu_id'];
$submenu_id = $_POST['submenu_id'];
$subcat_id = $_POST['subcat_id'];
$upval3 = $_REQUEST['upval3'];
echo $upval3;

if ($upval3 == '1') {

    mysqli_query($connection, "INSERT into user_privilege set user_id='$user_id',menu_id='$menu_id',submenu_id='$submenu_id',subcat_id='$subcat_id',status='1',createdate=Now()");
}

if ($upval3 == '0') {
 
    mysqli_query($connection, "update user_privilege  set status ='0' where user_id=$user_id && menu_id='$menu_id' &&  submenu_id='$submenu_id' && subcat_id='$subcat_id' ");
}
