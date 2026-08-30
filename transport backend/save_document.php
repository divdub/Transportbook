<?php

include("adminsession.php");


// echo $dre_id = $cmn->getvalfield($connection, "document_renawal", "dre_id", "1=1");

// echo $dre_id = $_GET['dre_id']; 

if (isset($_POST['submit'])) {
  $vehicle_id = $_POST['vehicle_id'];
	 $doccat_id = $_POST['doccat_id'];
	 $issue_date = $_POST['issue_date'];
	 $expiry_date = $_POST['expiry_date'];
	 $doc_img = $_FILES['doc_img'];
    // print_r($document_name);
	 $tdoc_id = $_POST['tdoc_id'];

	 
 $trenew = $cmn->getvalfield($connection, "truck_doc", "count(tdoc_id)","doccat_id=$doccat_id && vehicle_id=$vehicle_id");
 // echo $trenew; die;
		if($trenew==0) {
			$doc_name = $doc_img['name'];
			$tm = "DOC";
			$tm .= microtime(true) * 1000;
			$ext = pathinfo($doc_name, PATHINFO_EXTENSION);
			$doc_name = $tm . "." . $ext;
			move_uploaded_file($doc_img['tmp_name'], "upload/doc_upload/" . $doc_name);

			// echo "INSERT into document_renawal set vehicle_id='$vehicle_id',doccat_id='$doccat_id',issue_date='$issue_date',expiry_date='$expiry_date',doc_img='$doc_name',createdate='$createdate',comp_id='$comp_id',session_id='$session_id'";die;
			mysqli_query($connection, "INSERT into truck_doc set vehicle_id='$vehicle_id',doccat_id='$doccat_id',issue_date='$issue_date',expiry_date='$expiry_date',doc_img='$doc_name',created_date='$currentdate',comp_id='$comp_id',session_id='$session_id',user_id='$user_id'");

			$action = 1;
			echo "<script>location='documents.php?action=$action&vehicle_id=$vehicle_id'</script>";

	} else {
		// echo "ok";
		
    if($_FILES['doc_img']['tmp_name']!="")
				{
		
					//delete old file
					$sql = mysqli_query($connection,"select * from truck_doc where doccat_id='$doccat_id' && vehicle_id='$vehicle_id'");
	             $rowimg = mysqli_fetch_array($sql);
			
					$oldimg = $rowimg["doc_img"]; 
					if($oldimg != ""){
					unlink("upload/doc_upload/$oldimg");
				}
				 $imgpath="upload/doc_upload/";
					//insert new file
				$uploaded_filename = uploadImage($imgpath,$doc_img);
          // echo "UPDATE truck_doc set doc_img='$uploaded_filename' where doccat_id='$doccat_id' && vehicle_id='$vehicle_id'";die;
					mysqli_query($connection,"UPDATE truck_doc set doc_img='$uploaded_filename' where doccat_id='$doccat_id' && vehicle_id='$vehicle_id'");
					// mysqli_query($connection,"update $tblname set bilty_scan='$uploaded_filename' where $tblpkey='$keyvalue'");
				}
		mysqli_query($connection, "UPDATE truck_doc  set vehicle_id='$vehicle_id',doccat_id='$doccat_id',issue_date='$issue_date',expiry_date='$expiry_date',updated_date='$currentdate',comp_id='$comp_id',session_id='$session_id' WHERE doccat_id='$doccat_id' && vehicle_id='$vehicle_id'");

		$action = 2;
		echo "<script>location='documents.php?action=$action&vehicle_id=$vehicle_id'</script>";
	}
}

?>
