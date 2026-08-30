<?php

include("../adminsession.php");
$tablename = $_REQUEST['tablename'];
$tableid = $_REQUEST['tableid'];
$id = $_REQUEST['voucher_id'];

	// echo "Select * from  payment  where consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id  && voucher_id='$id'" ;
 $sql = mysqli_query($connection, "Select * from  payment  where consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id  && voucher_id='$id'  ");
      while ($row = mysqli_fetch_array($sql)) { 
        $dispatch_id = $row['dispatch_id'];
        $category_id=$row['category_id'];
        $checkbox=$cmn->getvalfield($connection,"dispatch_entry","checkbox","dispatch_id='$dispatch_id'");
        echo $checkbox;
        if($checkbox==0){
            
 mysqli_query($connection,"UPDATE dispatch_entry set is_create = 0 ,is_voucher= 0  WHERE dispatch_id='$dispatch_id'" );
            
             }
            if($checkbox==1){
            
 mysqli_query($connection,"UPDATE tpa_entry set is_create = 0  WHERE dispatch_id='$dispatch_id' && tpcat_id='$category_id'" );
                $amt = $cmn->getvalfield($connection,"tpa_entry","sum(amt)","dispatch_id = '$dispatch_id'");
                $wt_mt = $cmn->getvalfield($connection,"dispatch_entry","wt_mt","dispatch_id = '$dispatch_id'");
                $own_rate = $cmn->getvalfield($connection,"dispatch_entry","own_rate","dispatch_id = '$dispatch_id'");
                                          $freight_amt= $wt_mt * $own_rate;
                                          if($freight_amt== $amt){
                                               $iscreate=$cmn->getvalfield($connection,"tpa_entry","count(tpa_id)","dispatch_id='$dispatch_id' && is_create=0");
                                              if($iscreate==0){
                mysqli_query($connection,"UPDATE dispatch_entry set is_voucher= 1 ,updated_date='$currentdate' WHERE dispatch_id='$dispatch_id'" );
            }                                          }
            else {
                mysqli_query($connection,"UPDATE dispatch_entry set is_voucher= 0 ,updated_date='$currentdate' WHERE dispatch_id='$dispatch_id'" );

            }
                            }
                        }

                        
echo "delete from $tablename where $tableid=$id";
mysqli_query($connection,"delete from $tablename where consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id  && voucher_id='$id'");
?>


