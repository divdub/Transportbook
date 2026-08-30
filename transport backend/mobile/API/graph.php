<?php 
include('top_file.php');

    if ($token == "GURU")
   {
    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

     if ($tag == "pump_graph_report") {
    //   if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
       $user_id=7;
    if (!empty($user_id)) {
        // Grouped diesel_adv_amt month-wise
        $data = [];
        
        $query = "
            SELECT 
                DATE_FORMAT(bilty_date, '%Y-%m') AS month, 
                SUM(diesel_adv_amt) AS total_amt 
            FROM dispatch_entry 
            WHERE pump_id = '$user_id' 
            GROUP BY month 
            ORDER BY month ASC
        ";

        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($data,$row);
            }
            $success = true;
            $msg = "Graph data fetched";
        } else {
            $success = false;
            $msg = "No data found";
        }
    } else {
        $success = false;
        $msg = "Please Select Pump";
    }
}

if ($tag == "pump_pay_graph_report") {
    //   if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
      $user_id=7;
    if (!empty($user_id)) {
        // Grouped diesel_adv_amt month-wise
        $data = [];
        
        $query = "
            SELECT 
                DATE_FORMAT(rcv_date, '%Y-%m') AS month, 
                SUM(rcv_amt) AS total_amt 
            FROM diesel_pay 
            WHERE pump_id = '$user_id' 
            GROUP BY month 
            ORDER BY month ASC
        ";

        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($data,$row);
            }
            $success = true;
            $msg = "Graph data fetched";
        } else {
            $success = false;
            $msg = "No data found";
        }
    } else {
        $success = false;
        $msg = "Please Select Pump";
    }
}


}
   else{
    $success = false;
            $msg = "Incorrect Location";
}
include('footer.php');
?>