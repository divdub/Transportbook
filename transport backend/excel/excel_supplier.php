<?php include("../adminsession.php");
$tblname = "m_supplier";
$tblpkey = "supplier_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_supplier".strtotime("now").'.xls';
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
						<th>Supplier Name</th>
						<th>Head/Owner Name</th>
						<th>Mobile No.</th>
						<th>City</th>
						<th>Address</th>
										</tr>
									</thead>
									<tbody>
										   <?php
										$sn=1;
					$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
			$place_name=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[place_id]");
				$state_id=$cmn->getvalfield($connection,"m_place","state_id","place_id=$row[place_id]");
				$state_name=$cmn->getvalfield($connection,"m_state","state_name","state_id=$state_id");
										   ?>
										<tr>
							<td><?php echo $sn++; ?></td>
						<td><?php echo $row['supp_name']; ?></td>
						<td><?php echo $row['hname']; ?></td>
						<td><?php echo $row['mobile_no']; ?></td>
						<td><?php echo $place_name."-".$state_name; ?></td>
						<td class='hidden-350'><?php echo $row['saddress']; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
