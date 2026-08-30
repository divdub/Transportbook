<?php 
// error_reporting(0);
   include("../adminsession.php");
     $dispatch_id = $_REQUEST['dispatch_id']; 
     $tpcat_id=$_REQUEST['tpcat_id'];
// echo "select * from dispatch_entry where dispatch_id=$dispatch_id";


    $sql = mysqli_query($connection, "select * from dispatch_entry where dispatch_id=$dispatch_id");

      $row = mysqli_fetch_array($sql);
     
      $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id ='$row[vehicle_id]'");
      $destination = $cmn->getvalfield($connection, "m_place", "place_name", "place_id ='$row[destination_id]'");

$owner_name = $cmn->getvalfield($connection, "m_vehicle_owner", "owner_name", "owner_id =$row[owner_id]");
  $paid_to=$row['paid_to'];
    $bilty_no =$row['bilty_no'];
     $bilty_date =$row['bilty_date'];
     $wt_mt =$row['wt_mt'];
     $qty =$row['qty'];
    $comp_rate=$row['comp_rate'];
    $own_rate=$row['own_rate'];
    $rec_wt=$row['rec_wt'];
    $checkbox=$row['checkbox'];
    $agent_id=$row['agent_id'];
    $owner_id=$row['owner_id'];
    $consignee_id=$row['consignee_id'];
if($tpcat_id==1){

    if($paid_to=='Agent'){
        
        $rec_wt=$row['rec_wt'];
     $diesel_adv_amt=$row['diesel_adv_amt'];
     $cash_adv=$row['cash_adv'];
     $other_cash_adv=$row['other_cash_adv'];
$consignor_cash_adv=$row['consignor_cash_adv'];
$consignee_cash_adv=$row['consignee_cash_adv'];
$freight_amt=$cmn->getvalfield($connection, "tpa_entry", "amt", "category_id ='$agent_id'");
$freight_rate=$cmn->getvalfield($connection, "tpa_entry", "rate", "category_id ='$agent_id' && dispatch_id='$dispatch_id'");
$sort_wt=$wt_mt-$rec_wt;
  $commision=$comp_rate - $own_rate;
$sortamt=$sort_wt * $own_rate;

}
 if($paid_to!='Agent' && $paid_to=='Consignee' || $paid_to=='Truck Owner' && $checkbox==1){
  
     $diesel_adv_amt=0;
     $cash_adv=0;
     $other_cash_adv=0;
$consignor_cash_adv=0;
$consignee_cash_adv=0;
$sortamt=0;
 $commision=0;
$freight_amt=$cmn->getvalfield($connection, "tpa_entry", "amt", "category_id ='$agent_id' && dispatch_id='$dispatch_id'");
$freight_rate=$cmn->getvalfield($connection, "tpa_entry", "rate", "category_id ='$agent_id' && dispatch_id='$dispatch_id'");
   
    } 


    }
    if($tpcat_id==2){
   if($paid_to=='Consignee'){
  
     $diesel_adv_amt=$row['diesel_adv_amt'];
     $cash_adv=$row['cash_adv'];
     $other_cash_adv=$row['other_cash_adv'];
$consignor_cash_adv=$row['consignor_cash_adv'];
$consignee_cash_adv=$row['consignee_cash_adv'];
 $commision=$comp_rate - $own_rate;
$freight_amt=$cmn->getvalfield($connection, "tpa_entry", "amt", "category_id ='$consignee_id' && dispatch_id='$dispatch_id'");
$freight_rate=$cmn->getvalfield($connection, "tpa_entry", "rate", "category_id ='$consignee_id' && dispatch_id='$dispatch_id'");
$sort_wt=$wt_mt-$rec_wt;
$sortamt=$sort_wt * $own_rate;
    } 
      if($paid_to!='Consignee' && $paid_to=='Truck Owner' || $paid_to=='Agent' && $checkbox==1){
  
     $diesel_adv_amt=0;
     $cash_adv=0;
     $other_cash_adv=0;
$consignor_cash_adv=0;
$consignee_cash_adv=0;
$sortamt=0;
 $commision=0;
$freight_amt=$cmn->getvalfield($connection, "tpa_entry", "amt", "category_id ='$consignee_id' && dispatch_id='$dispatch_id'" );
$freight_rate=$cmn->getvalfield($connection, "tpa_entry", "rate", "category_id ='$consignee_id' && dispatch_id='$dispatch_id'");

    } 
}
    if($tpcat_id==4){

     if($paid_to=='Truck Owner'){
 
     $diesel_adv_amt=$row['diesel_adv_amt'];
     $cash_adv=$row['cash_adv'];
     $other_cash_adv=$row['other_cash_adv'];
$consignor_cash_adv=$row['consignor_cash_adv'];
$consignee_cash_adv=$row['consignee_cash_adv'];
$freight_amt=$cmn->getvalfield($connection, "tpa_entry", "amt", "category_id ='$owner_id' && dispatch_id='$dispatch_id' ");
$freight_rate=$cmn->getvalfield($connection, "tpa_entry", "rate", "category_id ='$owner_id' && dispatch_id='$dispatch_id'");
$sort_wt=$wt_mt-$rec_wt;
$sortamt=$sort_wt * $own_rate;
 $commision=$comp_rate - $own_rate;
    } 
    if($checkbox==0){
     $paid_to='Truck Owner';
     $diesel_adv_amt=$row['diesel_adv_amt'];
     $cash_adv=$row['cash_adv'];
     $other_cash_adv=$row['other_cash_adv'];
$consignor_cash_adv=$row['consignor_cash_adv'];
$consignee_cash_adv=$row['consignee_cash_adv'];
$freight_amt=$wt_mt*$own_rate;
$freight_rate=$own_rate;
$sort_wt=$wt_mt-$rec_wt;
$sortamt=$sort_wt * $own_rate;
 $commision=$comp_rate - $own_rate;
    } 
     if($paid_to!='Truck Owner' && $paid_to=='Consignee' || $paid_to=='Agent'  && $checkbox==1){
  
     $diesel_adv_amt=0;
     $cash_adv=0;
     $other_cash_adv=0;
$consignor_cash_adv=0;
$consignee_cash_adv=0;
$sortamt=0;
 $commision=0;
$freight_amt=$cmn->getvalfield($connection, "tpa_entry", "amt", "category_id ='$owner_id' && dispatch_id='$dispatch_id'");
$freight_rate=$cmn->getvalfield($connection, "tpa_entry", "rate", "category_id ='$owner_id' && dispatch_id='$dispatch_id'");


    } 

}


echo  $bilty_date."|".$vehicle_no."|".$destination."|".$wt_mt."|".$rec_wt."|".$comp_rate."|".$own_rate."|".$diesel_adv_amt."|".$cash_adv."|".$other_cash_adv."|".$consignor_cash_adv."|".$consignee_cash_adv."|".$freight_amt."|".$freight_rate."|".$sortamt."|".$paid_to."|".$commision;
 // $bilty_no;

   ?>