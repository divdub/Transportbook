<?php 
error_reporting(0);
include("../adminsession.php");
$tblname = "payment";
$tblpkey = "payment_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_voucher_report".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

if(isset($_GET['search']))
{
	 $fromdate = $_GET['fromdate'];
 	$todate = $_GET['todate'];
	
}
else
{
	$fromdate = $currentdate;
	$todate = $currentdate;

}

if (isset($_GET['cat_id'])) {
	$category_id = trim(addslashes($_GET['cat_id']));
} else
	$category_id = '';

if (isset($_GET['payee_name'])) {
	$payee_name = trim(addslashes($_GET['payee_name']));
} else
	$payee_name = '';



if ($fromdate != '' && $todate != '') {
	$crit .= "where voucher_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($category_id != '') {
	
	$crit .= " and category_id='$category_id'";
}


if ($payee_name != '') {
	$crit .= " and payee_name='$payee_name' ";
//   $cat_name=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id=$catname");

}
// if ($catname != '' && $category_id == 2) {
// 	$crit .= " and catname='$catname' ";
//   $cat_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$catname");
// }
// if ($catname != '' && $category_id == 4) {
//       $crit .= " and catname='$catname' ";
// 	  $cat_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$catname");
// }
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
<!DOCTYPE html>
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
									    <tr><th colspan="6" style="font-weight:bold;font-size:24px;"> <?php echo ucfirst($cname); ?> VOUCHER REPORT </th></tr>
										<tr>
				<th>S.No</th>
						<th>Category</th>
						<th>Voucher No.</th>
						<th>Voucher Name</th>
						<th>Voucher Date</th>
						<th>Voucher Amount</th>
						<th>User Name</th>  
						<!-- <th>Action</th> -->
										</tr>
									</thead>
									<tbody>
			 <?php
									$sn=1;
					// echo	"Select * from  $tblname  $crit && is_paid=0  GROUP BY voucher_no order by $tblpkey desc ";
				$sql = mysqli_query($connection,"Select * from  $tblname  where  consignorid=$consignorid  GROUP BY voucher_id ");
										  while($row= mysqli_fetch_array($sql)) {
	$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$row[user_id]");
$category=$row['category_id'];
if($category==1){
	$cname="Agent";
	
$agent_id=$cmn->getvalfield($connection,"dispatch_entry","agent_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id='$agent_id'");
	
} 
if($category==2){
	$cname="Consignee";
	
$consignee_id=$cmn->getvalfield($connection,"dispatch_entry","consignee_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consignee_id'");	
} 
if($category==4) {
	$cname="Truck Owner";
	
$owner_id=$cmn->getvalfield($connection,"dispatch_entry","owner_id","dispatch_id='$row[dispatch_id]'");
$vname=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$owner_id'");

}
$amt_paid_to=$cmn->getvalfield($connection,"payment","sum(amt_paid_to)","voucher_id='$row[voucher_id]'");
					  	
										   ?>
					<tr>
					<td><?php echo $sn++;?></td>
						<td><?php echo $cname; ?></td>
						<td><?php echo $row['voucher_id']; ?></td>
						<td><?php echo $vname; ?></td>
						<td><?php echo dateformatindia($row['voucher_date']); ?></td>
					<td><?php echo $amt_paid_to; ?></td>
						 
<td><?php echo $user_name; ?></td>

										</tr>
									<?php 	$tot+=$amt_paid_to; } ?>
									<tr>
									   	<td colspan="6" style="background-color:gray;text-align:center;font-weight:bold;font-size:24px;">Total Voucher Amount :
									   	<?php echo $tot; ?></td>
									</tr>
									<tr>
									    <td colspan="6" style="background-color:gray;text-align:center;font-weight:bold;font-size:24px;">In Words :
									   	<?php echo ucwords(getinwordsbyindia($tot)); ?></td>
									</tr>
									</tbody>
								</table>
</body>
</html>
