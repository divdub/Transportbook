<?php include("../adminsession.php");
$tblname = "inc_exp_head";
$tblpkey = "inc_exp_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_inc_ex_head".strtotime("now").'.xls';
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
											<th>S.no.</th>
											<th>Head Name</th>
											<th>Head Type</th>
											<th>Remark</th>
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
											<td><?php echo $row['head_name'];?></td>
											<td><?php echo $row['head_type'];?></td>
											<td><?php echo $row['remark'];?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
