<?php 
include("../adminsession.php");


	$pump_name = $_POST['pump_name'];
	$head_name = $_POST['head_name'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_petrol_pump WHERE pump_name='$pump_name'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
	
mysqli_query($connection, "INSERT INTO m_petrol_pump SET pump_name='$pump_name',head_name='$head_name',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_petrol_pump order by pump_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['pump_id']; ?>"><?php echo $row['pump_name']; ?></option>
<?php
}
?>