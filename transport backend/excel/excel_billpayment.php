<?php 
error_reporting(0);
include("../adminsession.php");
$tblname = "manualinv";
$tblpkey = "minvid";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_bill_payment".strtotime("now").'.xls';
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
                           <th>Invoice No.</th>
                           <th>Receive Date</th>
                           <th>Tds Amt</th>
                            <th>Gst Amt </th>
                           <th>Deduct Amount</th>
                           <th>Received Amount</th>
                           <!-- <th>Deduct Amount</th> -->
                           <th>Remark</th>
						   <th>User Name</th>
										</tr>
									</thead>
									<tbody>
				    <?php
                                          $sn=1;
                                          $total_tdsamt= 0;
            								$total_gstamt= 0;
            								$total_deduct= 0; 
            								$total_received= 0; 
								
                                          // echo		"Select * from  $tblname   order by $tblpkey desc";
                                          $sql = mysqli_query($connection,"Select * from  $tblname   order by $tblpkey desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
												$invno = $cmn->getvalfield($connection,"invoicebilty","invno","invoiceid='$row[invoiceid]'");	 		  	
												
												$total_tdsamt += $row['tds_amt'];
                								$total_gstamt += $row['gst_amt'];
                								$total_deduct += $row['deduct'];
                								$total_received += $row['received_amt'];
												$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
                                          	   ?>
                                    <tr>
									<td><?php echo $sn++;?></td>
						
                						<td><?php echo $invno; ?></td>
                						<td><?php echo dateformatindia($row['receive_date']); ?></td>
                                  <td class='hidden-350'><?php echo $row['tds_amt']; ?></td>
                                  <td class='hidden-350'><?php echo $row['gst_amt']; ?></td>
                						<td class='hidden-350'><?php echo $row['deduct']; ?></td>
                                  <td class='hidden-350'><?php echo $row['received_amt']; ?></td>
                                  <td class='hidden-350'><?php echo $row['remark']; ?></td>  
								  <td><?php echo $user_name; ?></td> 
                					</tr>
									<?php } ?>
                                            			</tbody>
                        <tbody>
                            <tr>
                                <td colspan="3" style="text-align:right; font-size:14px; font-weight:800"><b>Total</b></td>
                                <td style="font-size:14px; font-weight:800"><b><?= $total_tdsamt; ?></b></td>
                                <td style="font-size:14px; font-weight:800"><b><?= $total_gstamt; ?></b></td>
                                <td style="font-size:14px; font-weight:800"><b><?= $total_deduct; ?></b></td>
                                <td style="font-size:14px; font-weight:800"><b><?= $total_received; ?></b></td>
                                <td></td>
                            </tr>
                        </tbody>
								</table>
</body>
</html>
