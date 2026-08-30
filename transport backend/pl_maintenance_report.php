<?php
include("adminsession.php");
//    error_reporting(0);
$pagename = "pl_maintenance_report.php";

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = $_GET['fromdate'];

	 $todate = $_GET['todate'];
	 $vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';

if ($fromdate != '' && $todate != '') {
	$crit .= "service_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($vehicle_id != '') {
	$crit .= " and vehicle_id='$vehicle_id'";
}

?>
<!doctype html>
<html>



<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<!-- <title>Trip Master</title> -->
	

	<?php include("inc/top-files.php"); ?>
</head>

<body>

	<?php include("inc/model.php"); ?>
	<?php include("inc/top-header.php"); ?>
	<div>
		<center>
			<h3>Maintenance Details</h3>
		</center>
	</div>


	<div class="box-content nopadding" style="overflow:scroll">
	<table class="table table-condensed table-bordered "  id="">
									<thead>

										<th>S.No.</th>

										<th>Vehicle No</th>
										<!-- <th>Driver Name</th>
										<th>Head Name</th> -->
										

										<th>Service Date</th>
										<th>Next Service Date</th>
										<th>Remark</th>
										<th>Expenses Amt.</th>
										<!-- <th class='hidden-350'>Action</th> -->


									</thead>
									<tbody style="text-transform:capitalize;">

										<?php $sn = 1;
										// echo "select * from service_entry where $crit order by service_id desc";
										$sql = mysqli_query($connection, "select * from service_entry where $crit order by service_id desc");
										while ($row = mysqli_fetch_array($sql)) {

											// $driver_name = $cmn->getvalfield($connection, "driver_master", ""driver_name, "driver_id='$row[driver_id]'");
											$vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row[vehicle_id]'");
											// $head_name = $cmn->getvalfield($connection, "main_head_master", "head_name", "main_head_id='$row[main_head_id]'");
                                       $totalamt += $row['amount'];

										?>
											<tr>
												<td><?php echo $sn++; ?></td>
												<td><?php echo $vehicle_no; ?></td>
												<!-- <td><?php echo $driver_name; ?></td>
												<td><?php echo $head_name; ?></td> -->
												

												<td><?php echo date('d-m-Y', strtotime($row['service_date'])); ?></td>
												<td><?php echo $row['remark']; ?></td>
												<td><?php echo date('d-m-Y', strtotime($row['service_datenext'])); ?></td>

                                 <td><?php echo $row['amount']; ?></td>

												
											<?php } ?>
											</tr>
<tr>
	<td colspan="5" style="text-align:center;" > <b>Total</b></td>

						<td colspan=""><b><?php echo $totalamt; ?></b></td>
</tr>



									</tbody>
								</table>

	</div>
	</div>
	</div>
	</div>
	</div>

	</div>
	</div>
	</div>
	
</body>



</html>