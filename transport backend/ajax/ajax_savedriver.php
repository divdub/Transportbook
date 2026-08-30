<?php 
include("../adminsession.php");


	$driver_name = $_POST['driver_name'];
	$mobile_no = $_POST['mobile_no'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_driver WHERE driver_name='$driver_name' && mobile_no='$mobile_no'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
	
mysqli_query($connection, "INSERT INTO m_driver SET driver_name='$driver_name',mobile_no='$mobile_no',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_driver order by driver_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['driver_id']; ?>"><?php echo $row['driver_name']; ?></option>
<?php
}
?>