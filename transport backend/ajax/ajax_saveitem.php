<?php 
include("../adminsession.php");


	$item_name = $_POST['item_name'];
	$item_category_id = $_POST['item_category_id'];
	$unit_id=$_POST['unit_id'];
	$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_item WHERE item_name='$item_name' && item_category_id='$item_category_id'");
		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
		}  else { 
	
mysqli_query($connection, "INSERT INTO m_item SET item_name='$item_name',item_category_id='$item_category_id',unit_id='$unit_id',created_date='$currentdate'");
$action = 1;
   }
			
		?>
		
		<?php
$res = mysqli_query($connection,"select * from m_item order by item_id desc");

while($row = mysqli_fetch_array($res))
{
	
?>
	<option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
<?php
}
?>