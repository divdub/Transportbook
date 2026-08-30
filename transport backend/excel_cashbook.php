<?php
include("adminsession.php");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=cash_book.xls");

$fromdate = $_GET['fromdate'] ?? date('Y-m-d');
$todate = $_GET['todate'] ?? date('Y-m-d');

$cond = $cond1 = $cond2 = "";

if ($fromdate != '' && $todate != '') {
    $cond = "WHERE othr_inc_entry.inc_date BETWEEN '$fromdate' AND '$todate'";
    $cond1 = "WHERE other_expense_entry.exp_date BETWEEN '$fromdate' AND '$todate'";
    $cond2 = "WHERE dispatch_entry.cash_adv_date BETWEEN '$fromdate' AND '$todate'";
    $cond3="WHERE saleentry.saledate BETWEEN '$fromdate' AND '$todate'";
}

$prevbalance = $cmn->getcashopeningplant($connection, $fromdate, $comp_id, $consignorid, $session_id);

// Start HTML output
echo "<table border='1'>";
echo "<tr><th colspan='10' style='text-align:center;'>Cash Book Report</th></tr>";
echo "<tr><th colspan='10' style='text-align:center;'>From: $fromdate To: $todate</th></tr>";
echo "<tr><td colspan='10'><strong>Opening Balance:</strong> $prevbalance</td></tr>";

echo "<tr>
    <th>S.No</th>
    <th>Date</th>
    <th>Particular</th>
    <th>Description</th>
    <th>Remark</th>
    <th>Cash Advance</th>
    <th>Income</th>
    <th>Expense</th>
    <th>Sale Income</th>
    <th>Balance</th>
</tr>";
  $sn=1;
//                       echo		"SELECT cash_adv, cash_adv_date , vehicle_id,type,remark
// FROM dispatch_entry $cond2 and session_id='$session_id'  && consignor_id=$consignorid and (cash_adv !=0)
// UNION
// SELECT amount, inc_date, otherid,type,narration
// FROM othr_inc_entry $cond and session_id='$session_id'  && consignorid=$consignorid
// UNION
// SELECT amount, exp_date, otherid,type,narration
// FROM other_expense_entry $cond1 and session_id='$session_id' && consignorid=$consignorid ORDER BY cash_adv_date;";
                    $sql = mysqli_query($connection,"SELECT di_no,cash_adv, cash_adv_date , vehicle_id,type,remark
FROM dispatch_entry $cond2 and session_id='$session_id'  && consignor_id=$consignorid and (cash_adv !=0)
UNION ALL
SELECT payment_mode,amount, inc_date, otherid,type,narration
FROM othr_inc_entry $cond and session_id='$session_id' && amount!=0  && consignorid=$consignorid
UNION ALL
SELECT payment_mode,amount, saledate, vehicle_id,for_ledger,remark
FROM saleentry $cond3 and session_id='$session_id' && amount!=0 && payment_mode='Cash'  && consignorid=$consignorid
UNION ALL
SELECT payment_mode,amount, exp_date, otherid,type,narration
FROM other_expense_entry $cond1 and session_id='$session_id' && amount!=0 && consignorid=$consignorid ORDER BY cash_adv_date;");

                           while($row= mysqli_fetch_array($sql)) {

	$head_id=$row['vehicle_id'];
	$type=$row['type'];
	$incamount=0;
	$expense_amount=0;
	$saleincome=0;
	$cash_adv=0;
	if($totbalamt==''){
	    $totbalamt=$prevbalance;
	}
	
if($type=='INCOME'){
    $particular=$type;
    	$headname = $cmn->getvalfield($connection,"otherexp_master","head_name","otherid='$head_id'");
    $incamount=$row['cash_adv'];
    $balamt = $totbalamt + $incamount;
} elseif($type=='EXPENSE'){
     $particular=$type;
    	$headname = $cmn->getvalfield($connection,"otherexp_master","head_name","otherid='$head_id'");
    	 $expense_amount=$row['cash_adv'];
    	$balamt= $totbalamt - $expense_amount;
} 
elseif($type=='Sale'){
     $particular=$type;
    	$headname = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$head_id");
    	 $saleincome=$row['cash_adv'];
    	$balamt= $totbalamt + $saleincome;
}
else {
     $particular=' Advance';
    $headname = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$head_id'");
    $cash_adv=$row['cash_adv'];
    $balamt= $totbalamt - $cash_adv;
}


    echo "<tr>
        <td>{$sn}</td>
        <td>" . date('d-m-Y', strtotime($row['cash_adv_date'])) . "</td>
        <td>{$particular}</td>
        <td>{$headname}</td>
        <td>{$row['remark']}</td>
        <td align='right'>{$cash_adv}</td>
        <td align='right'>{$incamount}</td>
        <td align='right'>{$expense_amount}</td>
         <td align='right'>{$saleincome}</td>
        <td align='right'>{$balamt}</td>
    </tr>";

    $sn++;
       $total_sale+=$saleincome; 
                                                                          
                                                                                 $total_final+=$cash_adv;
                                                                                 $total_incamount+= $incamount;
                                                                                 $total_expense_amount+=$expense_amount;
                                                                                //   $balamt=$total_bal-$total_amt2;
                                                                                //  $totbalamt +=  $balamt + $total_incamount - $total_final -$total_expense_amount;
                                                                    $totbalamt = $prevbalance + $total_incamount - $total_final -$total_expense_amount + $total_sale;                                                                                                    
                                       
}

echo "<tr style='font-weight:bold; background-color:#f0f0f0;'>
    <td colspan='5' align='right'>Total</td>
    <td align='right'>{$total_final}</td>
    <td align='right'>{$total_incamount}</td>
    <td align='right'>{$total_expense_amount}</td>
      <td align='right'>{$total_sale}</td>
    <td align='right'>{$totbalamt}</td>
</tr>";

echo "</table>";
?>
