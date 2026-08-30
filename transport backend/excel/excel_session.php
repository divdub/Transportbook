<?php include("../adminsession.php");
$tblname = "m_session";
$tblpkey = "session_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_session".strtotime("now").'.xls';
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
											<th>Session Start</th>
											<th>Session End</th>
											<th>Session Name</th>
											
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
											<td>
												<?php echo date('d-m-Y', strtotime($row['session_start'])); ?>
											</td>
											<td><?php echo date('d-m-Y', strtotime($row['session_end'])); ?></td>
											<td><?php echo $row['session_name']; ?></td>
											
									           
											
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
