<?php 
include('top_file.php');

if ($token == "GURU")
{

 if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

if ($tag == "adv_report") {
        if (isset($_REQUEST['fromdate'])) $fromdate = $_REQUEST['fromdate'];
        if (isset($_REQUEST['todate'])) $todate = $_REQUEST['todate'];
        if (isset($_REQUEST['truck_id'])) $truck_id = $_REQUEST['truck_id'];
        if (isset($_REQUEST['consignee_id'])) $consignee_id = $_REQUEST['consignee_id'];
        if (isset($_REQUEST['demand_no'])) $demand_no = $_REQUEST['demand_no'];
        if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
        if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];
        if (isset($_REQUEST['paytype'])) $paytype = $_REQUEST['paytype'];
        //  $user_id = '7';
        $total_famt = 0;
        $total_wt = 0;
        $crit ='';
        
        if ($fromdate != '' && $todate != '') {
        $fromdate1 = date('Y-m-d', strtotime($fromdate));
        $todate1 = date('Y-m-d', strtotime($todate));
       
        $crit .= " AND bilty_date BETWEEN '$fromdate1' AND '$todate1'";
        }
        
         
        if ($truck_id != '') {
                $crit .= " AND vehicle_id = '$truck_id'";
            }
            
            
            if ($consignee_id != '') {
                $crit .= " AND consignee_id = '$consignee_id'";
            }
            
            if ($demand_no != '') {
                $crit .= " AND demand_no = '$demand_no'";
            }
            if ($paytype != '') {
                $crit .= " AND pay_type = '$paytype'";
            }
            
            //   echo "SELECT * FROM dispatch_entry where 1=1 $crit "; die;
            if($user_type =='1'){
                // echo "SELECT * FROM dispatch_entry where 1=1 $crit and owner_id='$user_id'"; die;
          $sql = mysqli_query($con, "SELECT * FROM dispatch_entry where 1=1 $crit and owner_id='$user_id' and is_advance=1");
            }
            
            if($user_type =='2'){
                // echo "SELECT * FROM dispatch_entry where 1=1 $crit and driver_id='$user_id'"; die;
         $sql = mysqli_query($con, "SELECT * FROM dispatch_entry where 1=1 $crit and driver_id='$user_id' and is_advance=1");
            }
            if($user_type =='3'){
                // echo "SELECT * FROM dispatch_entry where 1=1 $crit and pump_id='$user_id'"; die;
        $sql = mysqli_query($con, "SELECT * FROM dispatch_entry where 1=1 $crit and pump_id='$user_id' and is_advance=1");
            }
            if($user_type =='4'){
                // echo "SELECT * FROM dispatch_entry where 1=1 $crit and pump_id='$user_id'"; die;
        $sql = mysqli_query($con, "SELECT * FROM dispatch_entry where 1=1 $crit and is_advance=1");
            }
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
      

        while ($row = mysqli_fetch_assoc($sql)) {
            $consignee_id = $row['consignee_id'];
            $consignor_id = $row['consignor_id'];
            $brand_id = $row['brand_id'];
            $item_id = $row['item_id'];
            $vehicle_id = $row['vehicle_id'];
             $pump_id = $row['pump_id'];
            $destination_id = $row['destination_id'];
            $owner_id = $row['owner_id'];
            
            $consignee_name = getvalfield($con, "m_consignee", "consignee_name", "consignee_id='$consignee_id'");
             $consignor_name = getvalfield($con, "m_consignor", "consignor_name", "consignor_id='$consignor_id'");
             $vehicle_no = getvalfield($con, "m_vehicle", "vehicle_no", "vehicle_id='$vehicle_id'");
             $destination = getvalfield($con, "m_place", "place_name", "place_id='$destination_id'");
             $ownername = getvalfield($con, "m_vehicle_owner", "owner_name", "owner_id='$owner_id'");
             $item_name = getvalfield($con, "m_item", "item_name", "item_id='$item_id'");
             $brand_name = getvalfield($con, "m_brand", "brand_name", "brand_id='$brand_id'");
             $pump_name = getvalfield($con, "m_petrol_pump", "pump_name", "pump_id='$pump_id'");
             $bilty_date = date('d-m-Y', strtotime($row['bilty_date']));
             $famt=  $row['wt_mt'] * $row['own_rate'];
             $total_famt = $total_famt + $famt;
             $total_wt = $total_wt + $row['wt_mt'];
            // echo $consignee_name; die;
            $row['consignee_name'] = $consignee_name;
            $row['consignor_name'] = $consignor_name;
            $row['vehicle_no'] = $vehicle_no;
            $row['destination'] = $destination;
            $row['item_name'] = $item_name;
            $row['brand_name'] = $brand_name;
            $row['bilty_date'] = $bilty_date;
            $row['pump_name'] = $pump_name;
            $row['ownername'] = $ownername;
            $row['famt'] = $famt;
             array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }
         $row1['total_famt'] = $total_famt;
         $row1['total_wt'] = $total_wt;
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