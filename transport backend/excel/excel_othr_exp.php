<?php include("../adminsession.php");
$tblname = "other_expense_entry";
$tblpkey = "other_exp_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_other_exp".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);
if($_GET['fromdate'] && $_GET['todate'])
{
	 $fromdate = $_GET['fromdate'];
 	$todate = $_GET['todate'];
	
}
else
{
	$fromdate = $currentdate;
	$todate = $currentdate;

}

if (isset($_GET['otherid'])) {
	$otherid = trim(addslashes($_GET['otherid']));
} else
	$otherid = '';

if (isset($_GET['payment_mode'])) {
	$payment_mode = trim(addslashes($_GET['payment_mode']));
} else
	$payment_mode = '';
	

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where exp_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

// if ($vehicle_id != '') {
// 	$crit .= " and vehicle_id='$vehicle_id'";
// }
if ($otherid != '') {
	$crit .= " and otherid='$otherid'";
}

if ($payment_mode != '') {
	$crit .= " and payment_mode='$payment_mode'";
}


?>
<<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
   <title>
	</title>
	<style type="text/css">
		table, th, td {
  border: 1px solid;
}	
	</style>
</head>
<body>
<table>
									<thead>
										<tr>
					<th>S.No</th>
						<th> Date</th>
						<th>Other Expense</th>
						<!--<th class='hidden-350'>Truck No</th>-->
						<!-- <th>Mechanic/Service Name*</th> -->
					
						<!--<th class='hidden-1024'>Driver Name</th>-->
						<!--<th>Payment Type</th>-->
						<th>Payment Mode</th>
						<!-- <th>Next Meter Reading</th> -->
						<!-- <th>Qty (Bags)</th> -->
						<th>Narration</th>	
							<th>Amount</th>
			<th>User Name</th>  

										</tr>
									</thead>
									<tbody>
									 <?php
									$sn=1;
							// echo		"Select * from  $tblname  $crit  order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit && consignorid=$consignorid  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$head_name=$cmn->getvalfield($connection,"otherexp_master","head_name","otherid=$row[otherid]");
$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
// $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
// $driver_name=$cmn->getvalfield($connection,"m_driver","driver_name","driver_id=$row[driver_id]");
						  	$tamt+=$row['amount'];
										   ?>
										<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo dateformatindia($row['exp_date']); ?></td>
						<td><?php echo $head_name; ?></td>
						
						<!--<td><?php echo $vehicle_no; ?></td>-->
						<!-- <td class='hidden-350'><?php echo $mechanic_name; ?></td> -->
					
						<!--<td class='hidden-1024'><?php echo $driver_name; ?></td>-->
						<!--<td><?php echo $row['bill_type']; ?></td>-->
						<!-- <td><?php echo dateformatindia($row['service_datenext']); ?></td> -->
						<td><?php echo $row['bill_type']; ?></td>
						<td><?php echo $row['narration']; ?></td>
							<td><?php echo $row['amount']; ?></td>
						<td><?php echo $user_name; ?></td>

										</tr>
									<?php } ?>
									<tfoot>
									    <tr>
									        <td colspan='5'>TOTAL AMOUNT</td>
									        <td><?php echo $tamt; ?></td>
									    </tr>
									</tfoot>
									</tbody>
								</table>
</body>
</html>
