<?php
include("adminsession.php");
  
if(isset($_POST['SAVE'])) {

$typos=$_POST['typos']; 
$issue_cate=$_POST['issue_cate']; 

$vehicle_id = $_POST['vehicle_id'];
$pos_id=$_POST['pos_id'];

$meterreading=$_POST['meterreading'];
$uploaddate=$_POST['uploaddate'];  

$return_cate = $_POST['return_cate'];
$tyre_new_image=$_FILES['tyre_new_image'];
$tyre_old_image=$_FILES['tyre_old_image'];
$old_tyre_name=$_POST['old_tyre_name'];

$old_tyre_serial_no=$_POST['old_tyre_serial_no'];
$rpos_id=$_POST['rpos_id'];

 $iteminv_id=$_POST['iteminv_id'];
 
  
 for($i=0;$i<sizeof($typos);$i++)
	{
 if($tyre_new_image!=''){ 
         $doc_name = $tyre_new_image['name'];
         $tm="DOC";
         $tm.=microtime(true)*1000;
         $ext = pathinfo($doc_name, PATHINFO_EXTENSION);
         $doc_name=$tm.".".$ext;
          move_uploaded_file($tyre_new_image['tmp_name'],"uploaded/newtyre/".$doc_name);
  
           }
          if($tyre_old_image!=''){
         $doc_name1 = $tyre_old_image['name'];
         $tm="DOC";
         $tm.=microtime(true)*1000;
         $ext = pathinfo($doc_name1, PATHINFO_EXTENSION);
         $doc_name1=$tm.".".$ext;
          move_uploaded_file($tyre_old_image['tmp_name'],"uploaded/oldtyre/".$doc_name1);
          }

	mysqli_query($connection,"INSERT into tyre_map set vehicle_id='$vehicle_id',rpos_id='$rpos_id',return_cate='$return_cate',typos='$typos[$i]',issue_cate='$issue_cate',iteminv_id='$iteminv_id',pos_id='$pos_id', meterreading='$meterreading',uploaddate='$uploaddate',tyre_new_image='$doc_name',tyre_old_image='$doc_name',old_tyre_name='$old_tyre_name',createdate='$createdate',old_tyre_serial_no='$old_tyre_serial_no',sessionid='$sessionid',compid='$compid'");
      $mapid = $cmn->getvalfield($connection,"tyre_map","mapid","vehicle_id='$vehicle_id' and typos='$typos[$i]' && is_remove='0' && sessionid='$sessionid' && compid='$compid'"); 
      if($rpos_id!=''){
 
 mysqli_query($connection,"update  purchaseorderserial set return_cate='$return_cate' WHERE pos_id ='$rpos_id'");
 mysqli_query($connection,"update  tyre_map set is_remove='1' WHERE mapid ='$mapid'");
  mysqli_query($connection, "UPDATE purchaseorderserial SET is_issue = 0 WHERE pos_id = '$rpos_id'");

    }
    
  
    mysqli_query($connection,"update  purchaseorderserial set issue_cate='$issue_cate',is_issue=1 WHERE pos_id ='$pos_id'");
      $action=2;
   $process = "UPDATE";
   
   	echo "<script>location='tyre_opening_record.php?vehicle_id=$vehicle_id&search=Search'</script>";
}}
?>
