<?php 
error_reporting(0);
include("../adminsession.php");
$tblname = "tpa_entry";
$tblpkey = "tpa_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_tpa_report".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);


 if($_GET['fromdate'] && $_GET['todate'])
   {
      $fromdate = $_GET['fromdate'];
         $todate = $_GET['todate'];
    
   }
else
{
	$fromdate = $currentdate;
	$todate = $currentdate;

}

if ($fromdate != '' && $todate != '') {
	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($di_no != '') {
	$crit .= " and di_no='$di_no'";
}

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
					 <th>DI/LR No. </th>
					<th>Bilty Date</th>

					<th>Category</th>
					<th>Category Name</th>
					<th>Rate</th>
					<th>Amount.</th>
										</tr>
									</thead>
									<tbody>
				 <?php
									$sn=1;
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit && is_create=0 && consignorid=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$category=$row['tpcat_id'];
if($category==1){
	$cname="Agent";
	$catname = $cmn->getvalfield($connection,"m_agent","agent_name","agent_id = '$row[category_id]'");

} 
if($category==2){
	$cname="Consignee";
	$catname = $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id = '$row[category_id]'");

} 
if($category==4) {
	$cname="Truck Owner";
		$catname = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id = '$row[category_id]'");
}

										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
					<td><?php echo $row['di_no']; ?></td>
					<td><?php echo dateformatindia($row['bilty_date']); ?></td>
						<td><?php echo $cname; ?></td>
						<td><?php echo $catname; ?></td>
						<td><?php echo $row['rate']; ?></td>
						<!-- <td><?php echo $di_no; ?></td> -->
					<td><?php echo $row['amt']; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
