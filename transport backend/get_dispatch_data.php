<?php

include("adminsession.php");




$prev_session_id = $session_id - 1;

$prev_session = $cmn->getvalfield(
    $connection,
    "m_session",
    "session_name",
    "session_id = '$prev_session_id'"
);




$sql = mysqli_query($connection, "

    SELECT
        MONTH(bilty_date) AS month,
        COUNT(*) AS billty,
        SUM(wt_mt) AS total_qty

    FROM dispatch_entry

    WHERE session_id = '$session_id'
      AND comp_id = '$comp_id'
      AND consignor_id = '$consignorid'

    GROUP BY MONTH(bilty_date)

    ORDER BY MONTH(bilty_date)

");



$sql2 = mysqli_query($connection, "

    SELECT
        MONTH(bilty_date) AS month,
        COUNT(*) AS billty,
        SUM(wt_mt) AS total_qty

    FROM dispatch_entry

    WHERE session_id = '$prev_session_id'
      AND comp_id = '$comp_id'
      AND consignor_id = '$consignorid'

    GROUP BY MONTH(bilty_date)

    ORDER BY MONTH(bilty_date)

");



$current = [];
$previous = [];




while ($row = mysqli_fetch_assoc($sql)) {

    $monthNo = (int)$row['month'];

    $current[$monthNo] = [

        'month' => date(
            'M',
            mktime(0, 0, 0, $monthNo, 1)
        ),

        'billty' => (int)$row['billty'],

        'total_qty' => (float)$row['total_qty']
    ];
}




while ($row_get = mysqli_fetch_assoc($sql2)) {

    $monthNo = (int)$row_get['month'];

    $previous[$monthNo] = [

        'month' => date(
            'M',
            mktime(0, 0, 0, $monthNo, 1)
        ),

        'billty' => (int)$row_get['billty'],

        'total_qty' => (float)$row_get['total_qty']
    ];
}


$sessionMonths = [

    4,   // Apr
    5,   // May
    6,   // Jun
    7,   // Jul
    8,   // Aug
    9,   // Sep
    10,  // Oct
    11,  // Nov
    12,  // Dec
    1,   // Jan
    2,   // Feb
    3    // Mar

];



$chartData = [];

foreach ($sessionMonths as $month) {

    $chartData[] = [

        
        'month' => date(
            'M',
            mktime(0, 0, 0, $month, 1)
        ),


        
        'current_billty' =>
            isset($current[$month]['billty'])
                ? $current[$month]['billty']
                : 0,


        
        'current_qty' =>
            isset($current[$month]['total_qty'])
                ? $current[$month]['total_qty']
                : 0,


      
        'previous_billty' =>
            isset($previous[$month]['billty'])
                ? $previous[$month]['billty']
                : 0,


        // Previous Session Quantity
        'previous_qty' =>
            isset($previous[$month]['total_qty'])
                ? $previous[$month]['total_qty']
                : 0

    ];
}




echo json_encode([

    'success' => true,

    'current_session' => $session_name,

    'previous_session' => $prev_session,

    'data' => $chartData

]);

?>