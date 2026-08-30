<?php 
   include("../adminsession.php");
     $dispatch_id = $_REQUEST['dispatch_id']; 
$tpcat_id = $_REQUEST['tpcat_id']; 
if ($tpcat_id==1) {
$sql = mysqli_query($connection, "select * from m_agent");

     while($row = mysqli_fetch_array($sql)) { ?>
          <!--<option value="">Select</option>-->
      <option value="<?php echo $row['agent_id']; ?>"><?php echo $row['agent_name']; ?></option>
  <?php    }
 ?>
<option value="<?php echo $category_id ?>"><?php echo $cat_name;?></option> 
 <?php }
   if ($tpcat_id==2) {
$sql = mysqli_query($connection, "select * from m_consignee");
//  <option value="">Select</option>
     while($row = mysqli_fetch_array($sql)) { ?>
          
  <option value="<?php echo $row['consignee_id']; ?>"><?php echo $row['consignee_name']; ?></option>

  <?php }  }
  if ($tpcat_id==4) {
$sql = mysqli_query($connection, "select * from m_vehicle_owner");
   $row = mysqli_fetch_array($sql);

  ?>
      <option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
<?php 
} 
   ?>