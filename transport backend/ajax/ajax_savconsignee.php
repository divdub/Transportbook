<?php 
include("../adminsession.php");


	$consignee_name = $_POST['consignee_name'];
	$mobile_no = $_POST['mobile_no'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_consignee WHERE consignee_name='$consignee_name'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
	echo	"INSERT INTO m_consignee SET consignee_name='$consignee_name',mobile_no='$mobile_no',created_date='$currentdate'";
mysqli_query($connection, "INSERT INTO m_consignee SET consignee_name='$consignee_name',mobile_no='$mobile_no',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_consignee order by consignee_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['consignee_id']; ?>"><?php echo $row['consignee_name']; ?></option>
<?php
}
?>