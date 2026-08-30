<?php 
error_reporting(0);
include("../adminsession.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_dispatch_entry".strtotime("now").'.xls';
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
   if ($_GET['owner_id']) {
   	$owner_id = trim(addslashes($_GET['owner_id']));
   } else
   	$owner_id = '';
   if ($_GET['brand_id']) {
    $brand_id = $_GET['brand_id'];
   } else
    $brand_id = '';
       if (isset($_GET['selectype'])) {
   	$selectype = trim(addslashes($_GET['selectype']));
   } else
   	$selectype = '';
   	
      if ($_GET['item_id']) {
    $item_id = $_GET['item_id'];
   } else
    $item_id = '';
    
   if ($_GET['vehicle_id']) {
    $vehicle_id = $_GET['vehicle_id'];
   } else
    $vehicle_id = '';
   
     if ($_GET['is_invoice']) {
    $is_invoice = $_GET['is_invoice'];
   } else
    $is_invoice= '';
    
   if ($fromdate != '' && $todate != '') {
    $crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
   }
   
   if ($vehicle_id != '') {
    $crit .= " and vehicle_id='$vehicle_id'";
   }
    if ($owner_id != '') {
    $crit .= " and owner_id='$owner_id'";
   }
   if ($item_id != '') {
    $crit .= " and item_id='$item_id'";
   }
 if ($brand_id != '') {
    $crit .= " and brand_id='$brand_id'";
   }
    if ($is_invoice != '') {
    $crit .= " and is_invoice='$is_invoice'";
   }
     
   if ($selectype != '') {
   	$crit .= " and is_complete='$selectype'";
   }
    $cname = $cmn-> getvalfield($connection,"m_company","cname","comp_id=$comp_id");
    function getinwordsbyindia($number)
{
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? 'and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] :'';
		  
		
		  
if($points !='' && $points !='0')
{
 $words=  "$result Rupees $points  Paise";
}
else
{
	$words=  "$result Rupees  ";
}
   
   return $words;
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
									       <tr><th colspan="29" style="font-weight:bold;font-size:24px;"> <?php echo ucfirst($cname); ?> SUMMARY REPORT </th></tr>
										<tr>
							<th>S.No</th>
						<th>DI/LR No.</th>
						<th>Bilty No.</th>
						<th>GR No.</th>
							<th>Invoice No</th>
						<th class='hidden-350'>Bilty Date</th>
						
						<th>Consignee</th>
						<th class='hidden-1024'>Truck No.</th>
							<th>Owner Name</th>
						<th>Destination</th>
						<th>Item</th>
						<th>Weight/MT</th>
						<th>Qty (Bags)</th>
						<th>Company Rate</th>	
						<th>Own Rate</th>
						<th>Freight Amount</th>
						<!--<th>Pump Name</th>-->
						<!--	<th>Slip No.</th>-->
						<th>Diesel Adv. Amt.</th>
						<th>Cash Advance</th>
						<th>GPS Amt</th>
						<th>Bilty Commission</th>
						<th>Bank Charge</th>
						<th>Tds Amount</th>
						<!--<th>Voucher No</th>-->
											 <!--<th>Status</th>-->
                                       <!--<th>Paid To</th>-->
						<!--		<th>Freight Bill No</th>-->
						<!--	 <th>Freight Date</th>-->
						<!--<th>Difference  </th>-->
							<th>Agent Rate</th>
						<th>Agent Amt</th>
						<th>Consignee Rate</th>
						<th>Consignee Amt</th>
						<th>Truck owner Rate</th>
						<th>Truck owner Amt</th>
						<th>Balance</th>
										</tr>
									</thead>
									<tbody>
				 <?php
									$sn=1;
				$sql = mysqli_query($connection,"Select * from  $tblname $crit && consignor_id=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
	$consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
	$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
$destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
$item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");	
$owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");	
$pump_name=$cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id=$row[pump_id]");
 $wt_mt=$row['wt_mt'];
$own_rate=$row['own_rate'];
$difference=$row['checkbox'];
				$freight_amt=$wt_mt * $own_rate;
				
				       $invoiceid = $row['invoiceid'];
                                               	$invno = $cmn->getvalfield($connection,"invoicebilty","invno","invoiceid='$invoiceid'");
								
								if($invno=='') { $invno="Unbilled"; }	
								$invdate = $cmn->getvalfield($connection,"invoicebilty","invdate","invoiceid='$invoiceid'");
								     $is_complete = $row['is_complete'];
                                              	$voucher_id = $cmn->getvalfield($connection,"payment","voucher_id","dispatch_id='$row[dispatch_id]' && category_id='4'");
								 	$bilty_commision = $cmn->getvalfield($connection,"payment","sum(bilty_commision)","dispatch_id='$row[dispatch_id]'");
								 		$tds_amt = $cmn->getvalfield($connection,"payment","sum(tds_amt)","dispatch_id='$row[dispatch_id]'");
								 		$bank_charge = $cmn->getvalfield($connection,"payment","sum(bank_charge)","dispatch_id='$row[dispatch_id]'");
								 		$amt_paid_to = $cmn->getvalfield($connection,"payment","sum(amt_paid_to)","dispatch_id='$row[dispatch_id]'");	
								if($is_complete=='0') { 
								    $status="Unpaid";
								    } else {
								      $status="Paid";
								    }	
								    if($bank_charge==''){
								        $bank_charge='0';
								    }
								     if($tds_amt==''){
								        $tds_amt='0';
								    }
								     if($bilty_commision==''){
								        $bilty_commision='0';
								    }
								$payee_name = $cmn->getvalfield($connection,"payment","payee_name","voucher_id='$voucher_id'");
								if($difference=='1'){ 
								    $dispatchid=$row['dispatch_id'];
								    
								    		$sql1 = mysqli_query($connection,"Select * from  tpa_entry  where dispatch_id='$dispatchid '");
								    												  while($row1= mysqli_fetch_array($sql1)) {
								    												      if($row1['tpcat_id']=='1'){
								    												       $agrate=$row1['rate'];
								    												       $agamt=$row1['amt'];
								    												      }
								    												        if($row1['tpcat_id']=='2'){
								    												       $corate=$row1['rate'];
								    												       $coamt=$row1['amt'];
								    												      }
								    												        if($row1['tpcat_id']=='4'){
								    												       $trate=$row1['rate'];
								    												       $tamt=$row1['amt'];
								    												      }
								    												  }
								    
								} else {
								                                                           $agrate='0';
								    												       $agamt='0';
								    												     
								    												       $corate='0';
								    												       $coamt='0';
								    												  if($row['is_create']=='1'){
								    												        $trate=$own_rate;
								    												       $tamt=$freight_amt;
								    												  } else 
								    												  { 
								    												      $trate='0';
								    												       $tamt='0';
								    												      
								    												  }
								    												     
								}
								
								 $diesel_adv_amt=$row['diesel_adv_amt'];
								 $cash_adv=$row['cash_adv'];
								 $other_cash_adv=$row['other_cash_adv'];
								$bal=$freight_amt- $agamt -$coamt  - $diesel_adv_amt - $cash_adv - $other_cash_adv - $tds_amt - $bank_charge - $bilty_commision;
								
										   ?>
					<tr>
						<td><?php echo $sn++;?></td>
						<td><?php echo $row['di_no']; ?></td>
						<td><?php echo $row['bilty_no']; ?></td>
						<td><?php echo $row['gr_no']; ?></td>
							<td><?php echo $row['invoice_no']; ?></td>
						<td><?php echo dateformatindia($row['bilty_date']); ?></td>
						<!--<td><?php echo $consignor_name; ?></td>-->
						<td class='hidden-350'><?php echo $consignee_name; ?></td>
						<td class='hidden-1024'><?php echo $vehicle_no; ?></td>
						<td class='hidden-1024'><?php echo $owner_name; ?></td>
						<td class='hidden-1024'><?php echo $destination; ?></td>
						<td class='hidden-1024'><?php echo $item_name; ?></td>
						<td><?php echo $row['wt_mt']; ?></td>
						<td><?php echo $row['qty']; ?></td>
						<td><?php echo $row['comp_rate']; ?></td>
							<td><?php echo $row['own_rate']; ?></td>
												<td><?php echo $freight_amt; ?></td>
													<!--<td><?php echo $pump_name; ?></td>-->
														<!--<td><?php echo $row['slip_no']; ?></td>-->
												<td><?php echo $row['diesel_adv_amt']; ?></td>
						<td><?php echo $row['cash_adv']; ?></td>
						<td><?php echo $row['other_cash_adv']; ?></td>
						
								<td><?php echo $bilty_commision; ?></td>
									<td><?php echo $bank_charge; ?></td>
										<td><?php echo $tds_amt; ?></td>
						<!--<td><?php echo $voucher_id;?></td>-->
				   <!--<td -->
				   <!--<?php if($is_complete=='0'){ ?>-->
				   <!--style="color:red;" -->
				   <!--<?php  } else { ?>-->
				   <!--style="color:green;" <?php } ?>-->
				   <!-->-->
				   <!--    <?php echo $status;?>-->
				   <!--    </td> -->
				   <!--<td><?php echo $payee_name;?></td> -->
						 <!-- <td><?php echo $invno; ?></td>-->
				   <!--<td><?php echo $invdate; ?></td> -->
						<!--<td>-->
						<!--<?php  if($difference=='1'){echo "YES"; } else{	echo "NO" ;} ; ?>-->
						<!--</td>-->
						<td><?php echo $agrate; ?></td>
							<td><?php echo $agamt; ?></td>
						<td><?php echo $corate; ?></td>
							<td><?php echo $coamt; ?></td>
								<td><?php echo $trate; ?></td>
									<td><?php echo $tamt; ?></td>
									<td><?php echo $bal; ?></td>
										</tr>
									<?php

                          $totwt_mt +=$row['wt_mt'];
$totother_cash_adv +=$row['other_cash_adv'];
$totdiesel_adv_amt +=$row['diesel_adv_amt'];
$totcash_adv +=$row['cash_adv'];
                                                                         $totagamt +=$agamt;
								    									   $totcoamt +=  $coamt;
								    									$tottamt += $tamt;
								    									$totalbank_charge+=$bank_charge;
								    										$totaltds_amt+=$tds_amt;
								    										$totalbilty_commision+=$bilty_commision;
									$totfreight_amt +=$freight_amt;
								// 	$net =$totfreight_amt-$totother_cash_adv - $totdiesel_adv_amt - $totcash_adv - $totagamt - $totcoamt - $tottamt;
									$totalbal+=$bal;
									} ?>
									<tr>
										<td colspan="11"  style="font-weight:bold;background-color:blue;color: white;text-align: center;font-size: 24px;">Total</td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totwt_mt; ?></td>
<td  colspan="3" style="font-weight:bold;background-color:blue;color: white;"></td>

<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totfreight_amt; ?></td>
<!--<td  colspan="2" style="font-weight:bold;background-color:blue;color: white;"></td>-->

<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totdiesel_adv_amt; ?></td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totcash_adv; ?></td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totother_cash_adv; ?></td>

<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totalbilty_commision; ?></td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totalbank_charge; ?></td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totaltds_amt; ?></td>
<td   style="font-weight:bold;background-color:blue;color: white;"></td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totagamt; ?></td>
<td   style="font-weight:bold;background-color:blue;color: white;"></td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totcoamt; ?></td>
<td   style="font-weight:bold;background-color:blue;color: white;"></td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $tottamt; ?></td>
<td  style="font-weight:bold;background-color:blue;color: white;"> <?php echo $totalbal; ?></td>
									</tr>
									<tr>

					
					<td colspan="29" style="background-color:gray;text-align:center;font-weight:bold;font-size:24px;"> TOTAL FREIGHT AMOUNT	: <?php echo $totalbal; ?> </td>
										</tr>
									</tbody>
									<tfoot>
									    	<tr>

					
					<td colspan="29" style="background-color:gray;text-align:center;font-weight:bold;font-size:24px;"> TOTAL FREIGHT AMOUNT	: <?php echo ucwords(getinwordsbyindia($totalbal)); ?> </td>
										</tr>
									</tfoot>
								</table>
<script>
   
</script>
</body>

</html>
