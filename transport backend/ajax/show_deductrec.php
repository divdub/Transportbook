<?php
include("../adminsession.php");

$dispatch_id = $_POST['dispatch_id'] ?? '';

if($dispatch_id == ""){
    echo json_encode([
        "html"=>"<p class='text-danger'>Dispatch ID missing</p>",
        "total"=>0
    ]);
    exit;
}

// ✅ Safe query (Type casting security)
$dispatch_id = intval($dispatch_id);

$sql = mysqli_query($connection,
"SELECT d.*, m.deduct_name
FROM dispatch_deduction d
LEFT JOIN m_deduct m ON d.deduction_id = m.deduct_id
WHERE d.dispatch_id=$dispatch_id
ORDER BY d.id DESC");

$total = 0;
$html = "";

$html .= "<table class='table table-bordered'>";
$html .= "<tr>
<th>Deduction</th>
<th>Type</th>
<th>Amount</th>
<th>Date</th>
<th>Remark</th>
<th>Action</th>
</tr>";

while($row = mysqli_fetch_assoc($sql)){

    $amount = floatval($row['amount']);

    if(strtolower($row['type']) == "add"){
        $total += $amount;
    }
    elseif(strtolower($row['type']) == "subtract"){
        $total -= $amount;
    }

    $html .= "<tr>
    <td>".$row['deduct_name']."</td>
    <td>".$row['type']."</td>
    <td>".$row['amount']."</td>
    <td>".date('d-m-y',strtotime($row['date']))."</td>
    <td>".$row['remark']."</td>
    <td>
    <button class='btn btn-danger btn-sm'
    onclick='deleteDeduct(".$row['id'].",".$row['dispatch_id'].")'>
    Delete
    </button>
    </td>
    </tr>";
}

$html .= "<tr style='font-weight:bold;background:#f2f2f2'>
<td colspan='2' align='right'>Total</td>
<td colspan='4'>".number_format($total,2)."</td>
</tr>";

$html .= "</table>";

echo json_encode([
    "html"=>$html,
    "total"=>$total
]);
?>