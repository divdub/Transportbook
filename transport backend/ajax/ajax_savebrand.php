<?php 
include("../adminsession.php");
	$brand_name = $_POST['brand_name'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_brand WHERE brand_name='$brand_name'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
mysqli_query($connection,"INSERT INTO m_brand SET brand_name='$brand_name',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_brand order by brand_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
<?php
}
?>