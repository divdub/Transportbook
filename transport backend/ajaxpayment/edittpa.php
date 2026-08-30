<?php 
   include("../adminsession.php");
     $tpa_id = $_REQUEST['tpa_id']; 

    $sql = mysqli_query($connection, "select * from tpa_entry where tpa_id=$tpa_id");

  	  $row = mysqli_fetch_array($sql);
  	  $tpcat_id = $row['tpcat_id'];
  	  $paid_to = $row['paid_to'];
                       $rate=$row['rate'];
                        $amt=$row['amt'];
                    
echo	$rate."|".$amt."|".$tpcat_id."|".$tpa_id;
 // $bilty_no;
   ?>