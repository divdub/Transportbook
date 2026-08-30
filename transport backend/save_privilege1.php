<?php
include("adminsession.php");

	$user_id = $_POST['user_id'];
	$menu_id = $_POST['menu_id'];
$submenu_id = $_POST['submenu_id'];
	//  $subcat_id = $_POST['subcat_id'];
	//  $upval3 = $_REQUEST['upval3'];
    //  $upval2 = $_REQUEST['upval2'];
     $upval2 = $_REQUEST['upval2'];




	echo $upval2;
    if($upval2=='1'){

  echo  "INSERT into user_privilege set user_id='$user_id'
    ,menu_id='$menu_id',submenu_id='$submenu_id',status='1',
    createdate=Now()";

mysqli_query($connection,"INSERT into user_privilege set user_id='$user_id'
,menu_id='$menu_id',submenu_id='$submenu_id',status='1',
createdate=Now()");
}

if($upval2=='0'){

	mysqli_query($connection,"delete from user_privilege where user_id=$user_id && menu_id='$menu_id' &&  submenu_id='$submenu_id' && subcat_id='0' ");

}

?>
