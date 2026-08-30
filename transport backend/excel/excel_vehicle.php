<?php include("../adminsession.php");
$tblname = "m_vehicle";
$tblpkey = "vehicle_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_vehicle".strtotime("now").'.xls';
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
											  <th>Sno.</th>
											<th>Vehicle No.</th>
											<th>Owner Name</th>
											<th>Agent Name</th>
											<th>Vehicle Type </th>
											<th>Chassis No.</th>
											<th>Engine No.</th>
											<th>Meter Reading</th>
											<th>Meter Reading Date</th>
										</tr>
									</thead>
									<tbody>
										   <?php
										$sn=1;
					$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
										  	$owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
		$agent_name=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id=$row[agent_id]");
		$vehicle_type=$cmn->getvalfield($connection,"m_vehicle_type","vehicle_type","vehicle_type_id=$row[vehicle_type_id]");
		$no_of_wheels=$cmn->getvalfield($connection,"m_vehicle_type","no_of_wheels","vehicle_type_id=$row[vehicle_type_id]");
										   ?>
										<tr>
										<td><?php echo $sn++; ?></td>
                                            <td><?php echo $row['vehicle_no']; ?></td>
                                            <td><?php echo $owner_name; ?></td>
                                            <td><?php echo $agent_name; ?></td>
                                            <td><?php echo $no_of_wheels."-".$vehicle_type; ?></td>
                                            <td><?php echo $row['chassis_no']; ?></td>
                                            <td><?php echo $row['engine_no']; ?></td>
                                            <td><?php echo $row['meter_read']; ?></td>
                                            <td><?php echo dateformatindia($row['meter_read_date']); ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
