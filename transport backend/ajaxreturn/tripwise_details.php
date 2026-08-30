<?php 
   include("../adminsession.php");
     $trip_id = $_REQUEST['trip_id']; 

    $sql = mysqli_query($connection, "select * from trip_entry where trip_id=$trip_id ");

  	  $row = mysqli_fetch_array($sql);
  	 
      $truck_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id ='$row[vehicle_id]'");


  
     $frieght_amt =$row['frieght_amt'];
      $net_amount =$row['net_amount'];
     $loding_date =dateformatusa($row['loding_date']);
     $cash_advance=$row['cash_advance'];
     $diesel_advance=$row['diesel_advance'];
      $consignor_adv=$row['consignor_adv'];
     $tadv=$cash_advance + $diesel_advance + $consignor_adv ;
echo	$loding_date ."|".$truck_no."|".$frieght_amt."|".$tadv."|".$net_amount;
 // $bilty_no;
   ?>