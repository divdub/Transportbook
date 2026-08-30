<?php 
session_start();
include("dbinfo.php");
include("../lib/getval.php");
 $cmn = new Comman();
if(isset($_POST['login'])){
 $mobile=$_POST['mobile']; 
$password=$_POST['password'];
 $comp_id=$_POST['comp_id']; 
  $session_id=$_POST['session_id']; 
  $consignor_id=$_POST['consignor_id']; 
$user_type=$cmn->getvalfield($connection,"m_userlogin","user_type","mobile='$mobile'");
  if($user_type=='admin'){
// echo  "select * from m_userlogin where mobile='$mobile' && password='$password' ";die;
  $sql=mysqli_query($connection,"select * from m_userlogin where mobile='$mobile' && password='$password' ");
//   echo "ok"; die;
  }
   else
    {
// echo "no"; die;
  $sql=mysqli_query($connection,"select * from m_userlogin where mobile='$mobile' && password='$password' && consignor_id='$consignor_id'");
}
  $count=mysqli_num_rows($sql); 
   
 $row =mysqli_fetch_array($sql); 
if($count==1){
// echo $count; die;
    $_SESSION['user_id']=$row['user_id'];  
 $_SESSION['session_id']=$session_id;  
  $_SESSION['comp_id']=$comp_id;  
  $_SESSION['consignor_id']=$consignor_id;
  
    setcookie ("mobile",$_POST["mobile"],time()+ 3600);
	setcookie ("password",$_POST["password"],time()+ 3600);
   echo "<script>location='dashboard.php'</script>";
 }

else{

echo "<script>window.location='index.php'</script>";

  }
}




?>