<?php 
include('top_file.php');

if ($token == "GURU")
{

    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

    if ($tag == "diesel_pay") {
            if (isset($_REQUEST['fromdate'])) $fromdate = $_REQUEST['fromdate'];
            if (isset($_REQUEST['todate'])) $todate = $_REQUEST['todate'];
            if (isset($_REQUEST['bill_id'])) $bill_id = $_REQUEST['bill_id'];
            if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
            if (isset($_REQUEST['pump_id'])) $pump_id = $_REQUEST['pump_id'];
              if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];
        //  $user_id='7';
            $total_amt =0;
            $crit ='';
            if ($fromdate != '' && $todate != '') {
            $fromdate1 = date('Y-m-d', strtotime($fromdate));
            $todate1 = date('Y-m-d', strtotime($todate));
           
            $crit .= " AND rcv_date BETWEEN '$fromdate1' AND '$todate1'";
            }
            if ($bill_id != '') {
                    $crit .= " AND dbillid = '$bill_id'";
                }
             
             if($user_type=='4'){
            if ($pump_id != '') {
                    $crit .= " AND pump_id = '$pump_id'";
                }
             }
 
  if($user_type=='4'){
      $sql = mysqli_query($con, "SELECT * FROM diesel_pay where 1=1 $crit");
  }
  else{
      $sql = mysqli_query($con, "SELECT * FROM diesel_pay where 1=1 $crit  and pump_id='$user_id'");
  }
        
        $count = mysqli_num_rows($sql);
    
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $billid = $row['dbillid'];
                $pump_id = $row['pump_id'];
                $bill_no = getvalfield($con,"dieselbill","dbillno","dbillid='$billid'");
                $paiddate = date('d-m-Y', strtotime($row['rcv_date']));
                $pump_name = getvalfield($con, "m_petrol_pump", "pump_name", "pump_id='$pump_id'");
                $total_amt = $total_amt + $row['rcv_amt'];
                 $row['billno'] = $bill_no;
                 $row['pump_name'] = $pump_name;
                $row['billdate'] = $paiddate;
                 
                 array_push($data, $row);
                 $success = true;
               $msg = "Record Found";
            }
            $row1['total_amt'] = $total_amt;
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