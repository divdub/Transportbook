<?php 
error_reporting(0);
include("../adminsession.php");
$tblname = "trip_entry";
$tblpkey = "trip_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_return_entry".strtotime("now").'.xls';
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
   

     
   	
   
    
   if ($_GET['vehicle_id']) {
    $vehicle_id = $_GET['vehicle_id'];
   } else
    $vehicle_id = '';
   
     if ($_GET['consignor_id']) {
    $consignor_id = $_GET['consignor_id'];
   } else
    $consignor_id= '';
    
   if ($fromdate != '' && $todate != '') {
    $crit .= "where loding_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
   }
   
   if ($vehicle_id != '') {
    $crit .= " and vehicle_id='$vehicle_id'";
   }
   if ($consignor_id != '') {
    $crit .= " and consignor_id='$consignor_id'";
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
                                                      <th>Trip No.</th>
                                                      <th>Truck No.</th>
                                                      <th class='hidden-350'>Loading Date</th>
                                                      <th>Consignor</th>
                                                      <th>Consignee</th>
                                                      <!-- <th class='hidden-1024'>Truck No.</th> -->
                                                      <th>Destination</th>
                                                      <!-- <th>Item</th> -->
                                                      <th>Weight/MT</th>
                                                      <!-- <th>Qty (Bags)</th> -->
                                                      <th>Company Rate</th>
                                                       <th>Cash Adv</th>	 
                                                       <th>Diesel Adv</th>
                                                       <th>Consignor Adv</th>
                                                        <th>Office Adv</th>
										</tr>
									</thead>
									<tbody>
				 <?php
									$sn=1;
				$sql = mysqli_query($connection,"Select * from   $tblname $crit && sessionconsignor_id=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$consignor_name=$cmn->getvalfield($connection,"m_party","party_name","party_id=$row[consignor_id]");
	$consignee_name=$cmn->getvalfield($connection,"m_party","party_name","party_id=$row[consignee_id]");
	$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
$destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[toplaceid]");	
								
										   ?>
					<tr>
				 <td><?php echo $sn++;?></td>
                                                      <td><?php echo $row['trip_no']; ?></td>
                                                      <td class='hidden-1024'><?php echo $vehicle_no; ?></td>
                                                      <td><?php echo dateformatindia($row['loding_date']); ?></td>
                                                      <td><?php echo $consignor_name; ?></td>
                                                      <td class='hidden-350'><?php echo $consignee_name; ?></td>
                                                      <td class='hidden-1024'><?php echo $destination; ?></td>
                                                      <!-- <td class='hidden-1024'><?php echo $item_name; ?></td> -->
                                                      <td><?php echo $row['qty_mt_day_trip']; ?></td>
                                                      <!-- <td><?php echo $row['qty']; ?></td> -->
                                                      <td><?php echo $row['rate']; ?></td>
                                                       <td><?php echo $row['cash_advance']; ?></td>
                                                        <td><?php echo $row['diesel_advance']; ?></td>
                                                         <td><?php echo $row['consignor_adv']; ?></td>
                                                          <td><?php echo $row['office_adv']; ?></td>
										</tr>
									<?php

                        
									} ?>
<!--									<tr>-->
<!--										<td colspan="10"  style="font-weight:bold;background-color:blue;color: white;text-align: center;font-size: 24px;">Total</td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totwt_mt; ?></td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"></td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"></td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totfreight_amt; ?></td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totdiesel_adv_amt; ?></td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totcash_adv; ?></td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totother_cash_adv; ?></td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> </td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> </td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> </td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> </td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> </td>-->
<!--<td  style="font-weight:bold;background-color:blue;color: white;"> </td>-->
									<!--</tr>-->
									<!--<tr>-->

					
					<!--<td colspan="23" style="background-color:gray;text-align:center;font-weight:bold;font-size:24px;"> TOTAL FREIGHT AMOUNT	: <?php echo $totfreight_amt; ?> </td>-->
										<!--</tr>-->
									</tbody>
								</table>
</body>
</html>
