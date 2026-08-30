<?php
error_reporting(0);
include("../adminsession.php");
$tblname = "payment";
$tblpkey = "payment_id";

if ($_GET['fromdate'] && $_GET['todate']) {
	$fromdate = $_GET['fromdate'];
	$todate = $_GET['todate'];
	$paid_to = $_GET['paid_to'];
} else {
	$fromdate = $currentdate;
	$todate = $currentdate;
}

if (isset($_GET['paid_to'])) {
	$paid_to = urldecode($_GET['paid_to']);
} else {
	$paid_to = '';
}

if ($fromdate != '' && $todate != '') {
	$crit .= "where voucher_date BETWEEN  '$fromdate' and  '$todate' ";
	// 	echo $crit;
}

if ($paid_to != '') {
	$crit .= " and payee_name='$paid_to'";
}

header("Content-type: application/vnd-ms-excel");
$filename = "excel_tds_report" . strtotime("now") . '.xls';

header("Content-Disposition: attachment; filename=" . $filename);

?>
<<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
		</title>
		<style type="text/css">
			table,
			th,
			td {
				border: 1px solid;
			}
		</style>
	</head>

	<body>
		<table>
			
			<thead>
			    <tr>
            <th colspan="11" style="text-align:center; font-size:18px; font-weight:bold; border:1px solid black;">
                TDS REPORT
            </th>
        </tr>
				<tr>
					<th>S.No</th>
					<th>DI/LR No.</th>
					<th>Bilty Date</th>
					<th>Paid To</th>
					<!--<th>Payee Name</th>-->
					<th>Destination</th>
					<th>Truck Owner</th>
					<th>Truck No</th>
					<th>Pan No.</th>
					<th>Freight Amount</th>
					<th>Paid Amount</th>

					<th>TDS Amount</th>

				</tr>
			</thead>
			<tbody>
				<?php
				$sn = 1;
				$total_freight = 0;
				$total_paid = 0;
				$total_tds = 0;
				$sql = mysqli_query($connection, "Select * from  $tblname  $crit  && tds_amt!=0  && consignorid=$consignorid order by $tblpkey desc");
				while ($row = mysqli_fetch_array($sql)) {
					$di_no = $cmn->getvalfield($connection, "dispatch_entry", "di_no", "dispatch_id=$row[dispatch_id]");
					$bilty_date = $cmn->getvalfield($connection, "dispatch_entry", "bilty_date", "dispatch_id=$row[dispatch_id]");
					$destination_id = $cmn->getvalfield($connection, "dispatch_entry", "destination_id", "dispatch_id=$row[dispatch_id]");
					$owner_id = $cmn->getvalfield($connection, "dispatch_entry", "owner_id", "dispatch_id=$row[dispatch_id]");
					$owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id=$owner_id");
					$vehicle_id = $cmn->getvalfield($connection, "dispatch_entry", "vehicle_id", "dispatch_id=$row[dispatch_id]");
					$vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$vehicle_id");
					$place_name = $cmn->getvalfield($connection, "m_place", "place_name", "place_id=$destination_id");
					$wt_mt = $cmn->getvalfield($connection, "dispatch_entry", "wt_mt", "dispatch_id=$row[dispatch_id]");
					$comp_rate = $cmn->getvalfield($connection, "dispatch_entry", "comp_rate", "dispatch_id=$row[dispatch_id]");
					$amt = $comp_rate * $wt_mt;
					$tds_amt =	$row['tds_amt'];

					$total_freight += $amt;
					$total_paid += $row['amt_paid_to'];
					$total_tds += $tds_amt;

				?>
					<tr>
						<td><?php echo $sn++; ?></td>
						<td><?php echo $di_no; ?></td>
						<td><?php echo dateformatindia($bilty_date); ?></td>


						<!--<td><?php echo $row['paid_to']; ?></td>-->
						<td><?php echo $row['payee_name']; ?></td>
						<td><?php echo $place_name; ?></td>
						<td><?php echo $owner_name; ?></td>
						<td><?php echo $vehicle_no; ?></td>
						<td><?php echo $row['panno']; ?></td>

						<td><?php echo $amt; ?></td>
						<td><?php echo number_format(round(($row['amt_paid_to']), 2)); ?></td>

						<td><?php echo $tds_amt; ?></td>

					</tr>

				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="8" style="text-align:right;">Total</th>
					<th><?php echo number_format($total_freight, 2); ?></th>
					<th><?php echo number_format($total_paid, 2); ?></th>
					<th><?php echo number_format($total_tds, 2); ?></th>
				</tr>
			</tfoot>
		</table>

	</body>

	</html>