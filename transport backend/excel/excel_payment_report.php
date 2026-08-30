<?php 
error_reporting(0);
include("../adminsession.php");
$tblname = "payment_receive";
$tblpkey = "pay_receive_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_payment_report".strtotime("now").'.xls';
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
					<th>Category</th>
					<th>Voucher No.</th>
					<th>Voucher Name</th>
					<th>Receive No.</th>
					<th>Pay Amount.</th>
					<th>Pay Date</th>
					 <th>Remark</th>
					 <th>User Name</th> 
						<!-- <th>Action</th> -->
										</tr>
									</thead>
									<tbody>
				 <?php
									$sn=1;
							// echo		"Select * from  $tblname  $crit  order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname where consignorid=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
$category=$row['category'];
if($category==1){
	$cname="Agent";
	$voucher_no=$row['voucher_no'];
	
} 
if($category==2){
	$cname="Consignee";
$voucher_no=$row['voucher_no'];
	

} 
if($category==4) {
	$cname="Truck Owner";
	$voucher_no=$row['voucher_no'];

}

						  	
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo $cname; ?></td>
						<td><?php echo $voucher_no; ?></td>
						<td><?php echo $row['voucher_name']; ?></td>
						<td><?php echo $row['rec_no']; ?></td>
					<td><?php echo $row['receive_amt']; ?></td>
					<td><?php echo dateformatindia($row['receive_date']); ?></td>
					<td><?php echo $row['remark']; ?></td>
<td><?php echo $user_name; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
