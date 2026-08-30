<?php 
session_start();
// error_reporting(0);
include("dbinfo.php");
include("lib/getval.php");
 $cmn = new Comman();
if(isset($_POST['submit'])){
$user_name=$_POST['user_name'];
$otpcode=$_POST['otpcode'];

$password=$_POST['password'];
 $comp_id=$_POST['comp_id']; 
  $session_id=$_POST['session_id']; 
  $consignor_id=$_POST['consignor_id']; 
  $otpno = $cmn->getvalfield($connection,"get_otp","otpcode","id='1'");
$user_type=$cmn->getvalfield($connection,"m_userlogin","user_type","user_name='$user_name'");
  if($user_type=='admin'){
  // echo "select * from m_userlogin where user_name='$user_name' && password='$password' ";
  $sql=mysqli_query($connection,"select * from m_userlogin where user_name='$user_name' && password='$password' ");
 // echo "ok"; die;
  }
   else
    {
// echo "no"; die;&& session_id='$session_id'
// echo "select * from m_userlogin where user_name='$user_name' && password='$password' && consignor_id='$consignor_id'";die;
  $sql=mysqli_query($connection,"select * from m_userlogin where user_name='$user_name' && password='$password' && consignor_id='$consignor_id' && session_id='$session_id'");
}
  $count=mysqli_num_rows($sql); 
  // echo $count; die;
 $row =mysqli_fetch_array($sql); 
 $user_id=$row['user_id'];
if($otpcode==$otpno){

    $_SESSION['user_id']=$user_id; 
   $_SESSION['session_id']=$session_id;  
 $_SESSION['comp_id']=$comp_id; 
  $_SESSION['consignor_id']=$consignor_id; 
   echo "<script>location='dashboard.php'</script>";
 }

else{


echo "<script>window.location='loginotp.php'</script>";

  }
}




?>