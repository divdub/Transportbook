<?php
include("adminsession.php");
$tblname = 'maintance_entry';
$tblpkey = 'maintance_id';
$pagename  = 'excel_maintenance_report.php';
$modulename = "Billty Report";
$crit = "";
if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
    $fromdate = $_GET['fromdate'];

    $todate = $_GET['todate'];
    $vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else {
    $fromdate = date('Y-m-d');
    $todate = date('Y-m-d');
}

if (isset($_GET['vehicle_id'])) {
    $vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
    $vehicle_id = '';

if ($fromdate != '' && $todate != '') {
    $crit .= "meeter_reading_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
}

if ($vehicle_id != '') {
    $crit .= " and vehicle_id='$vehicle_id'";
}
// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
$filename = "P_L_report.xls";
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=" . $filename);



?>
<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
     table, th, td {
  border: 1px solid;
}  
    </style>
</head>
<body>
<table class="table table-bordered" width="50%">
    <thead>
        <tr style="border:1px;border-color: black;">
            <th>Sno</th>

            <th>Vehicle No</th> 
                                            <th>No Of Trip </th>
                                            <th>Total Freight </th>
                                      
                                            <th>Maintenance Expenses </th>
                                            <!-- <th>TP Amount</th> -->
                                            <!-- <th>Driver Payment </th> -->
                                            <th>Profit & Loss</th>

        </tr>
    </thead>
    <tbody>
    <?php if($vehicle_id!=''){ ?>
                                    <tbody>
                                        <?php $slno = 1;
                                        $frieght_amt = 0;
                                         $driver_payment_amt = 0;
                                        $trip_expenses = 0;
                                        $maintance_expenses_amt = 0;
                                        $tp_amount = 0;
                                        
                                        // echo"select * from m_vehicle where  vehicle_id='$vehicle_id' order by vehicle_no";
                                        $sql = mysqli_query($connection, "select * from dispatch_entry where  vehicle_id='$vehicle_id' && bilty_date BETWEEN '$fromdate' and  '$todate'");
                                        while ($row = mysqli_fetch_array($sql)) {

                                     
 $vehicle_id = $cmn->getvalfield($connection, "dispatch_entry", "vehicle_id", "vehicle_id='$row[vehicle_id]'  &&  comp_id='$comp_id' && bilty_date BETWEEN '$fromdate' and  '$todate' " );
$vehicle_no = $cmn->getvalfield($connection, "m_vehicle ", "vehicle_no", "vehicle_id='$vehicle_id'");
$trip_no = $cmn->getvalfield($connection, "dispatch_entry", "count(dispatch_id)", "vehicle_id='$row[vehicle_id]'  &&  comp_id='$comp_id' && bilty_date BETWEEN '$fromdate' and  '$todate' " );
$dispatch_id = $cmn->getvalfield($connection, "dispatch_entry", "dispatch_id", "vehicle_id='$row[vehicle_id]'" );
                                            $frieght_amt = $cmn->getvalfield($connection, "dispatch_entry", "sum(comp_rate*qty)", "vehicle_id='$row[vehicle_id]' &&  comp_id='$comp_id' && bilty_date BETWEEN '$fromdate' and  '$todate' ");
                                            $tp_amount = $cmn->getvalfield($connection, "tpa_entry", "sum(amt)", " dispatch_id='$dispatch_id' &&  comp_id='$comp_id' && bilty_date BETWEEN '$fromdate' and  '$todate' ");

                                               $maintance_expenses_amt = $cmn->getvalfield($connection, "service_entry", "sum(amount)", "vehicle_id ='$row[vehicle_id]' &&  comp_id='$comp_id' && service_date BETWEEN '$fromdate' and '$todate'");
                                     $frt=$frieght_amt - $tp_amount;
                                   $profit=$frt-$maintance_expenses_amt ;
                                   $tot_amount += $profit;
                                        ?>
                                            <tr>
                                            <td><?php echo $slno++; ?></td>
                                                 <td><?php echo $vehicle_no; ?></td> 
                                                <td style="text-align:right;"><a href="pl_trip_entry.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($trip_no, 2); ?></a></td>

                                                <td style="text-align:right;"><a href="pl_trip_entry.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($frt, 2); ?></a></td>

                                                <!-- <td style="text-align:right;"><a href="pl_trip_entry.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($trip_expenses, 2); ?></a></td> -->
                                                <td style="text-align:right;"><a href="pl_maintenance_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($maintance_expenses_amt, 2); ?></a></td>
                                                <!-- <td style="text-align:right;"><a href="excel_truck_expenses_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($tp_amount, 2); ?></a></td> -->
                                               <!-- <td><a href="pl_driver_payment_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($driver_payment_amt,2); ?></a></td> -->
                                                <td style="text-align:right;"><?php echo number_format($profit, 2); ?></a></td>                               
                              
                        	</tr>
                             
                                            <?php } ?>
							
                      </tr>




                  </tbody>
                  <?php } else { ?>
                    <tbody>
                                        <?php $slno = 1;
                                        $frieght_amt = 0;
                                         $driver_payment_amt = 0;
                                        $trip_expenses = 0;
                                        $maintance_expenses_amt = 0;
                                        $tp_amount = 0;
                                        
                                        // echo"select * from m_vehicle order by vehicle_no";
                                        $sql = mysqli_query($connection, "select * from dispatch_entry where  bilty_date BETWEEN '$fromdate' and  '$todate' ");
                                        while ($row = mysqli_fetch_array($sql)) {

 $vehicle_id = $cmn->getvalfield($connection, "dispatch_entry", "vehicle_id", "vehicle_id='$row[vehicle_id]'  &&  comp_id='$comp_id' && bilty_date BETWEEN '$fromdate' and  '$todate' " );
$vehicle_no = $cmn->getvalfield($connection, "m_vehicle ", "vehicle_no", "vehicle_id='$vehicle_id'");
$trip_no = $cmn->getvalfield($connection, "dispatch_entry", "count(dispatch_id)", "vehicle_id='$row[vehicle_id]'  &&  comp_id='$comp_id' && bilty_date BETWEEN '$fromdate' and  '$todate' " );
$dispatch_id = $cmn->getvalfield($connection, "dispatch_entry", "dispatch_id", "vehicle_id='$row[vehicle_id]'" );
                                            $frieght_amt = $cmn->getvalfield($connection, "dispatch_entry", "sum(comp_rate*qty)", "vehicle_id='$row[vehicle_id]' &&  comp_id='$comp_id' && bilty_date BETWEEN '$fromdate' and  '$todate' ");
                                            $tp_amount = $cmn->getvalfield($connection, "tpa_entry", "sum(amt)", " dispatch_id='$dispatch_id' &&  comp_id='$comp_id' && bilty_date BETWEEN '$fromdate' and  '$todate' ");

                                               $maintance_expenses_amt = $cmn->getvalfield($connection, "service_entry", "sum(amount)", "vehicle_id ='$row[vehicle_id]' &&  comp_id='$comp_id' && service_date BETWEEN '$fromdate' and '$todate'");
                                     $frt=$frieght_amt - $tp_amount;
                                   $profit=$frt-$maintance_expenses_amt ;
                                   $tot_amount += $profit;
                                        ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                                 <td><?php echo $vehicle_no; ?></td> 
                                                <td style="text-align:right;"><?php echo number_format($trip_no, 2); ?></td>

                                                <td style="text-align:right;"><?php echo number_format($frt, 2); ?></td>

                                                <!-- <td style="text-align:right;"><a href="pl_trip_entry.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($trip_expenses, 2); ?></a></td> -->
                                                <td style="text-align:right;"><?php echo number_format($maintance_expenses_amt, 2); ?></td>
                                                <!-- <td style="text-align:right;"><a href="excel_truck_expenses_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($tp_amount, 2); ?></a></td> -->
                                               <!-- <td><a href="pl_driver_payment_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vehicle_id=<?php echo $row['vehicle_id']; ?>"><?php echo number_format($driver_payment_amt,2); ?></a></td> -->
                                                <td style="text-align:right;"><?php echo number_format($profit, 2); ?></a></td>                               
                              
                        	</tr>
                             
                                            <?php } ?>
							
                      </tr>




                  </tbody>
                  <?php } ?>
    </tbody>
</table>


<script>
    window.close();
</script>
</body>
</html>

