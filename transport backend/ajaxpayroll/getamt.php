<?php 
include("../adminsession.php");

   $id = $_REQUEST['inc_exp_id'];
   $employee_id=$_REQUEST['employee_id'];
   $salary=$_REQUEST['salary'];
   $year=$_REQUEST['year'];
   $month=$_REQUEST['month'];
  $count=$cmn->getvalfield($connection,"payroll","count(payment_id)","inc_exp_id=$id && month=$month && year=$year && employee_id=$employee_id");
  if($count==1){
      echo "Salary Paid";
      
  } else {
   $total_days=$cmn->getvalfield($connection,"attendance","total_days","month=$month && year=$year && employee_id=$employee_id");
   $tno_days=$cmn->getvalfield($connection,"attendance","tno_days","month=$month && year=$year && employee_id=$employee_id");
   $amount=$cmn->getvalfield($connection,"payroll","sum(amount)","inc_exp_id!=$id && month=$month && year=$year && employee_id=$employee_id");
     $perday=$salary / $tno_days;
     $final= $perday * $total_days;
   $total=$final - $amount;
   
   
									echo round($total);
  }
									?>
																	

                                  

