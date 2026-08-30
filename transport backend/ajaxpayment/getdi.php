<?php 
   // error_reporting(0);
   include("../adminsession.php");
    $tpcat_id = $_REQUEST['tpcat_id']; 
   $name = $_REQUEST['name']; 
  ?>   <option value="">Select</option> <?php
   if($tpcat_id==1){

    $sql1 = mysqli_query($connection, "select * from tpa_entry where tpcat_id=1 && category_id='$name' && is_create=0 && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id" );
       while($row1 = mysqli_fetch_array($sql1))
        { $is_receive = $cmn->getvalfield($connection, "dispatch_entry", "is_receive", "dispatch_id ='$row1[dispatch_id]'");
        if($is_receive==1){
        	?>
<option value="<?php echo $row1['dispatch_id']; ?>"><?php echo $row1['di_no']; ?></option>
<?php	  
} }
 } 

  if($tpcat_id==2){
        echo "select * from tpa_entry where tpcat_id=2 && category_id='$name' && is_create=0";
   $sql1 = mysqli_query($connection, "select * from tpa_entry where tpcat_id=2 && category_id='$name' && is_create=0 && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
      
       while($row1 = mysqli_fetch_array($sql1))
        { $is_receive = $cmn->getvalfield($connection, "dispatch_entry", "is_receive", "dispatch_id ='$row1[dispatch_id]'");
        if($is_receive==1){	?>
<option value="<?php echo $row1['dispatch_id']; ?>"><?php echo $row1['di_no']; ?></option>
<?php	  
} }
 } 
if($tpcat_id==4){
   
$sql1=mysqli_query($connection, "select * from dispatch_entry where owner_id='$name' && is_create=0 && is_receive=1 && checkbox=0 && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
           while($row1 = mysqli_fetch_array($sql1)) 
           	{  
             
               
           		?>
<option value="<?php echo $row1['dispatch_id']; ?>"><?php echo $row1['di_no']; ?></option>
<?php 


 } 





$sql=mysqli_query($connection, "select * from tpa_entry where tpcat_id=4  && category_id='$name' && is_create=0 && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
           while($row = mysqli_fetch_array($sql)) {
          $is_receive = $cmn->getvalfield($connection, "dispatch_entry", "is_receive", "dispatch_id ='$row[dispatch_id]'");
        if($is_receive==1){ 
           ?>
           <option value="<?php echo $row['dispatch_id']; ?>"><?php echo $row['di_no']; ?></option> 
      <?php  }   }


}


   
   ?>