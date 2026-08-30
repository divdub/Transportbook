<?php 
error_reporting(0);
include("../adminsession.php");
$tblname = "dispatch_entry";
$tblpkey = "dispatch_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_dispatch_advance".strtotime("now").'.xls';
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

if (isset($_GET['pump_id'])) {
	$pump_id = trim(addslashes($_GET['pump_id']));
} else
	$pump_id = '';
	

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($vehicle_id != '') {
	$crit .= " and vehicle_id='$vehicle_id'";
}
if ($pump_id != '') {
	$crit .= " and pump_id='$pump_id'";
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
									       <tr><th colspan="8" style="font-weight:bold;font-size:24px;"> <?php echo ucfirst($cname); ?> DIESEL ADVANCE REPORT </th></tr>
										<tr>
						<th>S.No</th>
						<th>DI No.</th>
						<th>Bilty No.</th>
						<th>Truck No.</th>
						<th>Freight Amt</th>
						<th>Bilty Date</th>
						<th>Pump Name</th>
							<th>Rate</th>
						<th>Ltr</th>
						<th>Diesel Adv. Amt.</th>
						<!--<th>Cash Advance</th>-->
					
					
										</tr>
									</thead>
									<tbody>
				 <?php
									$sn=1;
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit && is_advance=1 && consignor_id=$consignorid order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
		      $pump_name=$cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id=$row[pump_id]");

	 $wt_mt =$row['wt_mt'];
     $own_rate=$row['own_rate'];
     $freight_amt=$wt_mt * $own_rate;
						  	
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo $row['di_no']; ?></td>
						<td><?php echo $row['bilty_no']; ?></td>
						<td><?php echo $vehicle_no; ?></td>
						<td><?php echo $freight_amt; ?></td>
						<td><?php echo dateformatindia($row['bilty_date']); ?></td>
												<td><?php echo $pump_name; ?></td>
	<td><?php echo $row['diesel_rate']; ?></td>
						<td><?php echo $row['diesel_ltr']; ?></td>
						<td><?php echo $row['diesel_adv_amt']; ?></td>
						<!--<td><?php echo $row['cash_adv']; ?></td>-->
					
						
										</tr>
										<?php
					$totcashadv+=$row['cash_adv'];
					$totdieseladv+=$row['diesel_adv_amt'];
						$dieselltr+=$row['diesel_ltr'];
					} ?>
					<tfoot >
					    <tr style="font-weight:bold;">
					       
					            <td colspan="8" >TOTAL</td>
					             <td><?php echo $dieselltr; ?></td>
					            <td><?php echo $totdieseladv; ?></td>
					            <!--<td><?php echo $totcashadv; ?></td>-->
					        
					    </tr>
					<!--    <tr>-->

					
					<!--<td colspan="8" style="background-color:gray;text-align:center;font-weight:bold;font-size:24px;"> TOTAL CASH ADVANCE AMOUNT	: <?php echo ucwords(getinwordsbyindia($totcashadv)); ?> </td>-->
					<!--					</tr>-->
										<tr>
					<td colspan="8" style="background-color:gray;text-align:center;font-weight:bold;font-size:24px;"> TOTAL DIESEL ADVANCE AMOUNT	: <?php echo ucwords(getinwordsbyindia($totdieseladv)); ?> </td>
						</tr>
					</tfoot>
								
									</tbody>
								</table>
</body>
</html>
