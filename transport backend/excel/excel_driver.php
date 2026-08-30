<?php include("../adminsession.php");
$tblname = "m_driver";
$tblpkey = "driver_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_driver".strtotime("now").'.xls';
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
											<th>Driver Name</th>
											<th>Mobile No.</th>
											<th>Address</th>
                                            <th>Licence Exp Date</th>
                                            <th>Basic Salary</th>
										</tr>
									</thead>
									<tbody>
										   <?php
										$sn=1;
					$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
			
										   ?>
										<tr>
					<td><?php echo $sn++; ?></td>
						<td><?php echo $row['driver_name']; ?></td>
						<td><?php echo $row['mobile_no']; ?></td>
						<td><?php echo $row['daddress']; ?></td>
					<td class='hidden-1024'><?php echo dateformatindia($row['lic_exp_date']); ?></td>
					<td><?php echo $row['salary']; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
