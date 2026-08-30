<?php 
include("../adminsession.php");


	$place_name = $_POST['place_name'];
	$state_id = $_POST['state_id'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_place WHERE place_name='$place_name' && state_id='$state_id'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
	
mysqli_query($connection, "INSERT INTO m_place SET place_name='$place_name',state_id='$state_id',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_place order by place_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['place_id']; ?>"><?php echo $row['place_name']; ?></option>
<?php
}
?>