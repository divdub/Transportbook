<?php
include("adminsession.php");

	$user_id = $_POST['user_id'];
	$menu_id = $_POST['menu_id'];
// $submenu_id = $_POST['submenu_id'];
	//  $subcat_id = $_POST['subcat_id'];
	//  $upval3 = $_REQUEST['upval3'];
    //  $upval2 = $_REQUEST['upval2'];
     $upval1 = $_REQUEST['upval1'];




	echo $upval1;
if($upval1=='1'){


mysqli_query($connection,"INSERT into user_privilege set user_id='$user_id'
,menu_id='$menu_id',status='1',
createdate=Now()");

// 			$action = 1;
			
} 
if($upval1=='0'){

	mysqli_query($connection,"delete from user_privilege where user_id=$user_id && menu_id='$menu_id' &&  submenu_id='0' && subcat_id='0' ");

}

// if($upval1=='1' && $upval2=='1' && $upval3=='0'){

// 	echo  "INSERT into user_privilege set user_id='$user_id'
// 	  ,menu_id='$menu_id',submenu_id='$submenu_id',subcat_id='0',status='1',
// 	  createdate=Now()";
  
//   mysqli_query($connection,"INSERT into user_privilege set user_id='$user_id'
//   ,menu_id='$menu_id',submenu_id='$submenu_id',subcat_id='0',status='1',
//   createdate=Now()");
  
//   // 			$action = 1;
			  
//   } 
  
// if($upval1=='1' && $upval2=='1' && $upval3=='1'){

// 	echo  "INSERT into user_privilege set user_id='$user_id'
// 	  ,menu_id='$menu_id',submenu_id='$submenu_id',subcat_id='0',status='1',
// 	  createdate=Now()";
  
//   mysqli_query($connection,"INSERT into user_privilege set user_id='$user_id'
//   ,menu_id='$menu_id',submenu_id='$submenu_id',subcat_id='$subcat_id',status='1',
//   createdate=Now()");
  
//   // 			$action = 1;
			  
//   } 
?>
