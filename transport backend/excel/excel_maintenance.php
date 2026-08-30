<?php include("../adminsession.php");
$tblname = "maintenance_entry";
$tblpkey = "main_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_maintenance".strtotime("now").'.xls';
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
						<th>S.No</th>
						
						<th>Truck No.</th>
						<th>Driver Name</th>
						<th> Date</th>
						<th>Mechanic Name.</th>
						<th>Maintenance / Spare </th>
						<th>Amount</th>
						<th>Payment Mode</th>
            <th>Remark</th>
			<th>User Name</th>
										</tr>
									</thead>
									<tbody>
										   <?php
										$sn=1;
					$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
								$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
	$mechanic_name=$cmn->getvalfield($connection,"mechanic_service_master","mechanic_name","mechanic_id=$row[mechanic_id]");
			$driver_name=$cmn->getvalfield($connection,"m_driver","driver_name","driver_id=$row[driver_id]");		
				$head_name=$cmn->getvalfield($connection,"head_master","head_name","head_id=$row[head_id]");	
				$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
										   ?>
										<tr>
						<td><?php echo $sn++;?></td>
						
						<td><?php echo $vehicle_no; ?></td>
						<td><?php echo $driver_name; ?></td>
						<td><?php echo dateformatindia($row['mdate']); ?></td>
						<td><?php echo $mechanic_name; ?></td>
						<td><?php echo $head_name; ?></td>
						<td><?php echo $row['amount']; ?></td>
						<td><?php echo $row['payment_mode']; ?></td>
						<td><?php echo $row['remark']; ?></td>
						<td><?php echo $user_name; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
