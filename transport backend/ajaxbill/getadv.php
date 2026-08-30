<?php
include("../adminsession.php");

$pump_id = $_REQUEST['pump_id'];

?> 
<option value"">Select</option>
<?php $sql = mysqli_query($connection, "Select * from  diesel_advpayment where consignorid=$consignorid && is_pay='0' && sessionid=$session_id && pump_id=$pump_id order by dadvpayid");
while ($row = mysqli_fetch_array($sql)) { ?>
  <option value="<?php echo $row['dadvpayid']; ?>"><?php echo $row['adv_no']; ?></option>

<?php } ?>