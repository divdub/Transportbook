<?php 
include("../adminsession.php");


	$owner_name = $_POST['owner_name'];
	$mobileno1 = $_POST['mobileno1'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_vehicle_owner WHERE owner_name='$owner_name'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
	
mysqli_query($connection, "INSERT INTO m_vehicle_owner SET owner_name='$owner_name',mobileno1='$mobileno1',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_vehicle_owner order by owner_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['owner_id']; ?>"><?php echo $row['owner_name']; ?></option>
<?php
}
?>