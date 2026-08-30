<?php 
include('top_file.php');

if ($token == "GURU")
{

    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

   if ($tag == "vehicleowner") {
    $user_id = $_REQUEST['user_id'] ?? '';
    $user_type = $_REQUEST['user_type'] ?? '';

    if ($user_type == '2') {
        $dispatch_sql = mysqli_query($con, "SELECT * FROM dispatch_entry WHERE driver_id='$user_id'");
    }

    if ($user_type == '3') {
        $dispatch_sql = mysqli_query($con, "SELECT * FROM dispatch_entry WHERE pump_id='$user_id'");
    }

    if ($user_type == '4') {
        $dispatch_sql = mysqli_query($con, "SELECT * FROM dispatch_entry");
    }

    $count = mysqli_num_rows($dispatch_sql);

    if ($count > 0) {
        $seen_owners = []; // to track unique owners

        while ($row = mysqli_fetch_assoc($dispatch_sql)) {
            $owner_id = $row['owner_id'];

            if (!in_array($owner_id, $seen_owners)) {
                $owner_name = getvalfield($con, "m_vehicle_owner", "owner_name", "owner_id='$owner_id'");
                $row['owner_name'] = $owner_name;

                array_push($data, $row);

                $seen_owners[] = $owner_id; // mark as seen
                $success = true;
                $msg = "Record Found";
            }
        }
    } else {
        $success = false;
        $msg = "Record Not Found";
    }
}


        if ($tag == "driver") {
            $data1 = mysqli_query($con, "SELECT * FROM m_driver");
            $count = mysqli_num_rows($data1);
        
            if ($count > 0) {
               
        
                while ($row = mysqli_fetch_assoc($data1)) {
                  array_push($data, $row);
                     $success = true;
                   $msg = "Record Found";
                }
        
               
            } else {
                $success = false;
                $msg = "Record Not Found";
              
            }
        }

if ($tag == "fuel_demand") {

    $fromdate = $_REQUEST['fromdate'] ?? '';
    $todate = $_REQUEST['todate'] ?? '';
    $truck_id = $_REQUEST['truck_id'] ?? '';
    $user_id = $_REQUEST['user_id'] ?? '';
    $owner_id = $_REQUEST['owner_id'] ?? '';
    $user_type = $_REQUEST['user_type'] ?? '';
    $driver_id = $_REQUEST['driver_id'] ?? '';
    $pump_id = $_REQUEST['pump_id'] ?? '';
    $demand_no = $_REQUEST['demand_no'] ?? '';
    $total_adv=0;
    $crit = '';
//   $owner_id = getvalfield($con, "dispatch_entry", "owner_id", "owner_id='$owner_id1'");

    if ($fromdate != '' && $todate != '') {
        $fromdate1 = date('Y-m-d', strtotime($fromdate));
        $todate1 = date('Y-m-d', strtotime($todate));
        $crit .= " AND bilty_date BETWEEN '$fromdate1' AND '$todate1'";
    }

    if ($truck_id != '') {
        $crit .= " AND vehicle_id = '$truck_id'";
    }

    if ($owner_id != '') {
        $crit .= " AND owner_id = '$owner_id'";
    }
    if($user_type =='4'){
    if ($driver_id != '') {
        $crit .= " AND driver_id = '$driver_id'";
    }

    if ($pump_id != '') {
        $crit .= " AND pump_id = '$pump_id'";
    }
    }
    if ($demand_no != '') {
        $crit .= " AND demand_no = '$demand_no'";
    }
    if ($user_type == '3') {
        // echo "SELECT * FROM dispatch_entry WHERE 1=1 $crit AND pump_id='$user_id"; die;
        $query = mysqli_query($con,"SELECT * FROM dispatch_entry WHERE 1=1 $crit AND pump_id='$user_id'");
       
    }
    else{
       $query = mysqli_query($con,"SELECT * FROM dispatch_entry WHERE 1=1 $crit "); 
    }
        $count = mysqli_num_rows($query);
        // $data = []; // ✅ Reset data array

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $vehicle_id = $row['vehicle_id'];
                $vehicle_no = getvalfield($con, "m_vehicle", "vehicle_no", "vehicle_id='$vehicle_id'");
                $driver = getvalfield($con, "m_driver", "driver_name", "driver_id='$row[driver_id]'");
                $owner = getvalfield($con, "m_vehicle_owner", "owner_name", "owner_id='$row[owner_id]'");
                $bilty_date = date('d-m-Y', strtotime($row['bilty_date']));
                $famt = $row['wt_mt'] * $row['own_rate'];
                $total_adv = $total_adv + $row['diesel_adv_amt'];
                $row['owner'] = $owner;
                $row['driver'] = $driver;
                $row['vehicle_no'] = $vehicle_no;
                $row['bilty_date'] = $bilty_date;
                 array_push($data,$row);
                 $success = true;
                $msg = "Record Found";
            }
            // echo $total_adv;
             $row1['total_adv'] = $total_adv;
             array_push($data1,$row1);
            
        } else {
            $success = false;
            $msg = "Record Not Found";
        }
    }

    
}



else{
    $success = false;
            $msg = "Incorrect Location";
}
include('footer.php');
?>