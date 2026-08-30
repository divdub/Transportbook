<?php include("../adminsession.php");
$tblname = "m_vehicle_owner";
$tblpkey = "owner_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_vehicle_owner".strtotime("now").'.xls';
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
									  <th>Vehicle Owner Name</th>
										<th>Father/Husband/Proprietor Name</th>
											<th>Email Id</th>
											<th>Mobile No</th>
											<th>Address</th>
											<th>Opaning Balance</th>
											<th>Opaning Bal. Date</th>
											<th>Owner Type.</th>
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
											<td><?php echo $row['owner_name']; ?></td>
                                            <td><?php echo $row['other_name']; ?></td>
                                            <td><?php echo $row['email_id']; ?></td>
                                            <td><?php echo $row['mobileno1']; ?></td>
                                            <td><?php echo $row['oaddress']; ?></td>
                                            <td><?php echo $row['opn_balnc']; ?></td>
                                            <td><?php echo dateformatindia($row['opn_balnc_date']); ?></td>
                                           <td><?php echo $row['owner_type']; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
