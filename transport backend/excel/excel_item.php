<?php include("../adminsession.php");
$tblname = "m_item";
$tblpkey = "item_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_item".strtotime("now").'.xls';
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
											<th>Item Name</th>
											<th>Category Name</th>
											<th>Unit Name</th>
										</tr>
									</thead>
									<tbody>
										   <?php
										$sn=1;
					$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
				$unit_name=$cmn->getvalfield($connection,"m_unit","unit_name","unit_id=$row[unit_id]");
		$category_name=$cmn->getvalfield($connection,"m_item_category","category_name","item_category_id=$row[item_category_id]");
										   ?>
										<tr>
											<td><?php echo $sn++; ?></td>
											<td><?php echo $row['item_name']; ?></td>
											<td><?php echo $category_name; ?></td>
											<td><?php echo $unit_name; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
