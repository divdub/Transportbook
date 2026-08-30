<?php 
include('top_file.php');

if ($token == "GURU")
{

    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

    if ($tag == "category") {
    $sql = mysqli_query($con, "SELECT * FROM tpcategory");
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

if ($tag == "voucher") {
    if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
    if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];

   if ($user_type == '4') {
    $sql = mysqli_query($con, "SELECT DISTINCT TRIM(LOWER(voucher_name)) AS voucher_name FROM payment_receive");
} else {
    $sql = mysqli_query($con, "SELECT DISTINCT TRIM(LOWER(voucher_name)) AS voucher_name FROM payment_receive WHERE catname='$user_id'");
}

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

    
  
  
  
  


if ($tag == "payment_report") {
        if (isset($_REQUEST['fromdate'])) $fromdate = $_REQUEST['fromdate'];
        if (isset($_REQUEST['todate'])) $todate = $_REQUEST['todate'];
        if (isset($_REQUEST['category_id'])) $category_id = $_REQUEST['category_id'];
        if (isset($_REQUEST['voucher_id'])) $voucher_id = $_REQUEST['voucher_id'];
          if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
          if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];
           if (isset($_REQUEST['comp_id'])) $comp_id = $_REQUEST['comp_id'];
            if (isset($_REQUEST['sessionid'])) $sessionid = $_REQUEST['sessionid'];
        //  $user_id='7';
        // $sessionid = '3';
        // $vouchername = getvalfield($con,"tpcategory","tp_name","tpcat_id='$row[category]'");
        $total_amt = 0;
        $crit ='';
        if ($fromdate != '' && $todate != '') {
        $fromdate1 = date('Y-m-d', strtotime($fromdate));
        $todate1 = date('Y-m-d', strtotime($todate));
       
        $crit .= " AND receive_date BETWEEN '$fromdate1' AND '$todate1'";
        }
        if ($category_id != '') {
                $crit .= "AND category = '$category_id'";
            }
         
        if ($voucher_id != '') {
                $crit .= " AND voucher_name = '$voucher_id'";
            }
            
 if($user_type =='4'){
     
   $sql = mysqli_query($con, "SELECT * FROM payment_receive where 1=1 $crit");  
 }
else{
    // echo "SELECT * FROM payment_receive where 1=1 $crit   and catname='$user_id'";die;
    $sql = mysqli_query($con, "SELECT * FROM payment_receive where 1=1 $crit   and catname='$user_id'");
    
}
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
      

        while ($row = mysqli_fetch_assoc($sql)) {
            // echo "payment","payee_name","voucher_id='$row[voucher_no]' && consignorid='$row[consignorid]' && session_id= '$sessionid'"; die;
            $paid_to= getvalfield($con,"payment","payee_name","voucher_id='$row[voucher_no]' && consignorid='$row[consignorid]' && session_id= '$sessionid'");
            $category= getvalfield($con,"tpcategory","tp_name","tpcat_id='$row[category]'");
            $paid_date = date('d-m-Y', strtotime($row['receive_date']));
            $total_amt = $total_amt + $row['receive_amt'];
            $row['paid_to'] = $paid_to;
            $row['categoryid'] = $category;
             $row['paid_date'] = $paid_date;
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