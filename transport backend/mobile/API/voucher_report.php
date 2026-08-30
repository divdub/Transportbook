<?php 
include('top_file.php');

if ($token == "GURU")
{

    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

   

if ($tag == "payee") {
    if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
    if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];

   if ($user_type == '4') {
    $sql = mysqli_query($con, "SELECT DISTINCT TRIM(LOWER(payee_name)) AS payee_name FROM payment");
} else {
    $sql = mysqli_query($con, "SELECT DISTINCT TRIM(LOWER(payee_name)) AS payee_name FROM payment WHERE catname='$user_id'");
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

    
  
  
  
  


if ($tag == "voucher_report") {
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
        $consignorid= '1';
        $total_amt = 0;
        $crit ='';
        if ($fromdate != '' && $todate != '') {
        $fromdate1 = date('Y-m-d', strtotime($fromdate));
        $todate1 = date('Y-m-d', strtotime($todate));
       
        $crit .= " AND voucher_date BETWEEN '$fromdate1' AND '$todate1'";
        }
        if ($category_id != '') {
                $crit .= "AND category_id = '$category_id'";
            }
         
        if ($voucher_id != '') {
                $crit .= " AND payee_name = '$voucher_id'";
            }
            
 if($user_type =='4'){
     
   $sql = mysqli_query($con, "SELECT * FROM payment where 1=1 $crit && comp_id=$comp_id && session_id=$sessionid GROUP BY voucher_id");  
 }
else{
    // echo "SELECT * FROM payment where 1=1 $crit   and catname='$user_id'";die;
    $sql = mysqli_query($con, "SELECT * FROM payment where 1=1 $crit  and catname='$user_id' && comp_id=$comp_id && session_id=$sessionid GROUP BY voucher_id");
    
}
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
      

        while ($row = mysqli_fetch_assoc($sql)) {
           
            // echo "payment","payee_name","voucher_id='$row[voucher_no]' && consignorid='$row[consignorid]' && session_id= '$sessionid'"; die;
            $paid_to= getvalfield($con,"payment","payee_name","voucher_id='$row[voucher_no]' && session_id= '$sessionid'");
        
            $categoryname= getvalfield($con,"tpcategory","tp_name","tpcat_id='$row[category_id]'");
       
            $paid_date = date('d-m-Y', strtotime($row['voucher_date']));
                 
            $amt_paid_to= getvalfield($con,"payment","sum(amt_paid_to)","voucher_id='$row[voucher_id]'  && comp_id=$comp_id && session_id=$sessionid");
            
            
            $category=$row['category_id'];
if($category==1){
	$cname="Agent";
	
$agent_id= getvalfield($con,"dispatch_entry","agent_id","dispatch_id='$row[dispatch_id]'");
$vname= getvalfield($con,"m_agent","agent_name","agent_id='$agent_id'");
$catid=$agent_id;	
$mobile =  getvalfield($con,"m_agent","mobileno1","agent_id='$agent_id'");

} 
if($category==2){
	$cname="Consignee";
	
$consignee_id= getvalfield($con,"dispatch_entry","consignee_id","dispatch_id='$row[dispatch_id]'");
$vname= getvalfield($con,"m_consignee","consignee_name","consignee_id='$consignee_id'");
$mobile = getvalfield($con,"m_consignee","mobile_no","consignee_id='$consignee_id'");

$catid=$consignee_id;
} 
if($category==4) {
	$cname="Truck Owner";
	
$owner_id= getvalfield($con,"dispatch_entry","owner_id","dispatch_id='$row[dispatch_id]'");
$vname= getvalfield($con,"m_vehicle_owner","owner_name","owner_id='$owner_id'");
$mobile = getvalfield($con,"m_vehicle_owner","mobileno1","owner_id='$owner_id'");

$catid=$owner_id;
    
}
    
            $total_amt = $total_amt + $amt_paid_to;
            $row['paid_to'] = $paid_to;
            $row['voucher_name'] = $vname;
            $row['categoryid'] = $categoryname;
             $row['paid_date'] = $paid_date;
             $row['amount'] = $amt_paid_to;
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