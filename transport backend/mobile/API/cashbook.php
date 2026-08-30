<?php 
include('top_file.php');

if ($token == "GURU")
{

    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

   if ($tag == "opening") {
       
       $fromdate = $_REQUEST['fromdate'] ?? '';
       $todate = $_REQUEST['todate'] ?? '';
       $user_id = $_REQUEST['user_id'] ?? '';
       $session_id = $_REQUEST['session_id'] ?? '';
       $openbal =  getvalfield($con,"m_petrol_pump","opn_balnc","pump_id='$user_id'"); 
     
  
	 $diesel_open_bal_str = strtotime(getvalfield($con,"m_petrol_pump","opn_balnc_date","pump_id='$user_id'"));
	  
	 $opn_balnc_date = getvalfield($con,"m_petrol_pump","opn_balnc_date","pump_id='$user_id'");
	   
	 $currdate_str = strtotime($fromdate);
	 	if($currdate_str >= $diesel_open_bal_str)
	{	
	    
// 		$opn_balnc_date =  date('Y-m-d', strtotime($opn_balnc_date . ' +1 day'));
		$currdate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));

	    $opn_balnc_date =  date('Y-m-d', strtotime($opn_balnc_date . ' +1 day'));
		$tot=0;	
 
		$sql = mysqli_query($con,"select * from dieselbill where dbilldate between '$opn_balnc_date' and '$currdate' && pump_id='$user_id'  && sessionid=$session_id");
	
		while($row=mysqli_fetch_assoc($sql))
		{
		     
		      $adv_diesel = getvalfield($con,"dispatch_entry","sum(diesel_adv_amt)","dbillid='$row[dbillid]'"); 
		    
			$tot += $adv_diesel;
       // 		     ';
			
		}
		$tot_pay =0;
		
     // 	echo	"select * from diesel_pay  where rcv_date between '$opn_balnc_date' and '$fromdate' && pump_id='$pump_id' && consignorid=$consignorid && sessionid=$session_id";
		$sql2 = mysqli_query($con,"select * from diesel_pay  where rcv_date between '$opn_balnc_date' and '$currdate' && pump_id='$user_id'  && sessionid=$session_id");

		while($row2=mysqli_fetch_assoc($sql2))
		{
			$tot_pay += $row2['rcv_amt'];
		}
		
				// echo $tot_pay;
		$curr_openingbal = $openbal + $tot - $tot_pay ;
	}
	else
	{
		$curr_openingbal = $openbal;	
	}
	$row['curr_openingbal'] = $curr_openingbal;
	array_push($data1,$row);
	 $success = true;
                $msg = "Record Found";
	
   }

if ($tag == "cashbook_pay") {

    $fromdate = $_REQUEST['fromdate'] ?? '';
    $todate = $_REQUEST['todate'] ?? '';
    $truck_id = $_REQUEST['truck_id'] ?? '';
    $user_id = $_REQUEST['user_id'] ?? '';
    $owner_id = $_REQUEST['owner_id'] ?? '';
    $user_type = $_REQUEST['user_type'] ?? '';
    $total_paid=0;
    $crit = '';

    if ($fromdate != '' && $todate != '') {
        $fromdate1 = date('Y-m-d', strtotime($fromdate));
        $todate1 = date('Y-m-d', strtotime($todate));
        $crit .= " AND rcv_date BETWEEN '$fromdate1' AND '$todate1'";
    }
    $openbal =  getvalfield($con,"m_petrol_pump","opn_balnc","pump_id='$user_id'"); 
    // if ($truck_id != '') {
    //     $crit .= " AND vehicle_id = '$truck_id'";
    // }

    // if ($owner_id != '') {
    //     $crit .= " AND owner_id = '$owner_id'";
    // }

    if ($user_type == '3') {
        // echo "SELECT * FROM  diesel_pay  WHERE 1=1 $crit AND pump_id='$user_id'"; 
        $query = mysqli_query($con,"SELECT * FROM  diesel_pay  WHERE 1=1 $crit AND pump_id='$user_id'");
       
    }
    else{
      $query = mysqli_query($con,"SELECT * FROM  diesel_pay  WHERE 1=1 $crit");
    }
        $count = mysqli_num_rows($query);
       

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $openbal =  getvalfield($con,"m_petrol_pump","opn_balnc","pump_id='$user_id'");
                $total_paid = $total_paid + $row['rcv_amt'];
                $paid_date = date('d-m-Y', strtotime($row['rcv_date']));
                $row['paid_date'] = $paid_date;
                
                 array_push($data,$row);
                 $success = true;
                $msg = "Record Found";
            }
            // echo $total_adv;
             $row1['total_paid'] = $total_paid;
             $row1['opening'] = $openbal;
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