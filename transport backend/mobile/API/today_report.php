<?php 
include('top_file.php');

    if ($token == "GURU")
   {
    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

     if ($tag == "today_report") {
      if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
      if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];
    //   $user_id=7;
    //   $user_type=4;
    $date = date('Y-m-d');
   $total_mt= 0;
   $count=0;
    
    if($user_type=='1'){
        // echo "SELECT  * FROM dispatch_entry WHERE pump_id = '$user_id' and bilty_date='$date'"; die;
        $query = mysqli_query($con,"SELECT  * FROM dispatch_entry WHERE owner_id = '$user_id' and bilty_date='$date'") ;
    }
    else if($user_type=='2'){
        // echo "SELECT  * FROM dispatch_entry WHERE pump_id = '$user_id' and bilty_date='$date'"; die;
        $query = mysqli_query($con,"SELECT  * FROM dispatch_entry WHERE driver_id = '$user_id' and bilty_date='$date'") ;
    }
    else if($user_type=='3'){
        // echo "SELECT  * FROM dispatch_entry WHERE pump_id = '$user_id' and bilty_date='$date'"; die;
        $query = mysqli_query($con,"SELECT  * FROM dispatch_entry WHERE pump_id = '$user_id' and bilty_date='$date'") ;
    }
    
    else if($user_type=='4'){
        // echo "SELECT  * FROM dispatch_entry WHERE pump_id = '$user_id' and bilty_date='$date'"; die;
        $query = mysqli_query($con,"SELECT  * FROM dispatch_entry WHERE  bilty_date='$date'") ;
    }
    
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $consignee_id = $row['consignee_id'];
            $consignor_id = $row['consignor_id'];
            $brand_id = $row['brand_id'];
            $item_id = $row['item_id'];
            $vehicle_id = $row['vehicle_id'];
            $destination_id = $row['destination_id'];
            
            $consignee_name = getvalfield($con, "m_consignee", "consignee_name", "consignee_id='$consignee_id'");
             $consignor_name = getvalfield($con, "m_consignor", "consignor_name", "consignor_id='$consignor_id'");
             $vehicle_no = getvalfield($con, "m_vehicle", "vehicle_no", "vehicle_id='$vehicle_id'");
             $destination = getvalfield($con, "m_place", "place_name", "place_id='$destination_id'");
             $item_name = getvalfield($con, "m_item", "item_name", "item_id='$item_id'");
             $brand_name = getvalfield($con, "m_brand", "brand_name", "brand_id='$brand_id'");
             $bilty_date = date('d-m-Y', strtotime($row['bilty_date']));
             $famt=  $row['wt_mt'] * $row['own_rate'];
             $adv = $row['diesel_adv_amt'] + $row['diesel_adv_amt'];
             $total_mt = $total_mt + $row['wt_mt'];
             $count= $count+1;
            // echo $consignee_name; die;
            $row['consignee_name'] = $consignee_name;
            $row['consignor_name'] = $consignor_name;
            $row['vehicle_no'] = $vehicle_no;
            $row['destination'] = $destination;
            $row['item_name'] = $item_name;
            $row['brand_name'] = $brand_name;
            $row['bilty_date'] = $bilty_date;
            $row['famt'] = $famt;
            $row['adv'] = $adv;
            // $row1['total_wt'] = $total_mt;
                array_push($data,$row);
                $success = true;
                $msg = "today data found";
            }
            
            $row1['total_wt'] = $total_mt;
            $row1['truck'] = $count;
            array_push($data1,$row1);
        } else {
            $success = false;
            $msg = "No data found";
        }
    } else {
        $success = false;
        $msg = "Please Select Pump";
    }
}



   else{
    $success = false;
            $msg = "Incorrect Location";
}
include('footer.php');
?>