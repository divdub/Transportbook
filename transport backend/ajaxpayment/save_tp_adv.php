<?php 
include("../adminsession.php");
error_reporting(0);
   $dispatch_id = $_REQUEST['dispatch_id'];
   
//    echo $dispatch_id;
	 $category_id = $_REQUEST['category_id'];
	$tpcat_id = $_REQUEST['tpcat_id'];
	$rate = $_REQUEST['rate'];
	$amt=$_REQUEST['amt'];
	 $tpa_id=$_REQUEST['tpa_id'];
$paid_to=$_REQUEST['paid_to'];
	$tparemark=$_REQUEST['tparemark'];
	$wt_mt=$_REQUEST['wt_mt'];
	$tpaown_rate=$_REQUEST['tpaown_rate'];
	if($dispatch_id==''){
    $dispatch_id='0';
}
	// echo $dispatch_id;
	// $di_no = $cmn->getvalfield($connection,"dispatch_entry","di_no","dispatch_id='$dispatch_id'");
	// $bilty_date = $cmn->getvalfield($connection,"dispatch_entry","bilty_date","dispatch_id='$dispatch_id'");
	$tblname="tpa_entry";

// echo  $tpa_id;
if($tpa_id=='')
	{
  $count = check_duplicate($connection,$tblname,"dispatch_id='$dispatch_id' && tpcat_id='$tpcat_id'");

		if($count == 0)
		{
		    // echo "ok";
		     //echo "'tpcat_id'=>$tpcat_id,'category_id'=>$category_id,'dispatch_id'=>$dispatch_id,'rate'=>$rate,'amt'=>$amt,'comp_id'=>$comp_id,'session_id'=>$session_id,'created_date'=>$currentdate";
			
			$form_data = array('tpcat_id'=>$tpcat_id,'category_id'=>$category_id,'dispatch_id'=>$dispatch_id,'di_no'=>$di_no,'bilty_date'=>$bilty_date,'rate'=>$rate,'amt'=>$amt,'comp_id'=>$comp_id,'session_id'=>$session_id,'consignorid'=>$consignorid,'created_date'=>$currentdate);

			 dbRowInsert($connection,$tblname, $form_data); 
			  
			 $amt = $cmn->getvalfield($connection, "tpa_entry", "sum(amt)", "dispatch_id ='$dispatch_id'");
			 $rate = $cmn->getvalfield($connection, "tpa_entry", "sum(rate)", "dispatch_id ='$dispatch_id'");
			 $own_rate = $cmn->getvalfield($connection, "dispatch_entry", "own_rate", "dispatch_id ='$dispatch_id'");

			//  echo $amt;
			if($dispatch_id==0){
			 $freightamt =$wt_mt * $tpaown_rate;
			//  echo $freightamt;
     $balamt=$freightamt -$amt;
	//  echo $balamt;
     $balrate=$tpaown_rate -$rate;
	} else {
		$freightamt =$wt_mt * $own_rate;
		//  echo $freightamt;
 $balamt=$freightamt -$amt;
//  echo $balamt;
 $balrate=$own_rate -$rate;
	}
	 echo $balamt."|".$balrate."|".$paid_to."|".$tparemark;
			// mysqli_query($connection,"update dispatch_entry set paid_to='$paid_to',tparemark='$tparemark'  where dispatch_id='$dispatch_id'");
	} else {
		echo  "1";
//   $duplicate = "ERROR: Duplicate Record...";
	} 
} 

else {
	
 //echo "'tpcat_id'=>$tpcat_id,'category_id'=>$category_id,'di_no'=>$di_no,'dispatch_id'=>$dispatch_id,'bilty_date'=>$bilty_date,'rate'=>$rate,'amt'=>$amt,'comp_id'=>$comp_id,'consignorid'=>$consignorid,'session_id'=>$session_id,'updated_date'=>$currentdate";
$form_data = array('tpcat_id'=>$tpcat_id,'category_id'=>$category_id,'di_no'=>$di_no,'dispatch_id'=>$dispatch_id,'bilty_date'=>$bilty_date,'rate'=>$rate,'amt'=>$amt,'comp_id'=>$comp_id,'consignorid'=>$consignorid,'session_id'=>$session_id,'updated_date'=>$currentdate);
		 dbRowUpdate($connection,$tblname, $form_data, "tpa_id='$tpa_id'");
		mysqli_query($connection,"update dispatch_entry set paid_to='$paid_to' ,tparemark='$tparemark'  where dispatch_id='$dispatch_id'");
		$amt = $cmn->getvalfield($connection, "tpa_entry", "sum(amt)", "dispatch_id ='$dispatch_id'");
		$rate = $cmn->getvalfield($connection, "tpa_entry", "sum(rate)", "dispatch_id ='$dispatch_id'");
		$freightamt =$wt_mt * $tpaown_rate;
		//  echo $freightamt;
 $balamt=$freightamt -$amt;
 $balrate=$tpaown_rate -$rate;
 echo $balamt."|".$balrate."|".$paid_to."|".$tparemark;
	}
	
//    $wt_mt = $cmn->getvalfield($connection, "dispatch_entry", "wt_mt", "dispatch_id ='$dispatch_id'");
// $own_rate = $cmn->getvalfield($connection, "dispatch_entry", "own_rate", "dispatch_id ='$dispatch_id'");
// $paid_to = $cmn->getvalfield($connection, "dispatch_entry", "paid_to", "dispatch_id ='$dispatch_id'");
// $tparemark=$cmn->getvalfield($connection, "dispatch_entry", "tparemark", "dispatch_id ='$dispatch_id'");
//  $freightamt =$wt_mt * $balrate;
//      $balamt=$freightamt -$amt;
//      $balrate=$own_rate -$rate;
// 	if($data=0){
//      echo $balamt."|".$balrate."|".$paid_to."|".$tparemark;
// 	}else {
// 		echo "1";
// 	}
?>
