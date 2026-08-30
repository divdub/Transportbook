<?php 
include("../adminsession.php");

   $dispatch_id = $_POST['dispatch_id'];
	$rec_wt = $_POST['rec_wt'];
	$rec_qty = $_POST['rec_qty'];
	$rec_date = $_POST['rec_date'];
	$unloading_place=$_POST['unloading_place'];
	$receive_type = $_POST['receive_type'];
	$rec_img = $_FILES['image']['name']; 

	$tblname="dispatch_entry";
    $form_data = array('rec_wt'=>$rec_wt,'rec_qty'=>$rec_qty,'rec_date'=>$rec_date,'unloading_place'=>$unloading_place,'receive_type'=>$receive_type,'is_receive'=>'1','updated_date'=>$currentdate, 'recuser_id' => $user_id);
	dbRowUpdate($connection,$tblname, $form_data, "dispatch_id='$dispatch_id'");
	if($rec_img!="")
	{
	$sql = mysqli_query($connection,"select * from $tblname where dispatch_id='$dispatch_id'");
	$rowimg = mysqli_fetch_array($sql);

		$oldimg = $rowimg["rec_img"]; 
	    move_uploaded_file($_FILES['image']['tmp_name'], "image/" . $_FILES['image']['name'] );
		mysqli_query($connection,"update $tblname set rec_img='$rec_img' where dispatch_id='$dispatch_id'");
	}

	
?>