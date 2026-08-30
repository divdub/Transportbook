<?php include("../adminsession.php");
$tblname = "payroll";
$tblpkey = "payment_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_payroll".strtotime("now").'.xls';
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
                
                  <th class='hidden-350'>Payment Date</th>
                  <th>Employee Name</th>
                  <th>Expense Head</th>
                  <th class='hidden-1024'>Amount</th>
                  <th>Pay Mode</th>
                  <th>Remark</th>
				  <th>User Name</th>
                  <!-- <th class='hidden-480'>Action</th> -->
										</tr>
									</thead>
									<tbody>
										   <?php
										$sn=1;
					$sql = mysqli_query($connection,"Select * from  $tblname  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
			   $employee_name=$cmn->getvalfield($connection,"m_employee","employee_name","employee_id=$row[employee_id]");
$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");

   $head_name=$cmn->getvalfield($connection,"inc_exp_head","head_name","inc_exp_id=$row[inc_exp_id]");
										   ?>
										<tr>
					  <td><?php echo $sn++;?></td>
                  <td><?php echo dateformatindia($row['payment_date']); ?></td>
                  <td><?php echo $employee_name; ?></td>
                  <td class='hidden-350'><?php echo $head_name; ?></td>
                  <td><?php echo $row['amount']; ?></td>
                  <td><?php echo $row['pay_mode']; ?></td>
                  <td><?php echo $row['remark']; ?></td>
				  <td><?php echo $user_name; ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
</body>
</html>
