<?php include("../adminsession.php");
$tblname = "othr_inc_entry";
$tblpkey = "other_inc_id ";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_other_inc".strtotime("now").'.xls';
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

if (isset($_GET['otherid'])) {
	$otherid = trim(addslashes($_GET['otherid']));
} else
	$otherid = '';
	
	
	if (isset($_GET['payment_mode'])) {
	$payment_mode= trim(addslashes($_GET['payment_mode']));
} else
	$payment_mode = '';
	

if (isset($_GET['vehicle_id'])) {
	$vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
	$vehicle_id = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where inc_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

// if ($vehicle_id != '') {
// 	$crit .= " and vehicle_id='$vehicle_id'";
// }
if ($otherid != '') {
	$crit .= " and otherid='$otherid'";
}

if ($payment_mode != '') {
	$crit .= " and payment_mode='$payment_mode'";
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
									      <tr><th colspan="6" style="font-weight:bold;font-size:24px;"> <?php echo ucfirst($cname); ?> OTHER INCOME REPORT </th></tr>
										<tr>
					<th>S.No</th>
						<th> Date</th>
						<th>Other Income</th>
						<!--<th class='hidden-350'>Truck No</th>-->
						<!-- <th>Mechanic/Service Name*</th> -->
					
						<!--<th class='hidden-1024'>Driver Name</th>-->
						<!--<th>Payment Type</th>-->
						<th>Payment Mode</th>
						<!-- <th>Next Meter Reading</th> -->
						<!-- <th>Qty (Bags)</th> -->
						<th>Narration</th>	
							<th>Amount</th>
							<th>User Name</th>  
										</tr>
									</thead>
									<tbody>
										   <?php
								$sn=1;
							// echo		"Select * from  $tblname  $crit  order by $tblpkey desc";
				$sql = mysqli_query($connection,"Select * from  $tblname  $crit && consignorid=$consignorid  order by $tblpkey desc");
										  while($row= mysqli_fetch_array($sql)) {
	$head_name=$cmn->getvalfield($connection,"otherexp_master","head_name","otherid=$row[otherid]");
$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
// $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
// $driver_name=$cmn->getvalfield($connection,"m_driver","driver_name","driver_id=$row[driver_id]");
						  	 	$tamt+=$row['amount'];
										   ?>
										<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo dateformatindia($row['inc_date']); ?></td>
						<td><?php echo $head_name; ?></td>
						
						<!--<td><?php echo $vehicle_no; ?></td>-->
						<!-- <td class='hidden-350'><?php echo $mechanic_name; ?></td> -->
					
						<!--<td class='hidden-1024'><?php echo $driver_name; ?></td>-->
						<!--<td><?php echo $row['bill_type']; ?></td>-->
						<!-- <td><?php echo dateformatindia($row['service_datenext']); ?></td> -->
						<td><?php echo $row['bill_type']; ?></td>
						<td><?php echo $row['narration']; ?></td>
							<td><?php echo $row['amount']; ?></td>
							<td><?php echo $user_name; ?></td>
										</tr>
									<?php } ?>
										<tfoot>
									    <tr>
									        <td colspan='5'>TOTAL AMOUNT</td>
									        <td><?php echo $tamt; ?></td>
											<td></td>
									    </tr>
									     <tr>
									        <td colspan='6'>IN WORDS :
									        <?php echo ucwords(getinwordsbyindia($tamt)); ?></td>
											<td></td>

									    </tr>
									</tfoot>
									</tbody>
								</table>
</body>
</html>
