<?php  error_reporting(0);                                                                                         
include("../adminsession.php");
$pay_type = trim(addslashes($_REQUEST['pay_type']));
?>
<option value=" ">Select</option>
<?php
if($pay_type=="Service")
{ 
    echo "select * from  service_entry where bill_type ='credit' && is_paid='0' && type='Service'";
	$sql = mysqli_query($connection,"select * from  service_entry where bill_type ='credit' && is_paid='0' && type='Service'");
	while($row=mysqli_fetch_assoc($sql))
	{
	?>
    
     <option value="<?php echo $row['service_id']; ?>"><?php echo $row['service_no'] ?></option>
    
    <?php
	}
}  
else if($pay_type=="Maintenance")
{
    echo "select * from  service_entry where bill_type ='credit' && is_paid='0' && type='Maintenance'";
	$sql = mysqli_query($connection,"select * from  service_entry where bill_type ='credit' && is_paid='0' && type='Maintenance'");
	while($row=mysqli_fetch_assoc($sql))
	{
	?>
    
     <option value="<?php echo $row['service_id']; ?>"><?php echo $row['main_no'] ?></option>
    
    <?php
	}
}else if($pay_type=="other")
{
	$sql = mysqli_query($connection,"select * from  other_expense_entry where bill_type ='credit' && is_paid='0'");
	while($row=mysqli_fetch_assoc($sql))
	{
	?>
    
     <option value="<?php echo $row['other_exp_id']; ?>"><?php echo $row['other_no'] ?></option>
    
    <?php
	}
}

?>