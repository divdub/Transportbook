<?php 
include("../adminsession.php");


	$consignor_name = $_POST['consignor_name'];
	$mobile_no = $_POST['mobile_no'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_consignor WHERE consignor_name='$consignor_name'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
	
mysqli_query($connection, "INSERT INTO m_consignor SET consignor_name='$consignor_name',mobile_no='$mobile_no',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_consignor order by consignor_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['consignor_id']; ?>"><?php echo $row['consignor_name']; ?></option>
<?php
}
?>