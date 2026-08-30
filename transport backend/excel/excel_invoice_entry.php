<?php 
error_reporting(0);
include("../adminsession.php");
$tblname = "invoicebilty";
$tblpkey = "invoiceid";
$crit =  '';
if ($_GET['fromdate'] && $_GET['todate']) {
	$fromdate = $_GET['fromdate'];
	$todate = $_GET['todate'];
	
} else {
	$fromdate = $currentdate;
	$todate = $currentdate;
}



if ($fromdate != '' && $todate != '') {
	$crit .= "where invdate BETWEEN  '$fromdate' and  '$todate' ";
	// 	echo $crit;
}


 header("Content-type: application/vnd-ms-excel");
$filename = "excel_invoice_entry".strtotime("now").'.xls';
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
         table,
         th,
         td {
            border: 1px solid;
         }
      </style>
   </head>

   <body>
      <table>
         <thead>
             <tr>
                 <th colspan="9"><?php echo date('d-m-Y', strtotime($fromdate)) . " To " . date('d-m-Y', strtotime($todate)); ?></th>
             </tr>
            <tr>
               <th>Sno</th>
               <th>Bill Type</th>
                <th>Invoice No</th>
                <th>Invoice Date</th>
                <th>Qty</th>
                <th> Amount</th>
                <th>Invoice Amount</th>
                <th>Status</th>
                <th>Received Amount</th>
            </tr>
         </thead>
         <tbody>
            <?php
                                          $sn=1;
                                          // echo		"Select * from  $tblname   order by $tblpkey desc";
                                        //   echo "Select * from  $tblname $crit and consignorid=$consignorid && sessionid=$session_id order by $tblpkey desc";die;
                                          $sql = mysqli_query($connection,"Select * from  $tblname $crit and consignorid=$consignorid and sessionid=$session_id  order by $tblpkey desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                        				$amount = $cmn->getinvoiceamount($connection,$row['invoiceid']);
                                      $wt_mt = $cmn->getvalfield($connection,"dispatch_entry","sum(wt_mt)","invoiceid='$row[invoiceid]'"); 
                                      $invoiceAmt  = $cmn->getvalfield($connection,"manualinv","sum(received_amt)","invoiceid='$row[invoiceid]'"); 
                                      $gstv = $row['gst'];
                                      	$gst =  ($amount * $gstv)/100;
                                      	$amount1=$amount+$gst;
                                      	$totalamount +=$amount;
                                      	$totalamount1 +=$amount1;
                                      	$totalinvamt +=$invoiceAmt;
                                      	if($row['is_pay']==1){
                                      	    $status = "Paid";
                                      	}else{
                                      	    $status = "Unpaid";
                                      	}
                                          	   ?>
            <tr>
               <td>
                  <?php echo $sn++; ?>
               </td>
               <td><?php echo ucfirst($row['billtype']);?></td>
                <td><?php echo ucfirst($row['invno']);?></td>
                <td><?php echo $cmn->dateformatindia($row['invdate']);?></td>
                <td><?php echo number_format($wt_mt,2);?></td>
                 <td><?php echo number_format($amount, 2); ?></td>
                <td><?php echo number_format($amount1,2);?></td
                <td><?php echo $status;?></td>
                <td><?php echo $invoiceAmt;?></td>
               
               
               
            </tr>
            <?php } ?>
         </tbody>
         <tfoot>
             <tr>
                 <td colspan="5" style="text-align:center;">Total</td>
                 <td><?php echo $totalamount;?></td>
                 <td><?php echo $totalamount1;?></td>
                 <td></td>
                 <td><?php echo $totalinvamt;?></td>
             </tr>
         </tfoot>
      </table>
   </body>

   </html>