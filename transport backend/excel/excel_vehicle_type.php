<?php include("../adminsession.php");
$tblname = "m_vehicle_type";
$tblpkey = "vehicle_type_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_vehicle_type".strtotime("now").'.xls';
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
											<th>S.no</th>
											<th>Vehicle type </th>
											<th>No. of Wheels</th>
											
										</tr>
									</thead>
									<tbody>
										   <?php
										$sn=1;
					$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
										   ?>
										<tr>
												<td><?php echo $sn++;?></td>
											<td><?php echo $row['vehicle_type']; ?></td>
											<td><?php echo $row['no_of_wheels']; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
