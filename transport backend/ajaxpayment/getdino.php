<?php 
   // error_reporting(0);
   include("../adminsession.php");
    $tpcat_id = $_REQUEST['catid']; 
   $name = $_REQUEST['tpaname']; 
  ?>   <option value="">Select</option> <?php
   if($tpcat_id==1){

$sql1=mysqli_query($connection, "select * from dispatch_entry where checkbox= 1   && agent_id='$name' && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
 while($row= mysqli_fetch_array($sql1)) {
$amt = $cmn->getvalfield($connection,"tpa_entry","sum(amt)","dispatch_id = '$row[dispatch_id]'");
                                                               $own_rate=$row['own_rate'];
                                                               $wt_mt=$row['wt_mt'];
                                                               $freight_amt= $wt_mt * $own_rate;
                                                     if($amt != $freight_amt and $freight_amt !=0){ ?>

                                                             ?>
             <option value="<?php echo $row['dispatch_id']; ?>"><?php echo $row['di_no']; ?></option>
                                                         <?php } } } 

  if($tpcat_id==2){
      echo  "select * from dispatch_entry where checkbox= 1   && consignee_id='$name' && consignor_id=$consignorid";
$sql1=mysqli_query($connection, "select * from dispatch_entry where checkbox= 1   && consignee_id='$name' && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
 while($row= mysqli_fetch_array($sql1)) {
$amt = $cmn->getvalfield($connection,"tpa_entry","sum(amt)","dispatch_id = '$row[dispatch_id]'");
                                       $own_rate=$row['own_rate'];
                                                               $wt_mt=$row['wt_mt'];
                                                               $freight_amt= $wt_mt * $own_rate;
                                                     if($amt != $freight_amt and $freight_amt !=0){ ?>

                                                             ?>
             <option value="<?php echo $row['dispatch_id']; ?>"><?php echo $row['di_no']; ?></option>
                                                         <?php } } } 
if($tpcat_id==4){
   
$sql1=mysqli_query($connection, "select * from dispatch_entry where checkbox= 1  && owner_id='$name' && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
 while($row= mysqli_fetch_array($sql1)) {
$amt = $cmn->getvalfield($connection,"tpa_entry","sum(amt)","dispatch_id = '$row[dispatch_id]'");
                                                               $own_rate=$row['own_rate'];
                                                               $wt_mt=$row['wt_mt'];
                                                               $freight_amt= $wt_mt * $own_rate;
                                                     if($amt != $freight_amt and $freight_amt !=0){ ?>

                                                             ?>
             <option value="<?php echo $row['dispatch_id']; ?>"><?php echo $row['di_no']; ?></option>
                                                         <?php } } } ?>
