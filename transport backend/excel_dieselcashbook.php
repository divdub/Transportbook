<?php
include("adminsession.php");

if(isset($_GET['fromdate'])) {
    $fromdate = $_GET['fromdate'];
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_GET['todate'])) {
    $todate =$_GET['todate'];
  }
  else
  $todate=date('Y-m-d');
if(isset($_GET['pump_id'])) {
    $pump_id =$_GET['pump_id'];
  }
  else
  $pump_id='';



	

  $cond="";
  $cond2="";



if($fromdate !='' && $todate !='' ) {
  $cond .= "and bilty_date between '$fromdate' and '$todate' "; 
    $cond1 .= "and rcv_date between '$fromdate' and '$todate' "; 
  
}
if($pump_id !='' ) {
  $cond .= "and pump_id='$pump_id'"; 
    $cond1 .= "and pump_id='$pump_id'"; 
  
// echo $fromdate;
  $openbal = $cmn->getvalfield($connection,"m_petrol_pump","opn_balnc","pump_id='$pump_id'"); 
	 $diesel_open_bal_str = strtotime($cmn->getvalfield($connection,"m_petrol_pump","opn_balnc_date","pump_id='$pump_id'"));
	 	 $opn_balnc_date = $cmn->getvalfield($connection,"m_petrol_pump","opn_balnc_date","pump_id='$pump_id'");
	 $currdate_str = strtotime($fromdate);
	if($currdate_str >= $diesel_open_bal_str)
	{	
// 			$opn_balnc_date =  date('Y-m-d', strtotime($opn_balnc_date . ' +1 day'));
		$currdate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));

	$opn_balnc_date =  date('Y-m-d', strtotime($opn_balnc_date . ' +1 day'));
		$tot=0;	
// 	echo	"select * from dieselbill where dbilldate between '$opn_balnc_date' and '$fromdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id"; 
		$sql = mysqli_query($connection,"select * from dieselbill where dbilldate between '$opn_balnc_date' and '$currdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id");
		while($row=mysqli_fetch_assoc($sql))
		{
		     
		      $adv_diesel = $cmn->getvalfield($connection,"dispatch_entry","sum(diesel_adv_amt)","dbillid='$row[dbillid]'"); 
			$tot += $adv_diesel;
// 			echo $adv_diesel.'     ';
			
		}
// 			$tot += $adv_diesel;
// 		echo "ot".$tot."  ";
		
		$tot_pay =0;
// 	echo	"select * from diesel_pay  where rcv_date between '$opn_balnc_date' and '$fromdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id";
		$sql2 = mysqli_query($connection,"select * from diesel_pay  where rcv_date between '$opn_balnc_date' and '$currdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id");
		while($row=mysqli_fetch_assoc($sql2))
		{
			$tot_pay += $row['rcv_amt'];
		}
		
				// echo $tot_pay;
		$curr_openingbal = $openbal + $tot - $tot_pay ;
	}
	else
	{
		$curr_openingbal = $openbal;	
	}
	
		
}

// header for Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=diesel_cashbook.xls");

echo "<table border='1'>";
echo "<tr>
    <th>S.No</th>
    <th>Invoice No</th>
    <th>GR Date</th>
    <th>GR/TR No</th>
    <th>DI No</th>
    <th>Truck No</th>
    <th>Consignee</th>
    <th>Destination</th>
    <th>Slip No</th>
    <th>Bill No</th>
    <th>Diesel Amt</th>
    <th>Paid Date</th>
    <th>Paid Amt</th>
</tr>";



$sn = 1;
$total_bal = 0;
$total_amt2 = 0;

//echo "SELECT * FROM dispatch_entry WHERE consignor_id=$consignorid AND session_id=$session_id $cond ORDER BY bilty_date DESC";die;
$sql = mysqli_query($connection,"SELECT * FROM dispatch_entry WHERE consignor_id=$consignorid AND session_id=$session_id $cond ORDER BY bilty_date DESC");
while($row = mysqli_fetch_array($sql)) {
    $consignee_name = $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id='$row[consignee_id]'");
    $truckno = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id='$row[vehicle_id]'");
    $deliverat = $cmn->getvalfield($connection, "m_place", "place_name", "place_id='$row[destination_id]'");
    $dbillno = $cmn->getvalfield($connection, "dieselbill", "dbillno", "dbillid='$row[dbillid]'");
    $is_pay = $cmn->getvalfield($connection, "dieselbill", "is_pay", "dbillno='$dbillno'");

    $total_amt1 = $is_pay != 0 ? $row['diesel_adv_amt'] : 0;
    $rcv_date = $is_pay != 0 ? date('d-m-Y', strtotime($cmn->getvalfield($connection,"diesel_pay","rcv_date","dbillid='$row[dbillid]'"))) : '';

    echo "<tr>
        <td>{$sn}</td>
        <td>{$row['invoice_no']}</td>
        <td>".date('d-m-Y',strtotime($row['bilty_date']))."</td>
        <td>{$row['gr_no']}</td>
        <td>{$row['di_no']}</td>
        <td>{$truckno}</td>
        <td>{$consignee_name}</td>
        <td>{$deliverat}</td>
        <td>{$row['slip_no']}</td>
        <td>{$dbillno}</td>
        <td>{$row['diesel_adv_amt']}</td>
        <td>{$rcv_date}</td>
        <td>{$total_amt1}</td>
    </tr>";

    $total_bal += $row['diesel_adv_amt'];
    $total_amt2 += $total_amt1;
    $sn++;
}

$balamt = $total_bal - $total_amt2;

echo "<tr>
    <td colspan='10'><strong>Total</strong></td>
    <td><strong>$total_bal</strong></td>
    <td></td>
    <td><strong>$total_amt2</strong></td>
</tr>";

echo "<tr>
    <td colspan='10'><strong>Balance</strong></td>
    <td colspan='3'><strong>$balamt</strong></td>
</tr>";

echo "</table>";
?>
