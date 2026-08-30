<?php  error_reporting(0);                                                                                         
include("../adminsession.php");
$pay_type = trim(addslashes($_REQUEST['pay_type']));
$bill_id = trim(addslashes($_REQUEST['bill_id']));

if($pay_type=="Service")
{ 
    // echo "select * from  service_entry where service_id ='$bill_id'";
	$sql = mysqli_query($connection,"select * from  service_entry where service_id ='$bill_id'");
	while($row=mysqli_fetch_assoc($sql))
	{
	
    	        
	          $bill_type= $row['bill_type'];
	         $paydate= $row['service_date'];
              $head_id=$cmn->getvalfield($connection,"service_detail","head_id","service_id='$row[service_id]'");
	          $headname=$cmn->getvalfield($connection,"head_master","head_name","head_id='$head_id'");
             $mechanic_id =$cmn->getvalfield($connection,"service_detail","mechanic_id","service_id='$row[service_id]'");
    	$mechanic_name= $cmn->getvalfield($connection,"mechanic_service_master","mechanic_name","mechanic_id='$mechanic_id'"); 
    	$driver = $cmn->getvalfield($connection,"m_driver","driver_name","driver_id='$row[driver_id]'"); 
    	$truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$row[vehicle_id]'");
         $amount=$cmn->getvalfield($connection,"service_detail","sum(amount)","service_id='$row[service_id]' && consignorid='$consignorid' && comp_id='$comp_id' && session_id='$session_id'");

         $receive_amt=$cmn->getvalfield($connection,"maintenance_entry ","sum(amount)","service_id='$row[service_id]' &&  pay_type= 'Service' && consignorid='$consignorid' && comp_id='$comp_id' && session_id='$session_id' ");
    

 

         $balance_amt=$amount - $receive_amt;
  
	}
}  
else if($pay_type=="Maintenance")
{
	$sql = mysqli_query($connection,"select * from  service_entry where service_id ='$bill_id'");
	while($row=mysqli_fetch_assoc($sql))
	{
	
	   $bill_type= $row['bill_type'];
	         $paydate= $row['service_date'];
              $head_id=$cmn->getvalfield($connection,"service_detail","head_id","service_id='$row[service_id]'");
	          $headname=$cmn->getvalfield($connection,"head_master","head_name","head_id='$head_id'");
             $mechanic_id =$cmn->getvalfield($connection,"service_detail","mechanic_id","service_id='$row[service_id]'");
    	$mechanic_name= $cmn->getvalfield($connection,"mechanic_service_master","mechanic_name","mechanic_id='$mechanic_id'"); 
    	$driver = $cmn->getvalfield($connection,"m_driver","driver_name","driver_id='$row[driver_id]'"); 
    	$truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$row[vehicle_id]'");
         $amount=$cmn->getvalfield($connection,"service_detail","sum(amount)","service_id='$row[service_id]' && consignorid='$consignorid' && comp_id='$comp_id' && session_id='$session_id'");
	  $receive_amt=$cmn->getvalfield($connection,"maintenance_entry ","sum(amount)","service_id='$row[service_id]' &&  pay_type= 'Maintenance' && consignorid='$consignorid' && comp_id='$comp_id' && session_id='$session_id' ");
     $balance_amt=$amount - $receive_amt;
    
        }
}else if($pay_type=="other")
{
	$sql = mysqli_query($connection,"select * from  other_expense_entry where other_exp_id ='$bill_id'");
	while($row=mysqli_fetch_assoc($sql))
	{
	    
	      $amount= $row['amount'];
	       $bill_type= $row['bill_type'];
	        $paydate= $row['service_date'];
    	$headname = $cmn->getvalfield($connection,"inc_ex_head_master","incex_head_name","inc_ex_id='$row[otherid]'"); 
    		$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 
    	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
    

	}
}
echo $paydate."|".$headname."|".$truckno."|".$driver."|".$balance_amt."|".$bill_type."|".$mechanic_name;
?>