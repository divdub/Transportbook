<?php 
include('top_file.php');

if ($token == "GURU")
{
if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

if ($tag == "fuel_report") {
        if (isset($_REQUEST['fromdate'])) $fromdate = $_REQUEST['fromdate'];
        if (isset($_REQUEST['todate'])) $todate = $_REQUEST['todate'];
        if (isset($_REQUEST['vehicle_id'])) $vehicle_id = $_REQUEST['vehicle_id'];
        if (isset($_REQUEST['pump_id'])) $pump_id = $_REQUEST['pump_id'];
          if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
        if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];
        //   $user_id ='1';
        $crit ='';
        if ($fromdate != '' && $todate != '') {
        $fromdate1 = date('Y-m-d', strtotime($fromdate));
        $todate1 = date('Y-m-d', strtotime($todate));
       
        $crit .= " AND bilty_date BETWEEN '$fromdate1' AND '$todate1'";
        }
        
        if ($vehicle_id != '') {
            $crit .= " AND vehicle_id = '$vehicle_id'";
        }
         if ($pump_id != '') {
            $crit .= " AND pump_id = '$pump_id'";
        }
      
            
//  if (!empty($pump_id)) {
//     // pump_id is NOT empty

    $data1 = mysqli_query($con, "SELECT * FROM dispatch_entry where 1=1 $crit  and owner_id='$user_id'");
    $count = mysqli_num_rows($data1);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($data1)) {
           
            $billdate = date('d-m-Y', strtotime($row['bilty_date']));
            $pump_id1 = $row['pump_id'];
            $vehicle_id = $row['vehicle_id'];
            $pump_name = getvalfield($con, "m_petrol_pump", "pump_name", "pump_id='$pump_id1'");
            $vehicle_no = getvalfield($con, "m_vehicle", "vehicle_no", "vehicle_id='$vehicle_id'");
            // echo $pump_name; die;
             $row['pump_name'] = $pump_name;
             $row['billdate'] = $billdate;
             $row['vehicle_no'] = $vehicle_no;
             array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }
    } else {
        $success = false;
        $msg = "Record Not Found";
      
    }
 }
 else{
    $success = false;
        $msg = "Please Select Pump"; 
 }
}

// }
else{
    $success = false;
            $msg = "Incorrect Location";
}
include('footer.php');
?>