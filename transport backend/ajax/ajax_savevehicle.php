<?php 
include("../adminsession.php");


	$vehicle_no = $_POST['vehicle_no'];
	$owner_id = $_POST['owner_id'];
	$agent_id=$_POST['agent_id'];
	$vehicle_type_id=$_POST['vehicle_type_id'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_vehicle WHERE vehicle_no='$vehicle_no'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
	
mysqli_query($connection, "INSERT INTO m_vehicle SET vehicle_no='$vehicle_no',owner_id='$owner_id',agent_id='$agent_id', vehicle_type_id='$vehicle_type_id',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_vehicle order by vehicle_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['vehicle_id']; ?>"><?php echo $row['vehicle_no']; ?></option>
<?php
}
?>