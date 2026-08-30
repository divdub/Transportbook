<?php 
include('top_file.php');

if ($token == "GURU")
{

    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

    if ($tag == "Bill_no") {
    $sql = mysqli_query($con, "SELECT * FROM dieselbill");
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
       

        while ($row = mysqli_fetch_assoc($sql)) {
          array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }

       
    } else {
        $success = false;
        $msg = "Record Not Found";
      
    }
}

if ($tag == "pump") {
    // echo "SELECT * FROM m_vehicle"; die;
    $sql = mysqli_query($con, "SELECT * FROM m_petrol_pump");
    
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
          array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }
    } else {
        $success = false;
        $msg = "Record Not Found";
    }
}
    
  
if ($tag == "diesel_bill") {
        if (isset($_REQUEST['fromdate'])) $fromdate = $_REQUEST['fromdate'];
        if (isset($_REQUEST['todate'])) $todate = $_REQUEST['todate'];
        if (isset($_REQUEST['bill_id'])) $bill_id = $_REQUEST['bill_id'];
         if (isset($_REQUEST['pump_id'])) $pump_id = $_REQUEST['pump_id'];
        if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
        if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];
        //   $user_id ='7';
        $total =0;
        $crit ='';
        if ($fromdate != '' && $todate != '') {
        $fromdate1 = date('Y-m-d', strtotime($fromdate));
        $todate1 = date('Y-m-d', strtotime($todate));
       
        $crit .= " AND dbilldate BETWEEN '$fromdate1' AND '$todate1'";
        }
        if ($bill_id != '') {
                $crit .= " AND bill_id = '$bill_id'";
            }
         
        if($user_type=='4'){
        if ($pump_id != '') {
                $crit .= " AND pump_id = '$pump_id'";
            }
         }
            // echo "SELECT * FROM dieselbill where 1=1 $crit and pump_id='$user_id'"; die;
 if($user_type=='4'){
     $sql = mysqli_query($con, "SELECT * FROM dieselbill where 1=1 $crit");
 }
 else{
    $sql = mysqli_query($con, "SELECT * FROM dieselbill where 1=1 $crit and pump_id='$user_id'");
 }
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $adv_diesel = getvalfield($con,"dispatch_entry","sum(diesel_adv_amt)","dbillid='$row[dbillid]'");
            $billdate = date('d-m-Y', strtotime($row['dbilldate']));
            $pump_id = $row['pump_id'];
            $pump_name = getvalfield($con, "m_petrol_pump", "pump_name", "pump_id='$pump_id'");
            $total = $total + $adv_diesel;
            // echo $pump_name; die;
             $row['pump_name'] = $pump_name;
            $row['billdate'] = $billdate;
            
            $row['amt'] = $adv_diesel;
             array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }
        $row1['total_amt'] = $total;
        array_push($data1,$row1);
    } else {
        $success = false;
        $msg = "Record Not Found";
      
    }
} 

if ($tag == "diesel_bill_details") {
        
         if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
        if (isset($_REQUEST['dbillid'])) $dbillid = $_REQUEST['dbillid'];
        if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];
         // $user_id ='7';
        
 if($user_type =='4'){
    $sql = mysqli_query($con, "SELECT * FROM dispatch_entry where dbillid='$dbillid'");
 }
 else{
    $sql = mysqli_query($con, "SELECT * FROM dispatch_entry where  pump_id='$user_id' and dbillid='$dbillid'"); 
 }
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
           $grdate = date('d-m-Y', strtotime($row['gr_date']));
           $pump_name = getvalfield($con, "m_petrol_pump", "pump_name", "pump_id='$row[pump_id]'");
           $vehicle_no = getvalfield($con, "m_vehicle", "vehicle_no", "vehicle_id='$row[vehicle_id]'");
          $consignee_name = getvalfield($con,"m_consignee","consignee_name","consignee_id='$row[consignee_id]'");
          $desc = getvalfield($con,"m_place","place_name","place_id='$row[destination_id]'");
          
           $row['vehicle'] = $vehicle_no;
           $row['grdate'] = $grdate;
           $row['pump_name'] = $pump_name;
           $row['desc'] = $desc;
          $row['consignee'] =$consignee_name;
             array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }
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