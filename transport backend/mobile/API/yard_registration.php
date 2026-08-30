<?php 
include('top_file.php');

if ($token == "GURU") {
    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

    if ($tag == "yard_registration") {
        if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
        if (isset($_REQUEST['truck_id'])) $truck_id = $_REQUEST['truck_id'];
        if (isset($_REQUEST['date'])) $date1 = $_REQUEST['date'];
        if (isset($_REQUEST['location'])) $location = $_REQUEST['location'];
        if (isset($_REQUEST['remark'])) $remark = $_REQUEST['remark'];
         $fromdate = date('Y-m-d', strtotime($date1));
         $cur_date = date('Y-m-d');
        
            $query = mysqli_query($con, "Insert into  yard_registration SET  res_date ='$fromdate',driver_id='$user_id',vehicle_no='$truck_id',location='$location',remark='$remark', createdate = '$cur_date'");
            if ($query && mysqli_affected_rows($con) > 0) {
                $success = true;
                $msg = "Registration  Successfully";
            } else {
                $success = false;
                $msg = " Registration Failed";
            }
   
    }
    
    
     
     if ($tag == "yard_report") {
    
    $data = [];

    // Get request values
    $fromdate1 = $_REQUEST['fromdate'] ?? '';
    $todate1 = $_REQUEST['todate'] ?? '';
    $truck_id = $_REQUEST['truck_id'] ?? '';
    $driver_id = $_REQUEST['driver_id'] ?? '';
    $user_id = $_REQUEST['user_id'] ?? '';
    $user_type = $_REQUEST['user_type'] ?? '';

    $crit = "";

    // Date filter
    if (!empty($fromdate1) && !empty($todate1)) {
        $fromdate = date('Y-m-d', strtotime($fromdate1));
        $todate = date('Y-m-d', strtotime($todate1));
        $crit .= " AND res_date BETWEEN '$fromdate' AND '$todate'";
    }

    // Truck (vehicle_no) filter for user_type 4
    if ($user_type == '4' && !empty($truck_id)) {
        $vehicle_no = getvalfield($con, "m_vehicle", "vehicle_no", "vehicle_id='$truck_id'");
        $crit .= " AND vehicle_no = '$vehicle_no'";
    }

    // Driver filter
    if (!empty($driver_id)) {
        $crit .= " AND driver_id = '$driver_id'";
    }

    // For vehicle owners (user_type = 1)
    if ($user_type == '1') {
        $success = false;
        $msg = "Record not found";
        $processedVehicles = [];

        $dis_query = mysqli_query($con, "SELECT * FROM dispatch_entry WHERE owner_id='$user_id'");
        while ($row = mysqli_fetch_assoc($dis_query)) {
            $vehicle_no = getvalfield($con, "m_vehicle", "vehicle_no", "vehicle_id='{$row['vehicle_id']}'");

            // Skip duplicates
            if (in_array($vehicle_no, $processedVehicles)) continue;

            $yard_query = mysqli_query($con, "SELECT * FROM yard_registration WHERE 1=1 $crit AND vehicle_no='$vehicle_no' and is_asign='0' limit 1");
            if (mysqli_num_rows($yard_query) > 0) {
                $row2 = mysqli_fetch_assoc($yard_query);
                $res_date1 = date('d-m-Y',strtotime($row2['res_date']));
            $driver_name = getvalfield($con, "m_driver", "driver_name", "driver_id='{$row2['driver_id']}'");
            $driver_mobile = getvalfield($con, "m_driver", "mobile_no", "driver_id='{$row2['driver_id']}'");
            
            $row2['res_date']=$res_date1;
            $row2['driver_name']=$driver_name;
            $row2['driver_mobile']=$driver_mobile;
                array_push($data, $row2);
                $processedVehicles[] = $vehicle_no;
                $success = true;
                $msg = "Record Found";
            }
        }

    } else {
        // For other user types - fetch unique vehicle_no only
        $success = false;
        $msg = "Record not found";

        $yard_query = mysqli_query($con, "SELECT * FROM yard_registration WHERE 1=1 $crit and is_asign='0' GROUP BY vehicle_no");
        while ($row = mysqli_fetch_assoc($yard_query)) {
            $res_date1 = date('d-m-Y',strtotime($row['res_date']));
            $driver_name = getvalfield($con, "m_driver", "driver_name", "driver_id='{$row['driver_id']}'");
            $driver_mobile = getvalfield($con, "m_driver", "mobile_no", "driver_id='{$row['driver_id']}'");
            
            $row['res_date']=$res_date1;
            $row['driver_name']=$driver_name;
            $row['driver_mobile']=$driver_mobile;
            array_push($data, $row);
            $success = true;
            $msg = "Record Found";
        }
    }

    // Optionally send JSON response if required
    // echo json_encode(["success" => $success, "msg" => $msg, "data" => $data]);
}

        if ($tag == "yard_assign") {
                if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
                if (isset($_REQUEST['res_id'])) $res_id = $_REQUEST['res_id'];
                
                 
                
                    $query = mysqli_query($con, "Update   yard_registration SET  is_asign ='1' where registration_id='$res_id'");
                    if ($query && mysqli_affected_rows($con) > 0) {
                        $success = true;
                        $msg = "Assign  Successfully";
                    } else {
                        $success = false;
                        $msg = " Assign  Failed";
                    }
           
            }
    
}
else {
    $success = false;
    $msg = "Incorrect token";
}

include('footer.php');
?>
