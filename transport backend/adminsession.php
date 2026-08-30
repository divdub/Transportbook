<?php 
error_reporting(0);
// echo "ok"; die;
$timeout = 43200; // 12 hours in seconds
ini_set("session.gc_maxlifetime", $timeout);      // Server side session expiry
ini_set("session.cookie_lifetime", $timeout);     // Client side cookie expiry
session_set_cookie_params($timeout);  
session_start();
include("dbinfo.php");
include("lib/dboperation.php");
include("lib/getval.php");
      $cmn = new Comman();
//   echo "ok"; die;
      if($_SESSION['user_id']!=''){
         
      $user_id = $_SESSION['user_id']; 
        $session_id = $_SESSION['session_id']; 
        $comp_id = $_SESSION['comp_id']; 
         // $consignorid = $_SESSION['consignor_id'];  
$user_name=$cmn->getvalfield($connection,"m_userlogin","user_name","user_id=$user_id");
$user_type=$cmn->getvalfield($connection,"m_userlogin","user_type","user_id=$user_id"); 
$session_name=$cmn->getvalfield($connection,"m_session","session_name","session_id=$session_id");
   if($user_type=='admin'){
//$consignorsessionid = $_GET['consignorid'];
$consignorid = $_SESSION['consignor_id'];  
}
else{
$consignorid = $_SESSION['consignor_id'];  

}
$createdate=date('Y-m-d H:i:s');
$currentdate=date('Y-m-d');
  }
  else
    echo "<script>location='index.php?msg=invalid' </script>" ;
?>