<?php
error_reporting(0);
include("../adminsession.php");
// include("function/dispatch_function.php");
$tblname = "service_entry";
$tblpkey = "service_id";
$pagename = "maintenance_report.php";
$modulename = "Service Details";
$crit = '';

	$fromdate = $_GET['fromdate'];
	$todate = $_GET['todate'];


if (isset($_GET['head_id'])) {
	$head_id = trim(addslashes($_GET['head_id']));
} else
	$head_id = '';
if (isset($_GET['mechanic_id'])) {
	$mechanic_id = trim(addslashes($_GET['mechanic_id']));
} else
	$mechanic_id = '';

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where service_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($vehicle_id != '') {
	$crit .= " and vehicle_id='$vehicle_id'";
}
if ($head_id != '') {
	$crit .= " and head_id='$head_id'";
}
if ($mechanic_id != '') {
	$crit .= " and mechanic_id='$mechanic_id'";
}

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_service".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

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
									<th>Sno</th>
												<th>Date</th>
												<th>Type</th>	
												<th>Meter Reading</th>
												<th>Truck No</th>
												<th>Driver Name </th>
												<th>Amount</th>
												<th>Billing type</th>
												<!--<th>Print</th>-->
												<th>User Name</th>
						<!-- <th>Bilty Scan</th>	 -->
										</tr>
									</thead>
									<tbody>
										 <?php
											$slno = 1;
										//echo "sselect * from service_entry  $crit  && comp_id=$comp_id && session_id='$session_id' order by service_id desc";
											$sel = "select * from service_entry  $crit  && comp_id=$comp_id && session_id='$session_id' order by service_id desc";
											$res = mysqli_query($connection, $sel);
											while ($row = mysqli_fetch_assoc($res)) {
												$driver_name =$cmn->getvalfield($connection, "m_driver", "driver_name", "driver_id='$row[driver_id]'");
												$vehicle_no= $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row[vehicle_id]'");
												$amount = $cmn->getvalfield($connection, "service_detail", "sum(amount)", "service_id='$row[service_id]'");
                                               $user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
											?>
												<tr>
													<td><?php echo $slno; ?></td>
													<td><?php echo dateformatindia($row['service_date']); ?></td>
													<td><?php echo $row['type']; ?></td>
													<td><?php echo $row['meter_reading']; ?></td>
													
													<td><?php echo strtoupper($vehicle_no); ?></td>
													<td><?php echo ucfirst($driver_name); ?></td>

													<td><?php echo $amount; ?></td>
													<td><?php echo strtoupper($row['bill_type']); ?></td>
													<td><?php echo $user_name; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
