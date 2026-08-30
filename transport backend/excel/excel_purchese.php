<?php include("../adminsession.php");
$tblname = "service_entry";
$tblpkey = "service_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_service".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
} else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if (isset($_GET['supplier_id'])) {
	$supplier_id  = trim(addslashes($_GET['supplier_id']));
} else
	$supplier_id= '';

if (isset($_GET['bill_type'])) {
	$bill_type  = trim(addslashes($_GET['bill_type']));
} else
	$bill_type = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {


	$crit .= " and  purchase_date   between '$fromdate' and '$todate'";
}

if ($supplier_id != '') {
	$crit .= " and supplier_id ='$supplier_id'";
}
if ($bill_type != '') {
	$crit .= " and bill_type ='$bill_type'";
}
if ($_GET['purchaseid'] != "") {

	
	mysqli_query($connection, "update purchase_entry  set is_complete=0  where is_complete=1 and purchaseid='$purchaseid");
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
  font-size:14px;
}	
	</style>
</head>
<body>
<table>
									<thead>
										<tr>
									<th>S.No</th>
						<th> Date</th>
						<th>Supplier Name</th>
						<th class='hidden-350'>Bill No.</th>
						<th>Bill Type</th>
						<th class='hidden-1024'>Qty</th>
						<th>Remark</th>
						<th>Net Total</th>
						<!--<th>Next Meter Reading</th>-->
						<!-- <th>Qty (Bags)</th> -->
						<!--<th>Narration</th>	-->
						<!-- <th>Bilty Scan</th>	 -->
										</tr>
									</thead>
									<tbody>
										   <?php
									$slno = 1;
									
										$sel = "select * from purchaseentry where 1=1 $crit && compid='$compid' &&  sessionid='$sessionid' order by billno desc  ";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
											$supplier_name = $cmn->getvalfield($connection, "m_supplier", "supp_name", "supplier_id='$row[supplier_id]'");
											$total_amt = $cmn->getvalfield($connection, "purchasentry_detail", "sum(nettotal)", "purchaseid='$row[purchaseid]'");
											$itemid = $cmn->getvalfield($connection, "purchasentry_detail", "iteminv_id", "purchaseid='$row[purchaseid]'");
											$qty = $cmn->getvalfield($connection, "purchasentry_detail", "sum(qty)", "purchaseid='$row[purchaseid]'");
											$purchaseid=$row['purchaseid'];
											$bill_type=$row['bill_type'];
											$iteminv_category_id = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id='$itemid'");
										   ?>
										<tr>
												<td><?php echo $slno++;?></td>
                        						<td><?php echo dateformatindia($row['purchase_date']); ?></td>
                                                <td><?php echo $supplier_name; ?></td>
                        						<td><?php echo ucfirst($row['billno']); ?></td>
                        						<td><?php echo ucfirst($row['bill_type']); ?></td>
                        						<td><?php echo $qty; ?></td>
                        						<td><?php echo ucfirst($row['remark']); ?></td>
                        						<td><?php echo number_format($total_amt,2); ?>
					
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
