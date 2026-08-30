<?php 
   include("../adminsession.php");
     $catname = $_REQUEST['catname']; 
$tpcat_id = $_REQUEST['cat_id']; 
if ($tpcat_id==1) {
$sql = mysqli_query($connection, "select * from m_vehicle");

     while($row = mysqli_fetch_array($sql)) { ?>
          <!--<option value="">Select</option>-->
      <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
  <?php    }
 ?>
 <?php }
   if ($tpcat_id==2) {
$sql = mysqli_query($connection, "select * from m_vehicle");
//  <option value="">Select</option>
     while($row = mysqli_fetch_array($sql)) { ?>
          
  <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>

  <?php }  }
  if ($tpcat_id==4) {
      echo "select * from m_vehicle where owner_id=$catname ";
$sql = mysqli_query($connection,"select * from m_vehicle where owner_id=$catname "); ?>
 <option value="">Select</option>
 <?php  while($row = mysqli_fetch_array($sql)) {

  ?>
      <option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
<?php 
} }
   ?>